<?php
namespace Ricci69\MmbakViewer;

class DbDriver
{
    public $db;

    public function __construct(string $file="db.mmbak")
    {
        try {
            $this->db = new \SQLite3($file, SQLITE3_OPEN_READWRITE);
            $this->db->enableExceptions(true);
        }
        catch (\Exception $e)
        {
            die($e->getMessage());
        }
        
        return $this->db;
    }
    
    /**
     * Fetch all the results of an SQLite3Result and returns the array
     * 
     * @param SQLite3Result $result
     * @return array
     */
    public function fetchAll(\SQLite3Result $result) : array
    {
        $fetchAllArray = array();
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            array_push($fetchAllArray, $row);
        }     
        
        return $fetchAllArray;
    }
}

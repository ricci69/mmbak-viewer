<?php
namespace Ricci69\MmbakViewer;

class Currencies
{
    private $db;

    public function __construct(DbDriver $Db)
    {
        $this->db = $Db->db;
    }
    
    /**
     * Returns the list of the currencies as a map [uid => symbol]
     * 
     * @return array [CURRENCY_ID] = SYMBOL
     */
    public function get() : array
    {
        $currency = array();
        $results = $this->db->query('SELECT * FROM CURRENCY');
        while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
            $currency[$row["uid"]] = $row["SYMBOL"];
        }
        
        return $currency;
    }
    
    /**
     * Returns the list of currencies as array of objects with uid and symbol
     * 
     * @return array [["uid" => "...", "symbol" => "..."], ...]
     */
    public function getAll() : array
    {
        $currency = array();
        $results = $this->db->query('SELECT * FROM CURRENCY');
        while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
            $currency[] = array("uid" => $row["uid"], "symbol" => $row["SYMBOL"]);
        }
        
        return $currency;
    }
    
    /**
     * Returns a single currency by UID
     * 
     * @param string $uid Currency UID
     * @return array|null
     */
    public function getById(string $uid) : ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM CURRENCY WHERE uid = :uid');
        $stmt->bindParam(":uid", $uid, SQLITE3_TEXT);
        $result = $stmt->execute();
        $row = $result->fetchArray(SQLITE3_ASSOC);
        
        if (!$row) {
            return null;
        }
        
        return array("uid" => $row["uid"], "symbol" => $row["SYMBOL"]);
    }
}
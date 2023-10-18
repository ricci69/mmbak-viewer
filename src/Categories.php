<?php
namespace Ricci69\MmbakViewer;

class Categories
{
    private $db;
    private $dbDriver;

    public function __construct(DbDriver $Db)
    {
        $this->db = $Db->db;
        $this->dbDriver = $Db;
    }
    
    /**
     * Returns the list of the active categories
     * 
     * @return array
     */
    public function get() : array
    {
        $result = $this->db->query('SELECT * FROM ZCATEGORY WHERE status=0 AND type=1 AND c_is_del IS NULL');
        return $this->dbDriver->fetchAll($result);
    }
}

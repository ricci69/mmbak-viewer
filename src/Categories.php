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
     * Returns the list of the active categories (type=1, status=0, not deleted)
     * 
     * @return array
     */
    public function get() : array
    {
        $result = $this->db->query('SELECT * FROM ZCATEGORY WHERE status=0 AND type=1 AND c_is_del IS NULL');
        return $this->dbDriver->fetchAll($result);
    }
    
    /**
     * Returns all categories including disabled and deleted ones
     * 
     * @return array
     */
    public function getAll() : array
    {
        $result = $this->db->query('SELECT * FROM ZCATEGORY');
        return $this->dbDriver->fetchAll($result);
    }
    
    /**
     * Returns a single category by UID
     * 
     * @param string $uid Category UID
     * @return array|null
     */
    public function getById(string $uid) : ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM ZCATEGORY WHERE uid = :uid');
        $stmt->bindParam(":uid", $uid, SQLITE3_TEXT);
        $result = $stmt->execute();
        $row = $result->fetchArray(SQLITE3_ASSOC);
        
        return $row ?: null;
    }
    
    /**
     * Returns categories filtered by type
     * 
     * @param int $type Category type (1=expense, 2=income, etc.)
     * @param bool $activeOnly Whether to filter only active (status=0, not deleted)
     * @return array
     */
    public function getByType(int $type, bool $activeOnly = true) : array
    {
        $where = "type = $type";
        if ($activeOnly) {
            $where .= " AND status=0 AND c_is_del IS NULL";
        }
        $result = $this->db->query("SELECT * FROM ZCATEGORY WHERE $where");
        return $this->dbDriver->fetchAll($result);
    }
}
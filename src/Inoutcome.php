<?php
namespace Ricci69\MmbakViewer;

class Inoutcome
{
    private $db;
    private $dbDriver;

    public function __construct(DbDriver $Db)
    {
        $this->db = $Db->db;
        $this->dbDriver = $Db;
    }

    /**
     * Returns the list of incomes/expenditures for a given period
     * 
     * @param int $type 0 for incomes, 1 for expenditures
     * @param string $start Y-m-d of the beginning
     * @param string $end Y-m-d of the end
     * @return array
     */
    private function get(int $type, string $start, string $end) : array
    {
        $stmt = $this->db->prepare('SELECT * FROM INOUTCOME WHERE do_type = :type AND wdate BETWEEN :start AND :end');
        
        $stmt->bindParam(":type", $type, SQLITE3_INTEGER);
        $stmt->bindParam(":start", $start, SQLITE3_TEXT);
        $stmt->bindParam(":end", $end, SQLITE3_TEXT);
        
        $result = $stmt->execute();
        
        return $this->dbDriver->fetchAll($result);
    }
    
    /**
     * Returns the list of incomes for a given period
     * 
     * @param string $start Y-m-d of the beginning
     * @param string $end Y-m-d of the end
     * @return array
     */
    public function getIn(string $start, string $end) : array
    {
        return $this->get(0, $start, $end);
    }
    
    /**
     * Returns the list of expenditures for a given period
     * 
     * @param string $start Y-m-d of the beginning
     * @param string $end Y-m-d of the end
     * @return array
     */    
    public function getOut(string $start, string $end) : array
    {
        return $this->get(1, $start, $end);
    }    
    
    /**
     * Returns the list of incomes and expenditures for a given period, with the 
     * information about the related category 
     * 
     * @param string $start
     * @param string $end
     * @return array
     */
    public function getFull(string $start, string $end) : array
    {
        $stmt = $this->db->prepare('SELECT INOUTCOME.wdate, zcategory.NAME, INOUTCOME.DO_TYPE, INOUTCOME.AMOUNT_ACCOUNT, INOUTCOME.currencyUid, INOUTCOME.ZCONTENT FROM INOUTCOME,zcategory WHERE zcategory.uid=INOUTCOME.ctgUid AND INOUTCOME.wdate BETWEEN :start AND :end');
        
        $stmt->bindParam(":start", $start, SQLITE3_TEXT);
        $stmt->bindParam(":end", $end, SQLITE3_TEXT);  
        
        $result = $stmt->execute();
        
        return $this->dbDriver->fetchAll($result);
    }
    
    /**
     * Returns the sum of incomes/expenditures for a given period
     * 
     * @param int $type 0 for income, 1 for expenditures
     * @param string $start Y-m-d of the beginning
     * @param string $end Y-m-d of the end
     * @return array "sum" with the total, "currency" with the currency ID
     */
    private function getSum(int $type, string $start, string $end): array
    {
        $stmt = $this->db->prepare('SELECT SUM(AMOUNT_ACCOUNT) as sum, currencyUid FROM INOUTCOME WHERE do_type = :type AND wdate BETWEEN :start AND :end');
        
        $stmt->bindParam(":type", $type, SQLITE3_INTEGER);
        $stmt->bindParam(":start", $start, SQLITE3_TEXT);
        $stmt->bindParam(":end", $end, SQLITE3_TEXT);
        
        $result = $stmt->execute();
        $row = $result->fetchArray(SQLITE3_ASSOC);
        
        return array("sum"=>$row["sum"], "currency"=>$row["currencyUid"]);        
    }
    
    /**
     * Returns the sum of incomes for a given period
     * 
     * @param string $start Y-m-d of the beginning
     * @param string $end Y-m-d of the end
     * @return array "sum" with the total, "currency" with the currency ID
     */    
    public function getSumIn(string $start, string $end) : array
    {
        return $this->getSum(0, $start, $end);
    }
    
    /**
     * Returns the sum of expenditures for a given period
     * 
     * @param string $start Y-m-d of the beginning
     * @param string $end Y-m-d of the end
     * @return array "sum" with the total, "currency" with the currency ID
     */     
    public function getSumOut(string $start, string $end) : array
    {
        return $this->getSum(1, $start, $end);
    }       
}
<?php
namespace Ricci69\MmbakViewer;

class Wallet
{
    private $db;
    private $dbDriver;

    public function __construct(DbDriver $Db)
    {
        $this->db = $Db->db;
        $this->dbDriver = $Db;
    }

    /**
     * Calculates the balance of wallet (Incomes - Expenditures)
     * 
     * @return array "tot" with the total, "currency" with the currency ID
     */
    public function getBalance() : array
    {
        $Inoutcome = new \Ricci69\MmbakViewer\Inoutcome($this->dbDriver);
        
        $in = $Inoutcome->getSumIn(date('Y-m-d',0), date('Y-m-d', PHP_INT_MAX));
        $out = $Inoutcome->getSumOut(date('Y-m-d',0), date('Y-m-d', PHP_INT_MAX));
        
        return array("balance"=>$in["sum"]-$out["sum"], "currency"=>$in["currency"]);
    }
}

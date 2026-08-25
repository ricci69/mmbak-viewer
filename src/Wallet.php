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
     * Calculates the balance of wallet (Incomes - Expenditures) for all time
     * 
     * @return array "balance" with the total, "currency" with the currency ID
     */
    public function getBalance() : array
    {
        $Inoutcome = new \Ricci69\MmbakViewer\Inoutcome($this->dbDriver);
        
        $in = $Inoutcome->getSumIn(date('Y-m-d', 0), date('Y-m-d', PHP_INT_MAX));
        $out = $Inoutcome->getSumOut(date('Y-m-d', 0), date('Y-m-d', PHP_INT_MAX));
        
        return array("balance"=>$in["sum"]-$out["sum"], "currency"=>$in["currency"]);
    }
    
    /**
     * Calculates the balance of wallet for a specific period
     * 
     * @param string $start Y-m-d of the beginning
     * @param string $end Y-m-d of the end
     * @return array "balance" with the total, "currency" with the currency ID
     */
    public function getBalanceByPeriod(string $start, string $end) : array
    {
        $Inoutcome = new \Ricci69\MmbakViewer\Inoutcome($this->dbDriver);
        
        $in = $Inoutcome->getSumIn($start, $end);
        $out = $Inoutcome->getSumOut($start, $end);
        
        // Handle null sums (no transactions in period)
        $inSum = $in["sum"] ?? 0;
        $outSum = $out["sum"] ?? 0;
        $currency = $in["currency"] ?? $out["currency"] ?? null;
        
        return array("balance"=>$inSum-$outSum, "currency"=>$currency);
    }
    
    /**
     * Calculates the balance of wallet for a specific currency
     * 
     * @param string $currencyUid Currency UID
     * @return array "balance" with the total, "currency" with the currency ID
     */
    public function getBalanceByCurrency(string $currencyUid) : array
    {
        $Inoutcome = new \Ricci69\MmbakViewer\Inoutcome($this->dbDriver);
        
        $in = $Inoutcome->getSumIn(date('Y-m-d', 0), date('Y-m-d', PHP_INT_MAX));
        $out = $Inoutcome->getSumOut(date('Y-m-d', 0), date('Y-m-d', PHP_INT_MAX));
        
        // Filter by currency - need to query directly since getSumIn/Out don't filter by currency
        $stmt = $this->db->prepare('SELECT SUM(AMOUNT_ACCOUNT) as sum FROM INOUTCOME WHERE do_type = 0 AND currencyUid = :currencyUid');
        $stmt->bindParam(":currencyUid", $currencyUid, SQLITE3_TEXT);
        $result = $stmt->execute();
        $row = $result->fetchArray(SQLITE3_ASSOC);
        $inSum = $row["sum"] ?? 0;
        
        $stmt = $this->db->prepare('SELECT SUM(AMOUNT_ACCOUNT) as sum FROM INOUTCOME WHERE do_type = 1 AND currencyUid = :currencyUid');
        $stmt->bindParam(":currencyUid", $currencyUid, SQLITE3_TEXT);
        $result = $stmt->execute();
        $row = $result->fetchArray(SQLITE3_ASSOC);
        $outSum = $row["sum"] ?? 0;
        
        return array("balance"=>$inSum-$outSum, "currency"=>$currencyUid);
    }
}
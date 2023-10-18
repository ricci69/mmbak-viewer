<?php
require '../vendor/autoload.php';
$Db = new Ricci69\MmbakViewer\DbDriver("../db.mmbak");
$Currencies = new Ricci69\MmbakViewer\Currencies($Db);
$Inoutcome = new Ricci69\MmbakViewer\Inoutcome($Db);
$Categories = new Ricci69\MmbakViewer\Categories($Db);
$Wallet = new Ricci69\MmbakViewer\Wallet($Db); 

echo "<h1>CURRENCIES</h1>";
$currencies = $Currencies->get();
foreach ($currencies as $key=>$value)
    echo "{$key} => {$value}<br />";
echo "<br /><br />";    
 

echo "<h1>CATEGORIES</h1>";
$categories = $Categories->get();
foreach ($categories as $category)
    echo "{$category["ID"]} => {$category["NAME"]}<br />";
echo "<br /><br />";    
    

echo "<h1>INCOMES OF THIS MONTH</h1>";
$start = date("Y-m-d", strtotime("first day of this month"));
$end = date("Y-m-d", strtotime("last day of this month"));
$inArray = $Inoutcome->getIn($start, $end);
foreach ($inArray as $row)
    echo "{$row["WDATE"]} | {$row["AMOUNT_ACCOUNT"]}{$currencies[$row["currencyUid"]]} <br />";
echo "<br /><br />";


echo "<h1>EXPENDITURES OF THIS MONTH</h1>";
$start = date("Y-m-d", strtotime("first day of this month"));
$end = date("Y-m-d", strtotime("last day of this month"));
$outArray = $Inoutcome->getOut($start, $end);
foreach ($outArray as $row)
    echo "{$row["WDATE"]} | {$row["AMOUNT_ACCOUNT"]}{$currencies[$row["currencyUid"]]} <br />";
echo "<br /><br />";


echo "<h1>TRANSACTIONS OF THIS MONTH (FULL VIEW)</h1>";
$start = date("Y-m-d", strtotime("first day of this month"));
$end = date("Y-m-d", strtotime("last day of this month"));
$outArray = $Inoutcome->getFull($start, $end);
foreach ($outArray as $row)
    echo "{$row["WDATE"]} | ".($row["DO_TYPE"] ? '-' : '+')."{$row["AMOUNT_ACCOUNT"]}{$currencies[$row["currencyUid"]]} | {$row["NAME"]} | {$row["ZCONTENT"]}<br />";
echo "<br /><br />";


echo "<h1>SUM OF THIS MONTH'S INCOMES</h1>";
$start = date("Y-m-d", strtotime("first day of this month"));
$end = date("Y-m-d", strtotime("last day of this month"));
$res = $Inoutcome->getSumIn($start, $end);
echo $res["sum"].$currencies[$res["currency"]];
echo "<br /><br />";


echo "<h1>SUM OF THIS MONTH'S EXPENDITURES</h1>";
$start = date("Y-m-d", strtotime("first day of this month"));
$end = date("Y-m-d", strtotime("last day of this month"));
$res = $Inoutcome->getSumOut($start, $end);
echo $res["sum"].$currencies[$res["currency"]];
echo "<br /><br />";


echo "<h1>WALLET BALANCE</h1>";
$res = $Wallet->getBalance();
echo $res["balance"].$currencies[$res["currency"]];
echo "<br /><br />";
<?php

$db = new SQLite3('tests/test.mmbak');

// Drop tables if they exist
$db->exec('DROP TABLE IF EXISTS CURRENCY');
$db->exec('DROP TABLE IF EXISTS ZCATEGORY');
$db->exec('DROP TABLE IF EXISTS INOUTCOME');

// Create tables
$db->exec('CREATE TABLE CURRENCY (uid TEXT, SYMBOL TEXT)');
$db->exec('CREATE TABLE ZCATEGORY (ID INTEGER, NAME TEXT, status INTEGER, type INTEGER, c_is_del INTEGER, uid TEXT)');
$db->exec('CREATE TABLE INOUTCOME (do_type INTEGER, wdate TEXT, AMOUNT_ACCOUNT REAL, currencyUid TEXT, ctgUid TEXT, ZCONTENT TEXT)');

// Insert data
$db->exec("INSERT INTO CURRENCY (uid, SYMBOL) VALUES ('1', 'USD')");
$db->exec("INSERT INTO CURRENCY (uid, SYMBOL) VALUES ('2', 'EUR')");

$db->exec("INSERT INTO ZCATEGORY (ID, NAME, status, type, c_is_del, uid) VALUES (1, 'Salary', 0, 1, NULL, 'cat1')");
$db->exec("INSERT INTO ZCATEGORY (ID, NAME, status, type, c_is_del, uid) VALUES (2, 'Groceries', 0, 1, NULL, 'cat2')");
$db->exec("INSERT INTO ZCATEGORY (ID, NAME, status, type, c_is_del, uid) VALUES (3, 'Disabled Category', 1, 1, NULL, 'cat3')");


$db->exec("INSERT INTO INOUTCOME (do_type, wdate, AMOUNT_ACCOUNT, currencyUid, ctgUid, ZCONTENT) VALUES (0, '2023-01-15', 2000.00, '1', 'cat1', 'Monthly Salary')");
$db->exec("INSERT INTO INOUTCOME (do_type, wdate, AMOUNT_ACCOUNT, currencyUid, ctgUid, ZCONTENT) VALUES (1, '2023-01-20', 150.50, '1', 'cat2', 'Weekly Groceries')");
$db->exec("INSERT INTO INOUTCOME (do_type, wdate, AMOUNT_ACCOUNT, currencyUid, ctgUid, ZCONTENT) VALUES (0, '2023-02-15', 2000.00, '1', 'cat1', 'Monthly Salary')");
$db->exec("INSERT INTO INOUTCOME (do_type, wdate, AMOUNT_ACCOUNT, currencyUid, ctgUid, ZCONTENT) VALUES (1, '2023-02-20', 250.75, '1', 'cat2', 'Weekly Groceries')");

echo "Test database created successfully.\n";

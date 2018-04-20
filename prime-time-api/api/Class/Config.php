<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: '.'Origin, X-Requested-With, Content-Type, Accept');


// MySQL Database settings

// Database Endpoint
$dbserver = 'shinji-db.chcovwezbrwn.us-east-2.rds.amazonaws.com';
// Database port
$dbserver_port = '3306';
// Database scheme name
$dbname = 'PrimeTime';
// Databse username
$dbuser = "shinji";
// Database password
$dbpasswd = "JzyMucun1996";
// Database type (mysqli/mysql)
$dbtype = 'mysqli';
// Database character sets (utf8/gbk)
$dbcharset = 'utf8';

$db_pre = 'prime_time_';

// Base Account info for collecting dataSets
$baseAccount = "jzy_tony";
$basePassword = "JzyMucun1996";

error_reporting(E_ALL);
ini_set('display_errors', 1);
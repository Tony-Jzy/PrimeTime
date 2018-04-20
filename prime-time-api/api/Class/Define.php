<?php

require_once dirname(__FILE__) . '/' . 'Config.php';

//　Database Host
define('DBSERVER',$dbserver);
// Database Port
define('DBSERVER_PORT',$dbserver_port);
// Database Name
define('DBNAME',$dbname);
// Database username
define('DBUSER',$dbuser);
// Database password
define('DBPASSWD',$dbpasswd);
// Database type (mysqli/mysql)
define('DBTYPE',$dbtype);
// Database character set (utf8/gbk)
define('DBCHARSET',$dbcharset);

define('DB_PRE', $db_pre);


// Base Account info for collecting dataSets
define('BASEACC', $baseAccount);
define('BASEPW', $basePassword);


define("ALREADY_VERIFIED", -2);
define("NAME_ALREADY_REGISTERED", -3);
define("EMAIL_ALREADY_REGISTERED", -4);
define("INCORRECT_AUTH_KEY", -20);
define("AUTH_KEY_EXPIRED", -21);
define("AUTH_ACTIVITY_NOT_FOUND", -22);
define("USER_NOT_FOUND", -99);
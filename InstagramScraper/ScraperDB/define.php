<?php

require_once dirname(__FILE__).'/'.'config.php';

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

// Base Account info for collecting dataSets
define('BASEACC', $baseAccount);
define('BASEPW', $basePassword);

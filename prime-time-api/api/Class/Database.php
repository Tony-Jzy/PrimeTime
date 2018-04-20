<?php

require_once 'Define.php';

class DB{
	 private static $instance = null;
	 private static $conn;
	 
	 public static function getInstance(){
		if(self::$instance === null || !(self::$instance instanceof DB)){
			self::$instance = new DB();
			self::$instance->connect();
		} 
		return self::$instance;
	}
	
	function connect(){
		switch(DBTYPE){
			case 'mysql':
				if(self::$conn = @mysql_connect(DBSERVER, DBUSER, DBPASSWD)){
					if(mysql_select_db(DBNAME,self::$conn)){
						mysql_query("SET character_set_connection=".DBCHARSET.", character_set_results=".DBCHARSET.", character_set_client=binary",self::$conn);
						mysql_query("SET NAMES UTF-8",self::$conn);
					}else{
						echo 'can not select db';exit;
					}
				}else{
					echo 'can not connect db';exit;
			    }
				break;
			case 'mysqli':
				if(self::$conn = new mysqli(DBSERVER,DBUSER,DBPASSWD,DBNAME,DBSERVER_PORT)){
					self::$conn->query("SET character_set_connection=".DBCHARSET.", character_set_results=".DBCHARSET.", character_set_client=binary");
				}else{
					echo 'can not connect db';exit;
				}
				break;
		}
	}
	
	function query($sql){
		self::getInstance();
		switch(DBTYPE){
			case 'mysql':
				$query = mysql_query($sql,self::$conn);
			    break;
			case 'mysqli':
				$query = self::$conn->query($sql);
				break;
		}
		return $query;
	}

	function fetch_array($query, $result_type = 1) {
		switch(DBTYPE){
			case 'mysql':
				return mysql_fetch_array($query, $result_type);
				break;
			case 'mysqli':
				return mysqli_fetch_array($query,1);
			    break;
		}
	}

	function fetch_all($sql) {
	     $query = $this->query($sql);
		while($data = $this->fetch_array($query)) {
			$arr[] = $data;
		}
		
		return $arr;
	}

	function affected_rows() {
		return mysql_affected_rows(self::$conn);
	}

	function result_first($sql) {
		$query = $this->query($sql);
		return $this->result($query, 0);
	}

	function result($query, $row) {
		$query = @mysql_result($query, $row);
		return $query;
	}

	function fetch_first($sql) {
		$query = $this->query($sql);
		return $this->fetch_array($query);
	}

	function getLastId(){
		self::getInstance();
		switch(DBTYPE){
			case 'mysql':
				return mysql_insert_id(self::$conn);
				break;
			case 'mysqli':
				return mysqli_insert_id(self::$conn);
			    break;
		}
	}

	function insert_id() {
		return ($id = mysqli_insert_id(self::$conn)) >= 0 ? $id : $this->result($this->query("SELECT last_insert_id()"), 0);
	}

	function close() {
		return mysql_close(self::$conn);
	}
	function test(){
		return 'OK';
	}
 }
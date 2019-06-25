<?php

define('DB_USER',"root");
define('DB_PASSWORD',"");
define('DB_DSN','mysql:host=localhost;dbname=books_rest_api');

class Database{
	private $dsn = DB_DSN;
	private $username = DB_USER;
	private $password = DB_PASSWORD;
	public $conn;
	//get the database connection
	public function getConnection(){
		$this->conn = null;
		try{
			$this->conn = new PDO($this->dsn,$this->username,$this->password);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}catch(PDOException $e){
			//log the error to the server's error log
			error_log($e->getMessage());
		}
		return $this->conn;
	}

}


?>
<?php

require('././config/env.php');


class Database{

	private $mysqli;
	private $logger; 

	public function __construct($logger){

		$this->logger = $logger; 
	}

    public function connect(){
        
        try{
        	$this->mysqli = mysqli_connect(DBHOST,DBUSER,DBPWD,DBNAME) or die("Couldn't connect");
        	return $this->mysqli;
        }catch(Exception $e){
			$this->logger->writeMessage($e->getMessage());			
		}

    }

    public function close() {
        
        try{
        	$this->mysqli->close() OR die("There was a problem disconnecting from the database.");
		}catch(Exception $e){
			$this->logger->writeMessage($e->getMessage());			
		}

    }
}







?>
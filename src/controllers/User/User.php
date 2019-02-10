<?php

class User{

    private $database;
    private $logger;

	public function __construct($database, $logger){

		$this->database = $database;
		$this->logger   = $logger;

	}


	public function create($data = null){

		# Implodes array into string of values
		$values = "'" . implode("','", array_values($data)) . "'";
		
		try{
		    $database = $this->database->connect();
			# String escape input
			$escaped_values = $database->real_escape_string($values);
			# Query values into database
			$query = $database->query("INSERT INTO persons (firstname, lastname, zip, city) VALUES($values)");
			# Close connection
			$this->database->close();
		}catch(Exception $e){
			$this->logger->writeMessage($e->getMessage());			
		}

	}

	
	public function read($data = null){

		try{
			$database = $this->database->connect();
			$query = $database->query("SELECT * FROM persons where id = $data");
		    $row = $query->fetch_object();
		    $this->database->close();
		}catch(Exception $e){
			$this->logger->writeMessage($e->getMessage());			
		}

	}


	public function delete($data = null){

		try{
			$database = $this->database->connect();
		    $query = $database->query("DELETE FROM persons where persons = $data");
		    $this->database->close();
		}catch(Exception $e){
			$this->logger->writeMessage($e->getMessage());			
		}

	}
}



?> 
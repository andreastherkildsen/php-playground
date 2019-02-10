<?php

class getJsonData{

	private $data;
	private $finalData = array();
	private $database;

	public function __construct($database){

		$this->database = $database;
		$this->getData();
	
	}

	public function getData(){

		$apiData    = file_get_contents(APIENTRY.'/users');
		$apiData    = json_decode($apiData);
		$this->data = $apiData;
		$this->formatData();

	}

	public function formatData(){

		$data = $this->data;
		foreach($data as $person){
			
			$fullName  = explode(" ", $person->name);
	        $firstName = $fullName[0];
	        $lastName  = $fullName[1];
			$city      = $person->address->city; 
			$zip       = $person->address->zipcode;

			$personData = array(
					'firstName' => $firstName,
					'lastName' => $lastName,
					'zip' => $zip,
					'city' => $city
			);

			$this->finalData[] = $personData;
		}

		$this->uploadToDatabase();
	}

	public function uploadToDatabase(){
	
		$persons = $this->finalData;
		$values = "";

		foreach($persons as $person){

			# Implodes array into string of values
			$value = "('" . implode("','", array_values($person)) . "'),";
			if( !next( $persons ) ) {
        		$value = "('" . implode("','", array_values($person)) . "')";
    		}
			$values .= $value;

		}
	
		try{
			$database = $this->database->connect();
		    # Query values into database
		    $query = $database->query("INSERT INTO persons (firstname, lastname, zip, city) VALUES $values");
		    # Close connection
		    $this->database->close();
		}catch(Exception $e){
		    $this->logger->writeMessage($e->getMessage());			
	    }

	}




}

?>
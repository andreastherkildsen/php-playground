<?php

class createOrderData{

	private $productData;
	private $personsData;
	private $finalData = array();
	private $database;

	public function __construct($database){

		$this->database = $database;
		$this->getProductData();
		$this->getuserData();
		$this->uploadOrders();
	
	}

	public function getProductData(){

		try{
			$database = $this->database->connect();
			$query = $database->query("SELECT product_id FROM products");
		    $result = $query->fetch_all(MYSQLI_ASSOC);
		    $this->database->close();
		    $this->productData = $result;
		}catch(Exception $e){
			$this->logger->writeMessage($e->getMessage());			
		}

	}

	public function getUserData(){

		try{
			$database = $this->database->connect();
			$query = $database->query("SELECT id FROM persons");
		    $result = $query->fetch_all(MYSQLI_ASSOC);
		    $this->database->close();
		    $this->personsData = $result;
		}catch(Exception $e){
			$this->logger->writeMessage($e->getMessage());			
		}

	}

	public function uploadOrders(){
	
		
		# Gets product data and create first / last range for id shuffle
		$this->productData;
		$first = reset($this->productData);
    	$last  = end($this->productData);
    	$first = $first['product_id'];
    	$last  = $last['product_id'];
    	$values = ""; 
    	$orderNo = "ordernum";
		
		# Init values for insert into statement
		foreach($this->personsData as $person){

			$id          = $person['id'];
			$randomRange = rand($first,$last);
			$value       = "('" . $id.$randomRange . "', '" . $id . "', '".$randomRange."'),";
			
			if( !next( $this->personsData ) ) {
        		$value = "('" . $id.$randomRange . "', '" . $id . "', '".$randomRange."')";
    		}

			$values .= $value;
		}
		echo $values;
		try{
			$database = $this->database->connect();
		    # Query values into database
		    $query = $database->query("INSERT INTO orders (order_no, person_id, order_info) VALUES $values");
		    # Close connection
		    $this->database->close();
		    echo "close";
		}catch(Exception $e){
		    $this->logger->writeMessage($e->getMessage());			
	    }


	}




}

?>
<?php

class getProductJsonData{

	private $data;
	private $finalData = array();
	private $database;

	public function __construct($database){

		$this->database = $database;
		$this->getData();
	
	}

	public function getData(){

		$apiData    = file_get_contents('https://gist.githubusercontent.com/andreastherkildsen/a4690573eda18f0c6a09c809d2ee8c24/raw/28a960482e325dff8d1c13534ac8961232741d0e/product.json');
		$apiData    = json_decode($apiData);
		$this->data = $apiData;
		$this->formatData();

	}

	public function formatData(){

		$data = $this->data;
		foreach($data as $product){
			
			
	        $productName = $product->name;
			$productId   = $product->id;

			$productData = array(
					'productname' => $productName
			);

			$this->finalData[] = $productData;
		}

		$this->uploadToDatabase();
	}

	public function uploadToDatabase(){
	
		$products = $this->finalData;
		$values = "";

		foreach($products as $prod){

			# Implodes array into string of values
			$value = "('" . implode("','", array_values($prod)) . "'),";
			if( !next( $products ) ) {
        		$value = "('" . implode("','", array_values($prod)) . "')";
    		}
			$values .= $value;

		}

		echo $values;
	
		try{
			$database = $this->database->connect();
		    # Query values into database
		    $query = $database->query("INSERT INTO products (productname) VALUES $values");
		    # Close connection
		    $this->database->close();
		}catch(Exception $e){
		    $this->logger->writeMessage($e->getMessage());			
	    }

	}




}

?>
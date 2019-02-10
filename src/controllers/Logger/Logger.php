<?php


class Logger{

	public function writeMessage($message){
		$date = date_create();
		$date = date_timestamp_get($date);
		$errorFile = fopen("./log/error.txt", "w") or die("Unable to open file!");
		fwrite($errorFile, $message);
		fclose($errorFile);

	}

}
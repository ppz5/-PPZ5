<?php
class db{
	public static function connect(){
		$servername = "127.0.0.1";
		$username = "anzzilla_pp5";
		$password = "1234";
		$dbname = "anzzilla_pp5";
		
		$con = mysqli_connect($servername, $username, $password, $dbname);
		
		/*
		if (!$con) {
			die("Connection failed: " . mysqli_connect_error());
		}
		*/
		return $con;
	}
	
	public static function encodeID($id){
		return dechex(($id * 5) + 100100);
	}
	
	public static function decodeID($id){
		return (hexdec($id)-100100)/5;
	}
}
?>
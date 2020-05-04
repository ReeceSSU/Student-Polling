<?php
ini_set('display_errors', 1);

	$host="localhost";
	$user="studentpoll";
	$password="studentpoll20";
	$db="studentpoll";

	$connection = mysqli_connect($host,$user,$password);
	if(!$connection) 
		die("Unable to connect to MYSQL: ".mysqli_error($connection));
				
	$db_select = mysqli_select_db($connection, $db);
	if(!$db_select) 
		die("Unable to select database: ".mysqli_error($connection));
				
	mysqli_select_db($connection, $db);
?>
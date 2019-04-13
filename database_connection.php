<?php
//database_connection.php

/*
	UNCOMMENT THE FOLLOING 2 LINES WHEN DEBUGGING
*/
error_reporting(0);
ini_set('display_errors', '0');


$connect = new PDO('mysql:host=localhost;dbname=cbsi_db', 'root', '');
session_start();

?>
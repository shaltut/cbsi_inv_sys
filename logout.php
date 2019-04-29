<?php
//logout.php

//Includes
include('database_connection.php'); //Database Connection

//This query sets the user_last_log to the current date when the user logs out
$query = "
	UPDATE user_details 
	SET user_last_log = :user_last_log
	WHERE user_id = :user_id
";
$statement = $connect->prepare($query);
$statement->execute(
	array(
		':user_last_log'	=>	date("Y-m-d H:i:s"),
		':user_id'		=>	$_SESSION["user_id"]
	)
);
$result = $statement->fetchAll();
if(isset($result))
{
	echo 'Equipment status change to ' . $status;
}

//Destroy session and log user out. Startsession ensures logged out users stay logged out
session_start();
session_destroy();

//Returns the user to the login page after killing the session and destroying all session variables.
header("location:login.php");
?>
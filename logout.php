<?php
//logout.php

//Includes
include('database_connection.php'); //Database Connection

	$query = "
		UPDATE user_details 
		SET user_last_log = :user_last_log
		WHERE user_id = :user_id
	";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':user_last_log'	=>	date("Y-m-d"),
				':user_id'		=>	$_SESSION["user_id"]
			)
		);
session_start();
session_destroy();
header("location:login.php");
?>
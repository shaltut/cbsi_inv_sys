<?php
//edit_profile.php

include('database_connection.php');

if(isset($_POST['user_name']))
{
	//If password isnt set, set everything but password. Else set everything
	if($_POST["user_new_password"] != '')
	{
		$query = "
			UPDATE user_details SET 
				user_name = '".$_POST["user_name"]."', 
				user_email = '".$_POST["user_email"]."', 
				user_cell = '".$_POST["user_cell"]."',
				user_password = '".password_hash($_POST["user_new_password"], PASSWORD_DEFAULT)."' 
				WHERE user_id = ".$_SESSION["user_id"]."
		";
		$_SESSION['user_name'] = $_POST['user_name'];
	}else{
		$query = "
			UPDATE user_details SET 
				user_email = '".$_POST["user_email"]."',
				user_name = '".$_POST["user_name"]."',
				user_cell = '".$_POST["user_cell"]."'
			WHERE user_id = '".$_SESSION["user_id"]."'
			";
		$_SESSION['user_name'] = $_POST['user_name'];
	}

	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();

	//Output alert
	if(isset($result))
	{
		echo '<div class="alert alert-success">Details Updated Successfully!</div>';
	}
}
?>
<?php
//edit_profile.php

include('database_connection.php');

if(isset($_POST['user_name']))
{
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
	}else{
		$query = "
			UPDATE user_details SET 
				user_email = '".$_POST["user_email"]."',
				user_name = '".$_POST["user_name"]."',
				user_cell = '".$_POST["user_cell"]."'
			WHERE user_id = '".$_SESSION["user_id"]."'
			";
	}

	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	if(isset($result))
	{
		$ses_name = $_SESSION['user_name'];
		$ses_email = $_SESSION['user_email'];
		$ses_cell = $_SESSION['user_cell'];

		//Beginning of the output
		if($_POST['user_name'] != $ses_name OR $_POST['user_email'] != $ses_email OR $_POST['user_cell'] != $ses_cell OR $_POST["user_new_password"] != ''){
			$output = '<div class="alert alert-success">Successfully updated account information:<ul>';
		}else{
			$output = '<div class="alert alert-warning">No Fields Were Changed, Nothing Edited.<ul>';
		}
		//Executes if the user's name was changed
		if($_POST['user_name'] != $ses_name){
			/*
				Resets the user's username for the current session to whatever they entered in the 'name' field. 

		 		Changing this here means the user doesnt have to log out, and log back in to see the changes they've made.
		 	*/
			$_SESSION['user_name'] = $_POST['user_name'];
			$output .= '<li> Name</li>';
			

		}
		// //Executes if the user's email was changed
		if($_POST['user_email'] != $ses_email){
			
		/* 		
			Resets the user_email for the current session to whatever they entered in the 'email' field. 

	 		Changing this here means the user doesnt have to log out, and log back in to see the changes they've made.
		*/
			$_SESSION['user_email'] = $_POST['user_email'];
			$output .= '<li> Email Address</li>';

		}
		//Executes if the user's cell was changed
		if($_POST['user_cell'] != $ses_cell){
			/*
				Resets the user_cell for the current session to whatever they entered in the 'name' field. 

				Changing this here means the user doesnt have to log out, and log back in to see the changes they've made.
			*/
			$_SESSION['user_cell'] = $_POST['user_cell'];
			$output .= '<li> Phone Number</li>';

		}

		//Executes if the user's name was changed
		if($_POST["user_new_password"] != ''){
			$output .= '<li> Password</li>';
		}

		//Closes the alert div (End of output)
		$output .= '</ul></div>';

		//Echos the output to the profile.php page
		echo $output;
	}


















}
?>
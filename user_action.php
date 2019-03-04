<?php

//user_action.php

/*
		Users are sent here after clicking a button or doing some action (like
	adding a user) on user.php. Below is the php, javascript, and SQL commands 
 	called whenever someone performs one of those actions.
*/

include('database_connection.php');

if(isset($_POST['btn_action']))
{
	//	**********	Add button pressed	********** 
	if($_POST['btn_action'] == 'Add')
	{
		$query = "
		INSERT INTO user_details (user_email, user_password, user_name, user_type, user_status) 
		VALUES (:user_email, :user_password, :user_name, :user_type, :user_status)
		";	
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':user_email'		=>	$_POST["user_email"],
				':user_password'	=>	password_hash($_POST["user_password"], PASSWORD_DEFAULT),
				':user_name'		=>	$_POST["user_name"],
				':user_type'		=>	'user',
				':user_status'		=>	'active'
			)
		);

		//Verifying that the database was updated successfully
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'New User Added';
		}
	}
	if($_POST['btn_action'] == 'fetch_single')
	{
		$query = "
		SELECT * FROM user_details WHERE user_id = :user_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':user_id'	=>	$_POST["user_id"]
			)
		);

		//Verifying that the database was updated successfully
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['user_email'] = $row['user_email'];
			$output['user_name'] = $row['user_name'];
		}
		echo json_encode($output);
	}

	//	**********	Update button pressed (for any user ac)	********** 
	if($_POST['btn_action'] == 'Edit')
	{
		if($_POST['user_password'] != '')
		{
			$query = "
			UPDATE user_details SET 
				user_name = '".$_POST["user_name"]."', 
				user_email = '".$_POST["user_email"]."',
				user_password = '".password_hash($_POST["user_password"], PASSWORD_DEFAULT)."' 
				WHERE user_id = '".$_POST["user_id"]."'
			";
		}
		else
		{
			$query = "
			UPDATE user_details SET 
				user_name = '".$_POST["user_name"]."', 
				user_email = '".$_POST["user_email"]."'
				WHERE user_id = '".$_POST["user_id"]."'
			";
		}
		$statement = $connect->prepare($query);
		$statement->execute();

		//Verifying that the database was updated successfully
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'User Details Edited';
		}
	}

	//	**********	Delete button pressed (for any user ac) ********** 
	if($_POST['btn_action'] == 'delete')
	{

		$status = 'Active';
		if($_POST['status'] == 'Active')
		{
			$status = 'Inactive';
		}
		$query = "
		UPDATE user_details 
		SET user_status = :user_status 
		WHERE user_id = :user_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':user_status'	=>	$status,
				':user_id'		=>	$_POST["user_id"]
			)
		);	

		//Verifying that the database was updated successfully
		$result = $statement->fetchAll();	
		if(isset($result))
		{
			echo 'User Status change to ' . $status;
		}
	}
}

?>
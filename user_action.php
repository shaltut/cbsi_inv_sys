<?php
//Includes all the functions in the functions.php page
include('function.php');

/*  PAGE:   user_action.php
*   INFO:   This page is used to complete an action after the user submits 
*           a form, clicks a button, or performs some other action. 
*
*   ACTIONS:
*       	Add:	Triggered when the add user form is submitted. It inserts a new row in the user_details table
*              					containing the form field data submitted by the user. (adds the user data as a row in the user_details table)
*          
*	fetch_single:	Triggered when the user selects an "Update" button (table button). It returns the data to pre-populate the user 
*							form so the user can see the current database fields while updating them.
*
*			Edit:	Triggered when the user submits the update form. It takes all the current form field values and updates the database
*							values to match.
*                   
*    	 disable:	Triggered when the user clicks the toggle button (table button). It toggles the given user's user_status
*							value in the database. (If user_status = 'active' then changes status to 'inactive' and vica versa)   
*					Also triggers another block which is used to set and reset the date that a given user was set to inactive. 
*					This date field is used for tracking the date that a user's account was deactivated   
*                   
*/
include('database_connection.php');
if(isset($_POST['btn_action']))
{
	//	**********	Add button pressed	********** 
	if($_POST['btn_action'] == 'Add')
	{
		$query = "
			INSERT INTO user_details (user_email, user_password, user_name, user_cell, user_job, user_type, user_status) 
			VALUES (:user_email, :user_password, :user_name, :user_cell, :user_job, :user_type, :user_status)
		";	
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':user_email'		=>	$_POST["user_email"],
				':user_password'	=>	password_hash($_POST["user_password"], PASSWORD_DEFAULT),
				':user_name'		=>	$_POST["user_name"],
				':user_cell'		=>	$_POST["user_cell"],
				':user_job'			=>	$_POST["user_job"],
				':user_type'		=>	$_POST["user_type"],
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

	//When the 'Update' button is pressed, this function sends data to the modal to display whatever current data is saved for each option
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

		//	Grabbing relevent data from the selected row to send via JSON back to the user.php page
		$result = $statement->fetchAll();
		foreach($result as $row)
		{

			$output['user_email'] = $row['user_email'];
			$output['user_name'] = $row['user_name'];
			$output['user_cell'] = $row['user_cell'];
			$output['user_type'] = $row['user_type'];
			$output['user_job'] = $row['user_job'];
			$output['ia_date'] = $row['ia_date'];
		}
		echo json_encode($output);
	}

	//********** VIEW BUTTON (Details Column)**********
	if($_POST['btn_action'] == 'user_details')
	{
		$query = "
		SELECT * FROM user_details
		WHERE user_id = '".$_POST["user_id"]."'
		";

		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$id = $row["user_id"];
			$email = $row["user_email"];
			$name = $row["user_name"];
			$cell = $row["user_cell"];
			$job = $row["user_job"];
			$type = $row["user_type"];
			$status = $row["user_status"];
			$date = $row["ia_date"];

			if($type == 'master'){
				$type = 'Full Access';
			}else{
				$type = 'Limited Access';
			}

			if($status == 'Active')
			{
				$status = '<span class="label label-success">Active</span>';
			}else{
				$status = '<span class="label label-danger">Inactive</span>';
			}

			if($date != null){
				//MySql Date conversion
				$time = strtotime($date);
				$date = date("F jS, Y", $time);

				$output .= '
					<div class="alert alert-danger" style="
						text-align:center;
						font-weight:bold;
						font-size:1.2em;
					">
						Account Deactivated On '.$date.'
					</div>';
			}

			//	Title which includes name and job-title
			$output .= '
				<div style="
					text-align:center;
					font-weight:bold;
					border:1px solid black;
				">
					<div style="font-size:1.5em">'.$name.'</div>
					<div style="font-size:1em;">'.$job.'</div>
				</div>';

			//	CBSI AMS Account Type Output
			$output .= '
				<div style="
					float:left;
					font-weight:bold;
					font-size:1.3em;
					padding-top: 5px;
					width:50%;
				">
					Account Type:
					<span class="text-info">'.$type.'</span>
				</div>';

			//Status Output
			$output .= '
			<div style="
				float:right;
				text-align:right;
				font-weight:bold;
				font-size:1.3em;
				padding-top: 5px;
				width:50%;
			">
			'.$status.'
			</div>
			';

			$output .= '<hr/>';

			//	Employee Contact Information Output
			$output .= '
			<div class="table-responsive" style="margin-top:20px">
				<table class="table table-bordered" style="text-align:center;">
				<tr>
					<th colspan="2"  style="
						text-align:center;
						font-weight:bold;
						font-size:1.3em;
						margin-top:10px;
					">
						Contact Information
					</th>
				</tr>
				<tr>
					<th style="width:220px;text-align:center">Phone Number</th>
					<th style="width:220px;text-align:center">Email Address</th>
				</tr>
				<tr>
					<td>'.$cell.'</td>
					<td>'.$email.'</td>
				</tr>
				</table>
			</div>
			';

			
			//Grabs a table of all equipment the user has checked out
			if( num_checkouts_by_id($connect, $id) == 0){
				$output .= '<div class="text-success" style="text-align:center;font-weight:bold;font-size:1.3em;">No Items Currently Checked Out!</div>';
			}else{
				$output .= "<br/>";
				$output .= table_checkouts_by_id($connect, $id);
			}
		}


		
		echo $output;
	}

	//	**********	Update button pressed (for any user ac)	********** 
	if($_POST['btn_action'] == 'Edit')
	{
		if($_POST['user_password'] != '')
		{
			$query = "
			UPDATE user_details SET 
				user_email = '".$_POST["user_email"]."',
				user_password = '".password_hash($_POST["user_password"], PASSWORD_DEFAULT)."', 
				user_name = '".$_POST["user_name"]."',
				user_cell = '".$_POST["user_cell"]."', 
				user_job = '".$_POST["user_job"]."',
				user_type = '".$_POST["user_type"]."'
			WHERE user_id = '".$_POST["user_id"]."'
			";
		}else{
			$query = "
			UPDATE user_details SET 
				user_email = '".$_POST["user_email"]."',
				user_name = '".$_POST["user_name"]."',
				user_cell = '".$_POST["user_cell"]."', 
				user_job = '".$_POST["user_job"]."',
				user_type = '".$_POST["user_type"]."'
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

	//	**********	Deactivate button pressed (for any user) ********** 
	if($_POST['btn_action'] == 'disable')
	{

		$status = 'Active';
		if($_POST['status'] == 'Active')
		{
			$status = 'Inactive';
		}
		$query = "
			UPDATE user_details 
			SET user_status = :user_status 
			WHERE user_id = :user_id;
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
	//********* Also sets the ia_date to null if made active ********* 
	if($_POST['btn_action'] == 'disable')
	{
		$status = $_POST['status'];
		if($status == 'Inactive'){
			$query = "
				UPDATE user_details
				SET ia_date = NULL
				WHERE user_id = :user_id
			";
			$statement = $connect->prepare($query);
			$statement->execute(
				array(
					':user_id'	=>	$_POST['user_id'],
				)
			);
		}else{
			$query = "
				UPDATE user_details
				SET ia_date = :ia_date
				WHERE user_id = :user_id
			";
			$statement = $connect->prepare($query);
			$statement->execute(
				array(
					':user_id'	=>	$_POST['user_id'],
					':ia_date'	=>	date('Y-m-d')
				)
			);
		}

		$result = $statement->fetchAll();
		if(isset($result)){
			foreach($result as $row)
			{
				echo ' date changed. ';
			}
		}
	}
	
}
?>
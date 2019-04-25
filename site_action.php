<?php
/*  PAGE:   site_action.php
*   INFO:   This page is used to complete an action after the user submits 
*           a form, clicks a button, or performs some other action. 
*   ACTIONS:
*       	 Add:	Triggered when the add site form is submitted. It inserts a new row in the sites table
*              					containing the form field data submitted by the user. (adds the site data as a row in the sites table)
*
*	site_details:	Triggered when "View" button is clicked (table button). It returns the table with all the info about 
*      							the selected job-site inside the view modal.      
*     
*	fetch_single:	Triggered when the user selects an "Update" button (table button). It returns the data to pre-populate the site
*							form so the user can see the current database fields while updating them.
*
*			Edit:	Triggered when the user submits the update form. It takes all the current form field values and updates the database
*							values to match.
*                   
*  		  delete:	Triggered when the user clicks the toggle button (table button). It toggles the given site's site_status
*							value in the database. (If site_status = 'active' then changes status to 'inactive' and vica versa)	
*/
include('database_connection.php');
// include('function.php');

if(isset($_POST['btn_action']))
{
	//********** ADD BUTTON **********
	if($_POST['btn_action'] == 'Add')
	{
		$query = "
		INSERT INTO sites (site_name, site_address, job_desc, start_date, site_status) 
		VALUES (:site_name, :site_address, :job_desc, :start_date, :site_status)
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':site_name'			=>	$_POST['site_name'],
				':site_address'			=>	$_POST['site_address'],
				':job_desc'				=>	$_POST['job_desc'],
				':start_date'			=> 	date('Y-m-d', strtotime($_POST['start_date'])),
				':site_status'			=>	'active'
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Site Added';

			
		}
	}

	//********** VIEW BUTTON (Details Column)**********
	if($_POST['btn_action'] == 'site_details')
	{
		$query = "
		SELECT * FROM sites 
		WHERE site_id = '".$_POST["site_id"]."'
		";

		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$name = $row['site_name'];
			$address = $row['site_address'];
			$job = $row['job_desc'];
			//MySql Date conversion
			$time = strtotime($row['start_date']); $startdate = date("F jS, Y", $time);
			$status = $row['site_status'];

			if($status == 'active')
			{
				$status = '<span class="label label-success">Active</span>';
			}else{
				$status = '<span class="label label-danger">Inactive</span>';
			}

			//Heading and Site Name Output
			$output .= '
				<div style="
					text-align:center;
					font-weight:bold;
					border:1px solid black;
				">
					<div style="font-size:1.4em">'.$name.'</div>
					<div style="font-size:1em;">'.$address.'</div>
				</div>';

			//Start Date Output
			$output .= '
				<div style="
					float:left;
					font-weight:bold;
					font-size:1.3em;
					padding-top: 5px;
					width:50%;
				">
					Start Date:
					<span class="text-info">'.$startdate.'</span>
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
					display:block;
				">
					<span class="text-success" style="margin-right:10px;">'.$status.'</span>
				</div>';

			$output .= '<hr/>';
			//Description Output
			if($job != '' && $job != Null){
				$output .= '
				<br/>
				<div style="
					text-align:center;
					font-weight:bold;
					font-size:1.3em;
				">
					Job Description
				</div>
				<div style="
					padding-left:30px;
					padding-right:30px;
					text-align:center;
				">
					'.$job.'
				</div>
				';
			}
			
		}
		echo $output;
	}

	//When the 'Update' button is pressed, this function sends data to the modal to display whatever current data is saved for each option
	if($_POST['btn_action'] == 'fetch_single')
	{
		$query = "
		SELECT * FROM sites WHERE site_id = :site_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':site_id'	=>	$_POST["site_id"]
			)
		);
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['site_name'] = $row['site_name'];
			$output['site_address'] = $row['site_address'];
			$output['job_desc'] = $row['job_desc'];
			$output['start_date'] = $row['start_date'];
		}
		echo json_encode($output);
	}

	//********** EDIT BUTTON **********
	if($_POST['btn_action'] == 'Edit')
	{
		$query = "
		UPDATE sites 
		set 
		site_name = :site_name,
		site_address = :site_address,
		job_desc = :job_desc, 
		start_date = :start_date
		WHERE site_id = :site_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':site_name'		=>	$_POST['site_name'],
				':site_address'		=>	$_POST['site_address'],
				':job_desc'			=>	$_POST['job_desc'],
				':start_date' 		=> 	date('Y-m-d', strtotime($_POST['start_date'])),
				':site_id'			=>	$_POST['site_id']
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Site Details Edited';
		}
	}
 
	//********** DELETE BUTTON **********
	if($_POST['btn_action'] == 'delete')
	{
		$status = 'active';
		if($_POST['status'] == 'active')
		{
			$status = 'inactive';
		}
		$query = "
		UPDATE sites 
		SET site_status = :site_status 
		WHERE site_id = :site_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':site_status'	=>	$status,
				':site_id'		=>	$_POST["site_id"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Site status change to ' . $status;
		}
	}
}
?>
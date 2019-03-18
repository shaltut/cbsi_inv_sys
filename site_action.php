<?php

//site_action.php

include('database_connection.php');

include('function.php');


if(isset($_POST['btn_action']))
{
	//********** ADD BUTTON **********
	if($_POST['btn_action'] == 'Add')
	{
		$query = "
		INSERT INTO sites (site_name, job_desc, start_date, site_status) 
		VALUES (:site_name, :job_desc, :start_date, :site_status)
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':site_name'			=>	$_POST['site_name'],
				':job_desc'				=>	$_POST['job_desc'],
				':start_date'			=> 	date('Y-m-d', strtotime($_POST['start_date'])),
				':site_status'			=>	'active'
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Product Added ('
			.$_POST['site_name'].', '
			.$_POST['job_desc'].', '
			.$_POST['start_date'].', '
			;

			
		}
	}

	//********** VIEW BUTTON (Details Column)**********
	if($_POST['btn_action'] == 'product_details')
	{

		$query = "
		SELECT * FROM sites 
		WHERE site_id = '".$_POST["site_id"]."'
		";

		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		$output = '
		<div class="table-responsive">
			<table class="table table-boredered">
		';
		foreach($result as $row)
		{
			$status = '';
			if($row['site_status'] == 'active')
			{
				$status = '<span class="label label-success">Active</span>';
			}
			else
			{
				$status = '<span class="label label-danger">Inactive</span>';
			}

			$output .= '
			<tr>
				<td>Site Name</td>
				<td>'.$row["site_name"].'</td>
			</tr>
			<tr>
				<td>Job Description</td>
				<td>'.$row["job_desc"].'</td>
			</tr>
			<tr>
				<td>Start Date</td>
				<td>'.$row["start_date"].'</td>
			</tr>
			<tr>
				<td>Status</td>
				<td>'.$status.'</td>
			</tr>
			';
		}

		$output .= '
			</table>
		</div>
		';
		echo $output;
	}


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
			$output['job_desc'] = $row['job_desc'];
			$output['equip_cost'] = $row['equip_cost'];
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
		job_desc = :job_desc, 
		start_date = :start_date
		WHERE site_id = :site_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':site_name'			=>	$_POST['site_name'],
				':job_desc'				=>	$_POST['job_desc'],
				':start_date' 			=> 	$_POST['start_date']
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Product Details Edited ('
			.$_POST['site_name'].', '
			.$_POST['job_desc'].', '
			.$_POST['start_date'].''
			;
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
			echo 'Product status change to ' . $status;
		}
	}
}


?>
<?php

//equipment_action.php

include('database_connection.php');

include('function.php');


if(isset($_POST['btn_action']))
{
	//********** ADD BUTTON **********
	if($_POST['btn_action'] == 'Add')
	{
		$query = "
		INSERT INTO equipment (equip_name, equip_desc, is_maintenance_required, maintain_every, last_maintained, equip_cost, equip_entered_by, equip_status, date_added) 
		VALUES (:equip_name, :equip_desc, :is_maintenance_required, :maintain_every, :last_maintained, :equip_cost, :equip_entered_by, :equip_status, :date_added)
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':equip_name'				=>	$_POST['equip_name'],
				':equip_desc'				=>	$_POST['equip_desc'],
				':is_maintenance_required'	=>	$_POST['is_maintenance_required'],
				':maintain_every'			=>	$_POST['maintain_every'],
				':last_maintained'			=> 	date('Y-m-d',strtotime($_POST['last_maintained'])),
				':equip_cost'				=>	$_POST['equip_cost'],
				':equip_entered_by'			=>	$_SESSION["user_id"],
				':equip_status'				=>	'active',
				':date_added'				=>	date("Y-m-d")
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Equipment Added';

			
		}
	}

	//********** VIEW BUTTON (Details Column)**********
	if($_POST['btn_action'] == 'equipment_details')
	{

		$query = "
		SELECT * FROM equipment 
		INNER JOIN user_details ON user_details.user_id = equipment.equip_entered_by 
		WHERE equipment.equip_id = '".$_POST["equip_id"]."'
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
			if($row['equip_status'] == 'active')
			{
				$status = '<span class="label label-success">Active</span>';
			}
			else
			{
				$status = '<span class="label label-danger">Inactive</span>';
			}
			
			$entered_by_user = ucfirst(get_user_name($connect, $row['user_id']));


			$output .= '
			<tr>
				<td>Equipment Name</td>
				<td>'.$row["equip_name"].'</td>
			</tr>';

			if($row['equip_desc'] == ''){
				$output .= '
				<tr>
					<td>Equipment Description</td>
					<td>(no description)</td>
				</tr>
				';
			}else{
				$output .= '
				<tr>
					<td>Equipment Description</td>
					<td>'.$row["equip_desc"].'</td>
				</tr>
				';
			}
			if($row['is_maintenance_required'] == 'yes'){
				$output .= '
					<tr>
						<td>Maintain Every</td>
						<td>'.$row["maintain_every"].' Months</td>
					
					</tr>
					<tr>
						<td>Last Maintained</td>
						<td>'.$row["last_maintained"].'</td>
					</tr>
				';
			}
			if($row['equip_cost'] > 0.00){
				$output .= '
				<tr>
					<td>Base Price</td>
					<td>'.$row["equip_cost"].'</td>
				</tr>';
			}else{
				$output .= '
				<tr>
					<td>Base Price</td>
					<td> (Price Unknown) </td>
				</tr>';
			}
			$output .= '
			<tr>
				<td>Entered Into System By</td>
				<td>'.$entered_by_user.' on '.$row["date_added"].'</td>
			</tr>';
			$output .= '
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

	//When the 'Update' button is pressed, this function sends data to the modal to display whatever current data is saved for each option
	if($_POST['btn_action'] == 'fetch_single')
	{
		$query = "
		SELECT * 
		FROM equipment 
		WHERE equip_id = :equip_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':equip_id'	=>	$_POST["equip_id"]
			)
		);
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['equip_name'] = $row['equip_name'];
			$output['equip_desc'] = $row['equip_desc'];
			$output['equip_cost'] = $row['equip_cost'];
			$output['is_maintenance_required'] = $row['is_maintenance_required'];
			$output['maintain_every'] = $row['maintain_every'];
			$output['last_maintained'] = $row['last_maintained'];
		}
		echo json_encode($output);
	}

	//When the 'Edit' button inside the 'update' modal is pressed, this function changes the old data values with the newly edited ones sent from the form.
	if($_POST['btn_action'] == 'Edit')
	{
		$query = "
		UPDATE equipment 
		set 
		equip_name = :equip_name,
		equip_desc = :equip_desc, 
		equip_cost = :equip_cost,
		is_maintenance_required = :is_maintenance_required,
		maintain_every = :maintain_every,
		last_maintained = :last_maintained
		WHERE equip_id = :equip_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':equip_name'				=>	$_POST['equip_name'],
				':equip_desc'				=>	$_POST['equip_desc'],
				':equip_cost'				=>	$_POST['equip_cost'],
				':is_maintenance_required'	=>	$_POST['is_maintenance_required'],
				':maintain_every'			=>	$_POST['maintain_every'],
				':last_maintained'			=>	$_POST['last_maintained'],
				':equip_id'					=>	$_POST['equip_id']
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Equipment Details Edited';
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
		UPDATE equipment 
		SET equip_status = :equip_status 
		WHERE equip_id = :equip_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':equip_status'	=>	$status,
				':equip_id'		=>	$_POST["equip_id"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Equipment status change to ' . $status;
		}
	}
}
?>
<?php

//equipment_action.php

include('database_connection.php');

include('function.php');


if(isset($_POST['btn_action']))
{
	//********** ADD BUTTON **********
	if($_POST['btn_action'] == 'Add')
	{
		/*
			Ensures that equipment that doesnt require maintenance gets null values in the database for the expected fields.
		*/
		if($_POST['is_maintenance_required'] == 'no'){
			$last_maintained = Null;
			$maintain_every = Null;
		}else{
			$last_maintained = $_POST['last_maintained'];
			$maintain_every = $_POST['maintain_every'];
		}

		/*
			Ensures that equipment that is not broken gets null values in the database for the expected fields.
		*/
		if($_POST['is_broken'] == 'no'){
			$broken_desc = Null;
		}else{
			$broken_desc = $_POST['broken_desc'];
		}

		/*
			Ensures that if a serial number isnt assigned, it is entered into the DB as a NULL value.
		*/
		if($_POST['equip_serial'] == ''){
			$serial = null;
		}else{
			$serial = $_POST['equip_serial'];
		}

		$query = "
		INSERT INTO equipment (equip_name, equip_serial, equip_desc, is_maintenance_required, maintain_every, last_maintained, is_broken, broken_desc, equip_cost, equip_entered_by, equip_status, date_added) 
		VALUES (:equip_name, :equip_serial, :equip_desc, :is_maintenance_required, :maintain_every, :last_maintained, :is_broken, :broken_desc, :equip_cost, :equip_entered_by, :equip_status, :date_added)
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':equip_name'				=>	$_POST['equip_name'],
				':equip_serial'				=>	$serial,
				':equip_desc'				=>	$_POST['equip_desc'],
				':is_maintenance_required'	=>	$_POST['is_maintenance_required'],
				':maintain_every'			=>	$maintain_every,
				':last_maintained'			=> 	$last_maintained,
				':is_broken'				=> 	$_POST['is_broken'],
				':broken_desc'				=> 	$broken_desc,
				':equip_cost'				=>	$_POST['equip_cost'],
				':equip_entered_by'			=>	$_SESSION["user_id"],
				':equip_status'				=>	'active',
				':date_added'				=>	date("Y-m-d")
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo ''.last_equipment_added_id($connect);
			
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
			<table class="table">
		';
		foreach($result as $row)
		{
			$entered_by_user = ucfirst(get_user_name($connect, $row['user_id']));

			//MySql Date conversion
			$time = strtotime($row['last_maintained']);
			$lastMaintained = date("F jS, Y", $time);

			//MySql Date conversion
			$time = strtotime($row['date_added']);
			$dateAdded = date("F jS, Y", $time);

			$status = '';
			if($row['equip_status'] == 'active')
			{
				$status = '<span class="label label-success">Active</span>';
			}else{
				$status = '<span class="label label-danger">Inactive</span>';
			}


			//Equipment Name Output
			$output .= '
			<thead>
				<th style="width:190px;text-align:right">Name:</th>
				<th style="font-weight:normal">'.$row["equip_name"].'</th>
			</thead>';

			//Serial Number Output
			if($row['equip_serial'] != NULL){
				$output .= '
				<tr>
					<td style="text-align:right;font-weight:bold">Serial Number:</td>
					<td>'.$row["equip_serial"].'</td>
				</tr>';
			}

			//Cost Output
			if($row['equip_cost'] != 0.00){
				$output .= '
				<tr>
					<td style="text-align:right;font-weight:bold">Base Price:</td>
					<td> $'.$row['equip_cost'].' </td>
				</tr>';
			}

			//Description Output
			if($row['equip_desc'] != ''){
				$output .= '
				<tr>
					<td style="text-align:right;font-weight:bold">Equipment Description:</td>
					<td>'.$row["equip_desc"].'</td>
				</tr>
				';
			}

			if($row['is_maintenance_required'] == 'yes'){
				$output .= '
					<tr>
						<td style="text-align:right;font-weight:bold">Maintain Every:</td>
						<td>'.$row["maintain_every"].' Months</td>
					
					</tr>
					<tr>
						<td style="text-align:right;font-weight:bold">Last Maintained:</td>
						<td>'.$lastMaintained.'</td>
					</tr>
				';
			}

			// Entered-by Output
			$output .= '
			<tr>
				<td style="text-align:right;font-weight:bold">Entered Into System:</td>
				<td>'.$entered_by_user.' on '.$dateAdded.'</td>
			</tr>';

			// Equipment Status Output
			$output .= '
			<tr>
				<td style="text-align:right;font-weight:bold">Status:</td>
				<td>'.$status.'</td>
			</tr>
			';

			//Availability Output
			if($row['is_available'] == 'available'){
				$output .= '
				<tr>
					<td style="text-align:right;font-weight:bold">Availability:</td>
					<td>
						<span class="text-success glyphicon glyphicon-ok"></span>
						Available for Checkout
					</td>
				</tr>
				';
			}else{
				$output .= '
				<tr>
					<td style="text-align:right;font-weight:bold">Availability:</td>
					<td>
						<span class="text-danger glyphicon glyphicon-remove"></span>
						In Use
					</td>
				</tr>
				';
			}

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
			$output['equip_serial'] = $row['equip_serial'];
			$output['equip_desc'] = $row['equip_desc'];
			$output['is_maintenance_required'] = $row['is_maintenance_required'];
			$output['maintain_every'] = $row['maintain_every'];
			$output['last_maintained'] = $row['last_maintained'];
			$output['is_broken'] = $row['is_broken'];
			$output['broken_desc'] = $row['broken_desc'];
			$output['equip_cost'] = $row['equip_cost'];
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
		equip_serial = :equip_serial,
		equip_desc = :equip_desc, 
		equip_cost = :equip_cost,
		is_maintenance_required = :is_maintenance_required,
		maintain_every = :maintain_every,
		last_maintained = :last_maintained,
		is_broken = :is_broken,
		broken_desc = :broken_desc
		WHERE equip_id = :equip_id
		";

		/*
			Ensures that equipment that doesnt require maintenance gets null values in the database for the expected fields.
		*/
		if($_POST['is_maintenance_required'] == 'no'){
			$last_maintained = Null;
			$maintain_every = Null;
		}else{
			$last_maintained = $_POST['last_maintained'];
			$maintain_every = $_POST['maintain_every'];
		}

		if($_POST['is_broken'] == 'no'){
			$broken_desc = Null;
		}else{
			$broken_desc = $_POST['broken_desc'];
		}


		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':equip_name'				=>	$_POST['equip_name'],
				':equip_serial'				=>	$_POST['equip_serial'],
				':equip_desc'				=>	$_POST['equip_desc'],
				':equip_cost'				=>	$_POST['equip_cost'],
				':is_maintenance_required'	=>	$_POST['is_maintenance_required'],
				':maintain_every'			=>	$maintain_every,
				':last_maintained'			=>	$last_maintained,
				':is_broken'				=>	$_POST['is_broken'],
				':broken_desc'				=>	$broken_desc,
				':equip_id'					=>	$_POST['equip_id']
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			// echo 'Equipment Details Edited';
			echo $_POST['is_broken'].', DESC: '.$broken_desc;
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
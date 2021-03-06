<?php
/*  PAGE:   maintain_action.php
*   INFO:   This page is used to complete an action after the user submits 
*           a form, clicks a button, or performs some other action. 
*   ACTIONS:
*       equipment_details:	Triggered when the 'View' button is clicked (table button). It displaysa all the info about the given
*							piece of equipment. 
*       					
*            fetch_single: 	Triggered when the 'Update' button is clicked. It takes the values that the user entered into the form 
*							and sets those values to match in the database.  
*                   		
*					 Edit:	Triggered when the user submits the update form. It takes all the current form field values and updates the database
*							values to match.
*                   
*                   Today:	Triggered when the user clicks the 'Auto-Reset' button (table button). It automatically resets the equipment's is_broken,
*							or is_maintenance_required values to their standard values ('no'). If the equipment is past its maintenance date, it sets 
*							the last_maintained date to the current system date. If is_broken is true, then it sets broken_desc to NULL.
*                   
*/
include('database_connection.php');
include('function.php');

if(isset($_POST['btn_action']))
{
	//********** VIEW BUTTON (Details Column)**********
	if($_POST['btn_action'] == 'equipment_details')
	{

		$query = "
		SELECT * FROM equipment 
		WHERE equipment.equip_id = '".$_POST["equip_id"]."'
		";

		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			//MySql Date conversion
			$time = strtotime($row['last_maintained']);
			$date = date("F jS, Y", $time);

			//Triggered if the equipment just needs maintenance
			if(check_equip_maintenance_month($connect, $row['equip_id']) == 'red'){
				$output = '
				<div style="text-align:center;font-weight:bold;font-size:1.3em;">Equipment Maintenance Info</div>
				<div class="table-responsive">
					<table class="table table-bordered" style="text-align:center">
					<tr>
						<th style="width:220px;text-align:center">Requires Maintenance Every</th>
						<th style="width:220px;text-align:center">Last Maintained On</th>
					</tr>
					<tr>
						<td>'.$row['maintain_every'].' Months</td>
						<td>'.$date.'</td>
					</tr>
					</table>
				</div>
				';
			}
			//Triggered if the equipment is actually broken
			if($row['is_broken'] == 'yes'){
				if($row['broken_desc'] != ''){
					$output = '
					<div style="text-align:center;font-weight:bold;font-size:1.3em;">Problem Description:</div>
					<div style="text-align:center;width:100%;padding-top:10px">'.$row['broken_desc'].'</div>
					';
				}else{
					$output = '
					<div style="text-align:center;">No description was given for the problem...</div>
					';
				}
			}
		}
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
			$output['maintain_every'] = $row['maintain_every'];
			$output['last_maintained'] = date('Y-m-d');
		}
		echo json_encode($output);
	}

	//********** EDIT BUTTON **********
	if($_POST['btn_action'] == 'Edit')
	{
		$query = "
		UPDATE equipment 
		set 
		maintain_every = :maintain_every,
		last_maintained = :last_maintained
		WHERE equip_id = :equip_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':maintain_every'	=>	$_POST['maintain_every'],
				':last_maintained'	=>	$_POST['last_maintained'],
				':equip_id'			=>	$_POST['equip_id']
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Equipment Details Edited';
		}
	}

	if($_POST['btn_action'] == 'Today')
	{
		$color = check_equip_maintenance_month($connect, $_POST['equip_id']);
		if($color == 'red'){

			$query = "
			UPDATE equipment 
			SET
			last_maintained = :last_maintained
			WHERE equip_id = :equip_id
			";

			$statement = $connect->prepare($query);
			$statement->execute(
				array(
					':last_maintained'	=>	date('Y-m-d'),
					':equip_id'			=>	$_POST['equip_id']
				)
			);
			$result = $statement->fetchAll();
			if(isset($result))
			{
				echo 'Item #'+$_POST['equip_id']+' was fixed';
			}
		}else{

			$query = "
			UPDATE equipment 
			SET
			is_broken = :is_broken,
			broken_desc = :broken_desc
			WHERE equip_id = :equip_id
			";
			$statement = $connect->prepare($query);
			$statement->execute(
				array(
					':is_broken'	=>	'no',
					':broken_desc'	=>	 Null,
					':equip_id'		=>	$_POST['equip_id']
				)
			);
			$result = $statement->fetchAll();
			if(isset($result))
			{

				echo 'Item #'+$_POST['equip_id']+' was fixed';
			}

		}
	}
}
?>
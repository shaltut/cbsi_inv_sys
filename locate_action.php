<?php

//locate_action.php

include('database_connection.php');

include('function.php');


if(isset($_POST['btn_action']))
{

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
			</tr>
			<tr>
				<td>Equipment Description</td>
				<td>'.$row["equip_desc"].'</td>
			</tr>
			';
			$output .= '
			<tr>
				<td>Base Price</td>
				<td>'.$row["equip_cost"].'</td>
			</tr>
			<tr>
				<td>Entered Into System By</td>
				<td>'.$entered_by_user.' on '.$row["date_added"].'</td>
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

	//When the 'Update' button is pressed, this function sends data to the modal to display whatever current data is saved for each option
	if($_POST['btn_action'] == 'fetch_single')
	{

		$last_chk = get_last_checkout_id($connect, $_POST['equip_id']);
		$query = "
		SELECT * 
		FROM equipment_checkout
		WHERE chk_id = :chk_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':chk_id'	=>	$last_chk
			)
		);
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['last_loc'] = $row['site_id'];
			$output['last_chk'] = $row['empl_id'];
			$output['last_date'] = $row['chk_date_time'];
			// $output['equip_cost'] = $row['equip_cost'];
			// $output['is_maintenance_required'] = $row['is_maintenance_required'];
			// $output['maintain_every'] = $row['maintain_every'];
			// $output['last_maintained'] = $row['last_maintained'];
		}
		echo json_encode($output);
	}
}
?>
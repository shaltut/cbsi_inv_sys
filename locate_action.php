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
			//MySql Date conversion
			$time = strtotime($row['date_added']);
			$dateAdded = date("F jS, Y", $time);

			$status = '';
			if($row['equip_status'] == 'active'){
				$status = '<span class="label label-success">Active</span>';
			}else{
				$status = '<span class="label label-danger">Inactive</span>';
			}
			
			$entered_by_user = ucfirst(get_user_name($connect, $row['user_id']));


			$output .= '
			<tr>
				<td>Equipment Name</td>
				<td>'.$row["equip_name"].'</td>
			</tr>
			';

			if($row['equip_desc'] != ''){
				$output .= '
				<tr>
					<td>Equipment Description</td>
					<td>'.$row["equip_desc"].'</td>
				</tr>
				';
			}else{
				$output .= '
				<tr>
					<td>Equipment Description</td>
					<td>(no description)</td>
				</tr>
				';
			}

			//COST only seen by master users
			if($_SESSION['type'] == 'master'){
				if($row['equip_cost'] > 0.00){
					$output .= '
					<tr>
						<td>Base Price</td>
						<td>$'.$row["equip_cost"].'</td>
					</tr>
					';
				}else{
					$output .= '
					<tr>
						<td>Base Price</td>
						<td> (unknown) </td>
					</tr>
					';
				}
			}

			$output .= '
			<tr>
				<td>Entered Into System By</td>
				<td>'.$entered_by_user.' on '.$dateAdded.'</td>
			</tr>';

			if($row['is_available'] == 'available'){
				$output .= '
				<tr>
					<td>Availability</td>
					<td>
						<span class="text-success glyphicon glyphicon-ok"></span>
						Item Is Available for Checkout
					</td>
				</tr>
				';
			}else{
				$output .= '
				<tr>
					<td>Availability</td>
					<td>
						<span class="text-danger glyphicon glyphicon-remove"></span>
						Item Currently In Use
					</td>
				</tr>
				';
			}

			$output .='
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
		JOIN user_details ON equipment_checkout.empl_id = user_details.user_id
		WHERE chk_id = :chk_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':chk_id'	=>	$last_chk
			)
		);
		$result = $statement->fetchAll();
		foreach($result as $row){
			if($row['site_id'] == '' && $row['empl_id'] == ''){
				$output['last_loc'] = '(Unknown)';
				$output['last_chk'] = '(Unknown)';
				$output['last_date'] = '(Unknown)';
				$output['message'] = false;
			}else{
				$site = get_site_name_by_id($connect, $row['site_id']);
				$usr = get_empl_name_by_id($connect, $row['empl_id']);
				$output['last_loc'] = $site.' (ID: '.$row['site_id'].')';
				$output['last_chk'] = $usr.' ('.$row['user_email'].')';
				$output['last_date'] = $row['chk_date_time'];
				$output['message'] = true;
			}
		}
		echo json_encode($output);
	}
}












?>
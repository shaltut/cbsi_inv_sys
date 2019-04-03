<?php
//search_action.php

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
			$output .= '
			<tr>
				<td>Status</td>
				<td>'.$row['is_available'].'</td>
			</tr>
			';
		}

		$output .= '
			</table>
		</div>
		';
		echo $output;
	}
}
?>
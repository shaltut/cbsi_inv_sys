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
		INSERT INTO equipment (equip_name, equip_desc, maintain_every,  equip_cost, equip_entered_by, equip_status, date_added) 
		VALUES ( :equip_name, :equip_desc, :maintain_every, :equip_cost, :equip_entered_by, :equip_status, :date_added)
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':equip_name'		=>	$_POST['equip_name'],
				':equip_desc'		=>	$_POST['equip_desc'],
				':maintain_every'	=>	$_POST['maintain_every'],
				':equip_cost'		=>	$_POST['equip_cost'],
				':equip_entered_by'	=>	$_SESSION["equip_id"],
				':equip_status'		=>	'active',
				':date_added'		=>	date("Y-m-d")
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Product Added';
		}
	}

	//********** DETAILS BUTTON **********
	if($_POST['btn_action'] == 'product_details')
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
			if($row['product_status'] == 'active')
			{
				$status = '<span class="label label-success">Active</span>';
			}
			else
			{
				$status = '<span class="label label-danger">Inactive</span>';
			}
			$output .= '
			<tr>
				<td>Product Name</td>
				<td>'.$row["equip_name"].'</td>
			</tr>
			<tr>
				<td>Product Description</td>
				<td>'.$row["equip_desc"].'</td>
			</tr>
			<tr>
				<td>Available Quantity</td>
				<td>'.$row["maintain_every"].'</td>
			</tr>
			<tr>
				<td>Base Price</td>
				<td>'.$row["equip_cost"].'</td>
			</tr>
			<tr>
				<td>Entered Into System By</td>
				<td>'.'Employee ID: '.$row["equip_entered_by"].
					' ('.$row["date_added"].')'.'</td>
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
		SELECT * FROM equipment WHERE equip_id = :equip_id
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
			$output['maintain_every'] = $row['maintain_every'];
			$output['equip_cost'] = $row['equip_cost'];
		}
		echo json_encode($output);
	}

	//********** EDIT BUTTON **********
	if($_POST['btn_action'] == 'Edit')
	{
		$query = "
		UPDATE equipment 
		set 
		equip_name = :equip_name,
		equip_desc = :equip_desc, 
		maintain_every = :maintain_every,
		equip_cost = :equip_cost
		WHERE equip_id = :equip_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':equip_name'			=>	$_POST['equip_name'],
				':equip_desc'	=>	$_POST['equip_desc'],
				':maintain_every'		=>	$_POST['maintain_every'],
				':equip_cost'	=>	$_POST['equip_cost'],
				':equip_id'			=>	$_POST['equip_id']
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Product Details Edited';
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
			echo 'Product status change to ' . $status;
		}
	}
}


?>
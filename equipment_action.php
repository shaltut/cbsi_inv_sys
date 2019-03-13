<?php

//equipment_action.php

include('database_connection.php');

include('function.php');


if(isset($_POST['btn_action']))
{

	if($_POST['btn_action'] == 'Add')
	{
		$query = "
		INSERT INTO product (product_name, product_description, product_quantity,  product_base_price, product_enter_by, product_status, product_date) 
		VALUES ( :product_name, :product_description, :product_quantity, :product_base_price, :product_enter_by, :product_status, :product_date)
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':product_name'			=>	$_POST['product_name'],
				':product_description'	=>	$_POST['product_description'],
				':product_quantity'		=>	$_POST['product_quantity'],
				':product_base_price'	=>	$_POST['product_base_price'],
				':product_enter_by'		=>	$_SESSION["user_id"],
				':product_status'		=>	'active',
				':product_date'			=>	date("Y-m-d")
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Product Added';
		}
	}

	if($_POST['btn_action'] == 'product_details')
	{

		$query = "
		SELECT * FROM product 
		INNER JOIN user_details ON user_details.user_id = product.product_enter_by 
		WHERE product.product_id = '".$_POST["product_id"]."'
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
				<td>'.$row["product_name"].'</td>
			</tr>
			<tr>
				<td>Product Description</td>
				<td>'.$row["product_description"].'</td>
			</tr>
			<tr>
				<td>Available Quantity</td>
				<td>'.$row["product_quantity"].'</td>
			</tr>
			<tr>
				<td>Base Price</td>
				<td>'.$row["product_base_price"].'</td>
			</tr>
			<tr>
				<td>Entered Into System By</td>
				<td>'.'Employee ID: '.$row["product_enter_by"].
					' ('.$row["product_date"].')'.'</td>
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
		SELECT * FROM product WHERE product_id = :product_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':product_id'	=>	$_POST["product_id"]
			)
		);
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			// $output['category_id'] = $row['category_id'];
			$output['product_name'] = $row['product_name'];
			$output['product_description'] = $row['product_description'];
			$output['product_quantity'] = $row['product_quantity'];
			// $output['product_unit'] = $row['product_unit'];

			$output['product_base_price'] = $row['product_base_price'];
			// $output['product_tax'] = $row['product_tax'];
		}
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'Edit')
	{
		$query = "
		UPDATE product 
		set 
		product_name = :product_name,
		product_description = :product_description, 
		product_quantity = :product_quantity,
		product_base_price = :product_base_price
		WHERE product_id = :product_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':product_name'			=>	$_POST['product_name'],
				':product_description'	=>	$_POST['product_description'],
				':product_quantity'		=>	$_POST['product_quantity'],
				':product_base_price'	=>	$_POST['product_base_price'],
				':product_id'			=>	$_POST['product_id']
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Product Details Edited';
		}
	}
	if($_POST['btn_action'] == 'delete')
	{
		$status = 'active';
		if($_POST['status'] == 'active')
		{
			$status = 'inactive';
		}
		$query = "
		UPDATE product 
		SET product_status = :product_status 
		WHERE product_id = :product_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':product_status'	=>	$status,
				':product_id'		=>	$_POST["product_id"]
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
<?php
//function.php

function sites_options($connect)
{
	$query = "
		SELECT site_id, site_name
		FROM sites
	";
	$output = '<option>Select a Site:</option>';
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	if(!isset($result)){
		$output = '
			<option> No Sites Listed!</option>
		';
	}else{
		foreach($result as $row)
		{
			$output .= '
			<option value="'.$row['site_id'].'">'.$row['site_name'].'</option>
			';
		}
	}  
	return $output;
}

/*
	Returns the number of pieces of equipment that are currently checked out
*/
function count_check_out_total($connect){
	$query = "
	SELECT * 
	FROM equipment_checkout
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}

/*
	Returns TRUE if the given piece of equipment is available, and FALSE if it is unavailable
*/
function check_equip_availability($connect, $equip_id){
	$query = "
	SELECT *
	FROM equipment
	WHERE equip_id = '".$equip_id."'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = 'The ID you have entered does not exist!';
	foreach($result as $row)
	{

		if($row['equip_id'] == $equip_id){

			if($row['is_available'] == 'available'){

				$data = true;

			}else{

				$data = false;

			}

		}

	}
	return $data;
}


/*
	returns the number of pieces of equipment that are currently checked out by a given user
*/
function count_check_out_user($connect, $user_id){
	$query = "
	SELECT * 
	FROM equipment_checkout
	WHERE empl_id = '".$user_id."'
	";
	$statement = $connect->prepare($query);
	$statement->execute();

	return $statement->rowCount();
}

/*
Should return total items currently needing maintenance, need to discuss how this will return items that currently need maintenance and not items in general that will require maintenace (In 6 months for example)

function count_maintenance_needed($connect){
	$query = "
	SELECT is_maintenance_required 
	FROM equipment
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$count=0
	foreach($result as $row)
	{
		if($bool = 'yes'){
			return 'checked';
			$count++
		}
	}
	return $count
}
*/

/*
Check site_status if active or inactive and returns the count

function count_active_site($connect){
	$query = "
	SELECT site_status 
	FROM sites
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$count=0
	foreach($result as $row)
	{
		if($site_status = 'active'){
			$count++
		}
	}
	return $count
}

function count_inactive_site($connect){
	$query = "
	SELECT site_status 
	FROM sites
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$count=0
	foreach($result as $row)
	{
		if($site_status = 'inactive'){
			$count++
		}
	}
	return $count
}
*/


/*
	Returns a string that tells the system, and the user, if the given piece of equipment is currently available.
*/
function check_equip_id_exists($connect, $equip_id){
	$query = "
	SELECT equip_id, equip_status
	FROM equipment 
	WHERE equip_id = '".$equip_id."' AND equip_status = 'active'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = 'The ID you have entered does not exist!';
	foreach($result as $row)
	{

		if($row['equip_id'] == $equip_id){

			if($row['equip_status'] == 'inactive'){

				$data = 'This item is currently unavailable';

			}else{

				$data = 'yes';

			}

		}

	}
	return $data;
}

/* 
	This function returns a user_name from the user_details table given any valid user_id from the user_details table.
*/
function get_user_name($connect, $user_id)
{
	$query = "
	SELECT user_name FROM user_details WHERE user_id = '".$user_id."'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return $row['user_name'];
	}
}

/*
	Checks if a given piece of equipment requires maintenance
*/
function check_is_maintenance_required($connect, $equip_id){
	$query = "
	SELECT is_maintenance_required FROM equipment WHERE equip_id = '".$equip_id."'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$bool = '';
	foreach($result as $row)
	{
		$bool = $row['is_maintenance_required'];
	}

	if($bool = 'yes'){
		return 'checked';
	}else{
		return '';
	}
}

/* 
	Returns an option value to be placed in a form for an individual piece of equipment. 

	This isnt really used anymore in the system, but might be used later.
*/
function fill_product_list($connect)
{
	$query = "
	SELECT * FROM equipment 
	WHERE equip_status = 'active' 
	ORDER BY equip_name ASC
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<option value="'.$row["equip_id"].'">'.$row["equip_name"].'</option>';
	}
	return $output;
}

/* 
	This function returns the equip_name, quantity, price, and tax from the equipment table.
*/
function fetch_product_details($equip_id, $connect)
{
	$query = "
	SELECT * FROM equipment 
	WHERE equip_id = '".$equip_id."'";

	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();

	foreach($result as $row)
	{
		$output['equip_name'] = $row["equip_name"];
		$output['quantity'] = $row["maintain_every"];
		$output['price'] = $row['equip_cost'];
	}
	return $output;
}

/* 
	This function is currently being used to display the "22" number on index.php

	It returns the number of items in inventory (adds up the "quantity" value for each equipment available)
*/
// function available_product_quantity($connect, $equip_id)
// {
// 	$product_data = fetch_product_details($equip_id, $connect);
// 	$query = "
// 	SELECT 	inventory_order_product.quantity 
// 	FROM inventory_order_product INNER JOIN inventory_order ON inventory_order.inventory_order_id = inventory_order_product.inventory_order_id
// 	WHERE inventory_order_product.equip_id = '".$equip_id."' AND
// 	inventory_order.inventory_order_status = 'active'
// 	";

// 	$statement = $connect->prepare($query);
// 	$statement->execute();
// 	$result = $statement->fetchAll();
// 	$total = 0;

// 	foreach($result as $row)
// 	{
// 		$total = $total + $row['maintain_every'];
// 	}
// 	$available_quantity = intval($product_data['maintain_every']) - intval($total);
// 	if($available_quantity == 0)
// 	{
// 		$update_query = "
// 		UPDATE equipment SET 
// 		equip_status = 'inactive' 
// 		WHERE equip_id = '".$equip_id."'
// 		";
// 		$statement = $connect->prepare($update_query);
// 		$statement->execute();
// 	}
// 	return $available_quantity;
// }

/*
	Returns the total number of pieces of equipment available (active) at the moment
*/
function count_equipment_total($connect){
	$query = "
	SELECT * 
	FROM equipment 
	WHERE equip_status = 'active'";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}

/*
	Returns the total number of (ACTIVE) users (Both MASTER and NON-MASTER) from the user_details table of the database.

	This count includes MASTER users (Admins)
*/
function count_total_user_active($connect)
{
	$query = "
	SELECT * FROM user_details WHERE user_status='active'";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}

/*
	Returns the total number of NON-MASTER users (active and inactive)

	This count includes MASTER users (Admins)
*/
function count_employee_total($connect)
{
	$query = "
	SELECT * FROM user_details WHERE user_type = 'user'";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}

/*
	Returns the number of ACTIVE NON-MASTER users
*/
function count_employee_active($connect)
{
	$query = "
	SELECT * FROM user_details WHERE user_type = 'user' AND user_status = 'active'";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}

/*
	Returns the number of ACTIVE MASTER users
*/
function count_master_active($connect)
{
	$query = "
	SELECT * FROM user_details WHERE user_type = 'master' AND user_status = 'active'";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}

/*
	Returns the total number of (ACTIVE) categories from the category table of the database.

	c
*/
// function count_total_category($connect)
// {
// 	$query = "
// 	SELECT * FROM category WHERE category_status='active'
// 	";
// 	$statement = $connect->prepare($query);
// 	$statement->execute();
// 	return $statement->rowCount();
// }

/*
	Returns the total number of (ACTIVE) equipment from the category table of the database.
*/
// function count_total_product($connect)
// {
// 	$query = "
// 	SELECT * FROM equipment WHERE equip_status='active'
// 	";
// 	$statement = $connect->prepare($query);
// 	$statement->execute();
// 	return $statement->rowCount();
// }

/* 
	This function is currently being used to display the "$32,107.35" number on index.php

	It returns the sum total of all money spent on inventory_order's that have an active status
*/
// function count_total_order_value($connect)
// {
// 	$query = "
// 	SELECT sum(inventory_order_total) as total_order_value FROM inventory_order 
// 	WHERE inventory_order_status='active'
// 	";
// 	if($_SESSION['type'] == 'user')
// 	{
// 		$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
// 	}
// 	$statement = $connect->prepare($query);
// 	$statement->execute();
// 	$result = $statement->fetchAll();
// 	foreach($result as $row)
// 	{
// 		return number_format($row['total_order_value'], 2);
// 	}
// }

/* 
	This function is currently being used to assist get_user_wise_total_order()

	It returns the number of inventory_order's that were paid for using 'cash'
*/
// function count_total_cash_order_value($connect)
// {
// 	$query = "
// 	SELECT sum(inventory_order_total) as total_order_value FROM inventory_order 
// 	WHERE payment_status = 'cash' 
// 	AND inventory_order_status='active'
// 	";
// 	if($_SESSION['type'] == 'user')
// 	{
// 		$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
// 	}
// 	$statement = $connect->prepare($query);
// 	$statement->execute();
// 	$result = $statement->fetchAll();
// 	foreach($result as $row)
// 	{
// 		return number_format($row['total_order_value'], 2);
// 	}
// }

/* 
	This function is currently being used to assist get_user_wise_total_order()

	It returns the number of inventory_order's that were paid for using 'credit'
*/
// function count_total_credit_order_value($connect)
// {
// 	$query = "
// 	SELECT sum(inventory_order_total) as total_order_value FROM inventory_order WHERE payment_status = 'credit' AND inventory_order_status='active'
// 	";
// 	if($_SESSION['type'] == 'user')
// 	{
// 		$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
// 	}
// 	$statement = $connect->prepare($query);
// 	$statement->execute();
// 	$result = $statement->fetchAll();
// 	foreach($result as $row)
// 	{
// 		return number_format($row['total_order_value'], 2);
// 	}
// }

/*
	Returns information on checkouts that took place on the current system date
*/
function get_checkouts_today($connect){
	$query = '
	SELECT user_details.user_id, user_details.user_name, equipment_checkout.equip_id, equipment.equip_name, equipment_checkout.chk_date_time
	FROM user_details
	INNER JOIN equipment_checkout ON equipment_checkout.empl_id = user_details.user_id
	INNER JOIN equipment ON equipment.equip_id = equipment_checkout.equip_id
	WHERE user_details.user_id = "'.$_SESSION['user_id'].'" AND
	equipment_checkout.chk_date_time = "'.date('Y-m-d').'"
	';
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '
	<div class="table-responsive">
		<table class="table table-bordered table-striped">
			<tr>
				<th style="width:110px;">Employee ID</th>
				<th>Name</th>
				<th>Equipment ID</th>
				<th>Equipment</th>
				<th>Date of Checkout</th>
			</tr>
	';
	foreach($result as $row)
	{
		$output .= '
		<tr>
			<td> '.$row["user_id"].'</td>
			<td> '.$row["user_name"].'</td>
			<td> '.$row["equip_id"].'</td>
			<td> '.$row["equip_name"].'</td>
			<td> '.$row["chk_date_time"].'</td>
		</tr>
		';
	}
	$output .= '
	</table>
	</div>
	';
	return $output;
}




























?>
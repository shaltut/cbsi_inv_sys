<?php
//function.php


/* 
	********** NEEDS WORK **********
	-Figure out what this function does and where it is used.

	-When you comment it out, and test the system, the equipment page (equipment.php) gets screwy... Might be a good place to start.
*/
function fill_category_list($connect)
{
	$query = "
	SELECT * FROM category 
	WHERE category_status = 'active' 
	ORDER BY category_name ASC
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<option value="'.$row["category_id"].'">'.$row["category_name"].'</option>';
	}
	return $output;
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
	********** NEEDS WORK **********
	- Figure out what this function does, and where it is used in the system.
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

	c
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
function available_product_quantity($connect, $equip_id)
{
	$product_data = fetch_product_details($equip_id, $connect);
	$query = "
	SELECT 	inventory_order_product.quantity 
	FROM inventory_order_product INNER JOIN inventory_order ON inventory_order.inventory_order_id = inventory_order_product.inventory_order_id
	WHERE inventory_order_product.equip_id = '".$equip_id."' AND
	inventory_order.inventory_order_status = 'active'
	";

	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$total = 0;

	foreach($result as $row)
	{
		$total = $total + $row['maintain_every'];
	}
	$available_quantity = intval($product_data['maintain_every']) - intval($total);
	if($available_quantity == 0)
	{
		$update_query = "
		UPDATE equipment SET 
		equip_status = 'inactive' 
		WHERE equip_id = '".$equip_id."'
		";
		$statement = $connect->prepare($update_query);
		$statement->execute();
	}
	return $available_quantity;
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
function count_user_total($connect)
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
// function count_user_active($connect)
// {
// 	$query = "
// 	SELECT * FROM user_details WHERE user_type = 'user' AND user_status = 'active'";
// 	$statement = $connect->prepare($query);
// 	$statement->execute();
// 	return $statement->rowCount();
// }

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
function count_total_category($connect)
{
	$query = "
	SELECT * FROM category WHERE category_status='active'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}

/*
	Returns the total number of (ACTIVE) equipment from the category table of the database.
*/
function count_total_product($connect)
{
	$query = "
	SELECT * FROM equipment WHERE equip_status='active'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}

/* 
	This function is currently being used to display the "$32,107.35" number on index.php

	It returns the sum total of all money spent on inventory_order's that have an active status
*/
function count_total_order_value($connect)
{
	$query = "
	SELECT sum(inventory_order_total) as total_order_value FROM inventory_order 
	WHERE inventory_order_status='active'
	";
	if($_SESSION['type'] == 'user')
	{
		$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	}
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return number_format($row['total_order_value'], 2);
	}
}

/* 
	This function is currently being used to assist get_user_wise_total_order()

	It returns the number of inventory_order's that were paid for using 'cash'
*/
function count_total_cash_order_value($connect)
{
	$query = "
	SELECT sum(inventory_order_total) as total_order_value FROM inventory_order 
	WHERE payment_status = 'cash' 
	AND inventory_order_status='active'
	";
	if($_SESSION['type'] == 'user')
	{
		$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	}
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return number_format($row['total_order_value'], 2);
	}
}

/* 
	This function is currently being used to assist get_user_wise_total_order()

	It returns the number of inventory_order's that were paid for using 'credit'
*/
function count_total_credit_order_value($connect)
{
	$query = "
	SELECT sum(inventory_order_total) as total_order_value FROM inventory_order WHERE payment_status = 'credit' AND inventory_order_status='active'
	";
	if($_SESSION['type'] == 'user')
	{
		$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	}
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return number_format($row['total_order_value'], 2);
	}
}

/*
Creates the table on Index.php that displays the "Total Order Value User Wise"

Calls the count_total_credit_order_value() function 
Calls the count_total_cash_order_value() function


********** CHANGES NEEDED **********
- needs to print out all pieces of equipment that are currently checked out by each user.
	--Something like:
		SELECT e.empl_id, e.empl_firstname||' '||e.empl_lastname as "empl_name", eq.equip_id, eq.equip_type, c.check_out_date_time
		FROM employees e INNER JOIN check_employee_equipment eq using (empl_id)
		JOIN equipment USING (equip_id)
		WHERE equip_status = 'checked out'

	-- Changes to be made to the database for this to be possible:

		- A "check_employee_equipment" table must be added to the DB:
			This table will be a bridge between the employees table and the 
			equipment table, and will hold information about check-outs, 
			including -> (check_id (PK), empl_id (FK), equip_id (FK), check_date_time)

		- The user_details table has to be changed to "employees"
			- Everywhere it says "user_%" in this table should be changed to "empl_%"

		- The product table has to be changed to "equipment"
			- Everywhere it says "product_%" in this table should be changed to "equip_%"

		- user_name (or "empl_name" after changed) in the user_details table (or "equipment" after changed) has to be split into "empl_firstname" and "empl_lastname"
		- The new equipment table must be modified to include an equip_type column
******************************************
*/
function get_user_wise_total_order($connect)
{
	$query = '
	SELECT sum(inventory_order.inventory_order_total) as order_total, 
	SUM(CASE WHEN inventory_order.payment_status = "cash" THEN inventory_order.inventory_order_total ELSE 0 END) AS cash_order_total, 
	SUM(CASE WHEN inventory_order.payment_status = "credit" THEN inventory_order.inventory_order_total ELSE 0 END) AS credit_order_total, 
	user_details.user_name 
	FROM inventory_order 
	INNER JOIN user_details ON user_details.user_id = inventory_order.user_id 
	WHERE inventory_order.inventory_order_status = "active" GROUP BY inventory_order.user_id
	';
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '
	<div class="table-responsive">
		<table class="table table-bordered table-striped">
			<tr>
				<th>User Name</th>
				<th>Total Order Value</th>
				<th>Total Cash Order</th>
				<th>Total Credit Order</th>
			</tr>
	';

	$total_order = 0;
	$total_cash_order = 0;
	$total_credit_order = 0;
	foreach($result as $row)
	{
		$output .= '
		<tr>
			<td>'.$row['user_name'].'</td>
			<td align="right">$ '.$row["order_total"].'</td>
			<td align="right">$ '.$row["cash_order_total"].'</td>
			<td align="right">$ '.$row["credit_order_total"].'</td>
		</tr>
		';

		$total_order = $total_order + $row["order_total"];
		$total_cash_order = $total_cash_order + $row["cash_order_total"];
		$total_credit_order = $total_credit_order + $row["credit_order_total"];
	}
	$output .= '
	<tr>
		<td align="right"><b>Total</b></td>
		<td align="right"><b>$ '.$total_order.'</b></td>
		<td align="right"><b>$ '.$total_cash_order.'</b></td>
		<td align="right"><b>$ '.$total_credit_order.'</b></td>
	</tr></table></div>
	';
	return $output;
}



?>
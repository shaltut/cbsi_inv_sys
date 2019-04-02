<?php
//function.php


function get_last_checkout_id($connect, $equip_id){
	$query = "
	SELECT *
	FROM equipment_checkout
	WHERE chk_date_time = (
		SELECT max(chk_date_time)
		FROM equipment_checkout
		WHERE equip_id = '".$equip_id."'
	) AND equip_id = '".$equip_id."'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	if(isset($result)){
		foreach($result as $row)
		{
			$output = $row['chk_id'];
		}
	}
	// return $count;
	return $output;
}

/*
	Returns data for the "Equipment Usage (Per-Site)" bar graph on stats.php#sites.
*/
function checkouts_by_site_names($connect){
	$output = '';
	$query = "
	SELECT sites.site_name as 'site', count(equipment_checkout.site_id) as 'checks'
	FROM sites INNER JOIN equipment_checkout ON sites.site_id = equipment_checkout.site_id
	GROUP BY sites.site_id
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$count = 0;
	$test = ' ';
	$result = $statement->fetchAll();
	if(isset($result)){
		foreach($result as $row)
		{
			$count = $count + 1;
			$output .= "'".$row['site']."',";
		}
	}
	// return $count;
	return $output;
}
/*
	Returns data for the "Equipment Usage (Per-Site)" bar graph on stats.php#sites.
*/
function checkouts_by_site_num_checkouts($connect){
	$output = '';
	$query = "
	SELECT sites.site_name as 'site', count(equipment_checkout.site_id) as 'checks'
	FROM sites INNER JOIN equipment_checkout ON sites.site_id = equipment_checkout.site_id
	GROUP BY sites.site_id
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$count = 0;
	$test = ' ';
	$result = $statement->fetchAll();
	if(isset($result)){
		foreach($result as $row)
		{
			$count = $count + 1;
			$output .= $row['checks'].",";
		}
	}
	// return $count;
	return $output;
}
/*
	Returns data for the "Equipment Usage (Per-Site)" bar graph on stats.php#sites.

	Limits checkouts returned to those checkouts that occured on the current system date.
*/
function checkouts_by_site_num_checkouts_today($connect){
	$output = '';
	$query = "
	SELECT sites.site_name as 'site', count(equipment_checkout.site_id) as 'checks'
	FROM sites INNER JOIN equipment_checkout ON sites.site_id = equipment_checkout.site_id
	WHERE equipment_checkout.chk_date_time = '".date('Y-m-d')."'
	GROUP BY sites.site_id
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$count = 0;
	$test = ' ';
	$result = $statement->fetchAll();
	if(isset($result)){
		foreach($result as $row)
		{
			$count = $count + 1;
			$output .= $row['checks'].",";
		}
	}
	// return $count;
	return $output;
}

/*
	Returns data for the "Equipment Usage (Per-Site)" bar graph on stats.php#sites.

	Limits checkouts returned to those checkouts that occured on the current system date.
*/
function checkouts_by_site_num_checkouts_week($connect){
	$output = '';
	$query = "
	SELECT sites.site_name as 'site', count(equipment_checkout.site_id) as 'checks'
	FROM sites INNER JOIN equipment_checkout ON sites.site_id = equipment_checkout.site_id
	WHERE equipment_checkout.chk_date_time BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE()
	GROUP BY sites.site_id
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$count = 0;
	$test = ' ';
	$result = $statement->fetchAll();
	if(isset($result)){
		foreach($result as $row)
		{
			$count = $count + 1;
			$output .= $row['checks'].",";
		}
	}
	// return $count;
	return $output;
}

/*
	Returns data for the "Equipment Usage (Per-Site)" bar graph on stats.php#sites.

	Limits checkouts returned to those checkouts that occured on the current system date.
*/
function checkouts_by_site_num_checkouts_month($connect){
	$output = '';
	$query = "
	SELECT sites.site_name as 'site', count(equipment_checkout.site_id) as 'checks'
	FROM sites INNER JOIN equipment_checkout ON sites.site_id = equipment_checkout.site_id
	WHERE equipment_checkout.chk_date_time BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()
	GROUP BY sites.site_id
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$count = 0;
	$test = ' ';
	$result = $statement->fetchAll();
	if(isset($result)){
		foreach($result as $row)
		{
			$count = $count + 1;
			$output .= $row['checks'].",";
		}
	}
	// return $count;
	return $output;
}

/*
	Returns data for the "Equipment Usage (Per-Site)" bar graph on stats.php#sites

	CHARTjs
*/
function checkouts_by_site($connect){
	$output = '';
	$query = "
	SELECT sites.site_name as 'site', count(equipment_checkout.site_id) as 'checks'
	FROM sites INNER JOIN equipment_checkout ON sites.site_id = equipment_checkout.site_id
	GROUP BY sites.site_id
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$count = 0;
	$test = ' ';
	$result = $statement->fetchAll();
	if(isset($result)){
		foreach($result as $row)
		{
			$count = $count + 1;
			$output .= '{ x: '.$count.', y: '.$row['checks'].', label: "'.$row['site'].'"},';
		}
	}
	// return $count;
	return $output;
}

/*Returns the number of pieces of equipment that currently require maintenance.
USED IN: equipment.php, stats.php
*/
function check_equip_maintenance($connect){
	$sysdate = date('Y-m-d');
	$query = "
	SELECT SYSDATE() as 'tday',last_maintained as 'lm', maintain_every as 'me' FROM equipment WHERE is_maintenance_required = 'yes' AND equip_status = 'active'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$count = 0;
	$test = ' ';
	$result = $statement->fetchAll();
	if(isset($result)){
		foreach($result as $row)
		{
			$today = $row['tday'];
			$last_m = $row['lm'];
			$m_every = $row['me'];

			$ts1 = strtotime($last_m);
			$ts2 = strtotime($today);

			$year1 = date('Y', $ts1);
			$year2 = date('Y', $ts2);

			$month1 = date('m', $ts1);
			$month2 = date('m', $ts2);

			$diff = (($year2 - $year1) * 12) + ($month2 - $month1);

			if($diff > $row['me'] ){
				$count = $count + 1;
			}
		}
	}
	// return $count;
	return $count;
}

//Returns every site_id and site_name in the form of a option HTML tag to be used in HTML forms.
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
	WHERE returned = 'false'
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
	WHERE empl_id = '".$user_id."' AND returned = 'false'
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


//Function to return number of active sites

function count_active_site($connect){
	$query = "
	SELECT site_status 
	FROM sites
	WHERE site_status = 'active'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$count=0;
	foreach($result as $row)
	{
			$count++;
		
	}
	return $count;
}

//Function to return number of inactive sites
function count_inactive_site($connect){
	$query = "
	SELECT site_status 
	FROM sites
	WHERE site_status = 'inactive'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$count=0;
	foreach($result as $row)
	{
			$count++;
	}
	return $count;
}



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
	Returns information on checkouts that took place on the current system date
*/
function get_checkouts_today($connect){
	$query = '
	SELECT user_details.user_id, user_details.user_name, equipment_checkout.equip_id, equipment.equip_name, equipment_checkout.chk_date_time, equipment_checkout.returned
	FROM user_details
	INNER JOIN equipment_checkout ON equipment_checkout.empl_id = user_details.user_id
	INNER JOIN equipment ON equipment.equip_id = equipment_checkout.equip_id
	WHERE equipment_checkout.chk_date_time = "'.date('Y-m-d').'"
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
				<th style="text-align:center;">Returned?</th>
			</tr>
	';
	foreach($result as $row)
	{
		if($row['returned'] == 'true'){
			$ret_val = '<span class="label label-success"><span class="glyphicon glyphicon-ok" style="text-size:1em;"></span></span>';
		}else{
			$ret_val = '<span class="label label-danger"><span class="glyphicon glyphicon-remove"></span></span>';
		}

		$output .= '
		<tr>
			<td style="text-align:center;"> '.$row["user_id"].'</td>
			<td> '.$row["user_name"].'</td>
			<td> '.$row["equip_id"].'</td>
			<td> '.$row["equip_name"].'</td>
			<td> '.$row["chk_date_time"].'</td>
			<td style="text-align:center;"> '.$ret_val.'</td>
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
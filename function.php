<?php
//function.php

/*	Returns the ID of the last piece of equipment added to the database
*	Used In:
*		- equipment_action.php
*/
function last_equipment_added_id($connect){
	$query = "
	SELECT max(equip_id) as 'eid' FROM equipment 
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$output = '';
	$result = $statement->fetchAll();
	if(isset($result)){
		foreach($result as $row)
		{
			$output = $row['eid'];
		}
	}
	return $output;

}

/*	Returns empl_name given empl_id
*	Used In:
*		- locate_action.php
*/
function get_empl_name_by_id($connect, $user_id){
	$output = '';
	$query = "
	SELECT user_name
	FROM user_details
	WHERE user_id = '".$user_id."'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	if(isset($result)){
		foreach($result as $row)
		{
			$output = $row['user_name'];
		}
	}
	// return $count;
	return $output;
}

/*	Returns site_name given site_id
*	Used In:
*		- locate_action.php
*/
function get_site_name_by_id($connect, $site_id){
	$query = "
	SELECT site_name
	FROM sites
	WHERE site_id = '".$site_id."'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	if(isset($result)){
		foreach($result as $row)
		{
			$output = $row['site_name'];
		}
	}
	// return $count;
	return $output;
}

/*	Returns site_name given site_id
*	Used In:
*		- locate_action.php
*/
function get_equip_name_by_id($connect, $equip_id){
	$query = "
	SELECT equip_name
	FROM equipment
	WHERE equip_id = '".$equip_id."'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	if(isset($result)){
		foreach($result as $row)
		{
			$output = $row['equip_name'];
		}
	}
	// return $count;
	return $output;
}

/*	Returns the last checkout id for any given piece of equipment
*	Used In:
*		- locate_action.php
*/
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

/*	Returns site_name given site_id
*	Used In:
*		- locate_action.php
*/
function num_checkouts_by_id($connect, $user_id){
	$query = "
	SELECT chk_id
	FROM equipment_checkout
	WHERE empl_id = '".$user_id."'
	AND returned = 'false'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$count = 0;
	if(isset($result)){
		foreach($result as $row)
		{
			$count = $count + 1;
		}
	}
	// return $count;
	return $count;
}

/*	Returns the number of items that are past their maintain by date
*	Used In:
*		- stats.php
*		- equipment.php
*/
function maintenance_red_num($connect){
	$count = 0;
	$query = "
	SELECT SYSDATE() as 'tday',last_maintained as 'lm', maintain_every as 'me' 
	FROM equipment 
	WHERE is_maintenance_required = 'yes' 
	AND equip_status = 'active' 
	";
	
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	if(isset($result)){
		foreach($result as $row)
		{
			$months = $row['me'];
			$last = $row['lm'];
			$today = $row['tday'];

			$maintain_by = date("Y-m-d", strtotime($months.' months', strtotime($last)));
			$maintain_warn = date("Y-m-d", strtotime('-1 months', strtotime($maintain_by)));

			if($today >= $maintain_by){
				$count = $count + 1;
			}
		}
		
	}
	return $count;
}

/*	Returns the number of items that are past their maintain by date
*	Used In:
*		- equipment.php
*/
function broken_num($connect){
	$count = 0;
	$query = "
	SELECT SYSDATE() as 'tday',last_maintained as 'lm', maintain_every as 'me' 
	FROM equipment 
	WHERE is_broken = 'yes' 
	AND equip_status = 'active' 
	";
	
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	if(isset($result)){
		foreach($result as $row)
		{
				$count = $count + 1;
		}
		
	}
	return $count;
}

/*	Returns the number of items that are past their maintain by date
*	Used In:
*		- equipment.php
*/
function maintenance_warning_num($connect){
	$count = 0;
	$query = "
	SELECT SYSDATE() as 'tday',last_maintained as 'lm', maintain_every as 'me' 
	FROM equipment 
	WHERE is_maintenance_required = 'yes' 
	AND equip_status = 'active' 
	";
	
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	if(isset($result)){
		foreach($result as $row)
		{
			$months = $row['me'];
			$last = $row['lm'];
			$today = $row['tday'];

			$maintain_by = date("Y-m-d", strtotime($months.' months', strtotime($last)));
			$maintain_warn = date("Y-m-d", strtotime('-1 months', strtotime($maintain_by)));

			if($today > $maintain_warn && $today < $maintain_by){
				$count = $count + 1;
			}
		}
		
	}
	return $count;
}

/*	Returns "good" if the given piece of equipment doesnt need maintenance, "yellow" if maintenance is needed in the next month, and "red" if maintenance is needed now.
*	Used In:
*		- chk_out_action.php
*		- equipment_fetch.php
*		- maintain_action.php
*		- maintain_fetch.php
*/
function check_equip_maintenance_month($connect, $equip_id){
	$ans = 'good';
	$query = "
	SELECT SYSDATE() as 'tday',last_maintained as 'lm', maintain_every as 'me' 
	FROM equipment 
	WHERE is_maintenance_required = 'yes' 
	AND equip_status = 'active' 
	AND equip_id = '".$equip_id."'
	";
	
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	if(isset($result)){
		foreach($result as $row)
		{
			$months = $row['me'];
			$last = $row['lm'];
			$today = $row['tday'];
			$maintain_by = date("Y-m-d", strtotime($months.' months', strtotime($last)));
			$maintain_warn = date("Y-m-d", strtotime('-1 months', strtotime($maintain_by)));
			if($today >= $maintain_by){
				$ans = 'red';
			}else if($today > $maintain_warn && $today < $maintain_by){
				$ans = 'yellow';
			}
		}
		
	}
	return $ans;
}

/*	Returns "good" if the given equipment's is_broken field value is 'no', or "red" if is_broken is'yes'
*	Used In:
*		- equiment_fetch.php
*/
function check_equip_broken($connect, $equip_id){
	$ans = 'good';
	$query = "
	SELECT is_broken 
	FROM equipment 
	WHERE equip_id = '".$equip_id."'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	if(isset($result)){
		foreach($result as $row){
			if($row['is_broken'] == 'yes'){
				$ans = 'red';
			}
		}
	}
	return $ans;
}

/*	Returns every site_id and site_name in the form of a option HTML tag to be used in HTML forms.
*	Used In:
*		- check.php
*/
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

/*	Returns the number of pieces of equipment that are currently checked out
*	Used In:
*		- index.php
*		- stats.php
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

/*	Returns TRUE if the given piece of equipment is available, and FALSE if it is unavailable
*	Used In:
*		- chk_out_action.php
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


/*	Returns the number of pieces of equipment that are currently checked out by a given user
*	Used In:
*		- index.php
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


/*	Returns a string that tells the system, and the user, if the given piece of equipment is currently available.
*	Used In:
*		- chk_out_action.php
*/
function check_equip_id_exists($connect, $equip_id){
	$query = "
	SELECT equip_id, equip_status
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
			if($row['equip_status'] == 'inactive'){
				$data = 'This item is currently unavailable, or undergoing maintenance. Please try again later.';
			}else{
				$data = 'yes';
			}
		}
	}
	return $data;
}

/* 	This function returns a user_name from the user_details table given any valid user_id from the user_details table.
*	Used In:
*		- maintain_action.php
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

/*	Returns information on all items that are currently checked out
*	Used In:
*		- index.php
*/
function table_checkouts($connect){
	$query = '
	SELECT user_details.user_id, user_details.user_name, equipment_checkout.equip_id, equipment.equip_name, equipment_checkout.chk_date_time, equipment_checkout.returned
	FROM user_details
	INNER JOIN equipment_checkout ON equipment_checkout.empl_id = user_details.user_id
	INNER JOIN equipment ON equipment.equip_id = equipment_checkout.equip_id
	WHERE equipment_checkout.returned = "false"
	';
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '
	<div class="table-responsive">
		<table class="table table-bordered table-striped" style="text-align:center;table-layout:fixed">
			<thead style="font-size:16px">
				<tr>
					<th style="text-align:center; vertical-align:center; padding:10px 5px; width:25%">Employee</th>
					<th style="text-align:center; vertical-align:center; padding:10px 5px;">Equipment</th>
					<th style="text-align:center; vertical-align:center; padding:10px 5px; width:25%">Date</th>
				</tr>
			</thead>
			<tbody style="font-size:12px">
	';
	foreach($result as $row)
	{
		//MySql Date conversion
		$time = strtotime($row['chk_date_time']);
		$chkDateTime = date("F jS, Y", $time);

		if($row['returned'] == 'true'){
			$ret_val = '<span class="label label-success"><span class="glyphicon glyphicon-ok" style="text-size:1em;"></span></span>';
		}else{
			$ret_val = '<span class="label label-danger"><span class="glyphicon glyphicon-remove"></span></span>';
		}

		$output .= '
				<tr>
					<td>'.$row["user_name"].'</br>(ID: '.$row["user_id"].')</td>
					<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"> '.$row["equip_name"].'</br>(ID: '.$row["equip_id"].')</td>
					<td> '.$chkDateTime.'</td>
				</tr>
			';
	}
	$output .= '
			</tbody>
		</table>
	</div>
	';
	return $output;
}

/*	Returns information on all items that are currently checked out
*	Used In:
*		- index.php
*/
function table_checkouts_user_wise($connect){
	$query = '
	SELECT user_details.user_id, user_details.user_name, equipment_checkout.equip_id, equipment.equip_name, equipment_checkout.chk_date_time, equipment_checkout.returned
	FROM user_details
	INNER JOIN equipment_checkout ON equipment_checkout.empl_id = user_details.user_id
	INNER JOIN equipment ON equipment.equip_id = equipment_checkout.equip_id
	WHERE equipment_checkout.returned = "false"
	AND equipment_checkout.empl_id = '.$_SESSION['user_id'].'
	OR equipment_checkout.chk_date_time = "'.date('Y-m-d').'"
	AND equipment_checkout.empl_id = "'.$_SESSION['user_id'].'"
	';
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '
	<div class="table-responsive">
		<table class="table table-bordered table-striped" style="text-align:center;table-layout:fixed">
			<thead>
				<tr>
					<th style="text-align:center; vertical-align:center; padding:10px 5px; width:20%; min-width:80px">ID</th>
					<th style="text-align:center; vertical-align:center; padding:10px 5px;">Name</th>
					<th style="text-align:center; vertical-align:center; padding:10px 5px; width:25%">Date</th>
					<th style="text-align:center; vertical-align:center; padding:10px 5px; width:78px;">Returned?</th>
				</tr>
			</thead>
			<tbody style="font-size:1.4em">
	';
	foreach($result as $row)
	{
		//MySql Date conversion
		$time = strtotime($row['chk_date_time']);
		$chkDateTime = date("M-d-y", $time);

		if($row['returned'] == 'true'){
			$ret_val = '<span class="label label-success"><span class="glyphicon glyphicon-ok"></span></span>';
		}else{
			$ret_val = '<span class="label label-danger"><span class="glyphicon glyphicon-remove"></span></span>';
		}
		$output .= '
				<tr>
					<td>'.$row["equip_id"].'</td>
					<td style="font-size:.7em;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"> '.$row["equip_name"].'</td>
					<td> '.$chkDateTime.'</td>
					<td>'.$ret_val.'</td>
				</tr>
		';
	}
	$output .= '
			</tbody>
		</table>
	</div>
	';
	return $output;
}

function table_checkouts_by_id($connect, $user_id){
	$query = "
	SELECT *
	FROM equipment_checkout
	WHERE empl_id = '".$user_id."'
	AND returned = 'false'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '
	<div class="text-warning" style="text-align:center;font-weight:bold;font-size:1.3em;">'.num_checkouts_by_id($connect, $user_id).' Item(s) Currently Checked Out</div>
	<div class="table-responsive">
		<table class="table table-bordered table-striped" style="text-align:center;table-layout:fixed">
			<thead style="font-size:16px">
				<tr>
					<th style="text-align:center; vertical-align:center; padding:10px 5px; width:25%">Equipment</th>
					<th style="text-align:center; vertical-align:center; padding:10px 5px; width:25%">Date</th>
				</tr>
			</thead>
			<tbody style="font-size:12px">
	';
	foreach($result as $row)
	{
		//MySql Date conversion
		$time = strtotime($row['chk_date_time']);
		$date = date("F jS, Y", $time);

		$output .= '
				<tr>
					<td>
						'.get_equip_name_by_id($connect, $row['equip_id']).'</br>(ID: '.$row["equip_id"].')
					</td>
					<td> '.$date.'</td>
				</tr>
			';
	}
	$output .= '
			</tbody>
		</table>
	</div>
	';
	return $output;
}


?>
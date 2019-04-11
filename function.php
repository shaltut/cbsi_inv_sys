<?php
//function.php

//For ChartJS output label (line graph)
function equip_monthly_checkouts_line_graph_labels($connect){
	$currentMonth = ltrim(date("m"),'0');
	$allMonths = array('Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
	$output = "'Jan',";
	for($i=0;$i<$currentMonth-1;$i++){
			if($i == ($currentMonth-2)){
				$output .= "'".$allMonths[$i]."'";
			}else{
				$output .= "'".$allMonths[$i]."',";
			}
	}

	return $output;
}

//For ChartJS data input (line graph)
function equip_monthly_checkouts_line_graph_data($connect){
	$query = "
	SELECT chk_date_time as 'date'
	FROM equipment_checkout
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$months = array(0,0,0,0,0,0,0,0,0,0,0,0,0);
	$output = '';
	$result = $statement->fetchAll();
	if(isset($result)){
		foreach($result as $row)
		{
			$curYear = date("Y");
			if(substr($row['date'],0,4) == strval($curYear)){
				$months[intval(substr($row['date'],5,2))] = $months[intval(substr($row['date'],5,2))]+1;
			}
		}
	}
	$output = $months[1].",".$months[2].",".$months[3].",".$months[4].",".$months[5].",".$months[6].",".$months[7].",".$months[8].",".$months[9].",".$months[10].",".$months[11].",".$months[12];
	// return $count;
	return $output;
}

//Returns the number of sites whoes site_name's contain 'DC', 'Washington', etc.
function total_sites_MD($connect){
	$query = "
	SELECT *
	FROM sites
	WHERE site_address LIKE '% MD %' OR site_address LIKE '% MD,%' OR site_address LIKE '% MD' OR site_address LIKE '% MARYLAND' OR site_address LIKE '% MARYLAND %' OR site_address LIKE '% MARYLAND,%'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}

//Returns the number of sites whoes site_name's contain 'DC', 'Washington', etc.
function total_sites_DC($connect){
	$query = "
	SELECT *
	FROM sites
	WHERE site_address LIKE '% DC %' OR site_address LIKE '% DC,%' OR site_address LIKE '% DC' OR site_address LIKE '% WASHINGTON' OR site_address LIKE '% WASHINGTON %' OR site_address LIKE '% WASHINGTON,%'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}

//Returns the number of sites whoes site_name's contain 'virginia', 'VA', etc.
function total_sites_VA($connect){
	$query = "
	SELECT *
	FROM sites
	WHERE site_address LIKE '% VA %' OR site_address LIKE '% VA,%' OR site_address LIKE '% VA' OR site_address LIKE '% VIRGINIA' OR site_address LIKE '% VIRGINIA %' OR site_address LIKE '% VIRGINIA,%'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}

//Returns the number of pieces of equipment that have a cost over 5000
function total_equipment_cost($connect){
	$query = "
	SELECT sum(equip_cost) as 'totalCost'
	FROM equipment
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$total = 0;
	$result = $statement->fetchAll();
	if(isset($result)){
		foreach($result as $row)
		{
			$total = $row['totalCost'];
		}
	}
	// return $total;
	return $total;
}

//Returns the number of pieces of equipment that have a cost over 5000
function equip_price_range_Over10000($connect){
	$query = "
	SELECT count(equipment.equip_cost) as 'countCost'
	FROM equipment
	WHERE equip_cost >= 10000
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$count = 0;
	$result = $statement->fetchAll();
	if(isset($result)){
		foreach($result as $row)
		{
			$count = $row['countCost'];
		}
	}
	// return $count;
	return $count;
}

//Returns the number of pieces of equipment that have a cost between 1001 and 2500
function equip_price_range_5000To9999($connect){
	$query = "
	SELECT count(equipment.equip_cost) as 'countCost'
	FROM equipment
	WHERE equip_cost BETWEEN 5000 AND 9999.99
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$count = 0;
	$result = $statement->fetchAll();
	if(isset($result)){
		foreach($result as $row)
		{
			$count = $row['countCost'];
		}
	}
	// return $count;
	return $count;
}

//Returns the number of pieces of equipment that have a cost between 501 and 1000
function equip_price_range_1000To4999($connect){
	$query = "
	SELECT count(equipment.equip_cost) as 'countCost'
	FROM equipment
	WHERE equip_cost BETWEEN 1000 AND 4999.99
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$count = 0;
	$result = $statement->fetchAll();
	if(isset($result)){
		foreach($result as $row)
		{
			$count = $row['countCost'];
		}
	}
	// return $count;
	return $count;
}

//Returns the number of pieces of equipment that have a cost between 101 and 500
function equip_price_range_100To999($connect){
	$query = "
	SELECT count(equipment.equip_cost) as 'countCost'
	FROM equipment
	WHERE equip_cost BETWEEN 100 AND 999.99
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$count = 0;
	$result = $statement->fetchAll();
	if(isset($result)){
		foreach($result as $row)
		{
			$count = $row['countCost'];
		}
	}
	// return $count;
	return $count;
}

//Returns the number of pieces of equipment that have a cost between 1 dollar and 100 dollars
function equip_price_range_Under100($connect){
	$query = "
	SELECT count(equipment.equip_cost) as 'countCost'
	FROM equipment
	WHERE equip_cost BETWEEN 1 AND 99.99
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$count = 0;
	$result = $statement->fetchAll();
	if(isset($result)){
		foreach($result as $row)
		{
			$count = $row['countCost'];
		}
	}
	// return $count;
	return $count;
}

//Returns the number of times the user checked out a piece of equipment
function user_wise_num_checkouts($connect, $user_id){
	$query = "
	SELECT count(equipment_checkout.empl_id) as 'checks'
	FROM equipment_checkout
	WHERE empl_id = '".$user_id."'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$count = 0;
	$result = $statement->fetchAll();
	if(isset($result)){
		foreach($result as $row)
		{
			$count = $row['checks'];
		}
	}
	// return $count;
	return $count;
}

//Returns the number of times the user returned a piece of equipment
function user_wise_num_checkins($connect, $user_id){
	$query = "
	SELECT count(equipment_checkout.empl_id) as 'checks'
	FROM equipment_checkout
	WHERE empl_id = '".$user_id."' AND returned = 'true'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$count = 0;
	$result = $statement->fetchAll();
	if(isset($result)){
		foreach($result as $row)
		{
			$count = $row['checks'];
		}
	}
	// return $count;
	return $count;
}

//Returns the number of times items were checked out
function num_checkouts($connect){
	$query = "
	SELECT count(equipment_checkout.chk_id) as 'checks'
	FROM equipment_checkout
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$count = 0;
	$result = $statement->fetchAll();
	if(isset($result)){
		foreach($result as $row)
		{
			$count = $row['checks'];
		}
	}
	// return $count;
	return $count;
}

//Returns the number of times items were returned
function num_returned($connect){
	$query = "
	SELECT count(equipment_checkout.chk_id) as 'checks'
	FROM equipment_checkout
	WHERE returned = 'true'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$count = 0;
	$result = $statement->fetchAll();
	if(isset($result)){
		foreach($result as $row)
		{
			$count = $row['checks'];
		}
	}
	// return $count;
	return $count;
}

function users_options($connect){
	$query = "
		SELECT user_id, user_name, user_status
		FROM user_details
		ORDER BY user_status
	";
	$output = '<option>Select Employee:</option>';
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	if(!isset($result)){
		$output = '
			<option> No Users Listed!</option>
		';
	}else{
		foreach($result as $row)
		{
			if($row['user_id'] == $_SESSION['user_id']){
				$output .= '
				<option value="'.$row['user_id'].'">
					My Account
				</option>
				';
			}else{
				if($row['user_status'] == 'Inactive'){
					$output .= '
					<option value="'.$row['user_id'].'">
						(Inactive) '.$row['user_name'].'
						(ID: '.$row['user_id'].') 
					</option>';
				}else{
					$output .= '
					<option value="'.$row['user_id'].'">
						'.$row['user_name'].' 
						(ID: '.$row['user_id'].') 
					</option>';
				}
			}
		}
	}  
	return $output;
}

//Returns empl_name given empl_id
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

//Returns sit_name given site_id
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
function checkouts_by_site_names_count($connect){
	$output = '';
	$query = "
	SELECT sites.site_name as 'site', count(equipment_checkout.site_id) as 'checks'
	FROM sites INNER JOIN equipment_checkout ON sites.site_id = equipment_checkout.site_id
	WHERE sites.site_status = 'active'
	GROUP BY sites.site_id
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	// return count;
	return $statement->rowCount();
}

//For ChartJS output label (bar graph for #sites... "Checkouts By Site")
function checkouts_by_site_names($connect){
	$output = '';
	$query = "
	SELECT sites.site_name as 'site', count(equipment_checkout.site_id) as 'checks'
	FROM sites INNER JOIN equipment_checkout ON sites.site_id = equipment_checkout.site_id
	WHERE sites.site_status = 'active'
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
			$string = explode(" ", $row['site']);
			$numTitles = checkouts_by_site_names_count($connect);
			if($numTitles >= 1 && $numTitles <= 2){
				if(strtoupper($string[0]) == "THE" && count($string) > 1){
						$output .= "'".$string[1]."',";
				}else{
						$output .= "'".$string[0]."',";
				}

			}elseif($numTitles >= 3 && $numTitles <= 4){
				if(strtoupper($string[0]) == "THE" && count($string) > 1){
					if(strlen($string[1]) > 8){
						$output .= "'".substr($string[1],0,8)."..',";
					}else{
						$output .= "'".$string[1]."',";
					}
				}else{
					if(strlen($string[0]) > 8){
						$output .= "'".substr($string[0],0,8)."..',";
					}else{
						$output .= "'".$string[0]."',";
					}
				}

			}elseif($numTitles >= 5 && $numTitles <= 6){
				if(strtoupper($string[0]) == "THE" && count($string) > 1){
					if(strlen($string[1]) > 4){
						$output .= "'".substr($string[1],0,4)."..',";
					}else{
						$output .= "'".$string[1]."',";
					}
				}else{
					if(strlen($string[0]) > 4){
						$output .= "'".substr($string[0],0,4)."..',";
					}else{
						$output .= "'".$string[0]."',";
					}
				}
			}elseif($numTitles > 7){
				if(strtoupper($string[0]) == "THE" && count($string) > 1){
					if(strlen($string[1]) > 4){
						$output .= "'".substr($string[1],0,2)."..',";
					}else{
						$output .= "'".$string[1]."',";
					}
				}else{
					if(strlen($string[0]) > 4){
						$output .= "'".substr($string[0],0,4)."..',";
					}else{
						$output .= "'".$string[0]."',";
					}
				}
			}
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
	$count = 0;
	$siteNum = count_active_site($connect);
	$query = "
	SELECT sites.site_name as 'site', count(equipment_checkout.site_id) as 'checks'
	FROM sites INNER JOIN equipment_checkout ON sites.site_id = equipment_checkout.site_id
	WHERE equipment_checkout.chk_date_time = '".date('Y-m-d')."'
	GROUP BY sites.site_id
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	if(isset($result)){
		foreach($result as $row)
		{
			$count = $count + 1;
			$output .= $row['checks'].",";
		}
		$siteNum = $siteNum - $count;
		$test = 0;
		for($i = 0; $i < $siteNum; $i++){
			if($i != 4){
				$output .= '0,';
			}else{
				$output .= '0';
			}
		}
	}
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

/*
	Returns the number of items that are past their maintain by date
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

/*
	Returns the number of items that are past their maintain by date
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

/*
	Returns output for the maintenance required error warning
*/
function maintenance_warning($connect){
	$output = 0;
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
				$ans = 'red';
			}else if($today > $maintain_warn && $today < $maintain_by){
				$ans = 'yellow';
			}
		}
		
	}
	return $output;
}

/*

STILL DEBUGGING

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
	SELECT * 
	FROM user_details 
	WHERE user_type = 'user'";
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
	SELECT * 
	FROM user_details 
	WHERE user_type = 'user' 
	AND user_status = 'active'";
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
	Returns information on all items that are currently checked out
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
	';
	foreach($result as $row)
	{
		if($row['returned'] == 'true'){
			$ret_val = '<span class="label label-success"><span class="glyphicon glyphicon-ok" style="text-size:1em;"></span></span>';
		}else{
			$ret_val = '<span class="label label-danger"><span class="glyphicon glyphicon-remove"></span></span>';
		}

		$output .= '
		<tbody style="font-size:12px">
			<tr>
				<td>'.$row["user_name"].'</br>(ID: '.$row["user_id"].')</td>
				<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"> '.$row["equip_name"].'</br>(ID: '.$row["equip_id"].')</td>
				<td> '.$row["chk_date_time"].'</td>
			</tr>
		</tbody>
		';
	}
	$output .= '
	</table>
	</div>
	';
	return $output;
}

/*
	Returns the number of checkouts that took place on the current system date
*/
function num_checkout_today($connect){
	$count = 0;
	$query = '
	SELECT count(chk_id) as "chks"
	FROM equipment_checkout
	WHERE chk_date_time = "'.date('Y-m-d').'"
	';
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$count = $row['chks'];
	}
	return $count;

}

/*
	Returns information on checkouts that took place on the current system date
*/
function table_checkouts_today($connect){
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
		<table class="table table-bordered table-striped" style="text-align:center; table-layout:fixed">
			<thead style="font-size:16px">
				<tr>
					<th style="text-align:center; vertical-align:center; padding:10px 5px; width:25%">Employee</th>
					<th style="text-align:center; vertical-align:center; padding:10px 5px;">Equipment</th>
					<th style="text-align:center; vertical-align:center; padding:10px 5px; width:25%">Returned</th>
				</tr>
			</thead>
	';
	foreach($result as $row)
	{
		if($row['returned'] == 'true'){
			$ret_val = '<span class="label label-success"><span class="glyphicon glyphicon-ok" style="text-size:1em;"></span></span>';
		}else{
			$ret_val = '<span class="label label-danger"><span class="glyphicon glyphicon-remove"></span></span>';
		}

		$output .= '
		<tbody style="font-size:12px">
			<tr>
				<td>'.$row["user_name"].'</br>(ID: '.$row["user_id"].')</td>
				<td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"> '.$row["equip_name"].'</br>(ID: '.$row["equip_id"].')</td>
				<td> '.$ret_val.'</td>
			</tr>
		</tbody>
		';
	}
	$output .= '
	</table>
	</div>
	';
	return $output;
}


/*
	Returns information on all items that are currently checked out
*/
function table_checkouts_user_wise($connect){
	$query = '
	SELECT user_details.user_id, user_details.user_name, equipment_checkout.equip_id, equipment.equip_name, equipment_checkout.chk_date_time, equipment_checkout.returned
	FROM user_details
	INNER JOIN equipment_checkout ON equipment_checkout.empl_id = user_details.user_id
	INNER JOIN equipment ON equipment.equip_id = equipment_checkout.equip_id
	WHERE equipment_checkout.returned = "false"
	AND equipment_checkout.empl_id = "'.$_SESSION['user_id'].'"
	';
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '
	<div class="table-responsive">
		<table class="table table-bordered table-striped" style="text-align:center;table-layout:fixed">
			<thead style="font-size:16px">
				<tr>
					<th style="text-align:center; vertical-align:center; padding:10px 5px; width:25%">ID</th>
					<th style="text-align:center; vertical-align:center; padding:10px 5px;">Name</th>
					<th style="text-align:center; vertical-align:center; padding:10px 5px; width:25%">Date Checked Out</th>
					<th style="text-align:center; vertical-align:center; padding:10px 5px; width:25%">Returned?</th>
				</tr>
			</thead>
			<tbody style="font-size:1.4em">
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
					<td>'.$row["equip_id"].'</td>
					<td style="font-size:.7em;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"> '.$row["equip_name"].'</td>
					<td> '.$row["chk_date_time"].'</td>
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


























?>
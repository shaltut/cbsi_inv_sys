<?php
/*	Returns the number of checkouts per site
*	Used In:
*		- the checkouts_by_site_names($connect) function
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

/*	For ChartJS output label (bar graph for #sites... "Checkouts By Site")
*	Used In:
*		- Charts_js.php
*/
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

/*	Returns data for the "Equipment Usage (Per-Site)" bar graph on stats.php#sites. 
* 	Limits checkouts returned to those checkouts that occured on the current system date.
*	Used In:
*	 	- charts_js.php
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

/* 	Returns data for the "Equipment Usage (Per-Site)" bar graph on stats.php#sites.
*	Limits checkouts returned to those checkouts that occured on the current system date.
*	Used In:
*		- charts_js.php
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

/*	Returns data for the "Equipment Usage (Per-Site)" bar graph on stats.php#sites.
*	Limits checkouts returned to those checkouts that occured on the current system date.
*	Used In:
*		- charts_js.php
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

/*	Returns data for the "Equipment Usage (Per-Site)" bar graph on stats.php#sites.
*	Used In:
*		- charts_js.php
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

/*	Returns the number of times the user checked out a piece of equipment
*	Used In:
*		- charts_js.php
*/
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

/*	Returns the number of times the user returned a piece of equipment
*	Used In:
*		- charts_js.php
*/
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

/*	Returns the total number of checkous
*	Used In:
*		- charts_js.php
*/
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

/*	Returns the number of times items were returned
*	Used In:
*		- charts_js.php
*/
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

/*	Returns the number of pieces of equipment that have a cost between 1 dollar and 100 dollars
*	Used In:
*		- charts_js.php
*/
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

/*	Returns the number of pieces of equipment that have a cost between 101 and 500
*	Used In:
*		- charts_js.php
*/
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

/*	Returns the number of pieces of equipment that have a cost between 501 and 1000
*	Used In:
*		- charts_js.php
*/
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

/*	Returns the number of pieces of equipment that have a cost between 1001 and 2500
*	Used in:
*		- charts_js.php
*/
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

/*	Returns the number of pieces of equipment that have a cost over 5000
*	Used In:
*		- charts_js.php
*/
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

/*	Returns a formatted CSV string starting at JAN, up to the current system month.
*	Used In:
*		- charts_js.php
*/
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

/*	Returns a number for each month that represents the number of checkouts that took place in that month
*	Used In:
*		- charts_js.php
*/
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

/*	Returns the number of active sites
*	Used In:
*		- stats.php
*		- checkouts_by_site_num_checkouts_today($connect)
*/
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

/*	Function to return number of inactive sites
*	Used In:
*		- stats.php
*/
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

/*	Returns the number of sites whoes site_name's contain 'virginia', 'VA', etc.
*	Used In:
*		- charts_js.php
*/
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

/*	Returns the number of sites whoes site_name's contain 'DC', 'Washington', etc.
*	Used In:
*		- charts_js.php
*/
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

/*	Returns the number of sites whoes site_name's contain 'DC', 'Washington', etc.
*	Used In:
*		- charts_js.php
*/
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

/*	Returns the number of ACTIVE NON-MASTER users
*	Used In:
*		- stats.php
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

/*	Returns the number of ACTIVE MASTER users
*	Used in:
*		- stats.php
*/
function count_master_active($connect)
{
	$query = "
	SELECT * FROM user_details WHERE user_type = 'master' AND user_status = 'active'";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}

/*	Returns the total number of (ACTIVE) users (Both MASTER and NON-MASTER) from the user_details table of the database.
*	This count includes MASTER users (Admins)
*	Used In:
*		- stats.php
*/
function count_total_user_active($connect)
{
	$query = "
	SELECT * FROM user_details WHERE user_status='active'";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}

/*	Returns options for the employee dropdown in stats.php
*	Used In:
*		- stats.php
*/
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

/*	Returns the total number of pieces of equipment available (active) at the moment
*	Used In:
*		- stats.php
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

/*Returns the number of pieces of equipment that are currently checked out
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

/*	Returns the total cost of all equipment in the database
*	Used In:
*		- charts_js.php
*/
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
?>
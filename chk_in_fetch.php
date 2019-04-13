<?php 
//chk_in_fetch.php

include('database_connection.php');
include('function.php');

$query = '';

$query .= '
	SELECT * FROM equipment_checkout 
INNER JOIN equipment ON equipment.equip_id = equipment_checkout.equip_id
WHERE equipment_checkout.empl_id = "'.$_SESSION['user_id'].'" 
AND equipment_checkout.returned = "false"
';

if(isset($_POST["search"]["value"])){
	$query .= 'AND (equipment_checkout.chk_date_time LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR equipment.equip_id LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR equipment.equip_name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR equipment_checkout.site_id LIKE "%'.$_POST["search"]["value"].'%" )';
}

if(isset($_POST['order']))
{
	if($_POST['order']['0']['column'] == 0){
		$sortVal = 'chk_date_time';
	}else if($_POST['order']['0']['column'] == 1){
		$sortVal = 'equipment.equip_id';
	}else if($_POST['order']['0']['column'] == 2){
		$sortVal = 'equip_name';
	}else if($_POST['order']['0']['column'] == 3){
		$sortVal = 'site_id';
	}

	$query .= 'ORDER BY '.$sortVal.' '.$_POST['order']['0']['dir'].' ';
}else{
	$query .= 'ORDER BY chk_date_time DESC ';
}

if($_POST['length'] != -1){
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
$filtered_rows = $statement->rowCount();

foreach($result as $row){
	//MySql Date conversion
	$time = strtotime($row['chk_date_time']);
	$chkDateTime = date("F jS, Y", $time);

	$sub_array = array();
	$sub_array[] = $chkDateTime;
	$sub_array[] = $row['equip_id'];
	$sub_array[] = $row['equip_name'];
	$sub_array[] = $row['site_id'];
	$sub_array[] = '
	<button type="button" name="chk_in_row" id="'.$row["chk_id"].'" class="btn btn-primary btn-xs chk_in_row" data-status="'.$row["equip_id"].'">
			Check-In
	</button>
	';
	$data[] = $sub_array;
}


function get_total_all_records($connect){
	$statement = $connect->prepare('
		SELECT * FROM equipment_checkout 
		INNER JOIN equipment ON equipment.equip_id = equipment_checkout.equip_id
		WHERE equipment_checkout.empl_id = "'.$_SESSION['user_id'].'" 
		AND equipment_checkout.returned = "false"
	');
	$statement->execute();
	return $statement->rowCount();
}

$output = array(
	"draw"    			=> 	intval($_POST["draw"]),
	"recordsTotal"  	=>  $filtered_rows,
	"recordsFiltered" 	=> 	get_total_all_records($connect),
	"data"    			=> 	$data
);

echo json_encode($output);

?>
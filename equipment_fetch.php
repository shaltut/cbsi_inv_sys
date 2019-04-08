<?php
//equipment_fetch.php

include('database_connection.php');
include('function.php');

$query = '';

$output = array();
$query .= "
	SELECT * FROM equipment 
	INNER JOIN user_details ON user_details.user_id = equipment.equip_entered_by 
	
";

if(isset($_POST["search"]["value"]))
{
	$query .= 'WHERE equipment.equip_name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR equipment.maintain_every LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR user_details.user_name LIKE "%'.$_POST["search"]["value"].'%" ';

	//Heres the problem
	$query .= 'OR equipment.equip_id LIKE "%'.$_POST["search"]["value"].'%" ';
}

if(isset($_POST['order']))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY equip_id DESC ';
}

if($_POST['length'] != -1)
{
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
$filtered_rows = $statement->rowCount();

foreach($result as $row)
{

	$sub_array = array();
	if(check_equip_maintenance_month($connect, $row['equip_id']) == 'red'){
		$sub_array[] =  '<div style="color:rgba(255, 0, 0, 1); border-radius: 15px;">'.$row['equip_id'].'</div>';
	}else if(check_equip_maintenance_month($connect, $row['equip_id']) == 'yellow'){
		$sub_array[] =  '<div style="color:rgba(248, 148, 6, 1); border-radius: 15px;">'.$row['equip_id'].'</div>';
	}else{
    	$sub_array[] = $row['equip_id'];
	}
	$sub_array[] = $row['equip_name'];
	$sub_array[] = '
		<button type="button" name="view" id="'.$row["equip_id"].'" class="btn btn-primary btn-xs view">View</button>
		';
	$sub_array[] = '
	<button type="button" name="update" id="'.$row["equip_id"].'" class="btn btn-success btn-xs update">Update</button>
	';

	//Toggle for status
	if($row['equip_status'] == 'active'){
		$sub_array[] = '
		<button type="button" name="delete" id="'.$row["equip_id"].'" class="btn btn-xs delete" data-status="'.$row["equip_status"].'"><img src="images/active.png" alt="Deactivate"/></button>';
	}else{
		$sub_array[] = '
		<button type="button" name="delete" id="'.$row["equip_id"].'" class="btn btn-xs delete" data-status="'.$row["equip_status"].'"><img src="images/inactive.png" alt="Activate"/></button>';
	}
	$data[] = $sub_array;
}

//	This function returns the total number of all rows returned by $query
function get_total_all_records($connect)
{
	$statement = $connect->prepare('SELECT * FROM equipment');
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
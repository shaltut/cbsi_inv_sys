<?php
/*	PAGE: 	equipment_fetch.php
*	INFO:	Fetch page used to populate the table data from the database.
*/

include('database_connection.php');
include('function.php');
$query = '';
$query .= "
	SELECT * FROM equipment 
";

if(isset($_POST["search"]["value"]))
{
	$query .= 'WHERE equip_id LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR equip_name LIKE "%'.$_POST["search"]["value"].'%" ';
}


if(isset($_POST['order']))
{
	if($_POST['order']['0']['column'] == 0){
		$sortVal = 'equip_id';
	}else if($_POST['order']['0']['column'] == 1){
		$sortVal = 'equip_name';
	}

	$query .= 'ORDER BY '.$sortVal.' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY date_added DESC ';
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
	
	$check_broken = check_equip_broken($connect, $row['equip_id']);

	$check_main = check_equip_maintenance_month($connect, $row['equip_id']);

	$sub_array = array();
	if($check_main == 'red' ||  $check_broken == 'red'){
		$sub_array[] =  '<div style="color:rgba(255, 0, 0, 1); border-radius: 15px;">'.$row['equip_id'].'</div>';
	}else if($check_main == 'yellow'){
		$sub_array[] =  '<div style="color:rgba(248, 148, 6, 1); border-radius: 15px;">'.$row['equip_id'].'</div>';
	}else{
    	$sub_array[] = $row['equip_id'];
	}
	$sub_array[] = $row['equip_name'];
	$sub_array[] = '
		<button type="button" name="view" id="'.$row["equip_id"].'" class="btn btn-info btn-xs view">View</button>
		';
	$sub_array[] = '
	<button type="button" name="update" id="'.$row["equip_id"].'" class="btn btn-warning btn-xs update">Update</button>
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
	"recordsTotal"  	=>  get_total_all_records($connect),
	"recordsFiltered" 	=> 	get_total_all_records($connect),
	"data"    			=> 	$data
);
echo json_encode($output);
?>
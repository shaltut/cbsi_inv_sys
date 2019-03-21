<?php

//index_fetch.php

include('database_connection.php');
include('function.php');

$query = '';

$output = array();
// $today_date = date("Y-m-d h:i a");
$query .= "
	SELECT * FROM equipment 
	INNER JOIN user_details ON user_details.user_id = equipment.equip_entered_by 
	INNER JOIN equipment_checkout on equipment_checkout.empl_id = user_details.user_id
	
";

if(isset($_POST["search"]["value"]))
{
	$query .= 'WHERE user_details.user_id LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR user_details.user_name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR equipment.equip_id LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR equipment.equip_name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR equipment_checkout.chk_date_time LIKE "%'.$_POST["search"]["value"].'%" ';
}

if(isset($_POST['order']))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY user_id DESC ';
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
	$sub_array[] = $row['user_id'];
	$sub_array[] = $row['user_name'];
	$sub_array[] = $row['equip_id'];
	$sub_array[] = $row['equip_name'];
	$sub_array[] = $row['chk_date_time'];
	$data[] = $sub_array;
}

//	This function returns the total number of all rows returned by $query
function get_total_all_records($connect)
{
	$statement = $connect->prepare('
		SELECT * FROM equipment 
		INNER JOIN user_details ON user_details.user_id = equipment.equip_entered_by 
		INNER JOIN equipment_checkout on equipment_checkout.empl_id = user_details.user_id
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
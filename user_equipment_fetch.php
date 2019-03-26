<?php

//search.php
//Used to fetch data from the database for search.php


include('database_connection.php');
include('function.php');

$query = '';

$output = array();
$query .= "
	SELECT equip_id, equip_name, equip_desc, equip_status 
	FROM equipment INNER JOIN user_details ON user_details.user_id = equipment.equip_entered_by
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
	$status = '';
	if($row['equip_status'] == 'active')
	{
		$status = '<span class="label label-success">Active</span>';
	}
	else
	{
		$status = '<span class="label label-danger">Inactive</span>';
	}
	$sub_array = array();
	$sub_array[] = $row['equip_id'];
	$sub_array[] = $row['equip_name'];
	$sub_array[] = $row['equip_desc'];
	$sub_array[] = $status;
	$data[] = $sub_array;
}

//	This function returns the total number of all rows returned by $query
function get_total_all_records($connect)
{
	$statement = $connect->prepare('SELECT equip_id equip_name, equip_desc, equip_status FROM equipment');
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
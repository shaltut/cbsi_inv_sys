<?php

//site_fetch.php

include('database_connection.php');
include('function.php');

$query = '';

$output = array();
$query .= "
	SELECT * FROM sites 
	GROUP BY site_id, site_name
";

if(isset($_POST["search"]["value"]))
{
	$query .= 'OR site_name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR job_desc LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR start_date LIKE "%'.$_POST["search"]["value"].'%" ';

	//Heres the problem
	$query .= 'OR site_id LIKE "%'.$_POST["search"]["value"].'%" ';
}

if(isset($_POST['order']))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY site_id DESC ';
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
	if($row['site_status'] == 'active')
	{
		$status = '<span class="label label-success">Active</span>';
	}
	else
	{
		$status = '<span class="label label-danger">Inactive</span>';
	}
	$sub_array = array();
	$sub_array[] = $row['site_id'];
	$sub_array[] = $row['site_name'];
	$sub_array[] = $row['job_desc'];
	$sub_array[] = $row['start_date'];
	$sub_array[] = $status;
	$sub_array[] = '
		<button type="button" name="view" id="'.$row["site_id"].'" class="btn btn-info btn-xs view">View</button>
		';
	$sub_array[] = '
	<button type="button" name="update" id="'.$row["site_id"].'" class="btn btn-warning btn-xs update">Update</button>
	';
	$sub_array[] = '
	<button type="button" name="delete" id="'.$row["site_id"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["site_status"].'">Delete</button>
	';
	$data[] = $sub_array;
}

//	This function returns the total number of all rows returned by $query
function get_total_all_records($connect)
{
	$statement = $connect->prepare('SELECT * FROM sites');
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
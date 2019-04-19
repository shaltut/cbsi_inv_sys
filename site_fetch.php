<?php
/*	PAGE: 	site_fetch.php
*	INFO:	Fetch page used to populate the table data from the database.
*/
include('database_connection.php');
// include('function.php');

$query = '';
$output = array();
$query .= "
	SELECT * FROM sites 
	GROUP BY site_id, site_name
";

if(isset($_POST["search"]["value"]))
{
	$query .= 'OR site_name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR site_address LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR site_id LIKE "%'.$_POST["search"]["value"].'%" ';
}

if(isset($_POST['order']))
{
	if($_POST['order']['0']['column'] == 0){
		$sortVal = 'site_name';
	}
	$query .= 'ORDER BY '.$sortVal.' '.$_POST['order']['0']['dir'].' ';
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
	
	$sub_array = array();
	$sub_array[] = $row['site_name'];
	$sub_array[] = '
		<button type="button" name="view" id="'.$row["site_id"].'" class="btn btn-info btn-xs view">View</button>
		';
	$sub_array[] = '
		<button type="button" name="update" id="'.$row["site_id"].'" class="btn btn-warning btn-xs update">Update</button>
		';

	if($row['site_status'] == 'active'){
		$sub_array[] = '
		<button type="button" name="delete" id="'.$row["site_id"].'" class="btn btn-xs delete" data-status="'.$row["site_status"].'"><img src="images/active.png" alt="Deactivate"/></button>';
	}else{
		$sub_array[] = '
		<button type="button" name="delete" id="'.$row["site_id"].'" class="btn btn-xs delete" data-status="'.$row["site_status"].'"><img src="images/inactive.png" alt="Activate"/></button>';
	}
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
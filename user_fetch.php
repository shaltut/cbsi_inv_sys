<?php
/*	PAGE: 	user_fetch.php
*	INFO:	Fetch page used to populate the table data from the database.
*/
include('database_connection.php');

$query = '';
$output = array();

/*
	This is the beginning of the query used to select all the users for display.

	Depending on the user's use of the buttons and actions available on the page, this query changes. Look for the '$query' variable throughout this page inside of decision structures that modify the original below.
*/
$query .= "
	SELECT * FROM user_details 
";

// **********	Search bar 	**********
if(isset($_POST["search"]["value"]))
{
	$query .= 'WHERE user_email LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR user_name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR user_status LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR user_id LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR user_job LIKE "%'.$_POST["search"]["value"].'%" ';
}

// **********	Ordered Header 	**********
if(isset($_POST["order"]))
{
	if($_POST['order']['0']['column'] == 0){
		$sortVal = 'user_id';
	}else if($_POST['order']['0']['column'] == 1){
		$sortVal = 'user_email';
	}else if($_POST['order']['0']['column'] == 2){
		$sortVal = 'user_name';
	}else if($_POST['order']['0']['column'] == 3){
		$sortVal = 'user_job';
	}
	$query .= 'ORDER BY '.$sortVal.' '.$_POST['order']['0']['dir'].' ';
}else{
	$query .= 'ORDER BY user_id DESC ';
}

// Limits the number of results returned to the LIMIT set in the "show __ Entries" portion of the table.
if($_POST["length"] != -1)
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
	$sub_array[] = $row['user_job'];
	//'View' Button
	$sub_array[] = '
		<button type="button" name="view" id="'.$row["user_id"].'" class="btn btn-info btn-xs view">View</button>
		';
	//'Update' Button
	$sub_array[] = '<button type="button" name="update" id="'.$row["user_id"].'" class="btn btn-warning btn-xs update">Update</button>';

	//'Status' Button
	if($row['user_status'] == 'Active'){
		$sub_array[] = '
		<button type="button" name="disable" id="'.$row["user_id"].'" class="btn btn-xs disable" data-status="'.$row["user_status"].'"><img src="images/active.png" alt="Deactivate"/></button>';
	}else{
		$sub_array[] = '
		<button type="button" name="disable" id="'.$row["user_id"].'" class="btn btn-xs disable" data-status="'.$row["user_status"].'"><img src="images/inactive.png" alt="Activate"/></button>';
	}

	$data[] = $sub_array;
}
//	This function returns the total number of all rows returned by $query
function get_total_all_records($connect)
{
	$statement = $connect->prepare('SELECT * FROM user_details');
	$statement->execute();
	return $statement->rowCount();
}
$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"  	=>  get_total_all_records($connect),
	"recordsFiltered" 	=> 	get_total_all_records($connect),
	"data"    			=> 	$data
);
echo json_encode($output);
?>
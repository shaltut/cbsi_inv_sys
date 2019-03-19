<?php

//user_fetch.php

include('database_connection.php');

$query = '';

$output = array();

/*
	This is the beginning of the query used to select all the users for display.

	Depending on the user's use of the buttons and actions available on the page, this query changes. Look for the '$query' variable throughout this page inside of decision structures that modify the original below.
*/
$query .= "
SELECT * FROM user_details 
WHERE user_type = 'user' AND
";


// **********	Search bar 	**********
if(isset($_POST["search"]["value"]))
{
	$query .= '(user_email LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR user_name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR user_status LIKE "%'.$_POST["search"]["value"].'%") ';
}

// **********	Ordered Header 	**********
if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
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
	$status = '';

	//Shows a different color status marker depending on each user's status.
	if($row["user_status"] == 'Active')
	{
		$status = '<span class="label label-success">Active</span>';
	}else{
		$status = '<span class="label label-danger">Inactive</span>';
	}

	//Displays each column of info in a specifc way depending on that column's value.
	$sub_array = array();
	$sub_array[] = $row['user_id'];
	$sub_array[] = $row['user_email'];
	$sub_array[] = $row['user_name'];
	$sub_array[] = $row['user_job'];
	$sub_array[] = $status;
	//Update button for each user
	$sub_array[] = '<button type="button" name="update" id="'.$row["user_id"].'" class="btn btn-warning btn-xs update">Update</button>';
	//Delete button for each user
	$sub_array[] = '<button type="button" name="disable" id="'.$row["user_id"].'" class="btn btn-danger btn-xs disable" data-status="'.$row["user_status"].'">Change Status</button>';
	//$sub_array[] = $row['user_job'];
	$data[] = $sub_array;
}

$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"  	=>  $filtered_rows,
	"recordsFiltered" 	=> 	get_total_all_records($connect),
	"data"    			=> 	$data
);
echo json_encode($output);

//Returns the number of rows returned from an SQL query
function get_total_all_records($connect)
{
	$statement = $connect->prepare("SELECT * FROM user_details WHERE user_type='user'");
	$statement->execute();
	return $statement->rowCount();
}

?>
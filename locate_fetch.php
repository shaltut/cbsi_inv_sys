<?php
/*	PAGE: 	locate_fetch.php
*	INFO:	Fetch page used to populate the table data from the database.
*/

include('database_connection.php');
// include('function.php');

$query = '';

// $output = array();
$query .= "
	SELECT * FROM equipment 	
";

if(isset($_POST["search"]["value"]))
{
	$query .= 'WHERE equipment.equip_name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR equipment.equip_id LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR equipment.is_available LIKE "%'.$_POST["search"]["value"].'%" ';
}

if(isset($_POST['order']))
{
	if($_POST['order']['0']['column'] == 0){
		$sortVal = 'equipment.equip_name';
	}else if($_POST['order']['0']['column'] == 1){
		$sortVal = 'is_available';
	}

	$query .= 'ORDER BY '.$sortVal.' '.$_POST['order']['0']['dir'].' ';
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
	$avail = '';
	if($row['is_available'] == "available"){
		$avail = '<span class="label label-success"><span class="glyphicon glyphicon-ok"></span></span>';
	}else{
		$avail = '<span class="label label-danger"><span class="glyphicon glyphicon-remove"></span></span>';
	}

	$sub_array = array();
	$sub_array[] = $avail;
	$sub_array[] = $row['equip_name'];
	$sub_array[] = '
		<button type="button" name="view" id="'.$row["equip_id"].'" class="btn btn-info btn-xs view">View</button>
	';
	$sub_array[] = '
		<button type="button" name="update" id="'.$row["equip_id"].'" class="btn btn-warning btn-xs locate glyphicon glyphicon-map-marker"></button>
	';
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
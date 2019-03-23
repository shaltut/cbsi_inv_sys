<?php

//chk_in_fetch.php

include('database_connection.php');
include('function.php');

$query = '';

$output = array();
$uid = $_SESSION['user_id'];
$query .= '
	SELECT * FROM equipment_checkout 
INNER JOIN equipment ON equipment.equip_id = equipment_checkout.equip_id
WHERE equipment_checkout.empl_id = "'.$_SESSION['user_id'].'" 
';

if(isset($_POST["search"]["value"]))
{
	$query .= 'AND (equipment_checkout.chk_date_time LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR equipment.equip_id LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR equipment.equip_name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR equipment_checkout.site_id LIKE "%'.$_POST["search"]["value"].'%" )';
}

if(isset($_POST['order']))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY chk_date_time DESC ';
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

		/*
			Test Values
		*/
		// $sub_array[] = $_POST['start'];
		// $sub_array[] = $_POST['length'];
		// $sub_array[] = $_SESSION['user_id'];
		// $sub_array[] = intval($_POST["draw"]);
		// $sub_array[] = $filtered_rows;
		// $sub_array[] = get_total_all_records($connect);
		// $sub_array[] = $row['chk_id'];
		// $sub_array[] = $row['empl_id'];


		/*
			Actual Values
		*/
		$sub_array[] = $row['chk_date_time'];
		$sub_array[] = $row['equip_id'];
		$sub_array[] = $row['equip_name'];
		$sub_array[] = $row['site_id'];
		$sub_array[] = '
		<button type="button" name="view" id="'.$row["chk_id"].'" class="btn btn-primary btn-xs view">Check-In</button>
		';
		$data[] = $sub_array;
}

//	This function returns the total number of all rows returned by $query
function get_total_all_records($connect)
{
	$statement = $connect->prepare('
		SELECT * FROM equipment_checkout 
		INNER JOIN equipment ON equipment.equip_id = equipment_checkout.equip_id
		WHERE equipment_checkout.empl_id = "'.$_SESSION['user_id'].'" 
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
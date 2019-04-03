<?php
//maintain_fetch.php

include('database_connection.php');
include('function.php');

$query = '';

$output = array();
$query = "
	SELECT SYSDATE() as 'tday', last_maintained AS 'lm', equip_id as 'equip_id', equip_name as 'equip_name', maintain_every AS 'me' FROM equipment WHERE is_maintenance_required = 'yes' AND equip_status = 'active'
	";

// if(isset($_POST["search"]["value"]))
// {
// 	$query .= 'OR equip_id LIKE "%'.$_POST["search"]["value"].'%" ';
// 	$query .= 'OR lm LIKE "%'.$_POST["search"]["value"].'%" ';
// 	$query .= 'OR me LIKE "%'.$_POST["search"]["value"].'%" ';

// }

// if(isset($_POST['order']))
// {
// 	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
// }
// else
// {
// 	$query .= 'ORDER BY eid DESC ';
// }

if($_POST['length'] != -1)
{
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
$filtered_rows = $statement->rowCount();

foreach($result as $row){

	$today = $row['tday'];
	$last_m = $row['lm'];
	$m_every = $row['me'];

	$ts1 = strtotime($last_m);
	$ts2 = strtotime($today);

	$year1 = date('Y', $ts1);
	$year2 = date('Y', $ts2);

	$month1 = date('m', $ts1);
	$month2 = date('m', $ts2);

	$diff = (($year2 - $year1) * 12) + ($month2 - $month1);
	$od_date = ($diff - $row['me'])*30;

	if($diff > $row['me']){
		$sub_array = array();
		$sub_array[] = $row['equip_id'];
		$sub_array[] = $row['equip_name'];
		//$sub_array[] = $od_date.' days';
		$sub_array[] = $row['lm'];
		$sub_array[] = '
			<button type="button" name="view" id="'.$row["equip_id"].'" class="btn btn-info btn-xs view">View</button>
			';
		$sub_array[] = '
		<button type="button" name="update" id="'.$row["equip_id"].'" class="btn btn-warning btn-xs update">Update</button>
		';
		$data[] = $sub_array;
	}

}

//	This function returns the total number of all rows returned by $query
function get_total_all_records($connect){
	$sysdate = date('Y-m-d');
	$query = "
	SELECT SYSDATE() as 'tday', last_maintained as 'lm', maintain_every as 'me' FROM equipment WHERE is_maintenance_required = 'yes' AND equip_status = 'active'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$count = 0;
	$test = ' ';
	$result = $statement->fetchAll();
	if(isset($result)){
		foreach($result as $row)
		{
			$today = $row['tday'];
			$last_m = $row['lm'];
			$m_every = $row['me'];

			$ts1 = strtotime($last_m);
			$ts2 = strtotime($today);

			$year1 = date('Y', $ts1);
			$year2 = date('Y', $ts2);

			$month1 = date('m', $ts1);
			$month2 = date('m', $ts2);

			$diff = (($year2 - $year1) * 12) + ($month2 - $month1);

			if($diff > $row['me'] ){
				$count = $count + 1;
			}
		}
	}
	// return $count;
	return $count;
}

$output = array(
	"draw"    			=> 	intval($_POST["draw"]),
	"recordsTotal"  	=>  $filtered_rows,
	"recordsFiltered" 	=> 	get_total_all_records($connect),
	"data"    			=> 	$data
);

echo json_encode($output);

?>
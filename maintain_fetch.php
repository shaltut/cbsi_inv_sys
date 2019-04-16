<?php
//maintain_fetch.php

include('database_connection.php');
include('function.php');

$query = '';
$count = 0;
$output = array();
$query = "
	SELECT SYSDATE() as 'tday', last_maintained AS 'lm', equip_id as 'equip_id', equip_name as 'equip_name', maintain_every AS 'me' FROM equipment WHERE is_maintenance_required = 'yes' AND equip_status = 'active'
	";

if($_POST['length'] != -1)
{
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();

foreach($result as $row){
	if(check_equip_maintenance_month($connect, $row['equip_id']) == 'red'){
		$sub_array = array();
		$sub_array[] = $row['equip_id'];
		$sub_array[] = $row['equip_name'];
		$sub_array[] = '<div style="color:rgba(255, 0, 0, 1);">'.$row['lm'].'</div>';
		$sub_array[] = '
			<button type="button" name="view" id="'.$row["equip_id"].'" class="btn btn-info btn-xs view">View</button>
			';
		$sub_array[] = '
		<button type="button" name="update" id="'.$row["equip_id"].'" class="btn btn-warning btn-xs update">Update</button>
		';
		$sub_array[] = '<button type="button" name="today" id="'.$row["equip_id"].'" class="btn btn-danger btn-xs today">Reset</button>
		';
		$data[] = $sub_array;
		$count = $count+1;
	}

}

$output = array(
	"draw"    			=> 	intval($_POST["draw"]),
	"recordsTotal"  	=>  $count,
	"recordsFiltered" 	=> 	$count,
	"data"    			=> 	$data
);

echo json_encode($output);

?>
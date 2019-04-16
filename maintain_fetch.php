<?php
//maintain_fetch.php

include('database_connection.php');
include('function.php');


$count = 0;

$query = '';
$query = "
	SELECT last_maintained, equip_id, equip_name, maintain_every 
	FROM equipment 
	WHERE (equip_status = 'active' AND is_maintenance_required = 'yes')
	";

// $_POST['length'] = -1;
// if($_POST['length'] != -1){
// 	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
// }

$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
foreach($result as $row){
	$check_month = check_equip_maintenance_month($connect, $row['equip_id']);
	if($check_month == 'red'){

		if($row['last_maintained'] == Null){
			$lm_date = 'BROKEN';
		}else{
			$lm_date = $row['last_maintained'];
		}

		$sub_array = array();
		$sub_array[] = $row['equip_id'];
		$sub_array[] = $row['equip_name'];
		$sub_array[] = '<div style="color:rgba(255, 0, 0, 1);">'.$lm_date.'</div>';
		$sub_array[] = '
			<button type="button" name="view" id="'.$row['equip_id'].'" class="btn btn-info btn-xs view">View</button>
			';
		$sub_array[] = '
		<button type="button" name="update" id="'.$row['equip_id'].'" class="btn btn-warning btn-xs update">Update</button>
		';
		$sub_array[] = '<button type="button" name="today" id="'.$row['equip_id'].'" class="btn btn-danger btn-xs today">Reset</button>
		';
		$data[] = $sub_array;

		$count = $count+1;

	}

}



$output = array(
	"draw"    			=> 	intval($_POST["draw"]),
	"recordsTotal"  	=>  maintenance_red_num($connect),
	"recordsFiltered" 	=>  maintenance_red_num($connect),
	"data"    			=> 	$data
);

echo json_encode($output);

?>
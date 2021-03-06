<?php
/*	PAGE: 	maintain_fetch.php
*	INFO:	Fetch page used to populate the table data from the database.
*/
include('database_connection.php');
include('function.php');

$query = '';
$count = 0;
$output = array();
$query = "
	SELECT *
	FROM equipment 
	WHERE (is_maintenance_required = 'yes' AND equip_status = 'active') OR (is_broken = 'yes' AND equip_status = 'active')
	";

// if(isset($_POST["search"]["value"]))
// {
// 	$query .= 'OR equip_id LIKE "%'.$_POST["search"]["value"].'%" ';
// 	$query .= 'OR equip_name LIKE "%'.$_POST["search"]["value"].'%" ';
// }

// if(isset($_POST['order']))
// {
// 	if($_POST['order']['0']['column'] == 0){
// 		$sortVal = 'equip_id';
// 	}else if($_POST['order']['0']['column'] == 1){
// 		$sortVal = 'equip_name';
// 	}

// 	$query .= 'ORDER BY '.$sortVal.' '.$_POST['order']['0']['dir'].' ';
// }
// else
// {
// 	$query .= 'ORDER BY date_added DESC ';
// }

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
		$sub_array[] = '<div style="color:rgba(255, 0, 0, 1);">'.$row['last_maintained'].'</div>';
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
	if($row['is_broken'] == 'yes'){
		$sub_array = array();
		$sub_array[] = $row['equip_id'];
		$sub_array[] = $row['equip_name'];
		$sub_array[] = '<div style="color:rgba(255, 0, 0, 1);"> BROKEN </div>';
		$sub_array[] = '
			<button type="button" name="view" id="'.$row["equip_id"].'" class="btn btn-info btn-xs view">View</button>
			';
		$sub_array[] = '';
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
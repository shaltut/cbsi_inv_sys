<?php 
/*	PAGE: 	chk_in_fetch.php
*	INFO:	Fetch page used to populate the table data from the database.
*
*/

//Includes connection to the database 
include('database_connection.php');

$query = '';
$query .= '
	SELECT * FROM equipment_checkout 
	INNER JOIN equipment ON equipment.equip_id = equipment_checkout.equip_id
	WHERE equipment_checkout.empl_id = "'.$_SESSION['user_id'].'" 
	AND equipment_checkout.returned = "false"
';

//	Triggers when the user starts entering values into the search bar
// if(isset($_POST["search"]["value"])){
// 	$query .= 'AND (equipment_checkout.chk_date_time LIKE "%'.$_POST["search"]["value"].'%" ';
// 	$query .= 'OR equipment.equip_id LIKE "%'.$_POST["search"]["value"].'%" ';
// 	$query .= 'OR equipment.equip_name LIKE "%'.$_POST["search"]["value"].'%" ';
// 	$query .= 'OR equipment_checkout.site_id LIKE "%'.$_POST["search"]["value"].'%" )';
// }

//	Triggered when the user clicks on the table's header to order the table by the selected table
// if(isset($_POST['order']))
// {
	/* 	Sets $sortVal to the column's database value. 
	*		For example, if the user clicks on the first column (column 0) this block will
	* 		assign $sortVal to chk_date_time which is the data stored in column 0;
	*
	*	If the user doesnt sort the table by a given column, the default (ELSE) is 
	*	to order by chk_date_time in decending order.
	*/
// 	if($_POST['order']['0']['column'] == 0){
// 		$sortVal = 'chk_date_time';
// 	}else if($_POST['order']['0']['column'] == 1){
// 		$sortVal = 'equipment.equip_id';
// 	}else if($_POST['order']['0']['column'] == 2){
// 		$sortVal = 'equip_name';
// 	}else if($_POST['order']['0']['column'] == 3){
// 		$sortVal = 'site_id';
// 	}

// 	$query .= 'ORDER BY '.$sortVal.' '.$_POST['order']['0']['dir'].' ';
// }else{
// 	$query .= 'ORDER BY chk_date_time DESC ';
// }

//	pagnation value control
if($_POST['length'] != -1){
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
$filtered_rows = $statement->rowCount();

foreach($result as $row){
	//MySql Date conversion
	$time = strtotime($row['chk_date_time']);
	$chkDateTime = date("F jS, Y", $time);

	$sub_array = array();
	$sub_array[] = $chkDateTime;
	$sub_array[] = $row['equip_id'];
	$sub_array[] = $row['equip_name'];
	$sub_array[] = $row['site_id'];

	/*	
	*	Creates a check-in button for each value in the table. chk_id provided tells the chk_in_action page 
	*	which row in the database to set returned to 'true'.
	*/
	$sub_array[] = '
	<button type="button" name="chk_in_row" id="'.$row["chk_id"].'" class="btn btn-primary btn-xs chk_in_row" data-status="'.$row["equip_id"].'">
			Check-In
	</button>
	';
	$data[] = $sub_array;
}

//	Returns the count of the number of rows that will be stored in the table (total non-pagnated)
function get_total_all_records($connect){
	$query .= '
		SELECT * FROM equipment_checkout 
		INNER JOIN equipment ON equipment.equip_id = equipment_checkout.equip_id
		WHERE equipment_checkout.empl_id = "'.$_SESSION['user_id'].'" 
		AND equipment_checkout.returned = "false"
	';
	$statement = $connect->prepare($query);
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
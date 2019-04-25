<?php
/*  PAGE:   locate_action.php
*   INFO:   This page is used to complete an action after the user submits 
*           a form, clicks a button, or performs some other action. 
*   ACTIONS:
*      	equipment_details:	Triggered when the 'View' button is clicked (table button). It displaysa all the info about the given
*							piece of equipment.
*                    
*         	 fetch_single:	Triggered when the 'Update' button is clicked. It takes the values that the user entered into the form 
*							and sets those values to match in the database.
*                   
*/
include('database_connection.php');
include('function.php');

if(isset($_POST['btn_action']))
{

	//********** VIEW BUTTON (Details Column)**********
	if($_POST['btn_action'] == 'equipment_details')
	{
$query = "
		SELECT * FROM equipment 
		INNER JOIN user_details ON user_details.user_id = equipment.equip_entered_by 
		WHERE equipment.equip_id = '".$_POST["equip_id"]."'
		";

		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$id = $row['equip_id'];
			$name = $row['equip_name'];
			$serial = $row['equip_serial'];
			$desc = $row['equip_desc'];
			$imr = $row['is_maintenance_required'];
			$maintainevery = $row['maintain_every'];
			//MySql Date conversion
			$time = strtotime($row['last_maintained']); $lastmaintained = date("F jS, Y", $time);
			$isbroken = $row['is_broken'];
			$brokendesc = $row['broken_desc'];
			$cost = $row['equip_cost'];
			$enteredby = ucfirst(get_user_name($connect, $row['equip_entered_by']));
			//MySql Date conversion
			$time2 = strtotime($row['date_added']); $dateadded = date("F jS, Y", $time2);
			$status = $row['equip_status'];
			//MySql Date conversion
			$time = strtotime($row['date_added']); $date= date("F jS, Y", $time);
			$isavailable = $row['is_available'];

			if($status == 'active')
			{
				$status = '<span class="label label-success">Active</span>';
			}else{
				$status = '<span class="label label-danger">Inactive</span>';
			}

			//	Heading
			if(check_equip_maintenance_month($connect, $row['equip_id']) == 'red' || $isbroken == 'yes'){
				$output .= '
					<div class="alert alert-danger" style="
						text-align:center;
						font-weight:bold;
						font-size:1.2em;
					">
						This Item Requires Maintenance!
					</div>';
			}else if(check_equip_maintenance_month($connect, $row['equip_id']) == 'yellow'){
				$output .= '
					<div class="alert alert-warning" style="
						text-align:center;
						font-weight:bold;
						font-size:1.2em;
					">
						Maintenance Required Soon
					</div>';
			}
			$output .= '
				<div style="
					text-align:center;
					font-weight:bold;
					font-size:1.4em;
					border:1px solid black;
				">
					'.$name.'
				</div>';

			//Serial Number Output
			if($serial != NULL){
				$output .= '
				<div style="
					float:left;
					font-weight:bold;
					font-size:1.3em;
					padding-top: 5px;
					width:50%;
				">
					Serial #:
					<span class="text-info">'.$serial.'</span>
				</div>';
			}else{
				$output .= '
				<div style="
					float:left;
					font-weight:bold;
					font-size:1.3em;
					padding-top: 5px;
					width:50%;
				">
					Serial #: --
				</div>';
			}

			//Status Output
			$output .= '
			<div style="
				float:right;
				text-align:right;
				font-weight:bold;
				font-size:1.3em;
				padding-top: 5px;
				width:50%;
			">
			'.$status.'
			</div>
			';

			$output .= '<hr/>';

			//Maintenance Information Output
			if($row['is_maintenance_required'] == 'yes'){
				$output .= '
				<div class="table-responsive" style="margin-top:20px">
					<table class="table table-bordered" style="text-align:center;">
					<tr>
						<th colspan="2"  style="
							text-align:center;
							font-weight:bold;
							font-size:1.3em;
							margin-top:10px;
						">
							Maintenance Information
						</th>
					</tr>
					<tr>
						<th style="width:220px;text-align:center">Requires Maintenance Every</th>
						<th style="width:220px;text-align:center">Last Maintained On</th>
					</tr>
					<tr>
						<td>'.$maintainevery.' Months</td>
						<td>'.$lastmaintained.'</td>
					</tr>
					</table>
				</div>
				';
			}

			//Description Output
			if($desc != '' && $desc != Null){
				$output .= '
				<div style="
					text-align:center;
					font-weight:bold;
					font-size:1.3em;
				">
					Equipment Description
				</div>
				<div style="
					padding-left:30px;
					padding-right:30px;
					text-align:center;
				">
					'.$desc.'
				</div>
				';
			}

			$output .= '
			<div>
				<br/>
			</div>
			';

			//Cost Output
			if($cost != NULL){
				$output .= '
				<div style="
					float:right;
					text-align:right;
					font-weight:bold;
					font-size:1.3em;
					padding-top: 5px;
					width:50%;
					display:block;
				">
					Cost:
					<span class="text-success">$'.$cost.'</span>
				</div>';
			}

			//Availability Output
			if($row['is_available'] == 'available'){
				$output .= '
				<div style="
					float:left;
					font-weight:bold;
					font-size:1.3em;
					padding-top: 5px;
					width:50%;
					display:block;
				">
					<span class="text-success glyphicon glyphicon-ok"></span>
				 	Available for Checkout
				</div>';
			}else{
				$output .= '
				<div style="
					float:left;
					font-weight:bold;
					font-size:1.3em;
					padding-top: 5px;
					width:50%;
					display:block;
				">
					<span class="text-danger glyphicon glyphicon-remove"></span>
					In Use
				</div>';
			}

			$output .= '
				<hr/>
			';

			// 	Entered-by Output
			$output .= '
				<div style="
					width:100%;
					text-align:right;
					font-weight:bold;
					margin-top:50px;
				">
					Entered Into System by <span class="text-info">'.$enteredby.'</span> on <span class="text-info">'.$dateadded.'</span>
				</div>';

		}
		echo $output;
	}

	//When the 'Update' button is pressed, this function sends data to the modal to display whatever current data is saved for each option
	if($_POST['btn_action'] == 'fetch_single')
	{

		$last_chk = get_last_checkout_id($connect, $_POST['equip_id']);
		$query = "
		SELECT * 
		FROM equipment_checkout
		JOIN user_details ON equipment_checkout.empl_id = user_details.user_id
		WHERE chk_id = :chk_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':chk_id'	=>	$last_chk
			)
		);
		$result = $statement->fetchAll();
		foreach($result as $row){
			$site = get_site_name_by_id($connect, $row['site_id']);
			$usr = get_empl_name_by_id($connect, $row['empl_id']);

			//MySql Date conversion
			$time = strtotime($row['chk_date_time']); $date = date("F jS, Y", $time);

			$siteinfo = '
				<div style="
					font-size:1.3em;
					font-weight:bold;
				">
					<span class="text-info" style="
						font-size:1.2em;
					">
						Last Known Location: 
					</span>
				</div>
				<div style="
					margin-left:20px;
				">
					<div style="
						font-size:1.1em;
						font-weight:bold;
					">
						'.$site.'
					</div>
					<div> 
						<span style="
							font-weight:bold;
							font-size:1.2em;
						">
							Site ID:
						</span> 
						'.$row['site_id'].'
					</div>
					<div> 
						<span style="
							font-weight:bold;
							font-size:1.2em;
						">
							Date Of Checkout:
						</span> 
						'.$date.'
					</div>
				</div>
				<hr/>
			';
			$contact = '
			<div style="font-size:1.3em;font-weight:bold;">
				<span class="text-info" style="
					font-size:1.3em;
				">
					Last Checked Out By: 
				</span>
				'.$usr.'
			</div>
			<div class="table-responsive" style="margin-top:20px">
				<table class="table table-bordered" style="text-align:center;">
				<tr>
					<th colspan="2">Contact Information</th>
				</tr>
				<tr>
					<th style="width:220px;text-align:center">Phone Number</th>
					<th style="width:220px;text-align:center">Email Address</th>
				</tr>
				<tr>
					<td>'.$row['user_cell'].'</td>
					<td>'.$row['user_email'].'</td>
				</tr>
				</table>
			</div>
			';

			// $on = '
			// 	<div style="font-size:1.2em;font-weight:bold;">
			// 		<span class="text-info" style="
			// 			font-size:1.3em;
			// 		">
			// 			On: 
			// 		</span>
			// 	'.$date.'
			// </div>';

			$output['last_loc'] = $siteinfo;
			$output['last_chk'] = $contact;
			// $output['last_date'] = $on;
			$output['message'] = true;




















		}
		echo json_encode($output);
	}
}
?>
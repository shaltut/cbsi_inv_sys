<?php
/*  PAGE:   equipment_action.php
*   INFO:   This page is used to complete an action after the user submits 
*           a form, clicks a button, or performs some other action. 
*   ACTIONS:
*   				  Add:	Triggered when the add equipment form is submitted. It inserts a new row in the equipment table
*              					containing the form field data submitted by the user. (adds the equipment data as a row in the equipment table)
*
*     	equipment_details:	Triggered when "View" button is clicked (table button). It returns the table with all the info about 
*      							the selected piece of equipment inside the view modal.           
*			 fetch_single:	Triggered when the user selects an "Update" button (table button). It returns the data to pre-populate the equipment
*							form so the user can see the current database fields while updating them.
*
*					 Edit:	Triggered when the user submits the update form. It takes all the current form field values and updates the database
*							values to match.
*                   
*                  delete:	Triggered when the user clicks the toggle button (table button). It toggles the given piece of equipment's equip_stats
*							value in the database. (If equip_status = 'active' then changes status to 'inactive' and vica versa)
*                   
*/

include('database_connection.php');

include('function.php');


if(isset($_POST['btn_action']))
{
	//********** ADD BUTTON **********
	if($_POST['btn_action'] == 'Add')
	{
		/*
			Ensures that equipment that doesnt require maintenance gets null values in the database for the expected fields.
		*/
		if($_POST['is_maintenance_required'] == 'no'){
			$last_maintained = Null;
			$maintain_every = Null;
		}else{
			$last_maintained = $_POST['last_maintained'];
			$maintain_every = $_POST['maintain_every'];
		}

		/*
			Ensures that equipment that is not broken gets null values in the database for the expected fields.
		*/
		if($_POST['is_broken'] == 'no'){
			$broken_desc = Null;
		}else{
			$broken_desc = $_POST['broken_desc'];
		}

		/*
			Ensures that if a serial number isnt assigned, it is entered into the DB as a NULL value.
		*/
		if($_POST['equip_serial'] == ''){
			$serial = null;
		}else{
			$serial = $_POST['equip_serial'];
		}

		$query = "
		INSERT INTO equipment (equip_name, equip_serial, equip_desc, is_maintenance_required, maintain_every, last_maintained, is_broken, broken_desc, equip_cost, equip_entered_by, equip_status, date_added) 
		VALUES (:equip_name, :equip_serial, :equip_desc, :is_maintenance_required, :maintain_every, :last_maintained, :is_broken, :broken_desc, :equip_cost, :equip_entered_by, :equip_status, :date_added)
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':equip_name'				=>	$_POST['equip_name'],
				':equip_serial'				=>	$serial,
				':equip_desc'				=>	$_POST['equip_desc'],
				':is_maintenance_required'	=>	$_POST['is_maintenance_required'],
				':maintain_every'			=>	$maintain_every,
				':last_maintained'			=> 	$last_maintained,
				':is_broken'				=> 	$_POST['is_broken'],
				':broken_desc'				=> 	$broken_desc,
				':equip_cost'				=>	$_POST['equip_cost'],
				':equip_entered_by'			=>	$_SESSION["user_id"],
				':equip_status'				=>	'active',
				':date_added'				=>	date("Y-m-d")
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo last_equipment_added_id($connect);
			
		}
	}

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
					'.$serial.'
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
			$output .= '<hr/>';

			//Maintenance Information Output
			if($row['is_maintenance_required'] == 'yes'){
				$output .= '
				<div class="table-responsive" style="margin-top:20px">
					<table class="table table-bordered" style="text-align:center">
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

			//Status Output
			$output .= '
			<div style="
				float:left;
				font-weight:bold;
				font-size:1.3em;
				padding-top: 5px;
				width:50%;
			">
				Status:
			'.$status.'
			</div>
			';

			//Availability Output
			if($row['is_available'] == 'available'){
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
					<span class="text-success glyphicon glyphicon-ok"></span>
				 	Available for Checkout
				</div>';
			}else{
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

			// //Availability Output
			// if($row['is_available'] == 'available'){
			// 	$output .= '
			// 	<tr>
			// 		<td style="text-align:right;font-weight:bold">Availability:</td>
			// 		<td>
			// 			<span class="text-success glyphicon glyphicon-ok"></span>
			// 			Available for Checkout
			// 		</td>
			// 	</tr>
			// 	';
			// }else{
			// 	$output .= '
			// 	<tr>
			// 		<td style="text-align:right;font-weight:bold">Availability:</td>
			// 		<td>
			// 			<span class="text-danger glyphicon glyphicon-remove"></span>
			// 			In Use
			// 		</td>
			// 	</tr>
			// 	';
			// }

		// }
		echo $output;
	}

	//When the 'Update' button is pressed, this function sends data to the modal to display whatever current data is saved for each option
	if($_POST['btn_action'] == 'fetch_single')
	{
		$query = "
		SELECT * 
		FROM equipment 
		WHERE equip_id = :equip_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':equip_id'	=>	$_POST["equip_id"]
			)
		);
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['equip_name'] = $row['equip_name'];
			$output['equip_serial'] = $row['equip_serial'];
			$output['equip_desc'] = $row['equip_desc'];
			$output['is_maintenance_required'] = $row['is_maintenance_required'];
			$output['maintain_every'] = $row['maintain_every'];
			$output['last_maintained'] = $row['last_maintained'];
			$output['is_broken'] = $row['is_broken'];
			$output['broken_desc'] = $row['broken_desc'];
			$output['equip_cost'] = $row['equip_cost'];
		}
		echo json_encode($output);
	}

	//When the 'Edit' button inside the 'update' modal is pressed, this function changes the old data values with the newly edited ones sent from the form.
	if($_POST['btn_action'] == 'Edit')
	{
		$query = "
		UPDATE equipment 
		set 
		equip_name = :equip_name,
		equip_serial = :equip_serial,
		equip_desc = :equip_desc, 
		equip_cost = :equip_cost,
		is_maintenance_required = :is_maintenance_required,
		maintain_every = :maintain_every,
		last_maintained = :last_maintained,
		is_broken = :is_broken,
		broken_desc = :broken_desc
		WHERE equip_id = :equip_id
		";

		/*
			Ensures that equipment that doesnt require maintenance gets null values in the database for the expected fields.
		*/
		if($_POST['is_maintenance_required'] == 'no'){
			$last_maintained = Null;
			$maintain_every = Null;
		}else{
			$last_maintained = $_POST['last_maintained'];
			$maintain_every = $_POST['maintain_every'];
		}

		if($_POST['is_broken'] == 'no'){
			$broken_desc = Null;
		}else{
			$broken_desc = $_POST['broken_desc'];
		}


		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':equip_name'				=>	$_POST['equip_name'],
				':equip_serial'				=>	$_POST['equip_serial'],
				':equip_desc'				=>	$_POST['equip_desc'],
				':equip_cost'				=>	$_POST['equip_cost'],
				':is_maintenance_required'	=>	$_POST['is_maintenance_required'],
				':maintain_every'			=>	$maintain_every,
				':last_maintained'			=>	$last_maintained,
				':is_broken'				=>	$_POST['is_broken'],
				':broken_desc'				=>	$broken_desc,
				':equip_id'					=>	$_POST['equip_id']
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			// echo 'Equipment Details Edited';
			echo 'Equipment successfully updated';
		}
	}
 
	//********** DELETE BUTTON **********
	if($_POST['btn_action'] == 'delete')
	{
		$status = 'active';
		if($_POST['status'] == 'active')
		{
			$status = 'inactive';
		}
		$query = "
		UPDATE equipment 
		SET equip_status = :equip_status 
		WHERE equip_id = :equip_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':equip_status'	=>	$status,
				':equip_id'		=>	$_POST["equip_id"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Equipment status change to ' . $status;
		}
	}
}
?>
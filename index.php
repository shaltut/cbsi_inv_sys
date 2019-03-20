<?php
//index. (cbsi_inv_sys)

include('database_connection.php');
include('function.php');

if(!isset($_SESSION["type"]))
{
	header("location:login.php");
}

include('header.php');
?>

	<br />
	<div class="row">
	<?php
	if($_SESSION['type'] == 'master')	
	{
	?>
			<!-- 

				This function should show the TOTAL number of employees with accounts (excluding master admin users)

			-->
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading"><strong>Total Employees</strong></div>
				<div class="panel-body" align="center">
					<h1><?php echo count_user_total($connect); ?></h1>
				</div>
			</div>
		</div>

			<!-- 
				NEEDS WORK

				This function should show the TOTAL number of pieces of equipment checked out by ALL employees (only seen by admin).

				That is to say, when an employee checks out a piece of equipment, this number should increment, and when the check it back in, it should decrement.
			-->
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading"><strong>Total Equipment Checked Out</strong></div>
				<div class="panel-body" align="center">
					<h1><?php echo count_check_out_total($connect); ?></h1>
				</div>
			</div>
		</div>

	<?php
	}
	?>

			<!-- 
				NEEDS WORK

				This function should show the number of pieces of equipment checked out by the employee who owns the account. 

				That is to say, when the employee currently logged in checks out a piece of equipment, this number should increment, and when they check it back in, it should decrement.
			-->
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading"><strong>Equipment Checked Out By You</strong></div>
				<div class="panel-body" align="center">
					<h1><?php echo count_check_out_user($connect, $_SESSION['user_id']); ?></h1>
				</div>
			</div>
		</div>

		<hr />
	
				<!-- 
					NEEDS WORK
					**** Admins should see **** DONE!
					This function should show a table that lists the following:
					- Employee#
					- Employee name (first and last)
					- equip_id
					- equip_name
					- site_id

					**** Users should see ****
					- equip_id
					- equip_name
					- site_id
					- 
				-->
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
	                <div class="panel-heading">
	                   	<div class="row">
	                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
	                           	<h3 class="panel-title">Checkouts Today</h3>
	                        </div>
	                    </div>
	                    <div class="clear:both"></div>
	                </div>
	                <div class="panel-body">
	                   	<div class="row"><div class="col-sm-12 table-responsive">
	                   		<table id="index_data" class="table table-bordered table-striped">
	                   			<thead>
									<tr>
										<th>Employee ID</th>
										<th>Name</th>
										<th>Equipment ID</th>
										<th>Equipment</th>
										<th>Date of Checkout</th>
									</tr>
								</thead>
	                   		</table>
	                   	</div>
	               	</div>
	           	</div>
	       	</div>
	    </div>
    </div>

    <?php
	include("footer.php");
	?>

<script>
$(document).ready(function(){
    var equipmentdataTable = $('#index_data').DataTable({
        "processing":true,
        "serverSide":true,
        "order":[],
        "ajax":{
            url:"index_fetch.php",
            type:"POST"
        },
        "columnDefs":[
            {

                // "targets":[],
                "orderable":false,
            },
        ],
        "pageLength": 5
    });

});
</script>
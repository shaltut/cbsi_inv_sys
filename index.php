<?php
//index.php

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
			This function shows the TOTAL number of employees with accounts (excluding master admin users).
		-->
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading"><strong>Total Employees</strong></div>
				<div class="panel-body" align="center">
					<h1><?php echo count_employee_total($connect); ?></h1>
				</div>
			</div>
		</div>

		<!-- 
			This function shows the TOTAL number of pieces of equipment checked out by ALL employees (only seen by admin).
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
		This function shows the number of pieces of equipment checked out by the employee who is currently logged in.
	-->
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading"><strong>Equipment Checked Out By You</strong></div>
			<div class="panel-body" align="center">
				<h1><?php echo count_check_out_user($connect, $_SESSION['user_id']); ?></h1>
			</div>
		</div>
	</div>

	<?php
	if($_SESSION['type'] == 'master')	
	{
	?>

	<hr />
	<!--
		Shows the currently checked out items, and the users who checked them out

		THIS IS A STATIC TABLE. IT JUST DISPLAYS ITEMS CHECKED OUT ON THE CURRENT SYS DATE. 
	-->
	<div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading" style="font-size:1.4em;">
            	<center><strong>Equipment Checked Out Today</strong></center>
            </div>
                <?php echo get_checkouts_today($connect); ?>
                <div style="float:right">
            		<span class="glyphicon glyphicon-ok" style="text-size:1em;"></span> = Returned,
            		<span class="glyphicon glyphicon-remove" style="text-size:1em;"></span> = Still In Use
            	</div>
        </div>
    </div>
	<?php
	}
	?>
    <?php
	include("footer.php");
	?>









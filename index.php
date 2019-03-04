<?php
//index.php
include('database_connection.php');
include('function.php');

if(!isset($_SESSION["type"]))
{
	header("location:login.php");
}
//Names: 
//Diana
include('header.php');
?>

	<br />
	<div class="row">
	<?php
	if($_SESSION['type'] == 'master')	
	{
	?>
			<!-- 
				NEEDS WORK

				This function should show the TOTAL number of employees with accounts (excluding master admin users)
			-->
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading"><strong>Total Employees</strong></div>
				<div class="panel-body" align="center">
					<h1><?php echo count_total_user($connect); ?></h1>
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
				<div class="panel-heading"><strong>Total Equipment Checked In</strong></div>
				<div class="panel-body" align="center">
					<h1><?php echo count_total_product($connect); ?></h1>
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
					<h1>$<?php echo count_total_order_value($connect); ?></h1>
				</div>
			</div>
		</div>

			<!-- 
				These probs arent needed, but figured id keep them here just in case.

				The first function 'count_total_cash_order_value($connect' returns the total value of all cash orders 

				The second function 'count_total_credit_order_value($connect)' returns the total value of all cash orders.
			-->
		<!-- <div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading"><strong>Total Cash Order Value</strong></div>
				<div class="panel-body" align="center">
					<h1>$<?php echo count_total_cash_order_value($connect); ?></h1>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading"><strong>Total Credit Order Value</strong></div>
				<div class="panel-body" align="center">
					<h1>$<?php echo count_total_credit_order_value($connect); ?></h1>
				</div>
			</div>
		</div> -->
		<hr />
		<?php
		if($_SESSION['type'] == 'master')
		{
		?>

				<!-- 
					NEEDS WORK

					This function should show a table that lists the following:
					- Employee#
					- Employee name (first and last)
					- SiteID
					- Equipment_id
				-->
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading"><strong>Total Order Value User wise</strong></div>
					<div class="panel-body" align="center">
						<?php echo get_user_wise_total_order($connect); ?>
					</div>
				</div>
			</div>
		<?php
		}
		?>
	</div>

<?php
include("footer.php");
?>
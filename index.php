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
				<div class="panel-heading">
					<strong>Total Employees</strong>
				</div>
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
				<div class="panel-heading">
					<strong>Total Equipment Checked Out</strong>
				</div>
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
			<div class="panel-heading">
				<strong>Equipment Checked Out By You</strong>
			</div>
			<div class="panel-body" align="center">
				<h1><?php echo count_check_out_user($connect, $_SESSION['user_id']); ?></h1>
			</div>
		</div>
	</div>

</div> <!-- First Row -->
<div class="row">

	<!-- This block of code either outputs a table that shows currently checked out items, or a div that displays "All Equipment Accounted For" -->
	<?php
	if($_SESSION['type'] == 'master'){
	   	if(count_check_out_total($connect) <= 0){
	?>
	   		<div class="col-md-12">
		        <div class="panel panel-default">
		            <div class="panel-heading" style="font-size:1.4em; background-color:rgba(0, 255, 0, 0.2);">
		            	<center>
		            		<strong>All Equipment Accounted For</strong>
		            		<button type="button" class="btn btn-link" data-toggle="popover" data-content="There are no items currently checked out, and all previously checked out items have been returned." data-placement="left" style="position: absolute; top:-5px; right:10px">
		                     	<img src="images/info5_sm.png" alt="info">
		                    </button>
		            	</center>
		            </div>
		        </div>
		    </div>
	<?php
	   	}else{
	?>
			<!--
				Shows the currently checked out items, and the users who checked them out
			-->
			<div class="col-md-12">
		        <div class="panel panel-default">
		            <div class="panel-heading" style="font-size:1.4em;">
		            	<center>
			            	<strong>Currently Checked Out</strong>
			            <button type="button" class="btn btn-link" data-toggle="popover" data-content="This table displays equipment still in use (or that hasn't been returned)." data-placement="left" style="position: absolute; top:-5px; right:10px">
			            	<img src="images/info5_sm.png" alt="info">
			           	</button>
			           </center>
		            </div>
		                <?php echo table_checkouts($connect); ?>
		        </div>
		    </div>
	<?php
		}
	?>

</div> <!-- Second Row -->
<div class="row">
	<?php
	   	if(num_checkout_today($connect) <= 0){
	?>
	   		<div class="col-md-12">
		        <div class="panel panel-default">
		            <div class="panel-heading" style="font-size:1.4em; background-color:rgba(0, 255, 0, 0.2);">
		            	<center>
		            		<strong>No Checkouts Occured Today</strong>
		            		<button type="button" class="btn btn-link" data-toggle="popover" data-content="No checkouts have occured yet today." data-placement="left" style="position: absolute; top:-5px; right:10px">
		                     	<img src="images/info5_sm.png" alt="info">
		                    </button>
		            	</center>
		            </div>
		        </div>
		    </div>
	<?php
	    }else{
	?>
		    <!--
				Shows the currently checked out items, and the users who checked them out

				THIS IS A STATIC TABLE. IT JUST DISPLAYS ITEMS CHECKED OUT ON THE CURRENT SYS DATE. 
			-->
			<div class="col-md-12">
		        <div class="panel panel-default">
		            <div class="panel-heading" style="font-size:1.4em;">
		            	<center>
		            		<strong>Equipment Checked Out Today</strong>
		            		<button type="button" class="btn btn-link" data-toggle="popover" data-content="This table displays all the checkouts that have occured today. (Both returned and not returned)" data-placement="left" style="position: absolute; top:-5px; right:10px">
		                     	<img src="images/info5_sm.png" alt="info">
		                    </button>
		            	</center>
		            </div>
		                <?php echo table_checkouts_today($connect); ?>
		                <div style="float:right">
		            		<span class="glyphicon glyphicon-ok" style="text-size:1em;"></span> = Returned,
		            		<span class="glyphicon glyphicon-remove" style="text-size:1em;"></span> = Still In Use
		            	</div>
		        </div>
		    </div>
	<?php
	    }
	}
	?>
</div> <!-- Third Row -->
<hr />
<div class="row">
	<!--
		Shows the currently checked out items for the currently logged in user
	-->
	<div class="col-md-12" style="">
	    <div class="panel panel-default">
	        <div class="panel-heading" style="font-size:1.4em;">
	        	<center>
	        		<strong>Your Equipment</strong>
	        		<button type="button" class="btn btn-link" data-toggle="popover" data-content="This table displays all the equipment you have checked out recently." data-placement="left" style="position:absolute;top:-5px;right:10px">
	                 	<img src="images/info5_sm.png" alt="info">
	                </button>
	        	</center>
	        </div>
	        <?php echo table_checkouts_user_wise($connect); ?>
	        <div style="float:right">
	        	<span class="glyphicon glyphicon-ok" style="text-size:1em;">
	        		
	        	</span> = Returned,
	        	<span class="glyphicon glyphicon-remove" style="text-size:1em;">
	        		
	        	</span> = Still In Use
	        </div>
	    </div>
	</div>
</div>





<!-- Importing the footer code -->    
</div>
<?php
include("footer.php");
?>





<script>
$(document).ready(function(){
    //Used to toggle off/on the INFO popovers on the forms
    $(function () {
        $('[data-toggle="popover"]').popover();
    });

});
</script>







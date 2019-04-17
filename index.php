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

<div class="row">
	<?php
	if(count_check_out_user($connect, $_SESSION['user_id']) > 0){
	?>
		<!-- 
			This function shows the number of pieces of equipment checked out by the employee who is currently logged in.
		-->
		<div class="col-sm-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<strong>Your Checkouts Total</strong>
				</div>
				<div class="panel-body" align="center">
					<h1><?php echo count_check_out_user($connect, $_SESSION['user_id']); ?></h1>
				</div>
			</div>
		</div>
	<?php
	}
	?>

</div> 	<!-- End First Row -->
<div class="row">
	<?php
	if(count_check_out_user($connect, $_SESSION['user_id']) > 0){
	?>
		<!--
			Shows the currently checked out items for the currently logged in user
		-->
		<div class="col-sm-12">
		    <div class="panel panel-default">
		        <div class="panel-heading" style="font-size:1.4em;">
		        	<center>
		        		<strong>Your Checkouts</strong>
		        		<button type="button" class="btn btn-link" data-toggle="popover" data-content="This table displays all the equipment you have checked out recently." data-placement="left" style="position:absolute;top:-5px;right:10px">
		                 	<img src="images/info5_sm.png" alt="info">
		                </button>
		        	</center>
		        </div>
		        <?php echo table_checkouts_user_wise($connect); ?>
		        <div style="float:right">
		        	<span class="glyphicon glyphicon-ok">
		        		
		        	</span> = Returned,
		        	<span class="glyphicon glyphicon-remove">
		        		
		        	</span> = Still In Use
		        </div>
		    </div>
		</div>
	<?php
	}else{
	?>
		<div class="row" style="margin:40px 0 0 0;">
		   		<div class="col-sm-12">
			        <div class="panel panel-default">
			            <div class="panel-heading" style="font-size:1.4em; background-color:rgba(0, 255, 0, 0.2);">
			            	<center>
			            		<strong>You have no equipment checked out!</strong>
			            		<button type="button" class="btn btn-link" data-toggle="popover" data-content="You have no outstanding checkouts!" data-placement="left" style="position: absolute; top:-5px; right:10px">
			                     	<img src="images/info5_sm.png" alt="info"/>
			                    </button>
			            	</center>
			            </div>
			        </div>
			    </div>
			</div>
	<?php
	}
	?>
</div> 	<!-- End Second Row -->
<hr/>


	<!-- This block of code either outputs a table that shows currently checked out items, or a div that displays "All Equipment Accounted For" -->
	<?php
	if($_SESSION['type'] == 'master'){
	   	if(count_check_out_total($connect) <= 0){
	?>
			<div class="row" style="margin:40px 0 0 0;">
		   		<div class="col-sm-12">
			        <div class="panel panel-default">
			            <div class="panel-heading" style="font-size:1.4em; background-color:rgba(0, 255, 0, 0.2);">
			            	<center>
			            		<strong>All Equipment Accounted For</strong>
			            		<button type="button" class="btn btn-link" data-toggle="popover" data-content="There are no items currently checked out, and all previously checked out items have been returned." data-placement="left" style="position: absolute; top:-5px; right:10px">
			                     	<img src="images/info5_sm.png" alt="info"/>
			                    </button>
			            	</center>
			            </div>
			        </div>
			    </div>
			</div>
	<?php
	   	}else{
	?>

			<!-- 
				This function shows the TOTAL number of pieces of equipment checked out by ALL employees (only seen by admin).
			-->
			<div class="row" style="margin:40px 0 0 0;">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<strong>Total Equipment Checked Out</strong>
						</div>
						<div class="panel-body" align="center">
							<h1><?php echo count_check_out_total($connect); ?></h1>
						</div>
					</div>
				</div>
			</div>

				<!--
					Shows the currently checked out items, and the users who checked them out
				-->
				<div class="row">
					<div class="col-sm-12">
				        <div class="panel panel-default">
				            <div class="panel-heading" style="font-size:1.4em;">
				            	<center>
					            	<strong>All Checkouts</strong>
					            <button type="button" class="btn btn-link" data-toggle="popover" data-content="This table displays equipment still in use (or that hasn't been returned). -- All Employees" data-placement="left" style="position: absolute;top:-5px; right:10px">
					            	<img src="images/info5_sm.png" alt="info"/>
					           	</button>
					           </center>
				            </div>
				                <?php echo table_checkouts($connect); ?>
				        </div>
				    </div>
				</div>
	<?php
		}
	}
	?>


<!-- Importing the footer code -->    
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

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
<style>
	#panel-head{
		text-align:center ;
	}

	@media (min-width: 768px) {
	  	#panel-head{
			text-align:left;
		}
		.row-small{
			width:25%;
			float:left;
			margin-left: 5%;
		}
		.table-small{
			width:65%;
			margin-right: 5%;
			float:right;
		}
		#info-div{
			width:65%;
			margin-right: 5%;
			float:right;
			padding:0 15px;
		}
	}

	@media (min-width: 992px) {
	  	
	}

	@media (min-width: 1200px) {
	  	
	}
</style>
	<div id="info-div">
		<div class="panel panel-default">
			<div class="panel-heading" id="panel-head">
				Account Information
			</div>
			<div class="panel-body" align="left">
				<table style="width:50%;float:left">
					<tr style="border-bottom:1px solid black;">
						<td style="font-weight:bold;font-size:1.3em;padding:3px;text-align:right;"> Name:</td>
						<td style="font-size:1.2em;padding:3px;text-align:left;"><?php echo '  &nbsp; '.$_SESSION['user_name']; ?></td>
					</tr>

					<tr>
						<td style="font-weight:bold;font-size:1.3em;padding:3px;text-align:right;">User ID:</td>
						<td style="font-size:1.2em;padding:3px"><?php 
							if($_POST['type'] == 'user'){
								echo '  &nbsp; Full Access';
							}else{
								echo '  &nbsp; Standard';
							} ?>
						</td>
					</tr>
				</table>
				<table style="width:50%;float:left">
					<tr style="border-bottom:1px solid black;">
						<td style="font-weight:bold;font-size:1.3em;padding:3px;text-align:right;"> Acct Type:</td>
						<td style="font-size:1.2em;padding:3px;text-align:left;">
							<?php 
								echo ' &nbsp; '.$_SESSION['user_id'];
							?>
						</td>
					</tr>

					<tr style="">
						<td style="font-weight:bold;font-size:1.3em;padding:3px;text-align:right;">Last Login:</td>
						<td style="font-size:1.07em;padding:3px"><?php 

							$date = get_empl_last_log_by_id($connect, $_SESSION['user_id']);

							$time = strtotime($date);

							$test_date = date("Y-m-d", $time);

							if($test_date == date("Y-m-d")){
								$out = 'Today at '.date("g:ia", $time);
							}else{
								$out = date("F jS, Y", $time);
							}

							echo ' &nbsp; '.$out;
							?></td>
					</tr>
				</table>
			</div>
		</div>
	</div>

	<!-- 
		This function shows the number of pieces of equipment checked out by the employee who is currently logged in.
	-->
	<div class="row-small">
		<div class="panel panel-default">
			<div class="panel-heading" id="panel-head">
				Your Checkouts
			</div>
			<div class="panel-body" align="center">
				<h1><?php echo count_check_out_user($connect, $_SESSION['user_id']); ?></h1>
			</div>
		</div>


	<!-- This block of code either outputs a table that shows currently checked out items, or a div that displays "All Equipment Accounted For" -->
	<?php
	if($_SESSION['type'] == 'master'){
	   	if(count_check_out_total($connect) <= 0){
	?>
	        <div class="panel panel-default">
	            <div class="panel-heading"id="panel-head">
	            	<center>
	            		All Equipment Accounted For
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
					<div class="panel panel-default">
						<div class="panel-heading" id="panel-head">
							<strong>System Checkouts</strong>
						</div>
						<div class="panel-body" align="center">
							<h1><?php echo count_check_out_total($connect); ?></h1>
						</div>
					</div>
				</div>
				<!--
					Shows the currently checked out items, and the users who checked them out
				-->
			<center>
				<div class="table-small">
					<div class="col-sm-12">
				        <div class="panel panel-default">
				            <div class="panel-heading" id="panel-head">
				            	<center>
					            	All Checkouts
					            <button type="button" class="btn btn-link" data-toggle="popover" data-content="This table displays equipment still in use (or that hasn't been returned). -- All Employees" data-placement="left" style="position: absolute;top:-5px; right:10px">
					            	<img src="images/info5_sm.png" alt="info"/>
					           	</button>
					           </center>
				            </div>
				                <?php echo table_checkouts($connect); ?>
				        </div>
				    </div>
				</div>
			</center>
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
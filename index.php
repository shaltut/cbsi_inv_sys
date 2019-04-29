<?php
//index.php
include('database_connection.php');	//Imports the connection to the database
include('function.php');	//Imports the function.php page
if(!isset($_SESSION["type"]))
{
	header("location:login.php");
}
include('header.php');	//Imports the header (Nav bar)
?>
<style>
	#panel-head{
		text-align:center ;
	}
	.lbl{
		font-weight:bold;
		font-size:1em;
		padding:3px;
		text-align:right;
	}
	.data{
		font-size:1.1em;
		padding:3px;
		text-align:left;
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
		.lbl{
			font-size:1.05em;
		}
		.data{
			font-size:1.1em;
		}
	}

	@media (min-width: 992px) {
		.row-small{
			width:20%;
			margin-left: 10%;
		}
		.table-small{
			width:60%;
			margin-right: 10%;
		}
		#info-div{
			width:60%;
			margin-right: 10%;
		}
		.lbl{
			font-size:1.1em;
		}
		.data{
			font-size:1.2em;
		}
	}

	@media (min-width: 1200px) {
		.row-small{
			width:15%;
			margin-left: 10%;
		}
		.table-small{
			width:63%;
			margin-right: 12%;
		}
		#info-div{
			width:63%;
			margin-right: 12%;
		}
		.lbl{
			font-size:1.3em;
		}
		.data{
			font-size:1.4em;
		}
	}
</style>

	<!-- Account Information Pannel -->
	<div id="info-div">
		<div class="panel panel-default">
			<div class="panel-heading" id="panel-head" style="background-color:rgba(0,24,48,.9);">
				Account Information
			</div>
			<div class="panel-body" align="left">
				<table style="width:50%;float:left">
					<tr style="border-bottom:1px solid black;">
						<td class="lbl"> Name:</td>
						<td class="data"><?php echo '  &nbsp; '.$_SESSION['user_name']; ?></td>
					</tr>

					<tr>
						<td class="lbl">Acct Type:</td>
						<td class="data"><?php 
							if($_SESSION['type'] == 'user'){
								echo '  &nbsp; <span style="color:blue;">Standard</span>';
							}else{
								echo '  &nbsp; <span style="color:red;">Full Access</style>';
							} ?>
						</td>
					</tr>
				</table>
				<table style="width:50%;float:left">
					<tr style="border-bottom:1px solid black;">
						<td class="lbl"> User ID:</td>
						<td class="data">
							<?php 
								echo ' &nbsp; '.$_SESSION['user_id'];
							?>
						</td>
					</tr>

					<tr style="">
						<td class="lbl">Last Login:</td>
						<td class="data"><?php 

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
			<div class="panel-heading" id="panel-head" style="background-color:rgba(0,24,48,.9);">
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
	            <div class="panel-heading" id="panel-head" style="background-color:darkgreen;">
	            	<center>
	            		All Equipment Accounted For
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
						<div class="panel-heading" id="panel-head" style="background-color:rgba(57,116,116,.9);">
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
				            <div class="panel-heading" id="panel-head"  style="background-color:rgba(57,116,116,.9);">
					            	All Checkouts
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

<script>
$(document).ready(function(){
    //Used to toggle off/on the INFO popovers on the forms
    $(function () {
        $('[data-toggle="popover"]').popover();
    });
});
</script>

<!-- Importing the footer code -->    
<?php
include("footer.php");
?>
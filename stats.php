<?php
//stats.php
//Work in progress, debating best way to style/present and developing functions with relevant info

include('database_connection.php');
include('function.php');
include('charts_js.php');

if(!isset($_SESSION["type"]))
{
    header('location:login.php');
}

if($_SESSION['type'] != 'master')
{
    header('location:index.php');
}

include('header.php');

?>
<!-- Alerts the user to changes they have made, or errors -->
<span id='alert_action'></span>

<button onclick="goBack()" style="float:right;">Go Back</button>

<center><h2 class="decorated"><span id="sites">Site Stats</span></h2></center>
<div class="row">
	<div class="col-lg-12">
	    <div class="panel panel-default">
	        <div class="panel-heading">
	            <div class="row">
	                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
	                    <h3 class="panel-title">Site Stats</h3>
	                </div>
	            </div>
	        </div>
	        <div class="panel-body">
	            <div class="row"><div class="col-sm-12 table-responsive">
	                <table id="equipment_data" class="table table-bordered table-striped">
	                    <thead><tr>
	                        <th>Active Sites</th>
	                        <th><?php echo count_active_site($connect); ?></th>
	                    </tr></thead>
	                    <thead><tr>
	                        <th>Inactive Sites</th>
	                        <th><?php echo count_inactive_site($connect); ?></th>
	                    </tr></thead>
	                </table>
	            </div></div>
	        </div>
	    </div>
	</div>
</div>


<center><h2 class="decorated"><span id="employees">Employee Stats</span></h2></center>
<div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                                <h3 class="panel-title">Employee Stats</h3>
                            </div>
                        
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align='right'>
                                
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row"><div class="col-sm-12 table-responsive">
                            <table id="equipment_data" class="table table-bordered table-striped">
                                <thead><tr>
                                    <th>Employees</th>
                                    <th><?php echo count_employee_total($connect); ?></th>
                                </tr></thead>
                                <thead><tr>
                                    <th>Admin Accounts</th>
                                    <th><?php echo count_master_active($connect); ?></th>
                                </tr></thead>
                                <thead><tr>
                                    <th>Total Users</th>
                                    <th><?php echo count_total_user_active($connect); ?></th>
                                </tr></thead>
                            </table>
                        </div></div>
                    </div>
                </div>
            </div>
        </div>

<center><h2 class="decorated"><span id="equipment">Equipment Stats</span></h2></center>
<div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                                <h3 class="panel-title">Equipment Stats</h3>
                            </div>
                        
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align='right'>
                                
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row"><div class="col-sm-12 table-responsive">
                            <table id="equipment_data" class="table table-bordered table-striped">
                                <thead><tr>
                                    <th>Total Equipment</th>
                                    <th><?php echo count_equipment_total($connect); ?></th>
                                </tr></thead>
                                <thead><tr>
                                    <th>Total Checked Out</th>
                                    <th><?php echo count_check_out_total($connect); ?></th>
                                </tr></thead>
                                <thead><tr>
                                    <th>Needs Maintenance</th>
                                    <th><?php echo check_equip_maintenance($connect); ?></th>
                                </tr></thead>
                            </table>
                        </div></div>
                        <center><div id="chartContainer" style="height: 500px; width: 50%;"></div></center>
                    </div>
                </div>
            </div>
        </div>


<script>
function goBack() {
  window.history.back();
}
</script>
           
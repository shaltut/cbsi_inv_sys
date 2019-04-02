<?php
//stats.php

include('database_connection.php');
include('function.php');

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

<button class="btn btn-info" onclick="goBack()" style="float:right;">Go Back</button>

<br/><br/><br/>

<!-- SITE STATS CARD-->
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
                <center>
                    <canvas id="check_by_site"></canvas>
                </center>
	        </div>
	    </div>
	</div>
</div>

<!-- EMPLOYEE STATS CARD-->
<div class="row" id="employees">
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
                    <br/>
                    <form action="#employees" method="post" id="user_stats_form">
                        <label for="empl_select" class="center">Select User to View Stats:</label>
                        <center>
                            <select class="form-control center" name="empl_id" id="empl_id" style="width:85%; display:inline">
                                <?php
                                    echo users_options($connect);
                                ?>
                            </select>
                            <input type="hidden" name="btn_action" id="btn_action"value="user_stat"/>
                            <input type="submit" name="emp_go" id="emp_go" class="btn btn-success" value="GO" onClick="submitEmplStats()"/>
                        </center>
                    </form>
                    <center><canvas id="empl_stat"></canvas></center>
            </div>
        </div>
    </div>
</div>

<!-- EQUIPMENT STATS CARD-->
<div class="row" id="equipment">
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
            </div>
        </div>
    </div>
</div>

<?php
    include('charts_js.php');
?>
<script>
$(document).ready(function(){

    $('#user_stats_form').on('change', function() {
        var $form = $(this).closest('form');
        $form.find('input[type=submit]').click();
    });

});
</script>
<script>
function goBack() {
  window.history.back();
}
</script>
           
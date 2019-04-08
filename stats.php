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
<div class="row" id="sites" style="padding-top: 10px">
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
	                <table id="site_stats_tbl" class="table table-bordered table-striped">
	                    <thead><tr>
	                        <th>Active Sites</th>
	                        <th><?php echo count_active_site($connect); ?></th>
	                    </tr></thead>
	                    <thead><tr>
	                        <th>Inactive Sites</th>
	                        <th><?php echo count_inactive_site($connect); ?></th>
	                    </tr></thead>
                        <?php
                        if(total_sites_VA($connect) > 0){
                        ?>
                            <thead><tr>
                                <th>Total Sites In Virginia</th>
                                <th><?php echo total_sites_VA($connect); ?></th>
                            </tr></thead>
                        <?php
                        }
                        if(total_sites_DC($connect) > 0){
                        ?>
                        <thead><tr>
                            <th>Total Sites In Washington DC</th>
                            <th><?php echo total_sites_DC($connect); ?></th>
                        </tr></thead>
                        <?php
                        }
                        if(total_sites_MD($connect) > 0){
                        ?>
                        <thead><tr>
                            <th>Total Sites In Maryland</th>
                            <th><?php echo total_sites_MD($connect); ?></th>
                        </tr></thead>
                        <?php
                        }
                        ?>
	                </table>
	            </div></div>
                <center>
                    <canvas id="check_by_site" style="max-width:600px;"></canvas>
                </center>
	        </div>
	    </div>
	</div>
</div>

<!-- EMPLOYEE STATS CARD-->
<div class="row" id="employees" style="padding-top: 10px">
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
                    <table id="empl_stats_tbl" class="table table-bordered table-striped">
                        <thead><tr>
                            <th>Number of Employees Registered</th>
                            <th><?php echo count_employee_total($connect); ?></th>
                        </tr></thead>
                        <thead><tr>
                            <th>Number of Admin Accounts</th>
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
                </div></div>
                <center>
                    <canvas id="empl_stat" style="max-width:600px; max-height:450px;"></canvas>
                </center>
            </div>
        </div>
    </div>
</div>

<!-- EQUIPMENT STATS CARD-->
<div class="row" id="equipment" style="padding-top: 10px">
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
                    <table id="equip_stats_tbl" class="table table-bordered table-striped">
                        <thead><tr>
                            <th>Equipment Total</th>
                            <th><?php echo count_equipment_total($connect); ?></th>
                        </tr></thead>
                        <thead><tr>
                            <th>Equipment Checked Out</th>
                            <th><?php echo count_check_out_total($connect); ?></th>
                        </tr></thead>
                        <thead><tr>
                            <th>Equipment Needing Maintenance</th>
                            <th><?php
                                $mCount = maintenance_red_num($connect); 
                                echo $mCount;
                                if($mCount > 0){
                                    echo "<a class=\"btn btn-xs btn-danger\" href=\"maintain.php\" role=\"button\" style=\"float:right; margin-right:10px;\">View</a>";
                                }else{
                                    echo "NOPE";
                                }
                            ?>    
                            </th>
                        </tr></thead>
                        <thead><tr>
                            <th>Total Cost of All Equipment</th>
                            <th><?php 
                                setlocale(LC_MONETARY, 'en_US');
                                echo money_format('%(#10n', total_equipment_cost($connect)); 
                            ?></th>
                        </tr></thead>
                    </table>
                </div></div>
                <div class="card">
                    <div class="card-body" style="border:5px">
                        <center><br/>
                            <!-- Pie Chart (Equipment Cost Visualized) -->
                            <canvas id="equip_cost_pie" style="max-width:600px; max-height:450px;"></canvas><br/>
                            <!-- Line Graph (Checkouts by month) -->
                            <canvas id="equip_monthly_checkouts" width="800" height="450"></canvas><br/>
                        </center>
                    </div>
                </div>
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
           
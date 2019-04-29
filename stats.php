<?php
//stats.php
include('database_connection.php');
include('chartjs_functions.php');

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
<div class="container">

<!-- Alerts the user to changes they have made, or errors -->
<span id='alert_action'></span>

<button class="btn" onclick="goBack()" style="float:right;background-color:rgba(3,54,78,.7);color:white">Go Back</button>

<br/><br/><br/>

<!-- SITE STATS CARD-->
<div class="row" id="sites" style="padding-top: 10px">
	<div class="col-lg-12">
	    <div class="panel panel-default" style="padding:0 0 40px 0;">
	        <div class="panel-heading " id="panel-head">Site Stats
	        </div>
	        <div class="panel-body">
	            <div class="row"><div class="col-sm-12 table-responsive">
	                <table id="site_stats_tbl" class="table table-bordered table-striped" style="border-color: red">
	                    <tr>
	                        <td style="font-weight:bold;font-size:1.2em">
	                        	Active Sites
	                        </td>
	                       	<td style="font-weight:bold;font-size:1.2em">
	                       		<?php echo count_active_site($connect); ?>
	                       	</td> 
	                    </tr>
	                    <tr>
	                        <td style="font-weight:bold;font-size:1.2em">
	                        	Inactive Sites
	                       	</td>
	                        <td style="font-weight:bold;font-size:1.2em">
	                        	<?php echo count_inactive_site($connect); ?>
	                      	</td>
	                    </tr>
                        <?php
                        if(total_sites_VA($connect) > 0){
                        ?>
                            <tr>
                                <td style="font-weight:bold;font-size:1.2em">
                                	Total Sites In Virginia
                                </td>
                                <td style="font-weight:bold;font-size:1.2em">
                                	<?php echo total_sites_VA($connect); ?>
                                </td>
                            </tr>
                        <?php
                        }
                        if(total_sites_DC($connect) > 0){
                        ?>
                        <tr>
                            <td style="font-weight:bold;font-size:1.2em">
                            	Total Sites In Washington DC
                            </td>
                            <td style="font-weight:bold;font-size:1.2em">
                            	<?php echo total_sites_DC($connect); ?>
                            </td>
                        </tr> 
                        <?php
                        }
                        if(total_sites_MD($connect) > 0){
                        ?>
                        <tr>
                            <td style="font-weight:bold;font-size:1.2em">
                            	Total Sites In Maryland
                        	</td>
                            <td style="font-weight:bold;font-size:1.2em">
                            	<?php echo total_sites_MD($connect); ?>
                            </td>
                        </tr>
                       <?php
                        }
                        ?>
	                </table>
	            </div></div>
                <center>
                    <div style="max-width:800px;padding:30px 0 0 0;">
                        <canvas id="check_by_site"></canvas>
                    </div>
                </center>
	        </div>
	    </div>
	</div>
</div>

<!-- EMPLOYEE STATS CARD-->
<div class="row" id="employees" style="padding-top: 10px">
    <div class="col-lg-12">
        <div class="panel panel-default" style="padding:0 0 40px 0;">
           <div class="panel-heading" id="panel-head">Employee Stats
	        </div>
            <div class="panel-body">
                <div class="row"><div class="col-sm-12 table-responsive">
                    <table id="empl_stats_tbl" class="table table-bordered table-striped">
                        <tr>
                            <td style="font-weight:bold;font-size:1.2em">
                            	Number of Employees Registered
                            </td>
                            <td style="font-weight:bold;font-size:1.2em">
                            	<?php echo count_employee_active($connect); ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold;font-size:1.2em">
                            	Number of Admin Accounts
                            </td>
                            <td style="font-weight:bold;font-size:1.2em">
                            	<?php echo count_master_active($connect); ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold;font-size:1.2em">
                            	Total Users
                            </td>
                            <td style="font-weight:bold;font-size:1.2em">
                            	<?php echo count_total_user_active($connect); ?>
                            </td>
                        </tr>
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
                    <div style="max-width:800px;padding:20px 0 0 0;">
                        <canvas id="empl_stat"></canvas>
                    </div>
                </center>
            </div>
        </div>
    </div>
</div>

<!-- EQUIPMENT STATS CARD-->
<div class="row" id="equipment" style="padding-top: 10px">
    <div class="col-lg-12">
        <div class="panel panel-default"  style="padding:0 0 40px 0;">
            <div class="panel-heading" id="panel-head">Equipment Stats
	        </div>
            <div class="panel-body">
                <div class="row"><div class="col-sm-12 table-responsive">
                    <table id="equip_stats_tbl" class="table table-bordered table-striped">
                        <tr>
                            <td style="font-weight:bold;font-size:1.2em">
                            	Equipment Total
                            </td>
                            <td style="font-weight:bold;font-size:1.2em">
                                <?php echo count_equipment_total($connect); ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold;font-size:1.2em">
                            	Equipment Checked Out
                            </td>
                            <td style="font-weight:bold;font-size:1.2em">
                                <?php echo count_check_out_total($connect); ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold;font-size:1.2em">
                            	Equipment Needing Maintenance
                            </td>
                            <td style="font-weight:bold;font-size:1.2em">
                            	<?php
	                                $mCount = maintenance_red_num($connect); 
	                                echo $mCount;
	                                if($mCount > 0){
	                                     echo "<a class=\"btn btn-xs btn-danger\" href=\"maintain.php\" role=\"button\" style=\"float:right; margin-right:10px;\">View</a>";
	                                }
                            	?>    
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold;font-size:1.2em">
                            	Total Cost of All Equipment
                            </td>
                            <td style="font-weight:bold;font-size:1.2em">
	                            <?php 
	                                echo printf("$%01.1f", total_equipment_cost($connect));
	                            ?>
                            </td>
                        </tr>
                    </table>
                </div></div>
                <div class="card">
                    <div class="card-body" style="border:5px">
                        <center><br/>
                            <div style="max-width:800px;padding:10px 0 0 0;">
                            <!-- Pie Chart (Equipment Cost Visualized) -->
                                <canvas id="equip_cost_pie"></canvas><br/>
                            </div>
                            <div style="max-width:800px;padding:40px 0 0 0;">
                            <!-- Line Graph (Checkouts by month) -->
                            <canvas id="equip_monthly_checkouts" width="800" height="450"></canvas><br/>
                            </div>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div><!-- Container -->
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
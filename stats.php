<?php
//stats.php
//Work in progress, debating best way to style/present and developing functions with relevant info

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


         <!-- Commented out stats cards in favor of stats page --> 

            

         <center><h2 class="decorated"><span>Site Stats</span></h2></center>

        
            <!--
                ********** NEEDS WORK ********** Needs function to show which sites are active and which are closed
              -->  

            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>
                    Active Sites</strong></div>
                    <div class="panel-body" align="center">
                        <h1><?php echo count_equipment_total($connect); ?></h1>
                    </div>
                </div>
            </div>

             <!--
                ********** NEEDS WORK ********** Function for inactive sites
                --> 
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Inactive Sites</strong></div>
                    <div class="panel-body" align="center">
                        <h1><?php echo count_master_active($connect); ?></h1>
                    </div>
                </div>
            </div>

              <!--
                ********** NEEDS WORK ********** Function for sites that are tagged DC (if we chose to input tags for DC or NOVA)
               --> 

            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>
                    DC</strong></div>
                    <div class="panel-body" align="center">
                        <h1><?php echo count_master_active($connect); ?></h1>
                    </div>
                </div>
            </div>

            <!--
                ********** NEEDS WORK ********** Function for sites that are tagged NOVA (if we chose to input tags for DC or NOVA)
                --> 
                
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Northern VA</strong></div>
                    <div class="panel-body" align="center">
                        <h1><?php echo count_total_user_active($connect); ?></h1>
                    </div>
                </div>
            </div>
        </div>

        <center><h2 class="decorated"><span>Employee Stats</span></h2></center>

        <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Employees</strong></div>
                    <div class="panel-body" align="center">
                        <h1><?php echo count_employee_total($connect); ?></h1>
                    </div>
                </div>
            </div>

            <!-- 
                    Shows the total number of Admins (Master)
                -->
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Admin Accounts</strong></div>
                    <div class="panel-body" align="center">
                        <h1><?php echo count_master_active($connect); ?></h1>
                    </div>
                </div>
            </div>

            <!-- 
                    Shows total number of users (Master & Non-Master)
                -->
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Total Users</strong></div>
                    <div class="panel-body" align="center">
                        <h1><?php echo count_total_user_active($connect); ?></h1>
                    </div>
                </div>
            </div>
        </div>


             <center><h2 class="decorated"><span>Equipment Stats</span></h2></center>

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Total Equipment</strong></div>
                    <div class="panel-body" align="center">
                        <h1><?php echo count_equipment_total($connect); ?></h1>
                    </div>
                </div>
            </div>

           <!--
                - Shows total checked out items
             -->  

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Total Checked-out</strong></div>
                    <div class="panel-body" align="center">
                        <h1><?php echo count_check_out_total($connect); ?></h1>
                    </div>
                </div>
            </div>

             <!--
                ********** NEEDS WORK **********
                    - The function needs to show items that need maintenance, currently working on the function in functions.php however, need to find a way for items that currently need maintenance to be  returned and not those that need in general (6months from now)
                -->

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Needs Maintenance</strong></div>
                    <div class="panel-body" align="center">
                        <h1><?php echo count_total_user_active($connect); ?></h1>
                    </div>
                </div>
            </div>
        </div>









<script>
$(document).ready(function(){
    var sitedataTable = $('#site_data').DataTable({
        "processing":true,
        "serverSide":true,
        "order":[],
        "ajax":{
            url:"site_fetch.php",
            type:"POST"
        },
        "columnDefs":[
            {

                "targets":[4, 5, 6],
                "orderable":false,
            },
        ],
        "pageLength": 6
    });

    $('#add_button').click(function(){
        $('#siteModal').modal('show');
        $('#site_form')[0].reset();
        $('.modal-title').html("<i class='fa fa-plus'></i> Add Item");
        $('#action').val("Add");
        $('#btn_action').val("Add");
    });

    $(document).on('submit', '#site_form', function(event){
        event.preventDefault();
        $('#action').attr('disabled', 'disabled');
        var form_data = $(this).serialize();
        $.ajax({
            url:"site_action.php",
            method:"POST",
            data:form_data,
            success:function(data)
            {
                $('#site_form')[0].reset();
                $('#siteModal').modal('hide');
                $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
                $('#action').attr('disabled', false);
                sitedataTable.ajax.reload();
            }
        })
    });

    $(document).on('click', '.view', function(){
        var site_id = $(this).attr("id");
        var btn_action = 'site_details';
        $.ajax({
            url:"site_action.php",
            method:"POST",
            data:{site_id:site_id, btn_action:btn_action},
            success:function(data){
                $('#sitedetailsModal').modal('show');
                $('#site_details').html(data);
            }
        })
    });

    $(document).on('click', '.update', function(){
        var site_id = $(this).attr("id");
        var btn_action = 'fetch_single';
        $.ajax({
            url:"site_action.php",
            method:"POST",
            data:{site_id:site_id, btn_action:btn_action},
            dataType:"json",
            success:function(data){
                $('#siteModal').modal('show');
                $('#site_name').val(data.site_name);
                $('#site_address').val(data.site_address);
                $('#job_desc').val(data.job_desc);
                $('#start_date').val(data.start_date);
                $('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Site");
                $('#site_id').val(site_id);
                $('#action').val("Edit");
                $('#btn_action').val("Edit");
            }
        })
    });

    $(document).on('click', '.delete', function(){
        var site_id = $(this).attr("id");
        var status = $(this).data("status");
        var btn_action = 'delete';
        if(confirm("Are you sure you want to change status?"))
        {
            $.ajax({
                url:"site_action.php",
                method:"POST",
                data:{site_id:site_id, status:status, btn_action:btn_action},
                success:function(data){
                    $('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
                    sitedataTable.ajax.reload();
                }
            });
        }
        else
        {
            return false;
        }
    });

});
</script>

<script>

    //Used to toggle the 'view stats' button 
    function buttontext() {
        if(document.getElementById("site_stat_btn").value === "Show Site Stats")
            document.getElementById("site_stat_btn").value = "Hide Site Stats";
        else
            document.getElementById("site_stat_btn").value = "Show Site Stats";
    }
</script>

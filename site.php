<?php
//site.php

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

            <input class="btn" id="site_stat_btn" value="Show Site Stats" type="button" data-toggle="collapse" data-target="#stats" aria-expanded="false" aria-controls="collapseExample" onclick="buttontext()"/>

        <div class="row collapse" id='stats'>
            <!-- 
                ********** NEEDS WORK **********
                -->
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>????</strong></div>
                    <div class="panel-body" align="center">
                        <h1><?php echo count_equipment_total($connect); ?></h1>
                    </div>
                </div>
            </div>

            <!-- 
                ********** NEEDS WORK **********
                -->
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>????</strong></div>
                    <div class="panel-body" align="center">
                        <h1><?php echo count_master_active($connect); ?></h1>
                    </div>
                </div>
            </div>

            <!-- 
                ********** NEEDS WORK **********
                -->
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>????</strong></div>
                    <div class="panel-body" align="center">
                        <h1><?php echo count_total_user_active($connect); ?></h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                                <h3 class="panel-title">Sites List</h3>
                            </div>
                        
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align='right'>
                                <button type="button" name="add" id="add_button" class="btn btn-success btn-xs">Add</button>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row"><div class="col-sm-12 table-responsive">
                            <table id="site_data" class="table table-bordered table-striped">
                                <thead><tr>
                                    <th>ID</th>
                                    <th>Site Name</th>
                                    <th>Job Description</th>
                                    <th>Start Date</th>
                                    <th>Status</th>
                                    <th>Details</th>
                                    <th>Update</th>
                                    <th>Delete</th>
                                </tr></thead>
                            </table>
                        </div></div>
                    </div>
                </div>
            </div>
        </div>

        <div id="siteModal" class="modal fade">
            <div class="modal-dialog">
                <form method="post" id="site_form">
                    <div class="modal-content">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><i class="fa fa-plus"></i> Add Site</h4>
                        </div>

                        <div class="modal-body">
                            <div class="form-group">
                                <label>Enter Site Name</label>
                                <input type="text" name="site_name" id="site_name" class="form-control" required />
                            </div>
                            <div class="form-group">
                                <label>Enter Job Description</label>
                                <textarea name="job_desc" id="job_desc" class="form-control" rows="5" required></textarea>
                            </div>
                            <div class="form-group">  
                                    <label for="start_date">Start Date</label>
                                    <input type="date" class="form-control" name="start_date" id="start_date"/>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <input type="hidden" name="site_id" id="site_id" />
                            <input type="hidden" name="btn_action" id="btn_action" />
                            <input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <div id="sitedetailsModal" class="modal fade">
            <div class="modal-dialog">
                <form method="post" id="site_form">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><i class="fa fa-plus"></i> Site Details</h4>
                        </div>
                        <div class="modal-body">
                            <Div id="site_details"></Div>
                        </div>
                        <div class="modal-footer">
                            
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
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

                "targets":[5, 6, 7],
                "orderable":false,
            },
        ],
        "pageLength": 8
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

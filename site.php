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

<!-- Button navigates to stats page-->
<a class="btn btn-link" href="stats.php#sites" role="button" style="float:right;">View Stats</a>

    <br/><br/>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                                <h3 class="panel-title" style="margin-top:10px; font-size:1.4em">Sites List</h3>
                            </div>
                        
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align='right'>
                                <button type="button" name="add" id="add_button" class="btn btn-link btn-md">
                                    <span class="glyphicon glyphicon-plus text-success" style="font-size:1.5em;"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row"><div class="col-sm-12 table-responsive">
                            <table id="site_data" class="table table-bordered table-striped display" cellspacing="0" width="100%">
                                <thead><tr>
                                    <th>ID</th>
                                    <th>Site Name</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
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
                                <input type="text" name="site_name" id="site_name" class="form-control" style="width:85%; display:inline;" required />
                                <button type="button" class="btn btn-link" data-toggle="popover" title="Name" data-content="What the site is typically called, either by business name, location (city), etc." data-placement="left">
                                    <img src="images/info5_sm.png" alt="info">
                                </button>
                            </div>
                            <div class="form-group">
                                <label>Enter Site Address</label>
                                <input type="text" name="site_address" id="site_address" class="form-control" style="width:85%; display:inline;" required />
                                <button type="button" class="btn btn-link" data-toggle="popover" title="Address" data-content="The site's physical address. If no address is available, list the closest address to the site's physical location" data-placement="left">
                                    <img src="images/info5_sm.png" alt="info">
                                </button>
                            </div>
                            <div class="form-group">
                                <label>Enter Job Description</label>
                                <textarea name="job_desc" id="job_desc" class="form-control" rows="5" style="width:85%; display:inline;" required></textarea>
                                <button type="button" class="btn btn-link" data-toggle="popover" title="Job Description" data-content="What work is being done at this site? What are we here to do?" data-placement="left">
                                    <img src="images/info5_sm.png" alt="info">
                                </button>
                            </div>
                            <div class="form-group">  
                                    <label for="start_date" style="width:100px;">Start Date</label>
                                    <input type="date" class="form-control" name="start_date" id="start_date" style="width:85%; display:inline;"/>
                                    <button type="button" class="btn btn-link" data-toggle="popover" title="Start Date" data-content="Select the date that work began at this site. If that date is unknown, leave this line blank." data-placement="left">
                                    <img src="images/info5_sm.png" alt="info">
                                </button>
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

                "targets":[4, 5, 6],
                "orderable":false,
            },
        ],
        "pageLength": 6
    });

    $('#add_button').click(function(){
        $('#siteModal').modal('show');
        $('#site_form')[0].reset();
        $('.modal-title').html("<i class='fa fa-plus'></i> Add New Site");
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
                $('.modal-title').html("<i class='fa fa-plus'></i>Site Details");
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

    $(function () {
        $('[data-toggle="popover"]').popover()
    })

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

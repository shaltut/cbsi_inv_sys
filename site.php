<?php
//site.php
include('database_connection.php');
// include('function.php');

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

<!-- This card/panel displays the Site dataTable on page load via JQuery (serverside DataTables) -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading" id="panel-head">
                <div class="row">
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                        <h3 class="panel-title" style="margin-top:10px; font-size:1.4em">Sites</h3>
                    </div>
                
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align='right'>
                        <button type="button" name="add" id="add_button" class="btn btn-link btn-md">
                            <span class="glyphicon glyphicon-plus text-success" style="font-size:1.5em;color:lightgreen"></span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="row"><div class="col-sm-12 table-responsive">
                    <table id="site_data" class="table table-striped" cellspacing="0" width="100%" style="text-align:center;">
                    	<!-- 
                    		This is where the JQuery data is sent to populate the DataTables table. Data is sent from site_fetch.php
                    	-->
                        <thead><tr>
                            <th class="dt_hr" style="padding-right:5px">Site Name</th>
                            <th class="dt_hr_sm">Details</th>
                            <th class="dt_hr_sm">Update</th>
                            <th class="dt_hr_sm">Status</th>
                        </tr></thead>
                    </table>
                </div></div>
            </div>
        </div>
    </div>
</div>

<!-- Display the View Stats button link to the stats.php page-->
<div style="text-align:right">
    <!-- Button navigates to stats page-->
    <a class="btn btn-stat" href="stats.php#sites" role="button" style="width:150px">More Sites Info</a><br/>
</div>
</br></br>

<!-- "Add/Update" Site Form Modal-->
<div id="siteModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="site_form">
            <div class="modal-content">
                <div class="modal-header">
                	<!-- 'Close' button (top) for Site Modal -->
                    <button type="button" class="close" data-dismiss="modal">
                    	<span class="glyphicon glyphicon-remove" style="color:white"></span>
                    </button>
                    <!-- Modal Header Text (also modified in JQuery at the bottom of this page) -->
                    <h4 class="modal-title" style="color:white"><i class="fa fa-plus"></i> Add Site</h4>
                </div>
                <!-- Input Field for Job-Site Name -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="site_name" class="form-lbl-lvl1">
                            Enter Job-site Name
                            <span style="color:red;font-size:1.5em"> *</span>
                        </label>
                        <input type="text" name="site_name" placeholder="Site Name" id="site_name" class="form-control form-in-lvl1" required />
                        <button type="button" class="btn btn-link" data-toggle="popover" title="Name" data-content="What the site is typically called. If there is only 1 job going on at this location, just enter the name of the business/location." data-placement="left">
                            <img src="images/info5_sm.png" alt="info">
                        </button>
                    </div>
                    <!-- Input Field for Address -->
                    <div class="form-group">
                        <label for="site_address" class="form-lbl-lvl1">
                            Enter Site Address
                            <span style="color:red;font-size:1.5em"> *</span>
                        </label>
                        <input type="text" name="site_address" placeholder="Site Address" id="site_address" class="form-control form-in-lvl1" required />
                        <button type="button" class="btn btn-link" data-toggle="popover" title="Address" data-content="The site's physical address. If no address is available, list the closest address to the site's physical location" data-placement="left">
                            <img src="images/info5_sm.png" alt="info">
                        </button>
                    </div>
                    <!-- Input Field for 'Job Description' -->
                    <div class="form-group">
                        <label for="job_desc" class="form-lbl-lvl1">
                            Enter Job Description
                            <span style="color:red;font-size:1.5em"> *</span>
                        </label>
                        <textarea name="job_desc" placeholder="Site Job Description" id="job_desc" class="form-control form-in-lvl1" rows="5" required></textarea>
                        <button type="button" class="btn btn-link" data-toggle="popover" title="Job Description" data-content="What work is being done at this site? What are we here to do?" data-placement="left">
                            <img src="images/info5_sm.png" alt="info">
                        </button>
                    </div>
                    <!-- Input Field for 'Start Date' -->
                    <div class="form-group">  
                        <label for="start_date" class="form-lbl-lvl1">
                            Start Date
                            <span style="color:red;font-size:1.5em"> *</span>
                        </label>
                        <input type="date" class="form-control form-in-lvl1" name="start_date" id="start_date"/>
                        <!-- Info PopOver Button -->
                        <button type="button" class="btn btn-link" data-toggle="popover" title="Start Date" data-content="Select the date that work began at this site. If that date is unknown, leave this line blank." data-placement="left">
                        	<!-- Info image -->
                        	<img src="images/info5_sm.png" alt="info">
                   	 	</button>
                    </div>
                </div>

                <div class="modal-footer">
                	<!-- These 2 hidden inputs send data that the action page requires when submitting the form -->
                    <input type="hidden" name="site_id" id="site_id" />
                    <input type="hidden" name="btn_action" id="btn_action" />
                    <!-- Submit Button for the Site Form -->
                    <input type="submit" name="action" id="action" class="btn btn-info" value="Add" style="width:100px"/>
                    <!-- Close Button (bottom) for the Site Form -->
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>

            </div>
        </form>
    </div>
</div>

<!-- "View" Site Information (or "Site Details") Modal-->
<div id="sitedetailsModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="site_form">
            <div class="modal-content">
                <div class="modal-header">
					<!-- Button (top) to close the modal -->
                    <button type="button" class="close" data-dismiss="modal">
                    	<span class="glyphicon glyphicon-remove" style="color:white"></span>
                    </button>
                    <!-- Modal header text -->
                    <h4 class="modal-title" style="color:white"><i class="fa fa-plus"></i> Site Details</h4>
                </div>
                <div class="modal-body">
                	<!-- This is where JQuery sends the html to display the site information -->
                    <Div id="site_details"></Div>
                </div>
                <div class="modal-footer">
 					<!-- Button (bottom) to close the modal -->
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

</div><!-- Container -->
<script>
$(document).ready(function(){
	/*
		DataTables API client side control variable.

		This variable initiates the dataTables API. Processing is serverside, and is done via site_fetch.php page.
	*/
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

                "targets":[1, 2, 3],
                "orderable":false,
            },
        ],
        "pageLength": 6
    });

    //	Action Processing for the '+' button to add a new site.
    $('#add_button').click(function(){
        $('#siteModal').modal('show');
        $('#site_form')[0].reset();
        $('.modal-title').html("<i class='fa fa-plus'></i> Add New Site");
        $('#action').val("Add");
        $('#btn_action').val("Add");
    });

    //	Action Processing for the form submit button (new site)
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

    //	Action Processing for the 'view' button (table)
    $(document).on('click', '.view', function(){
        var site_id = $(this).attr("id");
        var btn_action = 'site_details';
        $.ajax({
            url:"site_action.php",
            method:"POST",
            data:{site_id:site_id, btn_action:btn_action},
            success:function(data){
                $('#sitedetailsModal').modal('show');
                $('.modal-title').html("Site Details for ID: "+site_id);
                $('#site_details').html(data);
            }
        })
    });

    //	Action Processing for the 'Update' button (table)
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

    //	Action Processing for the information popovers
    $(function () {
        $('[data-toggle="popover"]').popover()
    })

    //	Action Processing for the disable/enable toggle button
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

    /*
		These are used to hardcode the CSS for various objects.

		They basically just auto-style the objects on page load suplimenting the bootstrap css.
    */
    //TOP (Show Entries and Search)
    $( "#site_data_length" ).css( "float", "left" );
    $( "#site_data_filter" ).css( "text-align", "right" );
    $( "input" ).css( "padding-left", "0" );
    $( "input" ).css( "padding-right", "0" );
    //BOTTOM (Showing x to y of z entries & Previous/Next)
    $( "#site_data_info" ).css( "float", "left" );
    $( "#site_data_info" ).css( "padding-left", "0" );
    $( "#site_data_info" ).css( "margin-left", "0" );
    $( "#site_data_paginate" ).css( "float", "right" );
    $( "#site_data_paginate" ).css( "padding-right", "0" );
    $( "#site_data_paginate" ).css( "margin-right", "0" );

});
</script>

<script>

    //	Action Processing for the 'Site Stats' button 
    function buttontext() {
        if(document.getElementById("site_stat_btn").value === "Show Site Stats")
            document.getElementById("site_stat_btn").value = "Hide Site Stats";
        else
            document.getElementById("site_stat_btn").value = "Show Site Stats";
    }
</script>
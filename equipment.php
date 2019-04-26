<?php
//equipment.php

//Includes
include('database_connection.php'); //Database Connection
include('function.php');    //Functions

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

<!-- Alerts -->
<span id='alert_action'></span>

<?php
$count_red = maintenance_red_num($connect);
$count_yellow = maintenance_warning_num($connect);
$broken = broken_num($connect);


//This alert displays when equipment is broken or requires maintenance
if($count_red > 0 || $broken > 0){
?>
    <!-- Alerts user if equipment needs to be maintained-->
    <div class="row" style="align-content:center;">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="alert alert-danger main-err" role="alert" >
                
                <div style="float:right;">
                    <a class="btn btn-warning" href="maintain.php" role="button" style="position:relative; top:20px; right:5pxpx;">View</a>
                </div>
                
                <div style="padding-top:15px;font-size:1.1em;font-weight:bold;text-align:center">
                    <?php echo 'MAINTENANCE REQUIRED! &nbsp'; ?>
                </div>
                
                <div style="font-size:1.1em; text-align:center">
                    <?php echo  $count_red." item(s) require maintenance and ".$broken." item(s) are broken"; ?>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>
<!-- 
    This is the main pannel on the page. Displays automatically and holds all
    the equipment data displayed to the user
-->
<div class="row" style="">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading" id="panel-head">
                <div class="row">
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                        <h3 class="panel-title" style="margin-top:10px; font-size:1.4em">Equipment</h3>
                    </div>
                
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align='right'>
                        <button type="button" name="add" id="add_button" class="btn btn-link btn-md">
                            <span class="glyphicon glyphicon-plus" style="font-size:1.5em;color:lightgreen"></span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="row"><div class="col-sm-12 table-responsive">
                    <table id="equipment_data" class="table table-striped" cellspacing="0" width="100%" style="text-align:center">
                        <thead><tr>
                            <th class="dt_hr_sm" style="padding-right:5px">ID</th>
                            <th class="dt_hr" style="padding-right:5px">Name</th>
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
    <a class="btn btn-stat" href="stats.php#equipment" role="button">
    	More Equipment Info
    </a>
    <br/>
</div>

</br></br>

<!-- Equipment Form Modal -->
<div id="equipmentModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="equipment_form">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- Modal close button -->
                    <button type="button" class="close" data-dismiss="modal">
                    	<span class="glyphicon glyphicon-remove" style="color:white"></span>
                    </button>
                    <h4 class="modal-title" style="color:white"><i class="fa fa-plus"></i> Add Equipment</h4>
                </div>
                <div class="modal-body">

                    <!-- Equipment Name Input -->
                    <div class="form-group">
                        <label for="equip_name" class="form-lbl-lvl1">
                            Equipment Name
                                <span style="color:red;font-size:1.5em"> *</span>
                        </label>
                        <input type="text" name="equip_name" placeholder="Equipment Name" id="equip_name" class="form-control form-in-lvl1" maxlength="50" required />
                        <!-- INFO BTN -->
                        <button type="button" class="btn btn-link" data-toggle="popover" title="Name/Title" data-content="Enter what the equipment is commonly called." data-placement="left">
                            <img src="images/info5_sm.png" alt="info">
                        </button>
                    </div>

                    <!-- Equipment Serial Number Input -->
                    <div class="form-group">
                        <label for="equip_serial" class="form-lbl-lvl1">Serial Number</label>
                        <input type="text" name="equip_serial" placeholder="Serial Number" id="equip_serial" class="form-control form-in-lvl1" maxlength="50"/>
                        <!-- INFO BTN -->
                        <button type="button" class="btn btn-link" data-toggle="popover" title="Serial Number" data-content="Enter the serial number, VIN number or other relevant identifier." data-placement="left">
                            <img src="images/info5_sm.png" alt="info">
                        </button>
                    </div>

                    <!-- Equipment Description Input -->
                    <div class="form-group">
                        <label for="equip_desc" class="form-lbl-lvl1">Description</label>
                        <textarea name="equip_desc" placeholder="Equipment Description" id="equip_desc" class="form-control form-in-lvl1" rows="5" maxlength="250"></textarea>
                        <!-- INFO BTN -->
                        <button type="button" class="btn btn-link" data-toggle="popover" title="Description" data-content="Describe any defining characteristics, such as color, VIN number, whether a permit is required to operate it or not, etc." data-placement="left">
                            <img src="images/info5_sm.png" alt="info">
                        </button>
                    </div>

                    <!-- Equipment Cost Input -->
                    <div class="form-group">
                        <label for="equip_cost" class="form-lbl-lvl1">Equipment Cost</label>
                        <input type="text" name="equip_cost" placeholder="Cost of Equipment" id="equip_cost" class="form-control form-in-lvl1" pattern="[+-]?([0-9]*[.])?[0-9]+" maxlength="10"/>
                        <!-- INFO BTN -->
                        <button type="button" class="btn btn-link" data-toggle="popover" title="Cost" data-content="If the price paid for this piece of equipment is unknown, enter the estimated current value." data-placement="left">
                            <img src="images/info5_sm.png" alt="info">
                        </button>
                    </div>

                    <!-- Maintenance Required Input checkbox -->
                    <div class="form-group">
                        <label for="is_maintenance_required" style="font-size:1.3em;padding:20px 0 10px 0;color:rgba(3,54,78,1)">Scheduled Maintenance?</label>
                        <input type="hidden" value="no" name="is_maintenance_required"/>
                        <input type="checkbox" value="yes" name="is_maintenance_required" id="is_maintenance_required" class="form-check-input form-ck" onclick="moreOptions()"/>
                        <!-- INFO BTN -->
                        <button type="button" class="btn btn-link" data-toggle="popover" data-content="Check this box is this piece of equipment requires/has a maintenance schedule." data-placement="left">
                            <img src="images/info5_sm.png" alt="info">
                        </button>
                    </div>
                        <div id="maintain_vis">

                            <!-- Maintain_every Input -->
                            <div class="form-group">
                                <label for="maintain_every" class="form-lbl-sub">Requires Maintenance Every</label>
                                <select class="form-control form-in-lvl1" name="maintain_every" id="maintain_every">
                                    <option value="3">3 Months</option>
                                    <option value="6">6 Months</option>
                                    <option value="12">1 Year</option>
                                    <option value="18">1 Year 6 Months</option>
                                    <option value="24">2 years</option>
                                </select>
                                <!-- INFO BTN -->
                                <button type="button" class="btn btn-link" data-toggle="popover" data-content="How often does this piece of equipment require maintenance?" data-placement="left">
                                    <img src="images/info5_sm.png" alt="info">
                                </button>
                            </div>

                            <!-- Last Maintained Input (Calendar)-->
                            <div class="form-group">  
                                <label for="last_maintained" class="form-lbl-sub">Last Maintenance Date</label>
                                <input type="date" class="form-control form-in-lvl1" name="last_maintained" id="last_maintained" />
                                <!-- INFO BTN -->
                                <button type="button" class="btn btn-link" data-toggle="popover" data-content="When was the last time this piece of equipment was maintained?" data-placement="left">
                                	<img src="images/info5_sm.png" alt="info">
                            	</button>
                            </div>
                        </div>
                    <!-- Maintenance Now Input Checkbox -->
                    <div class="form-group">
                        <label for="is_broken" style="font-size:1.3em;color:rgba(3,54,78,1)"> Needs Maintenance Now </label>
                        <input type="hidden" value="no" name="is_broken"/>
                        <input type="checkbox" value="yes" name="is_broken" id="is_broken" class="form-check-input form-ck" onclick="moreOptionsBroken()"/>
                        <!-- INFO BTN -->
                        <button type="button" class="btn btn-link" data-toggle="popover" data-content="Check this box if the piece of equipment breaks" data-placement="left">
                            <img src="images/info5_sm.png" alt="info">
                        </button>
                    </div>
                        <!-- Problem Description Input textarea -->
                        <div id="broken_vis" style="display:none">
                            <div class="form-group">  
                                <label for="last_maintained" class="form-lbl-sub">Describe the Problem</label>
                                <textarea name="broken_desc" placeholder="Explain the problem" id="broken_desc" class="form-control form-in-lvl1" rows="5" maxlength="250"></textarea>
                                <!-- INFO BTN -->
                                <button type="button" class="btn btn-link" data-toggle="popover" data-content="What caused this piece of equipment to break?" data-placement="left">
                                <img src="images/info5_sm.png" alt="info">
                            </button>
                            </div>
                        </div>

                </div>

                <div class="modal-footer">
                    <input type="hidden" name="equip_id" id="equip_id" />
                    <input type="hidden" name="btn_action" id="btn_action" />
                    <!-- Submit button -->
                    <input type="submit" name="action" id="action" class="btn btn-info" value="Add" style="width:100px"/>
                    <!-- Modal close button -->
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>

            </div>
        </form>
    </div>
</div>

<!-- Equipment Details Modal -->
<div id="equipmentdetailsModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="equipment_form">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                    	<span class="glyphicon glyphicon-remove" style="color:white"></span>
                    </button>
                    <h4 class="modal-title" style="color:white"><i class="fa fa-plus"></i> Equipment Details</h4>
                </div>
                <div class="modal-body">
                    <Div id="equipment_details"></Div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- ID output modal -->
<div id="addSuccess" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="equipment_form">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                    	<span class="glyphicon glyphicon-remove" style="color:white"></span>
                    </button>
                    <h4 class="modal-title" style="color:white"><i class="fa fa-plus"></i> Successfully Added Equipment Item!</h4>
                </div>
                <div class="modal-body">
                    <div style="text-align:center">
                        <h2>New ID: <span id="eq_id"></span></h2>
                    </div>
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

    //Used to control the DataTable (Table) on the page
    var equipmentdataTable = $('#equipment_data').DataTable({
        "processing":true,
        "serverSide":true,
        "order": [[1,"asc"]],
        "ajax":{
            url:"equipment_fetch.php",
            type:"POST"
        },
        "columnDefs":[
            {
                "targets":[2, 3, 4],
                "orderable":false
            },
            { "orderData": [ 0, 1 ],    "targets": 0 },
        ],

        "pageLength": 10
    });

    //Used to control the "NEW EQUIPMENT" button action
    $('#add_button').click(function(){
        $('#equipmentModal').modal('show');
        $('#equipment_form')[0].reset();
        moreOptions();
        $('.modal-title').html("<i class='fa fa-plus'></i> Add New Equipment");
        $('#action').val("Add");
        $('#btn_action').val("Add");
    });

    //Used to control the SUBMIT/ADD button action in the form
    $(document).on('submit', '#equipment_form', function(event){
        event.preventDefault();
        $('#action').attr('disabled', 'disabled');
        var form_data = $(this).serialize();
        $.ajax({
            url:"equipment_action.php",
            method:"POST",
            data:form_data,
            success:function(data)
            {
                $('#equipment_form')[0].reset();
                $('#equipmentModal').modal('hide');
                $('#addSuccess').modal('show');
                $('#eq_id').html(data);
                $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>').delay(4000).fadeOut();
                $('#action').attr('disabled', false);
                equipmentdataTable.ajax.reload();
            }
        })
    });

    //Used to control the VIEW button action 
    $(document).on('click', '.view', function(){
        var equip_id = $(this).attr("id");
        var btn_action = 'equipment_details';
        $.ajax({
            url:"equipment_action.php",
            method:"POST",
            data:{equip_id:equip_id, btn_action:btn_action},
            success:function(data){
                $('#equipmentdetailsModal').modal('show');
                $('.modal-title').html("Equipment Details for ID: "+equip_id);
                $('#equipment_details').html(data);
            }
        })
    });

    //Used to control the update button action
    $(document).on('click', '.update', function(){
        var equip_id = $(this).attr("id");
        var btn_action = 'fetch_single';
        $.ajax({
            url:"equipment_action.php",
            method:"POST",
            data:{equip_id:equip_id, btn_action:btn_action},
            dataType:"json",
            success:function(data){
                $('#equipmentModal').modal('show');
                $('#equip_name').val(data.equip_name);
                $('#equip_serial').val(data.equip_serial);
                $('#equip_desc').val(data.equip_desc);
                $('#equip_cost').val(data.equip_cost);

                if(data.is_maintenance_required == 'yes'){
                    $('#is_maintenance_required').prop('checked', true);
                    // moreOptions();
                    $('#maintain_vis').show();
                }else{
                    $('#is_maintenance_required').prop('checked', false);
                    // moreOptions();
                    $('#maintain_vis').hide();
                }
                $('#maintain_every').val(data.maintain_every);
                $('#last_maintained').val(data.last_maintained);

                //Displays the desc box for broken equipment
                if(data.is_broken == 'yes'){
                    $('#is_broken').prop('checked', true);
                    $('#broken_vis').show();
                }else{
                    $('#is_broken').prop('checked', false);
                    $('#broken_vis').hide();
                }
                $('#broken_desc').val(data.broken_desc);
                
                $('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Equipment");
                $('#equip_id').val(equip_id);
                $('#action').val("Edit");
                $('#btn_action').val("Edit");
            }
        })
    });

    //Used to toggle off/on the INFO popovers on the forms
    $(function () {
        $('[data-toggle="popover"]').popover();
    });

    //Controls the delete button inside the dataTable
    $(document).on('click', '.delete', function(){
        var equip_id = $(this).attr("id");
        var status = $(this).data("status");
        var btn_action = 'delete';
        if(confirm("Are you sure you want to change status?"))
        {
            $.ajax({
                url:"equipment_action.php",
                method:"POST",
                data:{equip_id:equip_id, status:status, btn_action:btn_action},
                success:function(data){
                    $('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>').delay(4000).fadeOut();
                    equipmentdataTable.ajax.reload();
                }
            });
        }
        else
        {
            return false;
        }
    });

    //Controls the delete button inside the dataTable
    $(document).on('click', '#broken_btn', function(){
        $('#broken_vis').toggle();
    });
    
    /* 
        THIS IS HARDCODED JQUERY STYLING FOR THE TABLE PAGNATION
        IF THEY OVERLAP ON MOBILE, DELETE THESE LINES AND IT WILL GO BACK TO NORMAL
    */

    //TOP (Show Entries and Search)
    $( "#equipment_data_length" ).css( "float", "left" );
    $( ".dataTables_filter" ).css( "text-align", "right" );
    $( "input" ).css( "padding-left", "0" );
    $( "input" ).css( "padding-right", "0" );
    //BOTTOM (Showing x to y of z entries & Previous/Next)
    $( "#equipment_data_info" ).css( "float", "left" );
    $( "#equipment_data_info" ).css( "padding-left", "0" );
    $( "#equipment_data_info" ).css( "margin-left", "0" );
    $( "#equipment_data_paginate" ).css( "float", "right" );
    $( "#equipment_data_paginate" ).css( "padding-right", "0" );
    $( "#equipment_data_paginate" ).css( "margin-right", "0" );




});
</script>

<script>

    //Used to toggle the extra maintenance options once checkbox is clicked on modal after the modal is already loaded
    function moreOptions() {
        if(document.getElementById("is_maintenance_required").checked === true){
            document.getElementById("maintain_vis").style.display = "block";
        }
        if(document.getElementById("is_maintenance_required").checked === false){
            document.getElementById("maintain_vis").style.display = "none";
        }
    }

    //Used to toggle the extra maintenance options once checkbox is clicked on modal after the modal is already loaded
    function moreOptionsBroken() {
        if(document.getElementById("is_broken").checked === true){
            document.getElementById("broken_vis").style.display = "block";
        }
        if(document.getElementById("is_broken").checked === false){
            document.getElementById("broken_vis").style.display = "none";
        }
    }
</script>





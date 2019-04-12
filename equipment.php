<?php
//equipment.php

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

// echo 'Last id: '.last_equipment_added_id($connect);
?>

<!-- Alerts the user to changes they have made, or errors -->

<span id='alert_action'></span>

<?php
$count_red = maintenance_red_num($connect);
$count_yellow = maintenance_warning_num($connect);
if($count_red > 0){
?>
    <!-- Alerts user if equipment needs to be maintained-->
    <div class="row" style="align-content:center;">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="alert alert-danger" role="alert" style="display:inline-block; width:100%; height:50px; padding:0 10px;border:2px solid rgba(255,0,0,.3);">
                
                <div style="float:right;">
                    <a class="btn btn-warning" href="maintain.php" role="button" style="position:relative; top:5px; right:5pxpx;">View</a>
                </div>
                
                <div style="padding-top:5px; font-size:16px; text-align:center">
                    <?php echo 'MAINTENANCE REQUIRED! &nbsp'; ?>
                </div>
                
                <div style="font-size:13px; text-align:center">
                    <?php echo  $count_red." item(s) require maintenance"; ?>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>

<div class="row" style="">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                        <h3 class="panel-title" style="margin-top:10px; font-size:1.4em">Equipment</h3>
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
                    <table id="equipment_data" class="table table-bordered table-striped display" cellspacing="0" width="100%" style="text-align:center">
                        <thead><tr>
                            <th style="min-width: 30px;text-align:center">ID</th>
                            <th style="text-align:center">Name</th>
                            <th style="min-width: 35px;text-align:center">Details</th>
                            <th style="min-width: 50px;text-align:center">Update</th>
                            <th style="min-width: 40px;text-align:center">Status</th>
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
    <a class="btn btn-info" href="stats.php#equipment" role="button" style="width:200px">More Equipment Info</a><br/>
</div>

<div id="equipmentModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="equipment_form">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-plus"></i> Add Equipment</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="equip_name">
                            Equipment Name
                                <span style="color:red;font-size:1.5em"> *</span>
                        </label>
                        <input type="text" name="equip_name" placeholder="Equipment Name" id="equip_name" class="form-control" style="width:85%; display:inline;" required />
                        <!-- INFO BTN -->
                        <button type="button" class="btn btn-link" data-toggle="popover" title="Name/Title" data-content="Enter what the equipment is commonly called." data-placement="left">
                            <img src="images/info5_sm.png" alt="info">
                        </button>
                    </div>
                    <div class="form-group">
                        <label for="equip_serial">Serial Number</label>
                        <input type="text" name="equip_serial" placeholder="Serial Number" id="equip_serial" class="form-control" style="width:85%; display:inline;"/>
                        <!-- INFO BTN -->
                        <button type="button" class="btn btn-link" data-toggle="popover" title="Serial Number" data-content="Enter the serial number, VIN number or other relevant identifier." data-placement="left">
                            <img src="images/info5_sm.png" alt="info">
                        </button>
                    </div>
                    <div class="form-group">
                        <label for="equip_desc">Description</label>
                        <textarea name="equip_desc" placeholder="Equipment Description" id="equip_desc" class="form-control" rows="5" style="width:100%; display:inline;"></textarea>
                        <!-- INFO BTN -->
                        <button type="button" class="btn btn-link" data-toggle="popover" title="Description" data-content="Describe any defining characteristics, such as color, VIN number, whether a permit is required to operate it or not, etc." data-placement="left">
                            <img src="images/info5_sm.png" alt="info">
                        </button>
                    </div>
                    <div class="form-group">
                        <label for="equip_cost" style="width:200px">Equipment Cost</label>
                        <input type="text" name="equip_cost" placeholder="Cost of Equipment" id="equip_cost" class="form-control" pattern="[+-]?([0-9]*[.])?[0-9]+" style="width:85%; display:inline;"/>
                        <!-- INFO BTN -->
                        <button type="button" class="btn btn-link" data-toggle="popover" title="Cost" data-content="If the price paid for this piece of equipment is unknown, enter the estimated current value." data-placement="left">
                            <img src="images/info5_sm.png" alt="info">
                        </button>
                    </div>

                    <div class="form-group">
                        <label for="is_maintenance_required">Maintenance Required </label>
                        <input type="hidden" value="no" name="is_maintenance_required"/>
                        <input type="checkbox" value="yes" name="is_maintenance_required" id="is_maintenance_required" class="form-check-input" onclick="moreOptions()" style="width:2%; display:inline;"/>
                        <!-- INFO BTN -->
                        <button type="button" class="btn btn-link" data-toggle="popover" data-content="Check this box is this piece of equipment requires/has a maintenance schedule." data-placement="left">
                            <img src="images/info5_sm.png" alt="info">
                        </button>
                    </div>

                    <div class="invisible" id="maintain_vis">
                        <div class="form-group">
                            <label for="maintain_every">Requires Maintenance Every</label>
                            <select class="form-control" name="maintain_every" id="maintain_every" style="width:85%; display:inline;">
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
                        <div class="form-group">  
                            <label for="last_maintained">Last Maintenance Date</label>
                            <input type="date" class="form-control" name="last_maintained" id="last_maintained" style="width:85%; display:inline;"/>
                            <!-- INFO BTN -->
                            <button type="button" class="btn btn-link" data-toggle="popover" data-content="When was the last time this piece of equipment was maintained?" data-placement="left">
                            <img src="images/info5_sm.png" alt="info">
                        </button>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <input type="hidden" name="equip_id" id="equip_id" />
                    <input type="hidden" name="btn_action" id="btn_action" />
                    <input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>

            </div>
        </form>
    </div>
</div>

<div id="equipmentdetailsModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="equipment_form">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-plus"></i> Equipment Details</h4>
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

<div id="addSuccess" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="equipment_form">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-plus"></i> Successfully Added Equipment Item!</h4>
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
        "order":[],
        "ajax":{
            url:"equipment_fetch.php",
            type:"POST"
        },
        "columnDefs":[
            {
                "targets":[2, 3, 4],
                "orderable":false
            },
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
                // $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>').delay(4000).fadeOut();
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
                $('.modal-title').html("<i class='fa fa-plus'></i>Equipment Details");
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
                    moreOptions();
                }else{
                    $('#is_maintenance_required').prop('checked', false);
                    moreOptions();
                }
                
                $('#maintain_every').val(data.maintain_every);
                $('#last_maintained').val(data.last_maintained);
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
            document.getElementById("maintain_vis").style.visibility = "visible";
        }
        if(document.getElementById("is_maintenance_required").checked === false){
            document.getElementById("maintain_vis").style.visibility = "hidden";
        }
    }
</script>





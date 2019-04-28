<?php
//maintain.php
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
<!-- Alerts the user to changes they have made, or errors -->
<span id='alert_action'></span>

<!-- Main Page Pannel that displays maintenance data for equipment that requires maintenance -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading" id="panel-head">
                <div class="row">
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                        <h3 class="panel-title">Maintenance List</h3>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="row"><div class="col-sm-12 table-responsive">
                    <table id="equipment_data" class="table table-striped" cellspacing="0" width="100%" style="text-align:center">
                        <thead>
                            <tr>
                                <th class="dt_hr_sm">ID</th>
                                <th class="dt_hr"style="text-align:center">Equipment Name</th>
                                <th class="dt_hr_sm">Last Maintained</th>
                                <th class="dt_hr_sm">Details</th>
                                <th class="dt_hr_sm">Manual Reset</th>
                                <th class="dt_hr_sm">Auto-Reset</th>
                            </tr>
                        </thead>
                    </table>
                </div></div>
            </div>
        </div>
    </div>
</div>
<!-- Back button -->
<button class="btn btn-info" onclick="goBack()" style="float:right;">Go Back</button>

<!-- Maintain Form Modal -->
<div id="maintainModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="equipment_form">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                    	<span class="glyphicon glyphicon-remove" style="color:white"></span>
                    </button>
                    <h4 class="modal-title" style="color:white;"><i class="fa fa-plus"></i> Add Item</h4>
                </div>

                <div class="modal-body">
                        
                    <div class="form-group" style="padding-top:10px">
                        <label for="maintain_every" class="form-lbl-lvl1">Requires Maintenance Every</label>
                        <select class="form-control form-in-lvl1" name="maintain_every" id="maintain_every">
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
                        <label for="last_maintained" class="form-lbl-lvl1">Last Maintained</label>
                        <input type="date" class="form-control form-in-lvl1" name="last_maintained" id="last_maintained"/>
                        <!-- INFO BTN -->
                        <button type="button" class="btn btn-link" data-toggle="popover" data-content="When was the last time this piece of equipment was maintained?" data-placement="left">
                           	<img src="images/info5_sm.png" alt="info">
                        </button>
                    </div>
                </div>

                <div class="modal-footer">
                    <input type="hidden" name="equip_id" id="equip_id" />
                    <input type="hidden" name="btn_action" id="btn_action" />
                    <input type="submit" name="action" id="action" class="btn btn-info" value="Add" style="width:100px;"/>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>

            </div>
        </form>
    </div>
</div>

<!-- Equipment Details Modal-->
<div id="maintaindetailsModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="equipment_form">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                    	<span class="glyphicon glyphicon-remove" style="color:white"></span>
                    </button>
                    <h4 class="modal-title" style="color:white;"><i class="fa fa-plus"></i> Equipment Details</h4>
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

<script>
$(document).ready(function(){
    //Grabs data from the server to display the dataTable when the page loads
    var maintainDataTable = $('#equipment_data').DataTable({
        "processing":true,
        "serverSide":true,
        "searching": false, 
        "order":[],
        "ajax":{
            url:"maintain_fetch.php",
            type:"POST"
        },
        "columnDefs":[
            {

                "targets":[0,1,2,3,4,5],
                "orderable":false,
            },
        ],
        "pageLength": 10
    });

    //  Action for submit form button
    $(document).on('submit', '#equipment_form', function(event){
        event.preventDefault();
        $('#action').attr('disabled', 'disabled');
        var form_data = $(this).serialize();
        $.ajax({
            url:"maintain_action.php",
            method:"POST",
            data:form_data,
            success:function(data)
            {
                $('#equipment_form')[0].reset();
                $('#maintainModal').modal('hide');
                $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
                $('#action').attr('disabled', false);
                maintainDataTable.ajax.reload();
            }
        })
    });


    //  Action for view button
    $(document).on('click', '.view', function(){
        var equip_id = $(this).attr("id");
        var btn_action = 'equipment_details';
        $.ajax({
            url:"maintain_action.php",
            method:"POST",
            data:{equip_id:equip_id, btn_action:btn_action},
            success:function(data){
                $('#maintaindetailsModal').modal('show');
                $('#equipment_details').html(data);
            }
        })
    });

    //  Action for update button
    $(document).on('click', '.update', function(){
        var equip_id = $(this).attr("id");
        var btn_action = 'fetch_single';
        $.ajax({
            url:"maintain_action.php",
            method:"POST",
            data:{equip_id:equip_id, btn_action:btn_action},
            dataType:"json",
            success:function(data){
                $('#maintainModal').modal('show');
                $('#maintain_every').val(data.maintain_every);
                $('#last_maintained').val(data.last_maintained);
                $('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Equipment");
                $('#equip_id').val(equip_id);
                $('#action').val("Edit");
                $('#btn_action').val("Edit");
            }
        })
    });

    //Controlls the action for the "Enter Maintenance Date Manually" button
    $(document).on('click', '#showForm', function(){
        $("#maintainForm").toggle();
        var btnTxt = $("#showForm").text();
        if(btnTxt == "Back"){
            $("#showForm").html("Enter Maintenance Date Manually");
        }else{
            $("#showForm").html("Back");
        }
        $("#todayBtn").toggle();
    });

    //  Action for auto-reset button
    $(document).on('click', '.today', function(){
        var equip_id = $(this).attr("id");
        var btn_action = 'Today';
        $.ajax({
            url:"maintain_action.php",
            method:"POST",
            data:{equip_id:equip_id, btn_action:btn_action},
            dataType:"json",
            success:function(data){

                $('#alert_action').fadeIn().html('<div class="alert alert-success">Equipment fixed or maintained, and removed from maintenance page</div>');
                maintainDataTable.ajax.reload();
            }
        })
    });

    //Used to toggle off/on the INFO popovers on the forms
    $(function () {
        $('[data-toggle="popover"]').popover();
    });

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
    function moreOptions() {
        if(document.getElementById("is_maintenance_required").checked === true){
            document.getElementById("maintain_vis").style.visibility = "visible";
        }
        if(document.getElementById("is_maintenance_required").checked === false){
            document.getElementById("maintain_vis").style.visibility = "hidden";
        }
    }
    function goBack() {
        window.history.back();
    }
</script>
<?php
//locate.php

include('database_connection.php');
include('function.php');

if(!isset($_SESSION["type"]))
{
    header('location:login.php');
}

include('header.php');

?>
<!-- Alerts the user to changes they have made, or errors -->

<span id='alert_action'></span>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                        <h3 class="panel-title" style="margin-top:10px; font-size:1.4em">Locate Equipment</h3>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="row"><div class="col-sm-12 table-responsive">
                    <table id="locate_data" class="table table-bordered table-striped display" cellspacing="0" width="100%" style="text-align:center">
                        <thead><tr>
                            <th style="text-align:center">Equipment Name</th>
                            <th style="min-width:5px">Available</th>
                            <th style="min-width:35px">Details</th>
                            <th style="min-width:20px">Locate</th>
                        </tr></thead>
                    </table>
                </div></div>
            </div>
        </div>
    </div>
</div>

<div id="equipmentModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="equipment_form">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <i class="fa fa-plus"></i> 
                        Last Known Location
                    </h4>
                </div>
                <div class="modal-body" id="loc_found">
                    <div class="form-group" id="loc_err">
                        <div class="text-info" style="display:inline;font-size:1.5em;font-weight:bold">This item has never been checked out. </div>
                    </div>
                    <div class="form-group">
                        <!-- INFO BTN -->
                        <button type="button" class="btn btn-link" data-toggle="popover" title="Last Known Location" data-content="The last location this piece of equipment was checked out from." data-placement="bottom" style="margin-top:-10px">
                            <img src="images/info5_sm.png" alt="info">
                        </button>
                        <div class="text-info" style="display:inline;font-size:1.5em;font-weight:bold">Last Known Location: </div>
                        <div id="last_loc" style="margin-left:10%"></div>
                        
                    </div>

                    <div class="form-group">
                        <!-- INFO BTN -->
                        <button type="button" class="btn btn-link" data-toggle="popover" title="Last Person to Check it Out" data-content="The last person who checked out this piece of equipment." data-placement="bottom" style="margin-top:-10px">
                            <img src="images/info5_sm.png" alt="info">
                        </button>
                        <div class="text-info" style="display:inline;font-size:1.5em;font-weight:bold">Last Checkedout By: </div>
                        <div id="last_chk" style="margin-left:10%"></div>
                    </div>

                    <div class="form-group">
                        <!-- INFO BTN -->
                        <button type="button" class="btn btn-link" data-toggle="popover" title="Last Checkout Date" data-content="The date that this piece of equipment was last checked out of the system." data-placement="bottom" style="margin-top:-10px">
                            <img src="images/info5_sm.png" alt="info">
                        </button>
                        <div class="text-info" style="display:inline;font-size:1.5em;font-weight:bold">On: </div>
                        <div id="last_date" style="margin-left:10%"></div>
                    </div>

                </div>

                <div class="modal-footer">
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

<script>
$(document).ready(function(){

    //Used to control the DataTable (Table) on the page
    var equipmentdataTable = $('#locate_data').DataTable({
        "processing":true,
        "serverSide":true,
        "order":[],
        "ajax":{
            url:"locate_fetch.php",
            type:"POST"
        },
        "columnDefs":[
            {

                "targets":[2,3],
                "orderable":false,
            },
        ],
        "pageLength": 10
    });

    //Used to control the VIEW button action 
    $(document).on('click', '.view', function(){
        var equip_id = $(this).attr("id");
        var btn_action = 'equipment_details';
        $.ajax({
            url:"locate_action.php",
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
    $(document).on('click', '.locate', function(){
        var equip_id = $(this).attr("id");
        var btn_action = 'fetch_single';
        $.ajax({
            url:"locate_action.php",
            method:"POST",
            data:{equip_id:equip_id, btn_action:btn_action},
            dataType:"json",
            success:function(data){
                // Display Modal
                $('#equipmentModal').modal('show');
                // Set all values to defaults
                $('#last_loc').html('');
                $('#last_chk').html('');
                $('#last_date').html('');
                $('#loc_err').show();

                /* 
                    Check if a message was returned from locate_action.
                    If so, display message to user. If not, hide message.
                */
                if(data.message == false){
                    $('#loc_err').show();
                }else{
                    $('#loc_err').hide();
                }

                //Set fields to the values given in locate_action
                $('#last_loc').html(data.last_loc);
                $('#last_chk').html(data.last_chk);
                $('#last_date').html(data.last_date);
                $('#equip_id').val(equip_id);

                //Set action button value
                $('#action').val("Edit");

                //Set btn_action value
                $('#btn_action').val("Edit");
            }
        })
    });

    //Used to toggle off/on the INFO popovers on the forms
    $(function () {
        $('[data-toggle="popover"]').popover();
    });

    /* 
        THIS IS HARDCODED JQUERY STYLING FOR THE TABLE PAGNATION
        IF THEY OVERLAP ON MOBILE, DELETE THESE LINES AND IT WILL GO BACK TO NORMAL
    */

    //TOP (Show Entries and Search)
    $( "#locate_data_length" ).css( "float", "left" );
    $( "#locate_data_filter" ).css( "text-align", "right" );
    $( "input" ).css( "padding-left", "0" );
    $( "input" ).css( "padding-right", "0" );
    //BOTTOM (Showing x to y of z entries & Previous/Next)
    $( "#locate_data_info" ).css( "float", "left" );
    $( "#locate_data_info" ).css( "padding-left", "0" );
    $( "#locate_data_info" ).css( "margin-left", "0" );
    $( "#locate_data_paginate" ).css( "float", "right" );
    $( "#locate_data_paginate" ).css( "padding-right", "0" );
    $( "#locate_data_paginate" ).css( "margin-right", "0" );

});
</script>





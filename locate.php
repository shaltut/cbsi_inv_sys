<?php
//locate.php

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



    <br/>

        <div class="row" style="margin-top:20px">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                                <h3 class="panel-title" style="margin-top:10px; font-size:1.4em">Equipment</h3>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row"><div class="col-sm-12 table-responsive">
                            <table id="equipment_data" class="table table-bordered table-striped display" cellspacing="0" width="100%">
                                <thead><tr>
                                    <th>ID</th>
                                    <th>Equipment</th>
                                    <th>Desc</th>
                                    <th style="width:3%">Details</th>
                                    <th style="width:3%"></th>
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
                            <h4 class="modal-title"><i class="fa fa-plus"></i> Add Equipment</h4>
                        </div>

                        <div class="modal-body">

                            <div class="form-group">
                                <label for="last_loc">Last Known Location</label>
                                <input type="text" name="last_loc" id="last_loc" class="form-control" style="width:85%; display:inline;" readonly/>
                                <!-- INFO BTN -->
                                <button type="button" class="btn btn-link" data-toggle="popover" title="Last Known Location" data-content="The last location this piece of equipment was checked out from." data-placement="left">
                                    <img src="images/info5_sm.png" alt="info">
                                </button>
                            </div>

                            <div class="form-group">
                                <label for="last_chk">Last Checked out by</label>
                                <input type="text" name="last_chk" id="last_chk" class="form-control" style="width:85%; display:inline;" readonly/>
                                <!-- INFO BTN -->
                                <button type="button" class="btn btn-link" data-toggle="popover" title="Last Person to Check it Out" data-content="The last person who checked out this piece of equipment." data-placement="left">
                                    <img src="images/info5_sm.png" alt="info">
                                </button>
                            </div>

                            <div class="form-group">
                                <label for="last_date">Date of Last Checkout</label>
                                <input type="text" name="last_date" id="last_date" class="form-control" style="width:85%; display:inline;" readonly/>
                                <!-- INFO BTN -->
                                <button type="button" class="btn btn-link" data-toggle="popover" title="Last Checkout Date" data-content="The date that this piece of equipment was last checked out of the system." data-placement="left">
                                    <img src="images/info5_sm.png" alt="info">
                                </button>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <!-- <input type="hidden" name="equip_id" id="equip_id" />
                            <input type="hidden" name="btn_action" id="btn_action" />
                            <input type="submit" name="action" id="action" class="btn btn-info" value="Add" /> -->
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
    var equipmentdataTable = $('#equipment_data').DataTable({
        "processing":true,
        "serverSide":true,
        "order":[],
        "ajax":{
            url:"locate_fetch.php",
            type:"POST"
        },
        "columnDefs":[
            {

                "targets":[3,4],
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
                $('#equipmentModal').modal('show');
                $('#last_loc').val(data.last_loc);
                $('#last_chk').val(data.last_chk);
                $('#last_date').val(data.last_date);
                $('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Last Known Location");
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

});
</script>





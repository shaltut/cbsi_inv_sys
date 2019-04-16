<?php
//maintain.php

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

echo check_equip_maintenance_month($connect, 202039);
?>
<!-- Alerts the user to changes they have made, or errors -->

<span id='alert_action'></span>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                        <h3 class="panel-title">Maintenance List</h3>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="row"><div class="col-sm-12 table-responsive">
                    <table id="equipment_data" class="table table-bordered table-striped" cellspacing="0" width="100%" style="text-align:center">
                        <thead>
                            <tr>
                                <th style="min-width: 30px;">ID</th>
                                <th style="text-align:center">Equipment Name</th>
                                <th style="min-width: 30px;">Last Maintained</th>
                                <th style="min-width: 35px;">Details</th>
                                <th style="min-width: 80px;">Manual Reset</th>
                                <th style="min-width: 80px;">Auto-Reset</th>
                            </tr>
                        </thead>
                    </table>
                </div></div>
            </div>
        </div>
    </div>
</div>

<button class="btn btn-info" onclick="goBack()" style="float:right;">Go Back</button>

<div id="maintainModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="equipment_form">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-plus"></i> Add Item</h4>
                </div>

                <div class="modal-body">
                        
                    <div class="form-group" style="padding-top:10px">
                        <label for="maintain_every">Maintain Every</label>
                        <select class="form-control" name="maintain_every" id="maintain_every">
                            <option value="3">3 Months</option>
                            <option value="6">6 Months</option>
                            <option value="12">1 Year</option>
                            <option value="18">1 Year 6 Months</option>
                            <option value="24">2 years</option>
                        </select>
                    </div>
                    <div class="form-group">  
                        <label for="last_maintained">Last Maintained</label>
                        <input type="date" class="form-control" name="last_maintained" id="last_maintained"/>
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

<div id="maintaindetailsModal" class="modal fade">
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
    var maintainDataTable = $('#equipment_data').DataTable({
        "processing":true,
        "serverSide":true,
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

    $(document).on('click', '.today', function(){
        var equip_id = $(this).attr("id");
        var btn_action = 'Today';
        $.ajax({
            url:"maintain_action.php",
            method:"POST",
            data:{equip_id:equip_id, btn_action:btn_action},
            dataType:"json",
            success:function(data){
                $('#alert_action').fadeIn().html('<div class="alert alert-success">Equipment Maintenance Date Set to the Current Date</div>');
                maintainDataTable.ajax.reload();
            }
        })
    });
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



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

?>
<!-- Alerts the user to changes they have made, or errors -->
        <span id='alert_action'></span>

<div class="row">
            <!-- 
                ********** NEEDS WORK **********
                    - The function needs to show total number of pieces of equipment
                -->
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Total Equipment</strong></div>
                    <div class="panel-body" align="center">
                        <h1><?php echo count_user_total($connect); ?></h1>
                    </div>
                </div>
            </div>

            <!-- 
                ********** NEEDS WORK **********
                - The function needs to show the total number of pieces of equipment checked out at the moment
                -->
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Total Checked-out</strong></div>
                    <div class="panel-body" align="center">
                        <h1><?php echo count_master_active($connect); ?></h1>
                    </div>
                </div>
            </div>

            <!-- 
                ********** NEEDS WORK **********
                    - The function needs to show ????? (some useful statistic)
                -->
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Total ??????</strong></div>
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
                                <h3 class="panel-title">Equipment List</h3>
                            </div>
                        
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align='right'>
                                <button type="button" name="add" id="add_button" class="btn btn-success btn-xs">Add</button>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row"><div class="col-sm-12 table-responsive">
                            <table id="product_data" class="table table-bordered table-striped">
                                <thead><tr>
                                    <th>ID</th>
                                    <th>Product Name</th>
                                    <th>Description</th>
                                    <th>Enter By</th>
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

        <div id="productModal" class="modal fade">
            <div class="modal-dialog">
                <form method="post" id="product_form">
                    <div class="modal-content">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><i class="fa fa-plus"></i> Add Item</h4>
                        </div>

                        <div class="modal-body">
                            <div class="form-group">
                                <label>Enter Equipment Name</label>
                                <input type="text" name="equip_name" id="equip_name" class="form-control" required />
                            </div>
                            <div class="form-group">
                                <label>Enter Equipment Description</label>
                                <textarea name="equip_desc" id="equip_desc" class="form-control" rows="5" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Enter Equipment Quantity</label>
                                <div class="input-group">
                                    <input type="text" name="maintain_every" id="maintain_every" class="form-control" required pattern="[+-]?([0-9]*[.])?[0-9]+" /> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Enter Equipment Cost</label>
                                <input type="text" name="equip_cost" id="equip_cost" class="form-control" required pattern="[+-]?([0-9]*[.])?[0-9]+" />
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

        <div id="productdetailsModal" class="modal fade">
            <div class="modal-dialog">
                <form method="post" id="product_form">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><i class="fa fa-plus"></i> Equipment Details</h4>
                        </div>
                        <div class="modal-body">
                            <Div id="product_details"></Div>
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
    var productdataTable = $('#product_data').DataTable({
        "processing":true,
        "serverSide":true,
        "order":[],
        "ajax":{
            url:"equipment_fetch.php",
            type:"POST"
        },
        "columnDefs":[
            {

                "targets":[5, 6, 7],
                "orderable":false,
            },
        ],
        "pageLength": 10
    });

    $('#add_button').click(function(){
        $('#productModal').modal('show');
        $('#product_form')[0].reset();
        $('.modal-title').html("<i class='fa fa-plus'></i> Add Item");
        $('#action').val("Add");
        $('#btn_action').val("Add");
    });

    $(document).on('submit', '#product_form', function(event){
        event.preventDefault();
        $('#action').attr('disabled', 'disabled');
        var form_data = $(this).serialize();
        $.ajax({
            url:"equipment_action.php",
            method:"POST",
            data:form_data,
            success:function(data)
            {
                $('#product_form')[0].reset();
                $('#productModal').modal('hide');
                $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
                $('#action').attr('disabled', false);
                productdataTable.ajax.reload();
            }
        })
    });

    $(document).on('click', '.view', function(){
        var equip_id = $(this).attr("id");
        var btn_action = 'product_details';
        $.ajax({
            url:"equipment_action.php",
            method:"POST",
            data:{equip_id:equip_id, btn_action:btn_action},
            success:function(data){
                $('#productdetailsModal').modal('show');
                $('#product_details').html(data);
            }
        })
    });

    $(document).on('click', '.update', function(){
        var equip_id = $(this).attr("id");
        var btn_action = 'fetch_single';
        $.ajax({
            url:"equipment_action.php",
            method:"POST",
            data:{equip_id:equip_id, btn_action:btn_action},
            dataType:"json",
            success:function(data){
                $('#productModal').modal('show');
                $('#equip_name').val(data.equip_name);
                $('#equip_desc').val(data.equip_desc);
                $('#maintain_every').val(data.maintain_every);
                $('#equip_cost').val(data.equip_cost);
                $('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Product");
                $('#equip_id').val(equip_id);
                $('#action').val("Edit");
                $('#btn_action').val("Edit");
            }
        })
    });

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
                    $('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
                    productdataTable.ajax.reload();
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

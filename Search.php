<?php
//Search.php is for the user view only. Allows the users to view equipment name, description, status and details

include('database_connection.php');
include('function.php');

if(!isset($_SESSION["type"]))
{
    header('location:login.php');
}

if($_SESSION['type'] == 'master')
{
    header('location:index.php');
}

include('header.php');

?>
<!-- Alerts the user to changes they have made, or errors -->
        <span id='alert_action'></span>

<div class="row">
           

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                                <h3 class="panel-title">Equipment List</h3>
                            </div>
                        
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align='right'>
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
                                    <th>Status</th>
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
                                <label>Enter Name</label>
                                <input type="text" name="equip_name" id="equip_name" class="form-control" required />
                            </div>
                            <div class="form-group">
                                <label>Enter Description</label>
                                <textarea name="equip_desc" id="equip_desc" class="form-control" rows="5" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Cost</label>
                                <input type="text" name="equip_cost" id="equip_cost" class="form-control" required pattern="[+-]?([0-9]*[.])?[0-9]+" />
                            </div>

                            <div class="form-group">
                                <label>Maintenance Required: </label>
                                <input type="hidden" value="no" name="is_maintenance_required"/>
                                <input type="checkbox" value="yes" name="is_maintenance_required" id="is_maintenance_required" class="form-check-input" onclick="moreOptions()" />
                            </div>

                            <div class="invisible" id="maintain_vis">
                                <div class="form-group">
                                    <label for="maintain_every">Maintain Every</label>
                                    <select class="form-control" name="maintain_every" id="maintain_every">
                                        <option value="1">6 Months</option>
                                        <option value="2">1 Year</option>
                                        <option value="3">1 Year 6 Months</option>
                                        <option value="4">2 years</option>
                                    </select>
                                </div>
                                <div class="form-group">  
                                    <label for="last_maintained">Last Maintained</label>
                                    <input type="date" class="form-control" name="last_maintained" id="last_maintained"/>
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
            url:"user_equipment_fetch.php",
            type:"POST"
        },
        "columnDefs":[
            {

                // "targets":[5, 6, 7],
                "orderable":false,
            },
        ],
        "pageLength": 10
    });


});
</script>

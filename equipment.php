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

	<?php
	$count_equip_require_maintainance = check_equip_maintenance($connect);
	if($count_equip_require_maintainance > 0){
	?>
	    <!-- Alerts user if equipment needs to be maintained-->
		<div class="alert alert-danger" role="alert" style="padding-top: 10px;">
	  		<?php echo $count_equip_require_maintainance.' piece(s) of equipment require maintenance!'; ?>
	  		<a class="btn btn-warning" href="maintain.php" role="button" style="float: right; height:30px; padding-top:3px;">
	  			View
	  		</a>
		</div>
	<?php
	}
	?>

<!-- Button navigates to stats page-->
<a class="btn btn-link" href="stats.php#equipment" role="button" style="float:right;">View Stats</a>

    <br/><br/>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                                <h3 class="panel-title">Equipment List</h3>
                            </div>
                        
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align='right'>
                                <button type="button" name="add" id="add_button" class="btn btn-success btn-xs">New Equipment</button>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row"><div class="col-sm-12 table-responsive">
                            <table id="equipment_data" class="table table-bordered table-striped">
                                <thead><tr>
                                    <th>ID</th>
                                    <th>Equipment Name</th>
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

        <div id="equipmentModal" class="modal fade">
            <div class="modal-dialog">
                <form method="post" id="equipment_form">
                    <div class="modal-content">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><i class="fa fa-plus"></i> Add Item</h4>
                        </div>

                        <div class="modal-body">
                            <div class="form-group">
                                <label for="equip_name">Enter Name/Type</label>
                                <input type="text" name="equip_name" id="equip_name" class="form-control" style="width:85%; display:inline;" required />
                                <!-- INFO BTN -->
                                <button type="button" class="btn btn-link" data-toggle="popover" title="Name/Title" data-content="Enter what the equipment is commonly called." data-placement="left">
                                    <img src="images/info5_sm.png" alt="info">
                                </button>
                            </div>
                            <div class="form-group">
                                <label for="equip_desc">Enter Description</label>
                                <textarea name="equip_desc" id="equip_desc" class="form-control" rows="5" style="width:85%; display:inline;" required></textarea>
                                <!-- INFO BTN -->
                                <button type="button" class="btn btn-link" data-toggle="popover" title="Description" data-content="Describe any defining characteristics, such as color, VIN number, whether a permit is required to operate it or not, etc." data-placement="left">
                                    <img src="images/info5_sm.png" alt="info">
                                </button>
                            </div>
                            <div class="form-group">
                                <label for="equip_cost" style="width:100px">Cost</label>
                                <input type="text" name="equip_cost" id="equip_cost" class="form-control" required pattern="[+-]?([0-9]*[.])?[0-9]+" style="width:85%; display:inline;"/>
                                <!-- INFO BTN -->
                                <button type="button" class="btn btn-link" data-toggle="popover" title="Cost" data-content="If the price paid for this piece of equipment is unknown, enter the estimated current value." data-placement="left">
                                    <img src="images/info5_sm.png" alt="info">
                                </button>
                            </div>

                            <div class="form-group">
                                <label for="is_maintenance_required">Maintenance Required: </label>
                                <input type="hidden" value="no" name="is_maintenance_required"/>
                                <input type="checkbox" value="yes" name="is_maintenance_required" id="is_maintenance_required" class="form-check-input" onclick="moreOptions()" style="width:2%; display:inline;"/>
                                <!-- INFO BTN -->
                                <button type="button" class="btn btn-link" data-toggle="popover" data-content="Check this box is this piece of equipment requires/has a maintenance schedule." data-placement="left">
                                    <img src="images/info5_sm.png" alt="info">
                                </button>
                            </div>

                            <div class="invisible" id="maintain_vis">
                                <div class="form-group">
                                    <label for="maintain_every">Maintain Every</label>
                                    <select class="form-control" name="maintain_every" id="maintain_every" style="width:85%; display:inline;">
                                        <option value="6">6 Months</option>
                                        <option value="12">1 Year</option>
                                        <option value="18">1 Year 6 Months</option>
                                        <option value="24">2 years</option>
                                    </select>
                                    <!-- INFO BTN -->
                                    <button type="button" class="btn btn-link" data-toggle="popover" data-content="How often does this piece of equipement require maintenance?" data-placement="left">
                                    <img src="images/info5_sm.png" alt="info">
                                </button>
                                </div>
                                <div class="form-group">  
                                    <label for="last_maintained">Last Maintained</label>
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

<script>
$(document).ready(function(){
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

                "targets":[5, 6, 7],
                "orderable":false,
            },
        ],
        "pageLength": 10
    });

    $('#add_button').click(function(){
        $('#equipmentModal').modal('show');
        $('#equipment_form')[0].reset();
        $('.modal-title').html("<i class='fa fa-plus'></i> Add Item");
        $('#action').val("Add");
        $('#btn_action').val("Add");
    });

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
                $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
                $('#action').attr('disabled', false);
                equipmentdataTable.ajax.reload();
            }
        })
    });

    $(document).on('click', '.view', function(){
        var equip_id = $(this).attr("id");
        var btn_action = 'equipment_details';
        $.ajax({
            url:"equipment_action.php",
            method:"POST",
            data:{equip_id:equip_id, btn_action:btn_action},
            success:function(data){
                $('#equipmentdetailsModal').modal('show');
                $('#equipment_details').html(data);
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
                $('#equipmentModal').modal('show');
                $('#equip_name').val(data.equip_name);
                $('#equip_desc').val(data.equip_desc);
                $('#equip_cost').val(data.equip_cost);

                if(data.is_maintenance_required == 'yes'){
                    $('#is_maintenance_required').prop('checked', true);
                }else{
                    $('#is_maintenance_required').prop('checked', false);
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

    $(function () {
        $('[data-toggle="popover"]').popover()
    })

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
                    equipmentdataTable.ajax.reload();
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

    //Used to display the extra maintenance options once checkbox is clicked on modal
    function moreOptions() {
        if(document.getElementById("is_maintenance_required").checked === true){
            document.getElementById("maintain_vis").style.visibility = "visible";
        }
        if(document.getElementById("is_maintenance_required").checked === false){
            document.getElementById("maintain_vis").style.visibility = "hidden";
        }
    }

    //Used to toggle the 'view stats' button 
    function buttontext() {
        if(document.getElementById("equip_stat_btn").value === "Show Equipment Stats")
            document.getElementById("equip_stat_btn").value = "Hide Equipment Stats";
        else
            document.getElementById("equip_stat_btn").value = "Show Equipment Stats";
    }
</script>





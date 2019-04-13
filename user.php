<?php
//user.php

include('database_connection.php');
include('function.php');

if(!isset($_SESSION["type"]))
{
	header('location:login.php');
}

if($_SESSION["type"] != 'master')
{
	header("location:index.php");
}
include('header.php');


?>
<span id="alert_action"></span>


<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
            <div class="panel-heading">
            	<div class="row">
                	<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                    	<h3 class="panel-title" style="margin-top:10px; font-size:1.4em">Employees</h3>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align="right">
                    	<button type="button" name="add" id="add_button" data-toggle="modal" data-target="#userModal" class="btn btn-link btn-md">
                    			<span class="glyphicon glyphicon-plus text-success" style="font-size:1.5em;"></span>
						</button>
                	</div>
                </div>
               
                <div class="clear:both"></div>
           	</div>
           	<div class="panel-body">
           		<div class="row"><div class="col-sm-12 table-responsive">
           			<table id="user_data" class="table table-bordered table-striped display compact" cellspacing="0" width="100%" style="text-align:center">
           				<thead>
							<tr>
								<th style="width:30px;text-align:center">ID</th>
								<th style="text-align:center">Email</th>
								<th style="text-align:center">Name</th>
								<th style="text-align:center">Job Title</th>
								<th style="width:35px;text-align:center">Update</th>
								<th style="width:70px;text-align:center">Status</th>
							</tr>
						</thead>
           			</table>
           		</div>
           	</div>
       	</div>
   	</div>
</div>

<!-- Display the View Stats button link to the stats.php page-->
<div style="text-align:right">
    <!-- Button navigates to stats page-->
    <a class="btn btn-info" href="stats.php#employees" role="button" style="width:175px;">More Employee Info</a><br/>
</div>




<!-- 
	Displays the modal that appears after the "New User" or "Update" buttons are pressed
-->
<div id="userModal" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="user_form">	<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"><i class="fa fa-plus"></i> Add Employee </h4>
			</div>
			<div class="modal-body">

				<div class="text-danger" id="ia_date" style="font-size:1.2em; text-align:center"></div>

				<div class="form-group">
					<label for="user_name">
						Enter Employee Name
						<span style="color:red;font-size:1.5em"> *</span>
					</label>
					<input type="text" name="user_name" placeholder="Employee Name" id="user_name" class="form-control" style="width:86%; display:inline;" required />
					<button type="button" class="btn btn-link" data-toggle="popover" data-content="Enter the employee's Full Name." data-placement="left">
							<img src="images/info5_sm.png" alt="info">
					</button>
				</div>
				<div class="form-group">
					<label for="user_type">
						Account Type
						<span style="color:red;font-size:1.5em"> *</span>
					</label>
					<select class="form-control" name="user_type" id="user_type" style="width:86%; display:inline;" required>
						<option value="user">Standard Access</option>
                        <option value="master">Full Access (Administrative)</option>
                    </select>
                    <button type="button" class="btn btn-link" data-toggle="popover" title="Account Type" data-content="Standard accounts can only check in, check out, and locate equipment. Full Access users can do those things, as well as change other users passwords and add/remove equipment and sites from the system." data-placement="left">
							<img src="images/info5_sm.png" alt="info">
					</button>
				</div>

				<div class="form-group">
					<label for="user_job">
						Enter Employee Job Title
						<span style="color:red;font-size:1.5em"> *</span>
					</label>
					<select class="form-control" name="user_job" id="user_job" style="width:86%; display:inline;" required>
						<option value="Project Manager">Project Manager</option>
                        <option value="Foreman">Foreman</option>
                        <option value="Laborer">Laborer</option>
                        <option value="Skilled Laborer">Skilled Laborer</option>
                        <option value="Supervisor">Supervisor</option>
                        <option value="Other">Other</option>
                    </select>
                    <button type="button" class="btn btn-link" data-toggle="popover" title="Job Title" data-content="Select the employee's job title. If you cant find a proper option, select 'other'." data-placement="left">
							<img src="images/info5_sm.png" alt="info">
					</button>
				</div>

				<div class="form-group">
					<label for="user_email">
						Enter Employee Email
						<span style="color:red;font-size:1.5em"> *</span>
					</label>
					<div class="input-group">
						<input type="email" name="user_email" placeholder="Employee Email" id="user_email" class="form-control" required />
						<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span> 
					</div>
				</div>

				<div class="form-group">
					<label>
						Enter Employee Password
						<span style="color:red;font-size:1.5em"> *</span>
					</label>
					<div class="input-group">
						<input type="password" name="user_password" placeholder="Password" id="user_password" class="form-control" required />
						<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<input type="hidden" name="user_id" id="user_id" />
				<input type="hidden" name="btn_action" id="btn_action" />
				<input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div></form>

	</div>
</div>




<script>
$(document).ready(function(){

	$('#add_button').click(function(){
		$('#user_form')[0].reset();
		$('.modal-title').html("<i class='fa fa-plus'></i> Add User");
		$('#action').val("Add");
		$('#btn_action').val("Add");
		$('#user_password').attr('required', true);
	});

	var userdataTable = $('#user_data').DataTable({
		"processing": true,
		"serverSide": true,
		"order": [],
		"ajax":{
			url:"user_fetch.php",
			type:"POST"
		},
		"columnDefs":[
            {

                "targets":[4,5],
                "orderable":false,
            },
		],
		"pageLength": 10
	});

	$(document).on('submit', '#user_form', function(event){
		event.preventDefault();
		$('#action').attr('disabled','disabled');
		var form_data = $(this).serialize();
		$.ajax({
			url:"user_action.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{
				$('#user_form')[0].reset();
				$('#userModal').modal('hide');
				$('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>').delay(4000).fadeOut();
				$('#action').attr('disabled', false);
				userdataTable.ajax.reload();
			}
		})
	});

	$(document).on('click', '.update', function(){
		var user_id = $(this).attr("id");
		var btn_action = 'fetch_single';
		$.ajax({
			url:"user_action.php",
			method:"POST",
			data:{user_id:user_id, btn_action:btn_action},
			dataType:"json",
			success:function(data)
			{
				$('#userModal').modal('show');
				$date = data.ia_date;
				if($date != null){
					$date = 'Account Deactivated on '+data.ia_date;
				}
				$('#ia_date').html($date);
				$('#user_name').val(data.user_name);
				$('#user_job').val(data.user_job);
				$('#user_email').val(data.user_email);
				$('#user_type').val(data.user_type);
				$('#user_status').val(data.status);
				$('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit User");
				$('#user_id').val(user_id);
				$('#action').val('Edit');
				$('#btn_action').val('Edit');
				$('#user_password').attr('required', false);
			}
		})
	});

	$(function () {
  		$('[data-toggle="popover"]').popover()
	})

	$(document).on('click', '.disable', function(){
		var user_id = $(this).attr("id");
		var status = $(this).data('status');
		var btn_action = "disable";
		if(confirm("Are you sure you want to change status?"))
		{
			$.ajax({
				url:"user_action.php",
				method:"POST",
				data:{user_id:user_id, status:status, btn_action:btn_action},
				success:function(data)
				{
					$('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>').delay(4000).fadeOut();
					userdataTable.ajax.reload();
				}
			})
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
    $( "#user_data_length" ).css( "float", "left" );
    $( "#user_data_filter" ).css( "text-align", "right" );
    $( "input" ).css( "padding-left", "0" );
    $( "input" ).css( "padding-right", "0" );
    //BOTTOM (Showing x to y of z entries & Previous/Next)
    $( "#user_data_info" ).css( "float", "left" );
    $( "#user_data_info" ).css( "padding-left", "0" );
    $( "#user_data_info" ).css( "margin-left", "0" );
    $( "#user_data_paginate" ).css( "float", "right" );
    $( "#user_data_paginate" ).css( "padding-right", "0" );
    $( "#user_data_paginate" ).css( "margin-right", "0" );

});
</script>

<?php
include('footer.php');
?>

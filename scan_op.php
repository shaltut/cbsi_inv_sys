<?php
//brand.php

//Includes connection to the database
include('database_connection.php');

//Includes all the functions in the functions.php page
include('function.php');

/*
	This function sends the user to the login.php page if they arent logged in (or no session as been initiated)
*/
if(!isset($_SESSION['type']))
{
	header('location:login.php');
}

/*
	This if statement sends the user back to the index.php homepage if they arent master users.
*/
// if($_SESSION['type'] != 'master')
// {
// 	header('location:index.php');
// }

//Includes the code for the navbar 
include('header.php');

?>
<br>
<form method="post" id="site_form">
	<input type="button" class="btn btn-primary btn-lg btn-block" id="check_out_btn" value="Check-Out" data-toggle="collapse" data-target="#siteModal"/>

	<div id="siteModal" class="modal fade" >
        <div class="modal-dialog">
            <form method="post" id="equip_id_form">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-plus"></i> Add Site</h4>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Enter ID Number on Equipment</label>
                            <input type="text" name="equip_name" id="equip_name" class="form-control" required />
                        </div>
                    </div>

                    <div class="modal-footer">
                    	/*
                    		Here we need hidden fields to grab the data that the user wont have to enter manually...
                    		(user_id, site_id, etc.)
                        */
                        <input type="hidden" name="site_id" id="site_id" />
                        <input type="hidden" name="btn_action" id="btn_action" />
                        <input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>

                 </div>
            </form>
        </div>
    </div>
    <br>
	<input type="button" class="btn btn-primary btn-lg btn-block" id="check_in_btn" value="Check-In"role="button"/>


</form>
<?php
include('footer.php');
?>


<script>
$(document).ready(function(){

    $('#check_out_btn').click(function(){
        $('#site_form')[0].reset();
        $('.modal-title').html("<i class='fa fa-plus'></i> Add Item");
        $('#action').val("Add");
        $('#btn_action').val("Add");
    });

    $('#check_out_btn').click(function(){
        $('#site_form')[0].reset();
        $('.modal-title').html("<i class='fa fa-plus'></i> Add Item");
        $('#action').val("Add");
        $('#btn_action').val("Add");
    });
    $(document).on('click', '.check_out_btn', function(){
        var site_id = $(this).attr("id");
        var btn_action = 'fetch_single';
        $.ajax({
            url:"site_action.php",
            method:"POST",
            data:{site_id:site_id, btn_action:btn_action},
            dataType:"json",
            success:function(data){
                $('#siteModal').modal('show');
                $('#site_name').val(data.site_name);
                $('#job_desc').val(data.job_desc);
                $('#start_date').val(data.start_date);
                $('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Site");
                $('#site_id').val(site_id);
                $('#action').val("Edit");
                $('#btn_action').val("Edit");
            }
        })
    });

});
</script>
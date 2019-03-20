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

//Includes the code for the navbar 
include('header.php');

?>
<!-- Alerts the user to changes they have made, or errors -->
<span id='alert_action'></span>

<br/>
<form method="post" id="check_out_btn_form">

	<!-- <input type="button" class="btn btn-primary btn-lg btn-block" name="check-out" id="check_out_btn" value="Check-Out"/> -->

    <button type="button" name="check" id="chkout_button" class="btn btn-primary btn-lg btn-block">Check-Out</button>
</form>
    <!-- 
        Modal that asks the user to enter the unique id for the piece of equipment they wish to check out.
    -->
	<div id="chkout_modal" class="modal fade" >
        <div class="modal-dialog">
            <form method="post" id="equip_id_form">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-plus"></i> </h4>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Enter ID Number on Equipment</label>
                            <input type="text" name="equip_id" id="equip_id" />
                        </div>
                    </div>

                    <div class="modal-footer">
                    	<!--
                    		Here we need hidden fields to grab the data that the user wont have to enter manually...
                    		(user_id, site_id, etc.)
                        -->
                        <input type="hidden" name="site_id" id="site_id" value="303000"/>
                        <input type="hidden" name="btn_action" id="btn_action" />
                        <input type="submit" name="action" id="action" class="btn btn-info" value="Check Out" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
    <br/>
<form method="post" id="check_in_btn_form" >
	<input type="button" class="btn btn-primary btn-lg btn-block" id="check_in_btn" value="Check-In"role="button"/>
</form>

        <?php 
        //foreach($data as $row){
        ?>

        <!--Print equipment checked out by $_SESSION['user_id'] (current user) here with a button that sends the individual piece of equipment's unique id to the check_out.php page along with the user's user_id-->

        <?php 
        //}
        ?>
</form>
<?php
include('footer.php');
?>


<script>
$(document).ready(function(){

    $('#chkout_button').click(function(){
        $('#chkout_modal').modal('show');
        $('#equip_id_form')[0].reset();
        $('.modal-title').html("<i class='fa fa-plus'></i> Check Out");
        $('#action').val("Check Out");
        $('#btn_action').val("Check Out");
    });
    
    $(document).on('submit', '#equip_id_form', function(event){
        event.preventDefault();
        $('#action').attr('disabled', 'disabled');
        var form_data = $(this).serialize();
        $.ajax({
            url:"chk_out_action.php",
            method:"POST",
            data:form_data,
            success:function(data)
            {
                $('#equip_id_form')[0].reset();
                $('#chkout_modal').modal('hide');
                $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
                $('#action').attr('disabled', false);
                
                /*This line of code will be used to update the table below the buttons showing items checked out by the user (it should show that the item they just checked out was added to that list)*/

                // equipmentdataTable.ajax.reload();
            }
        })
    });

});
</script>
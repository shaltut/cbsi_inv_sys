<?php
//check.php


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
<style>
    .center{
        display: block;
        margin-left: auto;
        margin-right: auto;
        padding-left: 0;
        min-width:300px;
        width:50%;
     }
</style>

<!-- Alerts the user to changes they have made, or errors -->
<span id='alert_action'></span>

<br/>

<button type="button" name="check" id="chkout_button" class="btn btn-primary btn-lg btn-block">Check-Out Equipment</button>

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
                            <!-- Equipment ID Field -->
                            <label class="center" for="equip_id">
                                Equipment ID
                                <span style="color:red;font-size:1.5em"> *</span>
                            </label>
                            <input type="text" name="equip_id" id="equip_id" class="center"/>

                            <label class="center" for="site_id">
                                Location
                                <span style="color:red;font-size:1.5em"> *</span>
                            </label>
                            <select class="form-control center" name="site_id" id="site_id">
                                <?php
                                    echo sites_options($connect);
                                ?>
                            </select>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <!--
                            Here we need hidden fields to grab the data that the user wont have to enter manually...
                            (user_id, site_id, etc.)
                        -->
                        <input type="hidden" name="btn_action" id="btn_action" />
                        <input type="submit" name="action" id="action" class="btn btn-info" value="Check Out" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
    <br/>

<button type="button" name="check" id="chkin_button" class="btn btn-primary btn-lg btn-block">Return Equipment</button>
<!-- -->
<div id="ret_modal" class="modal fade" >
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-plus"></i> </h4>
            </div>

            <div class="modal-body">
<!-- -->
    <div class="row" id="chk_in_tbl">
        <div class="col-lg-12">
            <div class="panel">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12 table-responsive">
                            <table id="index_data" class="table table-striped display compact" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Date of Checkout</th>
                                        <th>Equipment ID</th>
                                        <th>Equipment Name</th>
                                        <th>Site ID</th>
                                        <th style="width:3%"></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- -->
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

         </div>
    </div>
</div>
<!-- -->
<?php
include('footer.php');
?>

<script>
$(document).ready(function(){

    /*
        Action sequence for the 'Check-out' button
    */
    $('#chkout_button').click(function(){
        $('#chkout_modal').modal('show');
        $('#equip_id_form')[0].reset();
        $('.modal-title').html("<i class='fa fa-plus'></i> Check Out");
        $('#action').val("Check Out");
        $('#btn_action').val("Check Out");
    });
    
    /*
        Database action, and jQuery action sequence query for 'check-out' modal's form entry
    */
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
                $('#alert_action').fadeIn().html(data);
                $('#action').attr('disabled', false);
                tbl.ajax.reload();
            }
        })
    });

    /*
        Action sequence for the 'Check-out' button
    */
    $('#chkin_button').click(function(){
        $('#ret_modal').modal('show');
        $('.modal-title').html("<i class='fa fa-plus'></i> Return Equipment");
        $('#action').val("Check Out");
        $('#btn_action').val("Check Out");
    });

    /*
        Displays and populates the table under the "Return Equipment" button
    */
    var tbl = $('#index_data').DataTable({
        "processing":true,
        "serverSide":true,
        "searching": false, 
        "paging": true,
        "bLengthChange": false,
        "bInfo" : false,
        "order":[],
        "ajax":{
            url:"chk_in_fetch.php",
            type:"POST"
        },
        "columnDefs":[
            {

                "targets":[4],
                "orderable":false,
            },
        ],
        "pageLength": 10
    });

    /*
        Database action, and action sequence for the 'check-in' buttons located inside the table below the 'Return Equipment' button.
    */
    $(document).on('click', '.chk_in_row', function(){
        var chk_id = $(this).attr("id");
        var status = $(this).data("status");
        var btn_action = 'chk_in_btn';
        if(confirm("Are you sure you want to return this item?"))
        {
            $.ajax({
                url:"chk_in_action.php",
                method:"POST",
                data:{chk_id:chk_id, status:status, btn_action:btn_action},
                success:function(data){
                    $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
                    $('#ret_modal').modal('hide');
                    tbl.ajax.reload();
                }
            })
        }
        else
        {
            return false;
        }
    });
});
</script>








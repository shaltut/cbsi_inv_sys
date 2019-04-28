<?php
//profile.php

include('database_connection.php');

if(!isset($_SESSION['type']))
{
	header("location:login.php");
}

include('header.php');

$query = "
SELECT * FROM user_details 
WHERE user_id = '".$_SESSION["user_id"]."'
";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$name = '';
$email = '';
$user_id = '';
foreach($result as $row)
{
	$name = $row['user_name'];
	$email = $row['user_email'];
	$_SESSION['user_email'] = $row['user_email'];
	$cell = $row['user_cell'];
	$_SESSION['user_cell'] = $row['user_cell'];
}
?>
<div class="panel panel-default">
	<div class="panel-heading" id="panel-head">Edit Profile</div>
	<div class="panel-body">
		<form method="post" id="edit_profile_form">
			<span id="message"></span>

			<!-- Name Input -->
			<div class="form-group" style="width:100%;float:left;padding-bottom:20px">
				<label style="font-size:1.2em;width:100%">Name: </label>
				<input type="text" name="user_name" id="user_name" class="form-control form-in-lvl1" value="<?php echo $name; ?>" style="width:40%"required >
				
			</div>

			<!-- Email Input -->
			<div class="form-group" style="width:46%;float:left;">
				<label style="font-size:1.2em;width:100%;">Email: </label>
				<input type="email" name="user_email" id="user_email" class="form-control form-in-lvl1" value="<?php echo $email; ?>" required>
				
			</div>

			<!-- Cellphone Input -->
			<div class="form-group" style="width:46%;float:right;margin-bottom:50px">
				<label style="font-size:1.2em;width:100%">Cell: </label>
					<input type="tel" name="user_cell" id="user_cell" class="form-control form-in-lvl1" maxlength="16" placeholder="888-888-8888" onKeyup='addDashes(this)'value="<?php echo $cell; ?>" required/>
				
			</div>

			<hr />

			<label style="color:rgba(200,0,0,.7)">**Leave Password fields blank if you do not want to change it</label>

			<!-- New Password Input -->
			<div class="form-group">
				<label style="font-size:1.2em">New Password: </label>
				<input type="password" name="user_new_password" placeholder="Enter New Password" id="user_new_password" class="form-control" />
			</div>

			<!-- Confirm Password Input -->
			<div class="form-group">
				<label style="font-size:1.2em">Confirm New Password: </label>
				<input type="password" name="user_re_enter_password" placeholder="Re-Enter New Password" id="user_re_enter_password" class="form-control" />
				<span id="error_password"></span>	
			</div>

			<!-- Edit button -->
			<div class="form-group">
				<input type="submit" name="edit_prfile" id="edit_prfile" value="Submit Changes" class="btn btn-success" style="width:200px;float:right;font-weight:bold;" />
			</div>
		</form>
	</div>
</div>

<script>
$(document).ready(function(){
	$('#edit_profile_form').on('submit', function(event){
		event.preventDefault();
		if($('#user_new_password').val() != '')
		{
			if($('#user_new_password').val() != $('#user_re_enter_password').val())
			{
				$('#error_password').html('<label class="text-danger">Password Not Match</label>');
				return false;
			}
			else
			{
				$('#error_password').html('');
			}
		}

		$('#edit_prfile').attr('disabled', 'disabled');

		var form_data = $(this).serialize();

		$('#user_re_enter_password').attr('required',false);

		$.ajax({
			url:"edit_profile.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{
				$('#edit_prfile').attr('disabled', false);
				$('#user_new_password').val('');
				$('#user_re_enter_password').val('');
				$('#message').html(data);
			}
		})
	});
});
</script>
<script>
//Helps to format Cell-Phone input field
const isModifierKey = (event) => {
    const key = event.keyCode;
    return (event.shiftKey === true || key === 35 || key === 36) || // Allow Shift, Home, End
        (key === 8 || key === 9 || key === 13 || key === 46) || // Allow Backspace, Tab, Enter, Delete
        (key > 36 && key < 41) || // Allow left, up, right, down
        (
            // Allow Ctrl/Command + A,C,V,X,Z
            (event.ctrlKey === true || event.metaKey === true) &&
            (key === 65 || key === 67 || key === 86 || key === 88 || key === 90)
        )
};

//Helps to format Cell-Phone input field
const enforceFormat = (event) => {
    // Input must be of a valid number format or a modifier key, and not longer than ten digits
    if(!isNumericInput(event) && !isModifierKey(event)){
        event.preventDefault();
    }
};

//Helps to format Cell-Phone input field
const formatToPhone = (event) => {
    if(isModifierKey(event)) {return;}

    // I am lazy and don't like to type things more than once
    const target = event.target;
    const input = target.value.replace(/\D/g,'').substring(0,10); // First ten digits of input only
    const zip = input.substring(0,3);
    const middle = input.substring(3,6);
    const last = input.substring(6,10);

    if(input.length > 6){target.value = `(${zip}) ${middle} - ${last}`;}
    else if(input.length > 3){target.value = `(${zip}) ${middle}`;}
    else if(input.length > 0){target.value = `(${zip}`;}
};

//Helps to format Cell-Phone input field
const inputElement = document.getElementById('user_cell');
inputElement.addEventListener('keydown',enforceFormat);
inputElement.addEventListener('keyup',formatToPhone);
</script>
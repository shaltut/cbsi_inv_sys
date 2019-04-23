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
}
?>
<div class="panel panel-default">
	<div class="panel-heading" id="panel-head">Edit Profile</div>
	<div class="panel-body">
		<form method="post" id="edit_profile_form">
			<span id="message"></span>

			<!-- Name Input -->
			<div class="form-group" style="width:46%;float:left">
				<label style="font-size:1.2em">Name: </label>
				<input type="text" name="user_name" id="user_name" class="form-control" value="<?php echo $name; ?>" required 
				<?php
				if($_SESSION['type'] == 'user'){
					echo 'readonly';
				}
				?>
				/>
			</div>

			<!-- Email Input -->
			<div class="form-group" style="width:46%;float:right;padding:0 0 30px 0;">
				<label style="font-size:1.2em">Email: </label>
				<input type="email" name="user_email" id="user_email" class="form-control" required value="<?php echo $email; ?>" 
				<?php
				if($_SESSION['type'] == 'user'){
					echo 'readonly';
				}
				?>
				/>
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
				<input type="submit" name="edit_prfile" id="edit_prfile" value="Edit" class="btn btn-info" style="width:100px; float:right" />
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
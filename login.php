<?php
include('database_connection.php');
if(isset($_SESSION['type'])){
    header("Location:index.php");
    echo "<script> window.location.assign('index.php'); </script>";
}
$message = '';
if(isset($_POST["login"])){
	$query = "
	SELECT * FROM user_details 
		WHERE user_email = :user_email
	";
	$statement = $connect->prepare($query);
	$statement->execute(
		array(
				'user_email' =>	$_POST["user_email"]
			)
	);
	$count = $statement->rowCount();
	if($count > 0){
		$result = $statement->fetchAll();
		foreach($result as $row){
			if($row['user_status'] == 'Active'){
				if(password_verify($_POST["user_password"], $row["user_password"])){
					$_SESSION['type'] = $row['user_type'];
					$_SESSION['user_id'] = $row['user_id'];
					$_SESSION['user_name'] = $row['user_name'];
					header("Location: index.php");
					echo "<script> window.location.assign('index.php'); </script>";
				}else{
					$message = "<label>Wrong Password</label>";
				}
			}else{
				$message = "<label>Your account is disabled, Contact Master</label>";
			}
		}
	}else{
		$message = "<label>Account does not exist!</label>";
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>CBSI Inventory System | Log in</title>		
		<script src="js/jquery-1.10.2.min.js"></script>
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<script src="js/bootstrap.min.js"></script>

		<meta name="viewport" content="width=device-width, initial-scale=1">
		<style>
			.logoimg {
				display: block;
  				margin-right: auto;
  				margin-left: auto;
			}

			html {
				background-color: #cbcbcb;
			}

			body {
				background-color: #cbcbcb;
			}

			.form-in-log{
					width: 85%;
					display: inline;
			}	

			@media only screen and (max-width: 600px) {
				.form-in-log{
					width: 80%;
					display: inline;
					float:left;
				}
			} 
			#panel-head{
				font-size: 1.2em;
				font-weight:bold;
				text-align:left;
				background-color:rgba(3,54,78,.9);
				color:white;
			}

		</style>
	</head>
	<body>
		<br />
		<div class="container">

			<img class="logoimg" src="images/logo.png" alt="CBSI logo" width="300" height="171">	
			
			</br></br>
			<center>
				<div class="panel panel-default" style="max-width:450px;">
					<div class="panel-heading" id="panel-head">
						Login
					</div>
					<div class="panel-body">
						<form method="post">
							<?php echo $message; ?>
							<div class="form-group">
								<div style="text-align:left">
									<label style="font-size:1.2em">Email:</label>
								</div>
								<input type="text" name="user_email" placeholder="Enter Email" class="form-control form-in-log" required />
								<!-- INFO BTN -->
		                        <button type="button" class="btn btn-link" data-toggle="popover" data-content="Enter your CBSI email address. (ID login coming soon)" data-placement="left">
		                            <img src="images/info5_sm.png" alt="info">
		                        </button>
							</div>
							<div class="form-group">
								<div style="text-align:left">
									<label style="font-size:1.2em">Password:</label>
								</div>
								<input type="password" name="user_password" placeholder="Enter Password" class="form-control form-in-log" required />
								<!-- INFO BTN -->
		                        <button type="button" class="btn btn-link" data-toggle="popover" data-content="To change your password, please contact your supervisor." data-placement="left">
		                            <img src="images/info5_sm.png" alt="info">
		                        </button>
							</div>
							<div class="form-group">
								<input type="submit" name="login" value="Login" class="btn btn-success" style="width:200px;font-size:1.4em;"/>
							</div>
						</form>
					</div>
				</div>
			</center>
		</div>

<script>
	// Used to toggle off/on the INFO popovers on the forms
    $(function () {
        $('[data-toggle="popover"]').popover();
    });
</script>

	</body>
</html>
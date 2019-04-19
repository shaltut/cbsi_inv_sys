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

		</style>
	</head>
	<body>
		<br />
		<div class="container">

			<img class="logoimg" src="images/logo.png" alt="CBSI logo" width="300" height="171">	
			
			</br></br>
			<div class="panel panel-default">
				<div class="panel-heading" style="font-size: 1.2em;font-weight:bold;">Login</div>
				<div class="panel-body">
					<form method="post">
						<?php echo $message; ?>
						<div class="form-group">
							<div>
								<label>Email:</label>
							</div>
							<input type="text" name="user_email" placeholder="Enter Email" class="form-control" style="width:85%; display:inline;" required />
							<!-- INFO BTN -->
	                        <button type="button" class="btn btn-link" data-toggle="popover" data-content="Enter your CBSI email address. (ID login coming soon)" data-placement="left">
	                            <img src="images/info5_sm.png" alt="info">
	                        </button>
						</div>
						<div class="form-group">
							<div>
								<label>Password:</label>
							</div>
							<input type="password" name="user_password" placeholder="Enter Password" class="form-control" style="width:85%; display:inline;" required />
							<!-- INFO BTN -->
	                        <button type="button" class="btn btn-link" data-toggle="popover" data-content="To change your password, please contact your supervisor." data-placement="left">
	                            <img src="images/info5_sm.png" alt="info">
	                        </button>
						</div>
						<div class="form-group">
							<input type="submit" name="login" value="Login" class="btn btn-info" />
						</div>
					</form>
				</div>
			</div>
		</div>

<script>
	//Used to toggle off/on the INFO popovers on the forms
    // $(function () {
    //     $('[data-toggle="popover"]').popover();
    // });
</script>

	</body>
</html>
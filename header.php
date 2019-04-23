<?php //header.php
if(!isset($_SESSION["type"])){
    header('location:login.php');
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>CBSI Inventory System</title>
		<script src="js/jquery-1.10.2.min.js"></script>
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<script src="js/jquery.dataTables.min.js"></script>
		<script src="js/dataTables.bootstrap.min.js"></script>		
		<link rel="stylesheet" href="css/dataTables.bootstrap.min.css" />
		<script src="js/bootstrap.min.js"></script>
		<script src="js/Chart.min.js"></script>
	</head>
<style type="text/css">
	html {
		background-color:rgba(237, 237, 237,1);
	}
	body {
		background-color:rgba(237, 237,237,1);
	}
	.modal-header{
		font-size: 1.2em;
		font-weight:bold;
		text-align:left;
		background-color:rgba(3,54,78,.9);
		color:white;
	}
	#panel-head{
		font-size: 1.2em;
		font-weight:bold;
		text-align:left;
		background-color:rgba(3,54,78,.9);
		color:white;
	}
	nav .container-fluid{
		background-color:rgba(0,24,48,1);
	}
	

</style>
	<body>
<!-- NAVBAR ------------------------------------------------------------->
		<nav class="navbar navbar-inverse">
			<div class="container-fluid">
				<div class="navbar-header">
					<!-- mobile navbar -->
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu" aria-expanded="false">
						<!-- <span class="sr-only" >Toggle Navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span> -->
					</button>
					<a href="index.php" class="navbar-brand">
						<img src="images/homelogo.png" alt="Home" style="height:175%;position:relative;top:-8px"/>
					</a>
				</div> <!-- navbar-header -->
				<div id="menu" class="collapse navbar-collapse">
					<ul class="nav navbar-nav" style="padding-left:20px">
					<?php
					if($_SESSION['type'] == 'master') //Only seen by MASTER
					{
					?>
						<li>
							<a href="equipment.php" style="color:lightgray;font-weight:bold">EQUIPMENT</a>
						</li>
						<li>
							<a href="site.php" style="color:lightgray;font-weight:bold">SITES</a>
						</li>
						<li>
							<a href="user.php" style="color:lightgray;font-weight:bold">EMPLOYEES</a>
						</li>
					<?php
					}
					?>
						<li>
							<a href="locate.php" style="color:lightgray;font-weight:bold">LOCATE</a>
						</li>
						<li>
							<a href="check.php" style="color:lightgray;font-weight:bold">CHECKOUT</a>
						</li>
					<?php
					if($_SESSION['type'] == 'user') // Only seen by USER
					{
					?>
						<!-- <li><a href="Search.php">Search</a></li> -->
					<?php
					}
					?>
					</ul> <!-- left list -->
					<!-- 
						This is the far right of the nav bar that displays the users Username. It includes a dropdown with 2 options:
							- profile -> profile.php
							- logout -> logout.php
					-->
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"  style="color:lightgray;">
								<span class="label label-pill label-danger count"></span> 
									<?php echo ucfirst($_SESSION["user_name"]); ?>
									<span class="glyphicon glyphicon-user"></span>
							</a>
							<ul class="dropdown-menu" style="background-color:lightgray;">
								<li>
									<a href="profile.php" style="font-weight:bold;">Profile</a>
								</li>
								<li>
									<a href="logout.php" style="font-weight:bold;">Logout</a>
								</li>
							</ul>
						</li>
					</ul> <!-- right list dropdown -->
				</div> <!-- collapse -->
			</div> <!-- container-fluid -->
		</nav>
<!-- END NAVBAR --------------------------------------------------------->
<br />
		<div class="container">
<?php
//header.php

error_reporting(0);

if(!isset($_SESSION["type"]))
{
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
		<script type="text/javascript" src="js/Chart.min.js"></script>

	</head>
	<body>
		<br />
		<div class="container">

<!-- NAVBAR ----------------------------------------------------------------------->


			<nav class="navbar navbar-inverse">
				<div class="container-fluid">
					<div class="navbar-header">
						
						<!-- mobile navbar -->
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu" aria-expanded="false">
							<span class="sr-only" >Toggle Navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>


						<a href="index.php" class="navbar-brand">CBSI</a>
					</div> <!-- navbar-header -->

					<div id="menu" class="collapse navbar-collapse">

					<ul class="nav navbar-nav">
					
					<?php
					if($_SESSION['type'] == 'master') //Only seen by MASTER
					{
					?>
						<li><a href="equipment.php">Equipment</a></li>
						<li><a href="site.php">Sites</a></li>
						<li><a href="user.php">Employees</a></li>
					<?php
					}
					?>
						<li><a href="check.php">Checkout</a></li>
						<li><a href="locate.php">Locate</a></li>
					
					<?php
					if($_SESSION['type'] == 'user') // Only seen by USER
					{
					?>
						<li><a href="Search.php">Search</a></li>
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
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<span class="label label-pill label-danger count"></span> 
									<?php echo ucfirst($_SESSION["user_name"]); ?>
									<span class="glyphicon glyphicon-user"></span>
							</a>
							<ul class="dropdown-menu">
								<li><a href="profile.php">Profile</a></li>
								<li><a href="logout.php">Logout</a></li>
							</ul>
						</li>
					</ul> <!-- right list dropdown -->

				</div> <!-- collapse -->

				</div> <!-- container-fluid -->
			</nav>

<!-- END NAVBAR ----------------------------------------------------------------------------------------->
			
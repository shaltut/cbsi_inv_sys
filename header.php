<?php
//header.php
?>
<!DOCTYPE html>
<html>
	<head>
		<title>CBSI - Home</title>
		<script src="js/jquery-1.10.2.min.js"></script>
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<script src="js/jquery.dataTables.min.js"></script>
		<script src="js/dataTables.bootstrap.min.js"></script>		
		<link rel="stylesheet" href="css/dataTables.bootstrap.min.css" />
		<script src="js/bootstrap.min.js"></script>
	</head>
	<body>
		<br />
		<div class="container">

			<nav class="navbar navbar-inverse">
				<div class="container-fluid">
					<div class="navbar-header">
						<a href="index.php" class="navbar-brand">CBSI</a>
					</div>
					<ul class="nav navbar-nav">
					<?php
					if($_SESSION['type'] == 'master')
					{
					?>
						<!-- 
							These links should only be seen by master users. 
						-->
						<li><a href="user.php">Employees</a></li>
						<li><a href="product.php">Equipment</a></li>
					<?php
					}
					?>
						<!-- 
							NEEDS WORK:

							This link will bring users to a page with 2 options:
							- Check-in
							- Check-out

							Both options will take them to their camera, along with a POST (depending on which button they selected) header which will tell the app how the scanning of the barcode will affect the database.

							for example, if the user selects "Check-out" option:
								- $_POST("check-out") will be sent to the next page
								- *User scans the barcode*
								- the system will know that the Equipment_ID being read in is being CHECKED OUT by the current user.
						-->
						<li><a href="scan.php">SCAN</a></li>
						<!-- 
							NEEDS WORK:
							
							This link will bring users to a page with all equipment listings, along with their availabilities.

							There will be a search bar at the top, allowing them to search for and find equipment that they need.
						-->
						<li><a href="search.php">Search</a></li>
					</ul>


					<!-- 
						This is the far right of the nav bar that displays the users Username. It includes a dropdown with 2 options:
							- profile -> profile.php
							- logout -> logout.phpß
					-->
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-pill label-danger count"></span> <?php echo ucfirst($_SESSION["user_name"]); ?></a>
							<ul class="dropdown-menu">
								<li><a href="profile.php">Profile</a></li>
								<li><a href="logout.php">Logout</a></li>
							</ul>
						</li>
					</ul>

				</div>
			</nav>
			
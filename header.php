<?php
//header.php (cbsi_inv_sys)
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
		<script type="text/javascript" src="js/canvasjs.min.js"></script>
		<script type="text/javascript" src="js/Chart.min.js"></script>
	</head>
	<body>
		<br />
		<div class="container">

<!-- NAVBAR ----------------------------------------------------------------------------------------------------->


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
						<li><a href="user.php">Employees</a></li>
						<li><a href="equipment.php">Equipment</a></li>
						<li><a href="site.php">Sites</a></li>
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
						<li><a href="check.php">Checkout</a></li>
					
					<?php
					if($_SESSION['type'] == 'user') // Only seen by USER
					{
					?>
						<!-- 
							NEEDS WORK:
							
							This link will bring users to a page with all equipment listings, along with their availabilities.

							There will be a search bar at the top, allowing them to search for and find equipment that they need.
						-->
						<li><a href="Search.php">Search</a></li>
					<?php
					}//END
					?>

					</ul> <!-- left list -->


					<!-- 
						This is the far right of the nav bar that displays the users Username. It includes a dropdown with 2 options:
							- profile -> profile.php
							- logout -> logout.phpß
					-->
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<span class="label label-pill label-danger count"></span> 
									<?php echo ucfirst($_SESSION["user_name"]); ?>
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
			
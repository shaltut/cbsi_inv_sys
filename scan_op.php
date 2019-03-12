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

/*
	This if statement sends the user back to the index.php homepage if they arent master users.
*/
// if($_SESSION['type'] != 'master')
// {
// 	header('location:index.php');
// }

//Includes the code for the navbar 
include('header.php');

?>

<a class="btn btn-primary btn-lg btn-block" href="check_out.php" role="button">Check-out</a>
<a class="btn btn-primary btn-lg btn-block" href="check_in.php" role="button">Check-in</a>

<?php
include('footer.php');
?>
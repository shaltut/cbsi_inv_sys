<?php
//brand.php
include('database_connection.php');

include('function.php');

if(!isset($_SESSION['type']))
{
	header('location:login.php');
}

if($_SESSION['type'] != 'master')
{
	header('location:index.php');
}

include('header.php');

?>

<a class="btn btn-primary btn-lg btn-block" href="check_out.php" role="button">Check-out</a>
<a class="btn btn-primary btn-lg btn-block" href="check_in.php" role="button">Check-in</a>

<?php
include('footer.php');
?>
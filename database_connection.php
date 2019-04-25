<?php
// $servername = "alpha";
// $username = "cbsico_ams";
// $password = "6u9N8!pM?S1@";
// try {
//     $connect = new PDO("mysql:host=$servername;dbname=cbsico_ams", $username, $password);
//     session_start();
//     }catch(PDOException $e){
//     echo "Connection failed: " . $e->getMessage();
//     }

//LOCAL

error_reporting(0);
ini_set('display_errors', '0');


$connect = new PDO('mysql:host=localhost;dbname=cbsico_ams', 'root', '');
session_start();

?>
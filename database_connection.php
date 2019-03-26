<?php
//database_connection.php

/*
 This function hides errors that display information about the code 

 EXAMPLE: "Notice: Undefined index: e in C:\xampp\htdocs\cbsi_inv_sys(test)\equipment_action.php on line 2"
*/
// ini_set('display_errors', '0');

$connect = new PDO('mysql:host=localhost;dbname=cbsi_db', 'root', '');
session_start();

?>
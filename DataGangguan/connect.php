<?php
$host = "localhost";
$user = "root";
$password = "";
$databaseName ="datagangguan";
$connect = mysqli_connect($host, $user, $password, $databaseName);
if (!$connect) {
    die("Connection failed: ".mysqli_connect_error());
} 
?>
<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "marvel_studio";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn){
	die("Connection Fialed". mysqli_connect_error());
} else {} 
?>
<?php

$host     = "localhost";     // your Host name 
$username = "root";          // your Mysql username 
$password = "";              // your Mysql password 
$db_name  = "mainsite";          // your Database name

$con1=mysqli_connect("$host", "$username", "$password","$db_name")or die("could notconnect to server."); 
?>
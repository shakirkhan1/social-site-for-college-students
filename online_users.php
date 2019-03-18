<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/global_chat.css">
</head>
<body>
<?php 
session_start();
require 'dbconfig/config.php';
require 'dbconfig/db_online.php'; //it is just written for practice no need to write here.
?>
<?php 
//$users = array();
if(isset($_SESSION['username'])) //here we are checking whethere a user is logged on or not on the messaging page
{
	
	$session    = $_SESSION['username']; //storing username in the session
	$time = time(); //getting current time. it is in unix format
    $time_check = $time-1;   //We Have Set Time 1sec 

$sql = "SELECT * FROM `online_users` WHERE session='$session'"; //checking a particular user whether he is online or not 
$result=mysqli_query($con1,$sql); 
$count = mysqli_num_rows($result); //counting whether the particular user is present or not

//If count is 0 , it means this user is not in the database
if($count=="0"){ 
 $sql1    = "INSERT INTO `online_users`(session, time)VALUES('$session', '$time')"; 
 $result1 = mysqli_query($con1,$sql1);
}

 // else update the values 
 else {
 $sql2    = "UPDATE `online_users` SET time='$time' WHERE session = '$session'"; 
 $result2 = mysqli_query($con1,$sql2); 
}

 $sql3 = "SELECT * FROM `online_users` where session!='$session'";
 $result3 = mysqli_query($con1,$sql3); 
 $count_user_online = mysqli_num_rows($result3); //counting total users
 echo "<b id=total_online_users>Total Users Online :  $count_user_online </b><br>"; 
 
 $query2="select session from `online_users` where session!='$session'";
 $result_query2=mysqli_query($con1,$query2);
 $no_of_user=$count_user_online;
 if($result)
 {
 while($row=mysqli_fetch_row($result_query2))
 {echo "<b id=total_online_users>Users Online</b><br>";
	 foreach($row as $rows)
	 {
		 echo $rows.'<br>';
	 }
 }
 }
 // after 1 sec, session will be deleted 
         $sql4 = "DELETE FROM `online_users` WHERE time<$time_check";  //deleting users 
         $result4 = mysqli_query($con1,$sql4);
//mysqli_close($con1);
}
 ?>
 </body>
</html>
<?php 
if(isset($_POST['submit']))
{
	if($_POST['message']=='')
	{
		//echo '<script type="text/javascript"> alert("Enter some text") </script>';
	}
	if($_POST['message']!='') //if message box is not empty
	{
	$message=$_POST['message']; //storing message in variable message
	date_default_timezone_set('Asia/Hong_Kong');
	$date1=date("Y-m-d H:i:s");
	$query='INSERT INTO `message` (`id`, `message`, `user_name`,`date`) VALUES("","'.$message.'","'.$_SESSION['username'].'","'.$date1.'")'; //remember this format
	if(mysqli_query($con,$query))
	{
		
		header('location:messagepage.php');
	}
	//header('location:messagepage.php'); // to stop inserting duplicate values in the database
    }
}

if(isset($_POST['goback']))
{
	header('location:homepage.php');
}
$query_all_message="SELECT * FROM `message`";
$result=mysqli_query($con, $query_all_message);
//++++++++++++++++++++++++++++++++++++++++++=Function for time_ago calculation ++++++++++++++++++++++++++++++++++++++++++++
include 'timestamp.php';
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
while($row=mysqli_fetch_assoc($result)) //for fetching messages from database
{
	$message=$row['message']; //here this 'message' is from message table column;
	$user_name=$row['user_name'];
	$date=$row['date'];	//message timestamp (time_ago)
	//echo $date;
    date_default_timezone_set('Asia/Hong_Kong'); //setting default time zone for synchronization
    if($_SESSION['username'] == $user_name){
      echo '<h2 align=right style="color:purple;text-transform: capitalize">'.$user_name.'</h2>';
      echo '<p align=right style="font-size: 1.5em;">'.$message.'</p>'.'<p align=right class="ui sub header">'.chat_time_ago($date).'</p>'; //calling chat_time_ago function   
    }
    else{
       echo '<h2 style="color:purple;text-transform: capitalize">'.$user_name.'</h2>';
       echo '<p style="font-size: 1.5em;">'.$message.'</p>'.'<p class="ui sub header">'.chat_time_ago($date).'</p>'; //calling chat_time_ago function  
    }
	
	echo '<div class = "ui divider"></div>';
}
?>
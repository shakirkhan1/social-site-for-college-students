<?php 
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
	echo '<h4 style="color:red">'.$user_name.'</h4>';
    date_default_timezone_set('Asia/Hong_Kong'); //setting default time zone for synchronization
	echo '<p>'.$message.'</p>'.'<p align=right>'.chat_time_ago($date).'</p>'; //calling chat_time_ago function 
	echo '<hr>';
}
if(isset($_POST['submit']))
{
	if($_POST['message']=='')
	{
		echo '<script type="text/javascript"> alert("Enter some text") </script>';
	}
	if($_POST['message']!='') //if message box is not empty
	{
	$message=$_POST['message']; //storing message in variable message
	date_default_timezone_set('Asia/Hong_Kong');
	$date1=date("Y-m-d H:i:s");
	$query='INSERT INTO `message` (`id`, `message`, `user_name`,`date`) VALUES("","'.$message.'","'.$_SESSION['username'].'","'.$date1.'")'; //remember this format
	if(mysqli_query($con,$query))
	{
		echo '<h4 style="color:red">'.$_SESSION['username'].'</h4>';
		echo '<p>'.$message.'</p>';
		
	}
	header('location:messagepage.php'); // to stop inserting duplicate values in the database
    }
}

if(isset($_POST['goback']))
{
	header('location:homepage.php');
}

?>
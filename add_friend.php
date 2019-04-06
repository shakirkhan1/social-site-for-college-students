<?php 
session_start();
 require('dbconfig/config.php');
if(!isset($_SESSION['username']))
{
    header("location:index.php");
}

$myfriend=$_GET['accept']; //receiving the username of the sender
$me=$_SESSION['username'];
$q="INSERT INTO `friends`(user,friendname) VALUES('$me','$myfriend')";
$result=mysqli_query($con,$q);
$q1="DELETE FROM `friendrequest` WHERE receiver='".$_SESSION["username"]."' AND sender='".$_GET['accept']."' OR receiver='".$_GET['accept']."' AND sender='".$_SESSION["username"]."'";
$result1=mysqli_query($con,$q1);
if($result and $result1)
{
    echo "<script type=\"text/javascript\">alert(\"Friend added\");
    window.location='homepage.php'</script>";
}
else{
    echo "<script>alert(\"Something went wrong!! Please try again\")</script>";
}

?>
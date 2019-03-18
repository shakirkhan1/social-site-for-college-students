<?php 
session_start();
 require('dbconfig/config.php');
if(!isset($_SESSION['username']))
{
    header("location:index.php");
}

$myfriend=$_GET['accept'];
$me=$_SESSION['username'];
$q="DELETE FROM `friendrequest` WHERE receiver='".$_SESSION["username"]."' AND sender='".$_GET['accept']."' OR receiver='".$_GET['accept']."' AND sender='".$_SESSION["username"]."'";
$result=mysqli_query($con,$q);
if($result)
{
    echo "<script type=\"text/javascript\">alert(\"Friend Request Deleted\");
    window.location='homepage.php';
    </script>";
}
?>
<?php 
session_start();
 require('dbconfig/config.php');
if(!isset($_SESSION['username']))
{
    header("location:index.php");
}

$myfriend=$_GET['delete']; //receiving the username of the sender
$me=$_SESSION['username'];
$query=mysqli_query($con,"DELETE FROM `friends` WHERE user='".$me."' AND friendname='".$myfriend."' OR user='".$myfriend."' AND friendname='".$me."'");
if($query)
{
    echo "<script type=\"text/javascript\">
							alert(\"Friend has been deleted\");</script>";
     echo '<script>
    window.location.href="view_profile.php?username='.$myfriend.'"
    </script>';
}

?>
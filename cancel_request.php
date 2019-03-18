<?php 
session_start();
 require('dbconfig/config.php');
if(!isset($_SESSION['username']))
{
    header("location:index.php");
}

$myfriend=$_GET['cancel']; //receiving the username of the sender
$me=$_SESSION['username'];

$q="DELETE FROM `friendrequest` WHERE receiver='".$_SESSION["username"]."' AND sender='".$_GET['cancel']."' OR receiver='".$_GET['cancel']."' AND sender='".$_SESSION["username"]."'";
$result=mysqli_query($con,$q);
if($result)
{
    //echo "<script type=\"text/javascript\">alert(\"Friend Request Deleted\");
    echo '<script>window.location.href="view_profile.php?username='.$myfriend.'"</script>';
    
}

?>
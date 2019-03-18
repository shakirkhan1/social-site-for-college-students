<?php 
session_start();
 require('dbconfig/config.php');
if(!isset($_SESSION['username']))
{
    header("location:index.php");
}

$receiver=$_GET['send'];
$sender=$_SESSION['username'];

$q="SELECT * FROM `friendrequest` WHERE sender='".$receiver."' AND receiver='".$sender."'";
$r=mysqli_query($con,$q);
if(mysqli_num_rows($r)>0)
{
    echo '<script>alert("You already got a friend request from this user");
    </script>';
    echo '<script>
    window.location.href="view_profile.php?username='.$receiver.'"
    </script>';
    
}
else
{
    $r1=mysqli_query($con,"INSERT INTO `friendrequest`(sender,receiver) VALUES('$sender','$receiver')");
    /*echo "<script>alert(\"Friend Request Sent\");
							
						</script>";*/
    echo '<script>
    window.location.href="view_profile.php?username='.$receiver.'"
    </script>';
    
}

?>
<?php 
session_start();
 require('dbconfig/config.php');
if(!isset($_SESSION['username']))
{
    header("location:index.php");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $_SESSION['fullname']." Friend Request" ?></title>
    <link rel="stylesheet" type="text/css" href="css/friend_request1.css">
</head>
<body>
    <div class="friend-request-container">
        <div class="friend-request-messages">
           
            <?php
                $username = $_SESSION['username'];
                $q2="UPDATE `friendrequest` SET seen='1' WHERE receiver='$username'";
                mysqli_query($con,$q2);
                $q1 = "SELECT * FROM `friendrequest` WHERE receiver='$username' ORDER BY id DESC";
                $result1=mysqli_query($con,$q1);
                if(mysqli_num_rows($result1)>0)
                {
                    
                    while($row=mysqli_fetch_assoc($result1))
                    {
                        $sender=$row['sender'];
                        $q11="SELECT * from `user` WHERE username='$sender'";
                        $result11=mysqli_query($con,$q11);
                        $row1=mysqli_fetch_assoc($result11);
                        if($row1['imagelink']=="uploads/")
                        {
                            if($row1['gender']=="male")
                            {
                                $sender_img="imgs/male1.png";
                            }
                            else if($row1['gender']=="female")
                            {
                                $sender_img="imgs/female.png";
                            }
                        }
                         else
                         {
                             $sender_img=$row1['imagelink'];
                         }
                    echo '
                    <a style="text-decoration:none;float:left;color:black;text-transform:capitalize;" href="view_profile.php?username='.$sender.'"><img src='.$sender_img.' width="50px" height="50px" style="border-radius:50%;">'.$sender.'</a><br><br><br><br>';
                    echo '<div class="accept-btn"><a style="text-decoration:none;color:black;float:left;" href="add_friend.php?accept='.$row['sender'].'">Confirm</a>&nbsp;&nbsp;<a class="delete-btn" style="text-decoration:none;color:black;margin-top:-45px;" href="delete_friend_request.php?accept='.$row['sender'].' ">Delete</a></div><br>';
                    } 
                }
                else
                {
                    echo '<center>No Friend Requests Pending</center>';
                }
            ?>
        </div>
     </div>
</body>
</html>
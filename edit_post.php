<?php 
include 'dbconfig/config.php';
session_start();
if(!isset($_SESSION['username']))
{
    header('location:index.php');
}
?>
 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>edit_post</title>
    <link href="css/edit_post.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="edit_post_container">
    <form method="post" action='edit_post.php'>
            <input type="text" name="post_title1" placeholder="Your Post Title....." class="post_title">
            <?php if(isset($_POST['edit_post']))
            {
            $post_id1 = $_POST['post_id'];
            }?>
            <input type="hidden" name="post_id1" value="<?php echo $post_id1; ?>">
            <textarea name="post_message1" placeholder="Type Your Post Here....." rows="10" cols="64" style="padding-left:30px;padding-right:20px;padding-top:20px;border:5px dashed orange;font-size:15px;"></textarea><br>
            <input name="submit_post1" type="submit" value="Edit" class="submit_post">
       </form>
       <!--<a href="post.php" class="go_back_btn">Click here to go back</a>-->
       <button class="go_back_btn" onclick="window.location.href='post.php'">Click here to go back</button>
       </div> 
       <?php 
     if(isset($_POST['submit_post1']))
      {
          $post_id1=$_POST['post_id1'];
          $post_title1=$_POST['post_title1'];
          $post_message1=$_POST['post_message1'];
          date_default_timezone_set('Asia/Hong_Kong');
	      $date1=date("Y-m-d H:i:s");
          if ($_POST['post_title1']=='')
        {
            echo '<script> alert("Please Enter Post Title....") </script>';
        }
        else if($_POST['post_message1']=='')
        {
            echo '<script> alert("Write Something in the post...") </script>';
        }
        else if($_POST['post_title1']!='' and $_POST['post_message1']!='')
        {
          $sql= "UPDATE `posts` SET date='$date1',post='$post_message1',post_title='$post_title1' WHERE post_id='$post_id1'";
           $result=mysqli_query($con,$sql);

           //==============================================================================================================================================================================================================
           //               update notification_status for new updated post 
            //             for this we just do following things:-
             //     get the username who edited the post and set the notification status for this post to unseen(i.e. 0)
             // due to which all users in database will get new notification for this edited post 
                        $username=$_SESSION['username'];
                        // $retrevepost = 'select * from user ';
                        // $resultpost = mysqli_query($con,$retrevepost);
                        // while( $rw = mysqli_fetch_array($resultpost) )
                        // {
                        //   if( $rw['username'] != $username )
                        //   {
                            $pos = $post_id1;
                            $pos_title = $post_title1;
                            $zero = 0 ;
                            $update_sql = " update notification set post_title = '$pos_title', notification_status= $zero where post_id = '$pos' ";
                            mysqli_query($con,$update_sql);
                        //   }   
                        // }


//=============================================================================================================================================================================================================


           
           if($result)
            {
                echo '<script> alert("Your Post Edited") </script>';
                echo "<script>window.location.href='post.php'</script>";
            }
      }  
      }
    ?>
   
    
</body>
</html>
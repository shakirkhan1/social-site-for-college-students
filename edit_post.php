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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>
</head>

<body>
    <div class="ui container">
        <div class="ui raised segment" style="margin-top: 15%;">
            <form action="edit_post.php" method="post" class="ui form" style="margin-top: 2%;">
                <div class="ui grid" style="margin-left: 20%;">
                    <div class="eleven wide column">
                        <div class="field">
                            <label for="post_title1">
                                <h2> Post Title: </h2>
                            </label><br>
                            <input type="text" name="post_title1" placeholder="Your Post Title...." required>
                            <?php if(isset($_POST['edit_post']))
                        {
                        $post_id1 = $_POST['post_id'];
                        }?>
                            <input type="hidden" name="post_id1" value="<?php echo $post_id1; ?>">
                        </div><br>
                        <label for="post_message">
                            <h2>Post:</h2>
                        </label><br>
                        <textarea id="" cols="30" rows="10" placeholder="Type Your Post Here...." name="post_message1" required></textarea> <br><br><br>
                        <div class="ui icon right input">
                            <input type="submit" name="submit_post1" value="Edit Post" class="ui massive inverted blue large button">
                            <i class="edit large blue icon"></i>
                        </div>
                        <div class="ui massive button orange large inverted" onclick="window.location.href='post.php'" style="margin-left: 2%;">Click here to go back</div>
                    </div>
                </div>
            </form>
        </div>
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
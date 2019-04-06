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
    <title>Post</title>
    <link rel="stylesheet" href="css/post.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>
</head>

<body>
    <div class="ui container">
        <div class="ui raised segment" style="margin-top: 2%;">
            <form action="post.php" method="post" class="ui form" style="margin-top: 2%;margin-bottom: 2%;">
                <div class="ui grid" style="margin-left: 20%;">
                    <div class="eleven wide column">
                        <div class="field">
                            <label for="post_title">
                                <h2> Post Title: </h2>
                            </label><br>
                            <input type="text" name="post_title" placeholder="Your Post Title...." required>
                        </div><br>
                        <label for="post_message">
                            <h2>Post:</h2>
                        </label><br>
                        <textarea id="" cols="30" rows="10" placeholder="Type Your Post Here...." name="post_message" required></textarea> <br><br><br>
                        <div class="ui right icon input">
                            <input type="submit" name="submit_post" value="Post" class="ui inverted blue massive button">
                            <i class="write large blue icon"></i>
                        </div>
                        <div class="ui button orange massive inverted" onclick="window.location.href='homepage.php'" style="margin-left: 2%;">Click here to go back</div>
                    </div>
                </div>
            </form>
        </div>

        <br><br>
        <div class="ui divider"></div> <br><br>

        <?php 
    
    $username=$_SESSION['username'];
    $fullname=$_SESSION['fullname'];
    $query_all_posts="SELECT * FROM `posts` WHERE username='$username' ORDER BY date DESC";
    $result=mysqli_query($con, $query_all_posts);
    if(mysqli_num_rows($result)==0)
    {
        echo '<br>';
        echo '<h1 align="center" class="ui header">'."No Post Yet!".'</h1>';
    }
    else
    { //echo mysqli_num_rows($result);
        echo '<h1 class="ui header" style="text-align:center;font-size:50px;">My Posts</h1>';
        while($row=mysqli_fetch_assoc($result))
        {
            $post_id=$row['post_id'];
            $fullname=$row['fullname'];
            $post=$row['post'];
            date_default_timezone_set('Asia/Hong_Kong');
            require_once 'timestamp.php';
            $date1=$row['date'];
            $date2=chat_time_ago($date1);
            $post_title=$row['post_title'];
            echo '<div class="ui segments">
                    <div class="ui segment">
                     <form action="edit_post.php" method="post"><p style="text-transform:capitalize;font-size:30px;">'.$post_title.'
                        <input type="submit" name="edit_post" value="Edit" class="ui green inverted button" style="float: right;"></p>
                        <input type="hidden" name="post_id" value="'.$post_id.'">
                     </form>
                     <form action="post.php" method="post" ><p>'.$date2.'
                            <input type="submit" name="delete_post" value="Delete" id="" class="ui red inverted button" style="float: right;margin-top:-2%;">
                            <input type="hidden" name="post_id" value="'.$post_id.'"></p>
                    </form>
                    </div>
                    <div class="ui segment">
                        <p class="ui content" style="font-size: 25px;">'.$post.'</p>
                    </div>
                   </div><br><br>
                   <div class="ui divider"></div> <br>';
        }
       echo '<div class="ui header" style="text-align: center"> No More Post Found!! </div>';
        
    }
//+++++++++++++++++++++++++++ Submitting a post +++++++++++++++++++++++++++++++++++++++
    if(isset($_POST['submit_post']))
    {
        if ($_POST['post_title']=='')
        {
            echo '<script> alert("Please Enter Post Title....") </script>';
        }
        else if($_POST['post_message']=='')
        {
            echo '<script> alert("Write Something in the post...") </script>';
        }
        else if($_POST['post_title']!='' and $_POST['post_message']!='')
        {
            $post_title=$_POST['post_title'];
            //$username=$_SESSION['username'];
            
            date_default_timezone_set('Asia/Hong_Kong');
	        $date1=date("Y-m-d H:i:s");
            $message_post=$_POST['post_message'];
            
            $sql='INSERT INTO `posts` (`post_id`,`username`,`fullname`,`date`,`post`,`post_title`) VALUES ("","'.$username.'","'.$fullname.'","'.$date1.'","'.$message_post.'","'.$post_title.'")';
            $result=mysqli_query($con,$sql);
            
            //========================================================================================================================================================================================================
// setting up notification table
// here we fisrt get the username who posts something, after inserting this post a unique post_id is generated  .we fetch this postid this user will be the sender/owner of post and rest users available in database are receiver  
                        $username=$_SESSION['username'];

                        $ret_post_id = " select post_id from posts where username='$username' and date='$date1' order by date DESC ";
                        $post_id1 = mysqli_query($con,$ret_post_id);

                        while( $rr =mysqli_fetch_array($post_id1) )
                        {
                             $pos = $rr['post_id'] ;
                             break;
                        }
                        //echo '<script> alert("'.$pos.'") </script>';
                        $pos_title = $post_title;
                        $sender = $username ;
                        $zero = 0;
                        // we fetch all users in database to send notification for new uploaded posts 
                        $retrevepost = 'select * from user ';
                        $resultpost = mysqli_query($con,$retrevepost);

                        while( $rw = mysqli_fetch_array($resultpost) )
                        {
                            // we send notification to all users except sender/owner of this message
                          if( $rw['username'] != $username )
                          {
                            $receiver = $rw['username'] ;
                            $insert_sql = " insert into notification (post_id, post_title, sender_post, username ) values ( '$pos', '$pos_title', '$sender', '$receiver' ) ";
                            $res = mysqli_query($con,$insert_sql);
                            // if($res)
                            // { 
                            // echo '<script> alert("notifyed") </script>';
                            //  }
                           }   
                        }

//==========================================================================================================


            if($result)
            {
                echo '<script> alert("Your Post has been Successfully Posted") </script>';
                echo "<script>window.location.href='post.php'</script>";
            }
            
        }
    }
//+++++++++++++++++++++++++++Submitting Post End +++++++++++++++++++++++++++++++++++++++    
                    
//+++++++++++++++++++++++++++Deleting Post  +++++++++++++++++++++++++++++++++++++++                     
       if(isset($_POST['delete_post']))
       {
            $post_id1 = $_POST['post_id'];
                       $sql  =  "DELETE FROM `posts` WHERE post_id = '$post_id1'";
                       $sql1 = "DELETE FROM `comments` WHERE post_id='$post_id1'";
                       // delete the notification history from notification table from all users
                       // as this post exist no longer 
                       $sql2 = " delete from notification where post_id = '$post_id1' ";

                       $result2=mysqli_query($con,$sql2);
                       $result1=mysqli_query($con,$sql1);
                       $result=mysqli_query($con,$sql);

                       if($result and $result1 and $result2)
                        {
                            echo '<script> alert("Your Post Deleted")     </script>';
                            echo "<script> window.location.href='post.php'</script>";
                        }
                       else
                       {
                           echo '<script> alert("Something went wrong")';
                       
           }
       }                  
    ?>
        <br><br>
    </div>

</body>

</html>
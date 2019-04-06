<?php 
session_start();
require 'dbconfig/config.php';
if(!isset($_SESSION['username']))
{
	header("location:index.php");
}

    $current_user = $_SESSION['username']; //user which is accessing the profiles of others
    $username =mysqli_real_escape_string($con,$_REQUEST['username']);
   $username2=$username; //making a copy 
   $q1="SELECT * from `user` WHERE username='$username2'";
   $result=mysqli_query($con,$q1);
   $row=mysqli_fetch_assoc($result);
   //echo $row['fullname'];
   //echo $row['username'];
   //echo $row['gender'];
?>

<?php
if(isset($_POST['comment_sbmt']))
              {
                  $post_id1=$_POST['post_id1'];
                  $comment_msg=$_POST['comment_msg'];
                  //echo $comment_msg;
                  
                  date_default_timezone_set('Asia/Hong_Kong');
	              $date1=date("Y-m-d H:i:s");
                  $username1=$_SESSION['username'];
                  $fullname=$_SESSION['fullname'];
                  //echo $username;
                  //echo $fullname;
                  if($comment_msg!='')
                  {
                  $sql2='INSERT INTO `comments` (`comment_id`,`post_id`,`username`,`fullname`,`date`,`comment`) VALUES ("","'.$post_id1.'","'.$username1.'","'.$fullname.'","'.$date1.'","'.$comment_msg.'")';
                  $result2=mysqli_query($con,$sql2);
               
                  if($result2)
                  {
                      
                      $username=$_POST['username2_name'];
                    $url="view_profile.php?username=$username";
                    header("Location: ".$url);
					 //header('location:homepage.php');
                      
                  }
                  else{
                      echo '<script> alert("something went wrong");';
                  }
                } 
                else
                {
                    $username=$_POST['username2_name'];
                    $url="view_profile.php?username=$username";
                    header("Location: ".$url);
                }
              }
        
        if(isset($_POST['submit']))
        {
        $username1=$current_user;    
        $post_id2=$_POST['post_id2'];
        //echo $_POST['post_id2'];
        $count=1;
        $sql1="SELECT * FROM `likepage` where post_id='$post_id2' and username='$username1'";
        $result1=mysqli_query($con,$sql1);
        if(mysqli_num_rows($result1)==0)
        {
        $sql="INSERT INTO `likepage` VALUES('','$post_id2','$current_user','$count')";
        $result=mysqli_query($con,$sql);
        $username=$_POST['username2_name'];
        $url="view_profile.php?username=$username";
        header("Location: ".$url);
            
            
        }
        else
        {

            $sql3="DELETE FROM `likepage` WHERE post_id='$post_id2' and username='$current_user'";
            $result3=mysqli_query($con,$sql3);
            $username=$_POST['username2_name'];
            $url="view_profile.php?username=$username";
        header("Location: ".$url);
            
            
        }

        }
        
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php echo $row['fullname']." Profile"; ?></title>
    <!-- jQuery library -->


    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/view_profile.css" type="text/css">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>
</head>

<body>
    <?php include 'navbar.php' ?>
    <div id="result" style="position: absolute; z-index: 99999;background-color:white;margin-top: 0px;">
        <!-- for displaying search result -->
    </div>

    <div class="ui segment grid" style="width:90%;margin-left:5%;margin-top:1%;background-color: whitesmoke;">
        <div class="ui row">
            <div class="ui four wide column" style="margin-top: 1%;margin-left: 5%;">
                <img style="width:180px; height: 180px;" class="ui rounded bordered segment green tiny image" src="<?php 

                    if($row['imagelink']=="uploads/")
                {
                    if($row['gender']=="male")
                    {
                        echo "imgs/male1.png";
                    }
                    else if($row['gender']=="female")
                    {
                        echo "imgs/female.png";
                    }
                }
                 else
                 {
                     echo $row['imagelink'];
                 } ?>" width="150px" height="150px">
            </div>
            <div class="ui six wide column">
                <div class="ui header" style="font-size: 60px;margin-top:5%;margin-left:25%;text-transform: Capitalize;">
                    <?php echo $row['fullname'] ?>
                </div>
            </div>
            <div class="ui five wide column" style="margin-top: 10%;">
                <?php 
        if($current_user!=$username){
        $query="SELECT * FROM `friends` WHERE user='".$current_user."' AND friendname='".$username."' OR user='".$username."' AND friendname='".$current_user."'";
        $rr=mysqli_query($con,$query);
        if(mysqli_num_rows($rr)>0)
        {
            echo '<a style="float:right;font-size:20px;"class="ui large red inverted button" href="delete_friend.php?delete='.$username.'">Unfriend </a>';
        echo '<input type="button" class="ui grey large button" value="Friends" disabled style="float:right;
        font-size: 20px;">';
        }
        else
        {
            $q="SELECT * FROM `friendrequest` WHERE sender='".$current_user."' AND receiver='".$username."'";
            $r=mysqli_query($con,$q);
            if(mysqli_num_rows($r)>0)
            {
                echo '<a style="float:right;font-size:20px;" class="ui large red button" href="cancel_request.php?cancel='.$username.'">Cancel Request <i class="close icon"></i></a>';
                echo '<input type="button" class="ui grey large button" value="Request Sent" disabled style="float: right;font-size:20px;"> '; 
            }
            else
            {
                echo '<a class="ui massive blue button" style="float: right;" href="process.php?send='.$username.'">
                Add Friend &nbsp;<i class="add small icon"></i></a>';
            }

        }
    }
    ?>
            </div>
        </div>
    </div>


    <!--+++++++++++++++++ Navbar js ++++++++++++++++++++++++++++++++++-->
    <div class="ui grid" style="margin-top: 4%;">
        <div class="ui row">
            <div class="ui segment raised four wide column column" style="margin-left:5%;height: 500px;">
                <div style="text-align: center;font-size: 30px;font-weight: 800;">
                    Basic Information
                </div><br>
                <div class="ui segments">
                    <div class="ui red segment" style="font-size:25px;">
                        <strong>Fullname:</strong>
                        <span style="margin-left: 5%;text-transform: capitalize;font-weight: 500;float: right;"><?php echo $row['fullname']; ?></span>
                    </div>
                    <div class="ui blue segment" style="font-size:25px;">
                        <strong> Username: </strong>
                        <span style="margin-left: 5%;text-transform: capitalize;font-weight: 500;float: right;"> <?php echo $row['username']; ?></span>
                    </div>
                    <div class="ui green segment" style="font-size:25px;">
                        <strong> Gender: </strong>&nbsp;&nbsp; &nbsp;
                        <span style="margin-left: 5%;text-transform: capitalize;font-weight: 500;float: right;"><?php echo $row['gender']; ?></span>
                    </div>
                    <div class="ui yellow segment" style="font-size:25px;">
                        <span class="email1">
                            <strong> Email: </strong>
                            <span style="margin-left: 5%;font-weight: 500;float: right;"> <?php echo $row['email']; ?></span>
                        </span>
                    </div>
                    <div class="ui purple segment" style="font-size:25px;">
                        <strong> Contact No :</strong>
                        <span style="margin-left: 5%;text-transform: capitalize;font-weight: 500;float: right;"> <?php if($row['mobile_no']){
                echo $row['mobile_no']; 
            } 
            else
            { 
                echo "No Mobile no.";
            }?></span>
                    </div>
                </div>
            </div>
            <div class="ui six wide column">
                <?php
        //$username=$_SESSION['username'];
    $fullname=$_SESSION['fullname'];
        $query_all_posts="SELECT * FROM `posts` WHERE username='$username' ORDER BY date DESC";
    $result=mysqli_query($con, $query_all_posts);
    if(mysqli_num_rows($result)==0)
    {
        echo '<br>';
        echo '<h1 align="center">'."No Post Yet".'</h1>';
    }
    else
    { //echo mysqli_num_rows($result);
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
            echo '<div class="ui raised segment" style="margin-left: 5%;">
            <div class="ui segment">
            <form action="view_profile.php" method="post" class="ui form">
            <p style="text-transform:capitalize;font-size:30px;font-weight:bold;margin-left:4%;">'.$post_title.'</p>'.
            '<p style="text-transform:uppercase;font-size:15px;margin-left:4%;">Posted By: '.$fullname.'</p>'.'<p style="margin-left:4%;">'.$date2.'</p>';
            echo '</form>
            <div class="ui divider"></div>';
            echo '<div style="width:500px;height:auto;"><p style="text-transform:uppercase;font-size:25px;margin-left:4%;">'.$post.'</p></div><br><br></div>'; 
            
            $sql4="SELECT * FROM `likepage` where post_id='$post_id'";
            $result4=mysqli_query($con,$sql4);
            $count=mysqli_num_rows($result4);
            
             echo '<form id="'.$post_id.'" method="post" action="view_profile.php" class="ui form">
            <input type="hidden" value="'.$post_id.'" name="post_id2">
            <input type="hidden" value="'.$username2.'" name="username2_name">
            <div class="ui inline field">
            <input type="submit" id="'.$post_id.'" value="Like" name="submit" class="ui blue inverted large button">
            <span class="ui header">'.$count.'
            </span>
            </div>
            </form><br><br>';
            echo '
            <form action="view_profile.php" method="post" class="ui form">
             <input type="hidden" value="'.$username2.'" name="username2_name">
             <div class="ui inline field">
            <input type="text" name="comment_msg" placeholder="Type Your Comment...">
            <input type="submit" value="Comment" name="comment_sbmt" class="ui large purple button">
            </div>
            <input type="hidden" value="'.$post_id.'" name="post_id1">
            </form>';
            
           
            $query_all_comments="SELECT * FROM `comments` WHERE post_id='$post_id' ORDER BY date desc";
             $result1=mysqli_query($con, $query_all_comments);
            if(mysqli_num_rows($result1)==0)
            {echo '<div class="'.$post_id.'" style="display:none;">';
                echo '<br>';
               echo '<div class="ui segment" style="width:90%;margin-left:5%;">
               <h3 align="center">'."No Comments Yet!".'</h3>
               </div>';
             echo '</div>';
            }
            
            // fetching comments 
            echo '<div style="max-height:500px;overflow-y:auto;">'; //Comment Container
            while($row1=mysqli_fetch_assoc($result1))
            {   
                $comment_msg=$row1['comment'];
                $username1=$row1['username'];
                $fullname=$row1['fullname'];
                date_default_timezone_set('Asia/Hong_Kong');
               require_once 'timestamp.php';
               $date2=$row1['date'];
               $date2=chat_time_ago($date2); 
                echo '<div class="'.$post_id.'" id="'.$post_id.'" style="display:none;width:90%;margin:5%;">'.'
                
                <div class="ui segment">
                <p style="text-transform:capitalize;font-size:15px;">'.
                    $fullname.': '.$comment_msg.'
                    </p>'.'<p>'.$date2.'
                    </p>
                    </div>
                    </div>
                '; 
            }
            echo '</div>';
             // echo ''.$post_id.'<input type="button" onclick="open_div()" class="c-btn" id="'.$post_id.'" style="float:right;" value="Show me">'; //this button will show hide comments
            echo '<br><button id="'.$post_id.'" style="float:right;" class="ui button">show me</button>';
            echo '<br><br></div><br><br>
            ';
            
            
        }
        
    }
	
	?>
            </div>
            <div class="ui" style="width: 22%;margin-left: 5%;">
                <div class="ui huge segment raised header" style="text-align: center;width: 100%;height: auto;font-size:2.0rem;">
                    Friend Lists
                    <div class="ui grid" style="margin-top: 2%;">
                        <div class="ui row" style="text-align:center;">

                            <?php 
                    $q="SELECT * FROM `friends` WHERE user='".$_SESSION['username']."'";
                    $r=mysqli_query($con,$q);
                    if(mysqli_num_rows($r)>0)
                    {
                        while($rr=mysqli_fetch_assoc($r))
                        {
                            echo '<div class="ui thirteen wide column" style="margin:0px auto;">
                            <div class="ui segment" style="font-size:1.5rem;text-transform: Capitalize;">'.$rr['friendname'].'</div></div>';
                        }
                    }
                    $qq="SELECT * FROM `friends` WHERE  friendname='".$_SESSION['username']."'";
                    $rrr=mysqli_query($con,$qq);
                    if(mysqli_num_rows($rrr)>0)
                    {
                       while($rr=mysqli_fetch_assoc($rrr))
                        {
                           echo '<div class="ui thirteen wide column" style="margin:0px auto;">
                            <div class="ui segment" style="font-size:1.5rem;text-transform: Capitalize;">'.$rr['user'].'</div></div>';
                        } 
                    }
                    else if(mysqli_num_rows($r)==0 and mysqli_num_rows($rrr)==0)
                    {
                        echo '<div class="ui thirteen wide column" style="margin:0px auto;">
                            <div class="ui" style="font-size:1.3rem;text-transform: Capitalize;">
                            <div class="ui teal message">You Have No Friends!</div></div></div>';
                    }
                    
    
                    ?>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            function load_user(query) {
                $.ajax({
                    url: "profile_user_fetch.php",
                    method: "post",
                    data: {
                        query: query
                    },
                    success: function(data) {
                        $('#result').html(data);
                    }
                });
            }
            $('#search_text').keyup(function() {
                var search = $(this).val();
                if (search != '') {
                    load_user(search);
                } else {
                    $('#result').empty();
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#myDropdown2").load('friend_request1.php');
            $('.ui.dropdown').dropdown();
        });
    </script>
</body>

</html>
<?php 
    
	session_start();
   require 'dbconfig/config.php';
if(!isset($_SESSION['username'])){
 header('location:index.php');
}
	//include 'homepage.php';
	
    $username=$_SESSION['username'];
    $fullname=$_SESSION['fullname'];
    //echo $username;
    //echo $fullname;
    $query_all_posts="SELECT * FROM `posts` ORDER BY date DESC";
    $result=mysqli_query($con, $query_all_posts);
    if(mysqli_num_rows($result)==0)
    {
        echo '<br>';
        echo '<h1 align="center" class="ui header">
        <div class="ui blue message">You Have Not Posted Yet!
        </div></h1>';
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
            echo '
            <div class="ui raised segment" style="width: 95%;margin: 0px auto;">
            <div style="margin-left: 4%;;width:500px;height:auto;">
            <form action="display_all_post.php" method="post" >
            <p style="text-transform:capitalize;font-size:30px;font-weight:bold">'.$post_title.'</p>'.
            '<p style="text-transform:uppercase;font-size:15px;">Posted By: '.$fullname.'</p>'.'<p>'.$date2.'</p>
            </div>';
            echo '</form>';
            echo '<div class="ui divider"></div>
            <div style="margin-left: 4%;width:500px;"><p style="text-transform:uppercase;font-size:25px;">'.$post.'</p></div><br><br></div>'; 
            
            $sql4="SELECT * FROM `likepage` where post_id='$post_id'";
            $result4=mysqli_query($con,$sql4);
            $count=mysqli_num_rows($result4);
            
             echo '<form id="'.$post_id.'" method="post" action="likepage.php" class="ui form">
            <input type="hidden" value="'.$post_id.'" name="post_id2"><br>
            <div class="two wide field" style="margin-left:3%;">
            <input type="submit" id="'.$post_id.'" value="Like" name="submit" class="ui blue large inverted button" style="font-size: 18px;">
            <span style="font-size:30px;margin-top: 15%;">'.$count.'</span>
            </div>
            </form><br><br>';
            echo '<div class="comment_box"><form action="display_all_post.php" method="post" class="ui form">
            <div class="inline field">
            <input type="text" placeholder="Type Your Comment..." name="comment_msg" style="width: 40%;margin-left:2%;">
            <input type="submit" value="Comment" name="comment_sbmt" class="ui large purple inverted large button" style="width:20%;">            
            </div>
            <input type="hidden" value="'.$post_id.'" name="post_id1">
            </form></div>';
            
           
            $query_all_comments="SELECT * FROM `comments` WHERE post_id='$post_id' ORDER BY date desc";
             $result1=mysqli_query($con, $query_all_comments);
            if(mysqli_num_rows($result1)==0)
            {echo '<div class="'.$post_id.'" style="display:none;">';
                echo '<br>';
               echo '<h2 align="center">'."No Comments Yet!".'</h2>';
             echo '</div>';
            }

            // fetching comments 
            echo '<div style="max-height:500px;overflow-y:auto;">'; //Comment Container
            while($row1=mysqli_fetch_assoc($result1))
            {  
                $comment_msg=$row1['comment'];
                $username=$row1['username'];
                $fullname=$row1['fullname'];
                date_default_timezone_set('Asia/Hong_Kong');
               require_once 'timestamp.php';
               $date2=$row1['date'];
               $date2=chat_time_ago($date2); 
                echo '
                <div class="'.$post_id.' ui segment" id="'.$post_id.'" style="display:none;width: 80%;margin-left: 5%;">'.'<div><p style="text-transform:uppercase;font-size:15px;">'.$fullname.': '.$comment_msg.'</p>'.'<p>'.$date2.'</p></div><br><br></div>'; 
            }
             echo '</div>';
            echo '<button id="'.$post_id.'" style="float:right;" class="ui button large">show me</button>';
            echo '<br><br><br>
            <div class="ui divider" style="width: 98%;"></div>
            <br><br>';
            
        }
        
    }

            if(isset($_POST['comment_sbmt']))
              {
                  $post_id1=$_POST['post_id1'];
                  $comment_msg=$_POST['comment_msg'];
                  //echo $comment_msg;
                  
                  date_default_timezone_set('Asia/Hong_Kong');
	              $date1=date("Y-m-d H:i:s");
                  $username=$_SESSION['username'];
                  $fullname=$_SESSION['fullname'];
                  //echo $username;
                  //echo $fullname;
                  if($comment_msg!='')
                  {
                  $sql2='INSERT INTO `comments` (`comment_id`,`post_id`,`username`,`fullname`,`date`,`comment`) VALUES ("","'.$post_id1.'","'.$username.'","'.$fullname.'","'.$date1.'","'.$comment_msg.'")';
                  $result2=mysqli_query($con,$sql2);



    // ======================================================================================
                     //              COMMENT NOTIFICATION         //
    // ======================================================================================

                  $zero = 0;
                  // getting the current cooments id after its insertion in database
                  $ret_comment_id = " select comment_id from comments where username='$username' and date='$date1' ";
                  $ret_comment_id1 = mysqli_query($con,$ret_comment_id);
                  while( $rr =mysqli_fetch_array( $ret_comment_id1 ) )
                  {
                       $got_comment_id = $rr['comment_id'] ;// only one id will be in array
                       break;
                  }

                  // getting username for this post on which comment has be made
                $ret_user_comment = " select username from posts where post_id = '$post_id1' ";
                $ret_user_comment1 = mysqli_query($con,$ret_user_comment);

                  while( $rr =mysqli_fetch_array( $ret_user_comment1 ) )
                  {
                       $got_user_comment = $rr['username'] ;
                       break;
                  }
                  // echo '<script> alert("'.$got_user_comment.'") </script>';
                          
            // inserting who commented on who's posts and what commented
             $sql3 = " insert into noti_comments ( noti_comment_id, post_id, comment_username, comment_title, comment_owner ) values ( '$got_comment_id', '$post_id1', '$username', '$comment_msg', '$got_user_comment' ) ";
              mysqli_query($con,$sql3);

                  
               
                  if($result2)
                  {
                      
                      echo "<script>window.location.href='display_all_post.php'</script>";
					 //header('location:homepage.php');
                      
                  }
                  else{
                      echo '<script> alert("something went wrong");';
                  }
                } 
              }
	
	?>

<!DOCTYPE html>
<html>

<head>
    <title> Post Display </title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link href="css/display_all_post.css" rel="stylesheet" type="text/css">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>

</head>

<body>
    <script>
        $("form :button").click(function() {
            //alert("clicked");
            var current_id = $(this).attr('id'); //getting current like button id
            // alert(current_id);
            var form_id = $(this).closest("form [id]").attr('id'); //for getting form id
            // console.log(form_id);
            $.post($("#" + form_id).attr("action"), $("#" + form_id + " :input").serialize(), function(info) {
                //console.log(info); 
            });


        });



        $("button").click(function() {
            // alert(this.id);
            var a = this.id;
            var elems = document.getElementsByClassName(a);
            //console.log(elems);
            for (var i = 0; i < elems.length; i += 1) {
                if (elems[i].style.display == 'block') {
                    //elem1[i].value='Show me';
                    elems[i].style.display = 'none';
                } else {
                    //elem1[i].value='Hide me';
                    elems[i].style.display = 'block';
                }
            }

        });
    </script>
</body>

</html>
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $row['fullname']." Profile"; ?></title>
    <!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

   <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/view_profile.css" type="text/css">
    <link rel="stylesheet" href="css/homepage_navbar.css" type="text/css">
</head>
<body>
    <!--++++++++++++++++++++++++++++++++++++++++++++++++++++ Nav Bar++++++++++++++++++++++++++++++++++  -->
	    
    <div class="navbar">
<div class="dropdown">
    <button class="dropbtn" onclick="myFunction()">Settings
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content" id="myDropdown">
      <a href="profile.php">View Profile</a>
      <a href="edit_settings.php">Edit Settings</a>
      <hr style="border: 1px ridge grey;">
      <a href="logout.php">Logout</a>
    </div>
  </div> 
 <a href="profile.php">About Me</a>
 <div class="dropdown">
    <button class="dropbtn" onclick="myFunction1()">Chat
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content" id="myDropdown1">
      <!-- <a href="#">Private Chat</a> -->
      <!-- <a href="#">Group Chat</a> -->
      <a href="messagepage.php">Community Chat</a>
    </div>
  </div>
 
  <a href="post.php">Post</a>
   <div class="dropdown">
    <button class="dropbtn" onclick="myFunction2()">Friend Request
    <?php
        $username1 = $_SESSION['username'];
        $qqq = "SELECT * FROM `friendrequest` WHERE receiver='$username1' AND seen='0'";
       $result1=mysqli_query($con,$qqq);
       if(mysqli_num_rows($result1)>0)
       {
           $count_friends=mysqli_num_rows($result1);
           echo $count_friends;  
       }
    ?>
    </button>
    
    <div class="friend-request-content" id="myDropdown2">
    
    </div>
  </div>
  <!-- <a href="friend_request.php">Friend Request</a> -->
   <a href="homepage.php">Home</a>
   <label style="color:white;margin-left:2%;">Search</label>
   <input type="text" name="search_text" id="search_text" placeholder="Search..." style="margin-top: 1%;margin-left: 2%; height: 25px;width: 290px;border: 1px solid black;">
  <a href="#" style="width:120px;"><?php echo '<img width="40px" height="40px" style="border-radius:50%;margin-top:-5px;" src="'.$_SESSION['imglink'].'">';?><p style="padding-left: 5px;margin-top:-38px;margin-left:78px;text-transform:capitalize;"><?php echo($_SESSION['fullname'])?></p></a>
</div>
    <!--++++++++++++++++++++++++++++++++++++++++++++++++++++ Nav Bar End++++++++++++++++++++++++++++++++++  -->
    <div id="result" style="">
        <!-- for displaying search result -->
    </div>
    <div class="header">
    <div class="photo_img">
        <img class="user-img" src="<?php 
    
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
    <div class="fullname">
        <?php echo $row['fullname'] ?>
    </div>
    <div>
       <?php 
    if($current_user!=$username){
    $query="SELECT * FROM `friends` WHERE user='".$current_user."' AND friendname='".$username."' OR user='".$username."' AND friendname='".$current_user."'";
    $rr=mysqli_query($con,$query);
    if(mysqli_num_rows($rr)>0)
    {
        echo '<a style="width:auto;float:right;
    margin-right: 10%;
    margin-top: 20px;
    font-size: 24px;text-decoration:none;"  href="delete_friend.php?delete='.$username.'">Unfriend </a>';
    echo '<input type="button" value="Friends" disabled style="width:auto;float:right;
    margin-right: 1%;
    margin-top: 20px;
    font-size: 24px;">';
    }
    else
    {
        $q="SELECT * FROM `friendrequest` WHERE sender='".$current_user."' AND receiver='".$username."'";
        $r=mysqli_query($con,$q);
        if(mysqli_num_rows($r)>0)
        {
            echo '<a style="width:auto;float:right;
    margin-right: 10%;
    margin-top: 20px;
    font-size: 24px;text-decoration:none;"  href="cancel_request.php?cancel='.$username.'">Cancel Request </a>';
            echo '<input type="button" value="Request Sent" disabled style="width:auto;float:right;
    margin-right: 1%;
    margin-top: 20px;
    font-size: 24px;"> '; 
        }
        else
        {
            echo '<a style="width: auto;
    float:right;
    margin-right: 20%;
    margin-top: 20px;
    font-size: 24px;text-decoration:none;"  href="process.php?send='.$username.'">Add Friend +</a>';
        }
        
    }
}
    ?>
    </div>
    </div>
    
    <!--+++++++++++++++++ Navbar js ++++++++++++++++++++++++++++++++++-->
<div class="middle-body">
    <div class="basic-info">
        <strong><center>Basic Information</center></strong>
        <div class="information">
        Fullname: <?php echo $row['fullname']; ?><br>
   Username: <?php echo $row['username']; ?><br>
   Gender:&nbsp;&nbsp; &nbsp; <?php echo $row['gender']; ?><br>
   <span class="email1">
   Email: <?php echo $row['email']; ?></span><br>
   Contact No.: <?php if($row['mobile_no']){
    echo $row['mobile_no']; 
} 
            else
            { 
                echo "No Mobile no.";
            }?>
   </div>
    </div>
    <div class="container-post">
    <div id="show-post">
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
            echo '<div style="border:2px solid yellow;"><div style="margin:0px auto;width:500px;height:auto;"><form action="view_profile.php" method="post" ><p style="text-transform:capitalize;font-size:30px;font-weight:bold">'.$post_title.'</p>'.
            '<p style="text-transform:uppercase;font-size:15px;">Posted By: '.$fullname.'</p>'.'<p>'.$date2.'</p></div></div>';
            echo '<div style="border:2px solid grey;"><p></p></form>';
            echo '<div style="margin:0px auto;width:500px;height:auto;"><p style="text-transform:uppercase;font-size:25px;">'.$post.'</p></div><br><br></div>'; 
            
            $sql4="SELECT * FROM `likepage` where post_id='$post_id'";
            $result4=mysqli_query($con,$sql4);
            $count=mysqli_num_rows($result4);
            
             echo '<form id="'.$post_id.'" method="post" action="view_profile.php">
            <input type="hidden" value="'.$post_id.'" name="post_id2">
            <input type="hidden" value="'.$username2.'" name="username2_name">
            <input type="submit" id="'.$post_id.'" value="Likes" name="submit" class="like-btn" style="argin-right:10px;
    font-size: 25px;margin-left: 0px;margin-top: 10px;"><div class="like_count" style="font-size: 30px;margin-top: -39px;margin-left: 100px;">'.$count.'</div></form><br><br>';
            
            
            echo '<div class="comment_box"><form action="view_profile.php" method="post">
             <input type="hidden" value="'.$username2.'" name="username2_name">
            <input type="text" name="comment_msg">
            <input type="submit" value="comment" name="comment_sbmt">
            <input type="hidden" value="'.$post_id.'" name="post_id1">
            </form></div>';
            
           
            $query_all_comments="SELECT * FROM `comments` WHERE post_id='$post_id' ORDER BY date desc";
             $result1=mysqli_query($con, $query_all_comments);
            if(mysqli_num_rows($result1)==0)
            {echo '<div class="'.$post_id.'" style="display:none;">';
                echo '<br>';
               echo '<h6 align="center">'."No Comments Yet".'</h1>';
             echo '</div>';
            }
            
            // fetching comments 
            echo '<div style="max-height:200px;overflow-y:auto;">'; //Comment Container
            while($row1=mysqli_fetch_assoc($result1))
            {   
                $comment_msg=$row1['comment'];
                $username1=$row1['username'];
                $fullname=$row1['fullname'];
                date_default_timezone_set('Asia/Hong_Kong');
               require_once 'timestamp.php';
               $date2=$row1['date'];
               $date2=chat_time_ago($date2); 
                echo '<div class="'.$post_id.'" id="'.$post_id.'" style="display:none;">'.'<div><p style="text-transform:capitalize;font-size:15px;">'.$fullname.': '.$comment_msg.'</p>'.'<p>'.$date2.'</p></div><br><br></div>'; 
            }
            echo '</div>';
             // echo ''.$post_id.'<input type="button" onclick="open_div()" class="c-btn" id="'.$post_id.'" style="float:right;" value="Show me">'; //this button will show hide comments
            echo '<button id="'.$post_id.'" style="float:right;">show me</button>';
            echo '<br><br><br>';
            
            
        }
        
    }

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
    </div>
    </div>
</div>
 <div class="online-users" style="border:2px solid brown;margin-top:-750px;margin-left:78%;width:20%;min-height:750px;">
         <center>Online Users will display here</center><br><hr>
         
                     <?php 
                    $q="SELECT * FROM `friends` WHERE user='".$_SESSION['username']."'";
                    $r=mysqli_query($con,$q);
                    if(mysqli_num_rows($r)>0)
                    {
                        while($rr=mysqli_fetch_assoc($r))
                        {
                            echo '<center style="font-size:25px;">'.$rr['friendname'].'</center><br><hr>';
                        }
                    }
                    $qq="SELECT * FROM `friends` WHERE  friendname='".$_SESSION['username']."'";
                    $rrr=mysqli_query($con,$qq);
                    if(mysqli_num_rows($rrr)>0)
                    {
                       while($rr=mysqli_fetch_assoc($rrr))
                        {
                            echo '<center style="font-size:25px;">'.$rr['user'].'</center><br><hr>';
                        } 
                    }
                    
    
                    ?>
     </div>

<script type="text/javascript">
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
    function myFunction2(){
        document.getElementById("myDropdown2").classList.toggle("show1");
    }
function myFunction1() {
    document.getElementById("myDropdown1").classList.toggle("show1");
   
}
function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(e) {
  if (!e.target.matches('.dropbtn')) {
    var myDropdown = document.getElementById("myDropdown");
      var myDropdown1 = document.getElementById("myDropdown1");
      if (myDropdown.classList.contains('show')) {
        myDropdown.classList.remove('show');
      }
      if (myDropdown1.classList.contains('show1')) {
        myDropdown1.classList.remove('show1');
      }
      if(myDropdown2.classList.contains('show1')){
          myDropdown2.classList.remove('show1');
      }
  }
}

    </script>
<!--+++++++++++++++++ Navbar js End++++++++++++++++++++++++++++++++++-->
<script>
             $("form :button").click(function(){
                //alert("clicked");
                 var current_id=$(this).attr('id'); //getting current like button id
                // alert(current_id);
                 var form_id = $(this).closest("form [id]").attr('id'); //for getting form id
                // console.log(form_id);
                  $.post($("#"+form_id).attr("action"), $("#"+form_id+" :input").serialize(), function(info){ 
                      //console.log(info); 
                    });
                 
 
                });
             
            
             
             $("button").click(function(){
                // alert(this.id);
                 var a=this.id;
               var elems= document.getElementsByClassName(a);
                 //console.log(elems);
                for (var i=0;i<elems.length;i+=1){ 
                     if(elems[i].style.display == 'block')
                    {
                     //elem1[i].value='Show me';
                     elems[i].style.display = 'none';
                 }
          else
         {  
        //elem1[i].value='Hide me';
           elems[i].style.display = 'block';
          }
            }
                    
             });
    </script>
    
    <script>
    $(document).ready(function(){
          function load_user(query)
          {
                  $.ajax({
                  url:"profile_user_fetch.php",
                  method:"post",
                  data:{query:query},
                  success:function(data)
                  {
                      $('#result').html(data);
                  }
              });
          }
          $('#search_text').keyup(function(){
              var search=$(this).val();
              if(search!='')
                  {
                      load_user(search);
                  }
              else
                  {
                     $('#result').empty();
                  }
          });
        });
    </script>
    <script>
    $(document).ready(function(){
        $("#myDropdown2").load('friend_request1.php');
    });
    </script>
</body>
</html>
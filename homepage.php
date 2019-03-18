<?php 
session_start();
require 'dbconfig/config.php';
if(!isset($_SESSION['username']))
{
	header("location:index.php");
}
?>

 
<!DOCTYPE html>
<html lang="en">
<head>
   <title>homepage</title>

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/newhomepage.css" type="text/css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="css/homepage_navbar.css">
    <link rel="stylesheet" type="text/css" href="css/notificationdropdown.css">
</head>
<body onload="loadpost()">
   <script>
          
          function loadpost()
       {
           document.getElementById("show_post").innerHTML = '<object type="text/php" data="display_all_post.php" style="width:100%; height:730px;"></object>';
       }
           window.setInterval("refreshDiv()", 100000);
       var w=document.getElementById("show_post");
       
            function refreshDiv(){
                
                document.getElementById("show_post").innerHTML = '<object type="text/php" data="display_all_post.php" style="width:100%; height:730px"></object>';
            }
       
        </script>
       
    <!--<script>
		$(document).ready(function() {
			$('#show_post').load('display_all_post.php')
			setInterval(function () {
				$('#show_post').load('display_all_post.php')
			}, 60000);
		});
	</script> -->
	<div id="main">
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

   <!-- for notification -->
                                      <!-- start -->

        <div class="dropdown">
              <button onclick="myFunctionnotification()" class="dropbtn db_notification dropdown-togglenotification">
                 <span class="countnotification"> </span> Notifications
              </button>
                <div id="myDropdownnotification" class="dropdown-content d_not dropdown-menunotification"></div>
        </div>


                                       <!-- end -->

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
<!--   <a href="#">Friend Request
   
   </a> -->
   <a href="homepage.php">Home</a>
   <label style="color:white;margin-left:2%;">Search</label>
   <input type="text" name="search_text" id="search_text" placeholder="Search..." style="margin-top: 1%;margin-left: 2%; height: 25px;width: 290px;border: 1px solid black;">
  <a href="#" style="width:120px;"><?php //echo '<img width="40px" height="40px" style="border-radius:50%;margin-top:-5px;" src="'.$_SESSION['imglink'].'">';?><img width="40px" height="40px" style="border-radius:50%;margin-top:-5px;" src="<?php 
               $q1='SELECT * from `user` WHERE username="'.$_SESSION['username'].'"';
                $result=mysqli_query($con,$q1);
                $row=mysqli_fetch_assoc($result);
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
                     }                                                              
               ?>"><p style="padding-left: 5px;margin-top:-38px;margin-left:78px;text-transform:capitalize;"><?php echo($_SESSION['fullname'])?></p></a>
</div>
    <!--++++++++++++++++++++++++++++++++++++++++++++++++++++ Nav Bar End++++++++++++++++++++++++++++++++++  -->
	    <div class="header">
	        <div class="photo">
	            <?php // echo '<img alt="Upload Photo" class="image" width="148px" height="160px" src="'.$_SESSION['imglink'].'">';?> 
	           <img alt="Upload Photo" class="image" width="148px" height="160px" src="<?php 
               $q1='SELECT * from `user` WHERE username="'.$_SESSION['username'].'"';
                $result=mysqli_query($con,$q1);
                $row=mysqli_fetch_assoc($result);
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
                     }                                                              
               ?>">
	        </div>
	        <div class="welcome_message">
	            <b>
                 Welcome <?php echo ($_SESSION['fullname'])?>
                </b>
	        </div>
	    </div>
	    
		<div class="middle_body">
	        <div class="post_body">
	            <div id="show_post">
                        
<!-- ++++++++++++++++++++++++++++++ Displaying Post ++++++++++++++++++++++++++++++++++++++++  -->
          
               
<!-- ++++++++++++++++++++++++++++++Displaying Post End ++++++++++++++++++++++++++++++++++++++++  --> 
                </div>
	        </div>
	        
	        <div class="users_display">
	            <div class="online_users">
                    <p align="center" style="font-size: 35px;"> <b>Friend List</b> </p><br><hr>
                    <?php 
                    $q="SELECT * FROM `friends` WHERE user='".$_SESSION['username']."'";
                    $r=mysqli_query($con,$q);
                    if(mysqli_num_rows($r)>0)
                    {
                        while($rr=mysqli_fetch_assoc($r))
                        {
                            echo '<center style="font-size:25px;">'.$rr['friendname'].'</center><hr><br>';
                        }
                    }
                    $qq="SELECT * FROM `friends` WHERE  friendname='".$_SESSION['username']."'";
                    $rrr=mysqli_query($con,$qq);
                    if(mysqli_num_rows($rrr)>0)
                    {
                       while($rr=mysqli_fetch_assoc($rrr))
                        {
                            echo '<center style="font-size:25px;">'.$rr['user'].'</center><hr><br>';
                        } 
                    }
                    else if(mysqli_num_rows($r)==0 and mysqli_num_rows($rrr)==0)
                    {
                        echo '<center style="font-size:25px;">You Have No Friends</center>';
                    }
                    
    
                    ?>
                    </div>
	        </div>
	    </div>
	 </div>
<!-- For fetching Search User information -->	 
<script>
    $(document).ready(function(){
          function load_user(query)
          {
                  $.ajax({
                  url:"user_fetch.php",
                  method:"post",
                  data:{query:query},
                  success:function(data)
                  {
                      $('#show_post').html(data);
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
                      loadpost();
                  }
          });

//======================================================================================

//     method to find info.  unseen Notifications                                   

//=====================================================================================
                                      //    start     //

  
      function unseen_notification(view = '')
        {
          $.ajax({
                url    : "notification.php",
                method : "post",
                data   : { view : view },
                datatype : "json",

                success:function(data)
                {
                  s = JSON.parse(data);
                  //alert(s.count);
                  
                  $(".dropdown-menunotification").html(s.notification);
                  // now checking if there is any unseen notification
                  if(s.unseen_notifications > 0)
                  {
                      $(".countnotification").html(s.unseen_notifications);
                  }
                } 
          });
        }
        unseen_notification();// calling this function for 1st on pageload 
       
         $(document).on('click', '.dropdown-togglenotification', function(){

           $(".countnotification").html('');

             //unseen_notification('yes');
               $(document).on('click', '.dropdown-togglenotification', function(){
                      unseen_notification('yes');
                       });
         });

      setInterval(function(){
         unseen_notification();
      }, 5000);


  });
//======================================================================================
//=====================================================================================


</script>
<!-- For fetching Search User information End -->    
<!--+++++++++++++++++ Navbar js ++++++++++++++++++++++++++++++++++-->

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

//=============== FOR NOTIFICATION=================================================
   /*            When the user clicks on the button, 
              toggle between hiding and showing the dropdown content     */
           function myFunctionnotification()
          {
          document.getElementById("myDropdownnotification").classList.toggle("shownotification");
          }
              // Close the dropdown if the user clicks outside of it
              window.onclick = function(event) 
              {
                if (!event.target.matches('.db_notification'))
                 {
                  var dropdowns = document.getElementsByClassName("d_not");
                  // var i;
                  // for (i = 0; i < dropdowns.length; i++) 
                  // {
                  //   var openDropdown = dropdowns[i];
                  //   if (openDropdown.classList.contains('shownotification'))
                  //    {
                  //     openDropdown.classList.remove('shownotification');
                  //     }
                  // }

                  if (dropdowns.classList.contains('shownotification'))
                   {
                    dropdowns.classList.remove('shownotification');
                   }
                }
              }
//===========================================================================================


   
// Close the dropdown if the user clicks outside of it
window.onclick = function(e) {
  if (!e.target.matches('.dropbtn')) {
    var myDropdown = document.getElementById("myDropdown");
      var myDropdown1 = document.getElementById("myDropdown1");
      var myDropdown2 = document.getElementById("myDropdown2");
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
<!--+++++++++++++++++ Navbar js End++++++++++++++++++++++++++++++++++-->
</script>
<script>
    $(document).ready(function(){
        $("#myDropdown2").load('friend_request1.php');
    });
    </script>	 
</body>
</html>
<?php
session_start();
require 'dbconfig/config.php';
if(!isset($_SESSION['username']))
{
	header('location:index.php');
}
else
{
	$username=$_SESSION['username'];
	$q1="SELECT * from user WHERE username='$username'";
	$result=mysqli_query($con,$q1);
	$row=mysqli_fetch_assoc($result);
	$fullname=$row['fullname'];
	$gender=$row['gender'];
	$email=$row['email'];
	$mobile_no=$row['mobile_no'];
	if($mobile_no==0)
	{
		$mobile_no='';
	}
	/*echo $fullname.'<br>'; 
	echo $email.'<br>';
	echo $gender.'<br>';
	echo $mobile_no.'<br>';
	*/
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title> Profile </title>
	<link rel="stylesheet" type="text/css" href="css/profile.css">
  </head>
  <body>
    <div id="main">
      <div class="heading">
        <form action="profile.php" method="post">
		  <input type="submit" id="edit_settings1" name="Home_page" value="Home Page">
		  <?php 
		  if(isset($_POST['Home_page']))
		  {
			  header("location:homepage.php");
		  }
		  ?>
		  </form>
      </div>
      <div class="heading1">
        <p style="margin-left:10px;"> User Profile </p>
      </div>
      <div>
       <div style="margin-left:40%;">
                <?php //echo '<img id="uploadPreview" alt="Upload Photo" style="border-radius:50%;width:150px;height:150px;" src="'.$_SESSION['imglink'].'">';?>
                <img id="uploadPreview" alt="Upload Photo" style="border-radius:50%;width:150px;height:150px;" src="<?php 
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
        <div class="labels1">
           <label class="labels column_left"> Full Name: </label>
          <label class="labels column_left"> User Name: </label>
           <label class="labels column_left"> Gender: </label>
             <label class="labels column_left"> Email: </label>
           <label class="labels column_left"> Mobile No: </label>
        </div>
       <div class="details1">
        <input class="details column" type="text" value="<?php echo $fullname;?>" disabled >
         
        <input class="details column" type="text" value="<?php echo $username;?>" disabled >
        
        <input class="details column" type="text" value="<?php echo $gender;?>" disabled >
        <input class="details column" type="text" value="<?php echo $email;?>" disabled > 
        <input class="details column" type="text" value="<?php echo $mobile_no;?>" disabled >
               </div>
      </div>
	  <div id="edit_settings">
          <form action="profile.php" method="post">
		  <input type="submit" id="edit_settings1" name="edit_settings" value="Edit Settings">
		  <?php 
		  if(isset($_POST['edit_settings']))
		  {
			  header("location:edit_settings.php");
		  }
		  ?>
		  </form>
        </div>
       </div>
      
  </body>
</html>

<?php 

require 'dbconfig/config.php';
session_start();
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
    
	if(isset($_POST['submit']))
	{
		$fullname_edit = $_POST['fullname'];
		$email_edit = $_POST['email'];
        if (!preg_match("/^[a-zA-Z ]*$/",$fullname_edit)) 
		{
		echo '<script> window.alert("Only letters and white space are allowed in fullname") </script>';
        }
		else if(!filter_var($email_edit, FILTER_VALIDATE_EMAIL)) 
		{
		 echo '<script> window.alert("Invalid email format") </script>';
        }
		else
		{
		$fullname_edit=mysqli_real_escape_string($con,$_POST['fullname']);
		$gender_edit=mysqli_real_escape_string($con,$_POST['gender']);
		$email_edit=mysqli_real_escape_string($con,$_POST['email']); 
		$mobile_no_edit=mysqli_real_escape_string($con,$_POST['mobile_no']);
            
        $img_name = $_FILES['imglink']['name'];
        $img_size = $_FILES['imglink']['size'];
        $img_tmp = $_FILES['imglink']['tmp_name'];
        $directory = "uploads/";
        $target_file = $directory.$img_name;
        
        if($img_size>2097152)  //this size in bytes which is equivalent to 2MB
        {
            echo '<script type="text/javascript"> alert("Image file size larger than 2 MB.. Try another image") </script>';
        }
        else if(!is_uploaded_file($_FILES['imglink']['tmp_name'])) //just checking whether user has uploaded a file or not
        {
        //echo 'No upload';
        $update_query="UPDATE user SET fullname='$fullname_edit',gender='$gender_edit',email='$email_edit',mobile_no='$mobile_no_edit' where username='$username'";
		$result_update=mysqli_query($con,$update_query);
            
		if($result) //checking whether query is properly executed or not
		{
			echo '<script> window.alert("Your details updated successfully")</script>';
			echo "<script>window.location.href='edit_settings.php'</script>"; //this line will update the page
			
		}
		else
		{
			echo '<script> alert("Try again") </script>';
		}
        }
        else  
        {
         move_uploaded_file($img_tmp,$target_file);
		  $update_query="UPDATE user SET fullname='$fullname_edit',gender='$gender_edit',email='$email_edit',mobile_no='$mobile_no_edit',imagelink='$target_file' where username='$username'";
		$result_update=mysqli_query($con,$update_query);
            
		if($result) //checking whether query is properly executed or not
		{
			echo '<script> window.alert("Your details updated successfully")</script>';
			echo "<script>window.location.href='edit_settings.php'</script>"; //this line will update the page
			
		}
		else
		{
			echo '<script> alert("Try again") </script>';
		}
		}
        }
        /* Updating New Session Variables */
            $q1="SELECT * from user WHERE username='$username'";
            $result=mysqli_query($con,$q1);
            $row=mysqli_fetch_assoc($result);
            $_SESSION['fullname']=$row['fullname'];
            $_SESSION['imglink']=$row['imagelink'];
	}
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title> Profile </title>
	<link rel="stylesheet" type="text/css" href="css/edit_settings.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
  </head>
  <body>
    <div id="main" style=" border: 5px solid green;
  margin:200px auto;
  width: 550px;
  height: 650px;">
      <div class="heading">
        <form action="edit_settings.php" method="post">
		  <input type="submit" id="edit_settings1" name="Home_page" value="Home Page" style="font-size: 25px;
    margin-left: 0px;">
		  <?php 
		  if(isset($_POST['Home_page']))
		  {
			  header("location:homepage.php");
		  }
		  ?>
		  </form>
      </div>
      <div class="heading1">
        <p style="margin-left:10px;"> Edit Details </p>
      </div>
      
       <div style="margin-left:40%;">
                <?php // echo '<img id="uploadPreview" alt="Upload Photo" class="login-img" style="border-radius:50%;width:150px;height:150px;" src="'.$_SESSION['imglink'].'">';?>
                <img id="uploadPreview" alt="Upload Photo" class="login-img" style="border-radius:50%;width:150px;height:150px;" src="<?php 
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
          <br>
           <label class="labels column_left"> Full Name: </label>
		   <label class="labels column_left"> Username: </label>
          <label class="labels column_left"> Gender: </label>
		   <label class="labels column_left"> Email: </label>
           <label class="labels column_left"> Mobile No: </label>
        </div>
         <form action="edit_settings.php" method="post" enctype="multipart/form-data">
	             <input type="file" id="imglink" name="imglink" accept=".jpg, .jpeg, .png" onchange="PreviewImage();" />
       <div class="details1">
	            
        <input class="details column" name="fullname" type="text" pattern=".{3,20}" required title="Name Should Contain atleast 3 letters" value="<?php echo $fullname;?>">
		
		<input class="details column" name="username" type="text" value="<?php echo $username;?>" disabled>
		
		<input class="details column" name="gender" pattern="[a-zA-Z]{4,6}" required title="enter MALE or FEMALE" type="text" value="<?php echo $gender;?>">
		
		<input class="details column" name="email" required maxlength="30" type="text" placeholder="xyz@gmail.com" value="<?php echo $email;?>">
        
        <input class="details column" name="mobile_no" type="text" pattern=".{10,10}" title="Enter a valid number" maxlength= "10" value="<?php echo $mobile_no;?>">
               </div>
      
	  <div id="edit_settings">
     <br><br>
      <input type="submit" id="edit_settings1" name="submit" value="Submit" style="font-size: 25px;margin-left: -140px;margin-top:220px;">
		  <input type="submit" id="edit_settings2" name="profile" value="Click here to go back" style="font-size: 25px;
  float: right;margin-top: -35px;">
		  <?php 
		  if(isset($_POST['profile']))
		  {
			  header("location:profile.php");
		  }
		  ?>
		  </div>
		  </form>
        
       </div>
       <!-- For PreviewImage -->
      <script type="text/javascript">
        function PreviewImage() {
            var freader = new FileReader();
            freader.readAsDataURL(document.getElementById("imglink").files[0]);
            freader.onload = function(frevent) {
                document.getElementById("uploadPreview").src = frevent.target.result;
            };
        };
    </script>
    
  </body>
</html>
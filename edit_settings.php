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
   <?php 
		  if(isset($_POST['profile']))
		  {
			  header("location:profile.php");
		  }
		  ?>
<!DOCTYPE html>
<html>
  <head>
    <title> Profile </title>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css">
  </head>
  <body>
       <div class="ui container" style="margin-top: 5%;">
          <div class="ui raised segment">
      <form action="profile.php" method="post" class="ui form">
          <div class="ui grid">
                <div class="row">
                <div class="four wide column">
                  <div class="field">
                    <div class="ui input left icon">
                     <input type="submit" class="ui massive button inverted orange" name="Home_page" value="Home Page">
                        <i class="home large icon"></i>
                          <?php 
                          if(isset($_POST['Home_page']))
                          {
                              header("location:homepage.php");
                          }
                          ?>
                      </div>
                    </div>
                  </div>
                 </div>
              </form>
              <div class="ui huge header" style="margin: 0 auto;">
                Edit Details
              </div>
              <div class="row">
                <img id="uploadPreview" style="width: 150px; height: 150px;" class="ui circular centered image" alt="Upload Photo" class="login-img" style="border-radius:50%;width:150px;height:150px;" src="<?php 
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
              <form action="edit_settings.php" method="post" enctype="multipart/form-data" class="ui form" style="margin: 0 auto;">
                  <div class="field" style="margin: 0 auto;font-size: 15px;">
                      <div class="ui right icon input">
                          <input type="file" id="imglink" name="imglink" accept=".jpg, .jpeg, .png" onchange="PreviewImage();" class="ui green label"/> 
                          <i class="upload large arrow icon"></i>
                      </div>
                  </div>
                  <div class="row" style="margin-top: 5%;">
                      <div class="inline field" style="margin: 0 auto;font-size: 20px;">
                        <input type="text" value="Fullname" class="ui label" disabled>
                        <input name="fullname" type="text" pattern=".{3,20}" required title="Name Should Contain atleast 3 letters" value="<?php echo $fullname;?>">
                      </div>  
                  </div>
                  <div class="row" style="margin-top: 1%;">
                      <div class="inline field" style="margin: 0 auto;font-size: 20px;">
                        <input type="text" value="Username" class="ui label" disabled>
                        <input name="username" type="text" pattern=".{3,20}" required title="Name Should Contain atleast 3 letters" value="<?php echo $username;?>" disabled>
                      </div>
                  </div>
                   <div class="row" style="margin-top: 1%;">
                      <div class="inline field" style="margin: 0 auto;font-size: 20px;">
                        <input type="text" value="Gender" class="ui label" disabled>
                        <input name="gender" type="text" name="gender" pattern="[a-zA-Z]{4,6}" required title="Enter MALE or FEMALE" value="<?php echo $gender;?>">
                      </div>
                  </div>
                   <div class="row" style="margin-top: 1%;">
                      <div class="inline field" style="margin: 0 auto;font-size: 20px;">
                        <input type="text" value="Email" class="ui label" disabled>
                        <input name="email" required maxlength="30" type="text" placeholder="xyz@gmail.com" value="<?php echo $email;?>">
                      </div>
                  </div> 
                   <div class="row" style="margin-top: 1%;">
                      <div class="inline field" style="margin: 0 auto;font-size: 20px;">
                        <input type="text" value="Mobile No." class="ui label" disabled>
                        <input name="mobile_no" type="text" pattern=".{10,10}" title="Enter a valid number" maxlength= "10"  value="<?php echo $mobile_no;?>">
                      </div>
                  </div> 
                  
	            </div> <!-- ui grid -->
              <br>
          <div class ="ui compact" style="text-align: center;margin-top: 4%;">
           <input type="submit" name="submit" value="Update" class="ui massive purple button">
		  <input type="submit" name="profile" value="Click here to go back" class="ui orange massive button">
          </div>
         
     </form>
              
       </div> <!-- Ui segment -->
    </div> <!-- ui Container -->
      
    <div id="main" style=" border: 5px solid green;
  margin:200px auto;
  width: 550px;
  height: 650px;">
         
        
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
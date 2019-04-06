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
}
?>
<!DOCTYPE html>
<html>

<head>
    <title> Profile </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>
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
                    <div class="ui huge header" style="margin: 0 auto;">
                        User Profile
                    </div>
                    <div class="row">
                        <img style="width: 150px; height: 150px;" class="ui circular centered image" src="<?php 
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
                </div>
                <table class="ui two wide column celled green table" style="margin-top: 5%;">
                    <tbody>
                        <tr>
                            <td data-label="fullname" class="ui header">Full Name:</td>
                            <td data-label="value" style="font-size: 25px;text-transform: capitalize;"><?php echo $fullname;?></td>
                        </tr>
                        <tr>
                            <td data-label="Name" class="ui header">User Name:</td>
                            <td data-label="Age" style="font-size: 25px;text-transform: capitalize;"><?php echo $username;?></td>
                        </tr>
                        <tr>
                            <td data-label="Name" class="ui header">Gender:</td>
                            <td data-label="Age" style="font-size: 25px;text-transform: capitalize;"><?php echo $gender;?></td>
                        </tr>
                        <tr>
                            <td data-label="Name" class="ui header">Email:</td>
                            <td data-label="Age" style="font-size: 25px;"><?php echo $email;?></td>
                        </tr>
                        <tr>
                            <td data-label="Name" class="ui header">Mobile No:</td>
                            <td data-label="Age" style="font-size: 25px;text-transform: capitalize;"><?php echo $mobile_no;?></td>
                        </tr>
                    </tbody>
                </table> <br>
            </form>

            <form action="profile.php" method="post" class="ui form">
                <div class="four wide field" style="margin: 0 auto;">
                    <div class="ui icon input">
                        <input type="submit" name="edit_settings" value="Edit Your Profile" class="ui massive button inverted blue">
                        <i class="edit large icon blue"></i>
                    </div>
                </div>
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
<?php
     require 'dbconfig/config.php';
?>
<!DOCTYPE html>
<html>

<head>
    <title> Register page </title>
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <script type="text/javascript">
        function PreviewImage() {
            var freader = new FileReader();
            freader.readAsDataURL(document.getElementById("imglink").files[0]);
            freader.onload = function(frevent) {
                document.getElementById("uploadPreview").src = frevent.target.result;
            };
        };
    </script>
</head>

<body style="background-color:#96ceb4">
    <form class="myform" action="register.php" method="post" enctype="multipart/form-data">
        <div id="main" class="main_register">
            <center>
                <h2> Register Page </h2>
                <img id="uploadPreview" src="imgs/login.png" class="login-img"><br>
                <input type="file" id="imglink" name="imglink" accept=".jpg, .jpeg, .png" onchange="PreviewImage();" />
            </center>
            <label style="font-size: 18px"><b>Fullname:</label><br>
            <input name="fullname" type="text" class="inputvalues" pattern=".{3,20}" required title="Name Should Contain atleast 3 letters" placeholder="Fullname" required><br>
            <label style="font-size: 18px"><b>Gender:</label><br>
            <input name="gender" type="radio" class="radiobtn" value='male' checked>Male
            <input name="gender" type="radio" class="radiobtn" value='female'>Female<br>
            <label style="font-size: 18px"><b>Username:</label><br>
            <input name="username" type="text" class="inputvalues" placeholder="Username" required><br>
            <label style="font-size: 18px"><b>Password:</label><br>
            <input name="password" type="password" id="pass1" class="inputvalues" placeholder="Password" required><br>
            <p id="warning1">WARNING! Caps lock is ON</p>
            <label style="font-size: 18px">Confirm Password</label><br>
            <input name="cpassword" type="password" id="pass2" class="inputvalues" placeholder="Password"><br>
            <p id="warning2">WARNING! Caps lock is ON</p>
            <label style="font-size: 18px">Email</label><br>
            <input type="text" name="email" required maxlength="30" type="text" placeholder="xyz@gmail.com" class="inputvalues" required><br>
            <input name="submit_btn" type="submit" class="register_btn" value="Sign Up">
            <p>
                <font size="6px"> Already a member? </font><a href="index.php"><input type="button" class="signin_btn" value="Sign in"></a>
            </p>
    </form>

    <?php
	         if(isset($_POST['submit_btn']))
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
				// echo '<script type="text/javascript"> alert("Sign up button clicked") </script>';
				$fullname=mysqli_real_escape_string($con,$_POST['fullname']);
				$gender=mysqli_real_escape_string($con,$_POST['gender']);
				$username=mysqli_real_escape_string($con,$_POST['username']);
				$password=mysqli_real_escape_string($con,$_POST['password']);
				$cpassword=mysqli_real_escape_string($con,$_POST['cpassword']);
				$email=mysqli_real_escape_string($con,$_POST['email']);
				
				// for uploading image file ==================================================
				$img_name = $_FILES['imglink']['name'];
				$img_size = $_FILES['imglink']['size'];
				$img_tmp = $_FILES['imglink']['tmp_name'];
				
				$directory = "uploads/";
				$target_file = $directory.$img_name;
				// ============================================================================
				if($password==$cpassword)
				{
					$query="select * from user where username='$username'";
					$query_run=mysqli_query($con,$query);
					if(mysqli_num_rows($query_run)>0)
					{
						echo '<script type="text/javascript"> alert("Username already exists..") </script>';
					}
					/*else if(file_exists($target_file))
					{
						echo '<script type="text/javascript"> alert("Image file already exists..") </script>';
					}*/
					else if($img_size>2097152)  //this size in bytes which is equivalent to 2MB
					{
						echo '<script type="text/javascript"> alert("Image file size larger than 2 MB.. Try another image") </script>';
					}
					else 
					{
						move_uploaded_file($img_tmp,$target_file);
						$password=md5($password);  //encrypting password
						$query="insert into user values('','$fullname','$gender','$username','$email','$password','$target_file','')";
						$query_run=mysqli_query($con,$query);

						if($query_run)   //if it returns "1" then the values are successfully inserted into the database
						{
							echo '<script type="text/javascript"> alert("User Registered.. Go to Login page to login") </script>';
						}
                        else
						{
							echo '<script type="text/javascript"> alert("Please Try again Something went wrong") </script>';
						}
					}
				}
				else
				{
					echo '<script type="text/javascript"> alert("Password and Confirm Password does not match!") </script>';
				}
			 }
            }
	 ?>
    </div>
    <script>
        
        var input1 = document.getElementById("pass1");
        var input2 = document.getElementById("pass2");
        var text1 = document.getElementById("warning1");
        var text2 = document.getElementById("warning2");
        input1.addEventListener("keyup", pass1_capslock);

        function pass1_capslock() {
            if (event.getModifierState("CapsLock")) {
                text1.style.display = "block";
            } else {
                text1.style.display = "none";
            }
        }
        input2.addEventListener("keyup", pass2_capslock);

        function pass2_capslock() {
            if (event.getModifierState("CapsLock")) {
                text2.style.display = "block";
            } else {
                {
                    text2.style.display = "none";
                }
            }
        }
    </script>
</body>

</html>
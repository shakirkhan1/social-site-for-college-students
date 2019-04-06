<?php
session_start();
require 'dbconfig/config.php';
?>
<!DOCTYPE html>
<html>

<head>
    <title> Login page </title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>
</head>

<body style="background-color:#96ceb4;">
    <div class="ui container">
        <div class="ui segment raised huge label" style="float:left;margin-left: 40%;margin-top: 15%;width: 42%;text-align: center;">
            Welcome To the Social Site
        </div>
        <div class="ui segment raised label" style="margin-left: 40%;margin-top: 1%;">
            <center>
                <h2> Login Page </h2>
                <img src="imgs/login.png" class="login-img">
            </center>

            <form class="myform ui form" action="index.php" method="post">

                <label for="username" style="font-size: 22px;font-weight: bold;"> Username:</label><br>
                <input name="username" type="text" class="inputvalues" placeholder="Username" required><br><br><br>
                <label style="font-size: 22px"><b> Password:</b></label>
                <input name="password" type="password" id="pass1" class="inputvalues" placeholder="Password" required><br>
                <p id="warning">WARNING! Caps lock is ON.</p>
                <input name="login" type="submit" class="ui green inverted fluid large button" value="Login" style="margin-top: 5%;"><br>
                <a href="register.php">
                    <input type="button" class="ui blue inverted fluid large button" value="Register"></a>

            </form>
            <?php
 if(isset($_POST['login']))
 {
	 $username=$_POST['username'];
	 $password=md5($_POST['password']);
	 $query="select * from user where username='$username' and password='$password'";
	 $query_run=mysqli_query($con,$query);

	 if(mysqli_num_rows($query_run)>0)
	 {
		 $row=mysqli_fetch_assoc($query_run);
		 //$query1="select fullname from user where username='$username' and password='$password'";
		 //$result=mysqli_query($con,$query1);
		 //$row = mysqli_fetch_assoc($result); //the returned result from mysqli_query can't be directly converted to string so we store it in form of array and then retrieve it later. //fetches a result row as an associative array (key value pair type).
		 //$fullname=mysqli_query($con,$query1);
		 
         $_SESSION['imglink']=$row['imagelink'];
		 $_SESSION['username']= $row['username']; //username is a session and it is used to identify the user.
		 $_SESSION['fullname']=$row['fullname'];
		 header('location:homepage.php');

	 }
	 else
	 {
		 echo '<script type="text/javascript"> alert("Invalid Credentials!") </script>';
	 }

 }

?>

        </div>
    </div>

    <!-- For CapsLock -->
    <script>
        var input = document.getElementById("pass1");
        var text = document.getElementById("warning"); //storing whole "document.getElementById("warning")" in text variable.
        input.addEventListener("keyup", check_capslock); //addEventListener() method attaches an event handler to the specified element
        function check_capslock() {
            if (event.getModifierState("CapsLock")) //get the state of the CapsLock
            {
                text.style.display = "block";

            } else {
                {
                    text.style.display = "none";
                }
            }
        }
    </script>

    <!-- ------------------------------------  -->
</body>

</html>
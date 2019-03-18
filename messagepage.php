<?php 
session_start();
require 'dbconfig/config.php';
if(!isset($_SESSION['username']))
{
	header("location:index.php");
}
?>
<!DOCTYPE HTML>
<html>
<head>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<link rel="stylesheet" type="text/css" href="css/global_chat.css">

</head>
<body> <!--onload="JavaScript:AutoRefresh(5000);" --> <!--onload="clearmessage;-->
<!-- function for refreshing the online users -->
<script type='text/javascript'>
			$(document).ready(function() {
				$('#auto').load('online_users.php');
				//$('#message').load('message.php');
				refresh();
			});
			
			function refresh()
			{
				
				setTimeout(function() {
					$('#auto').load('online_users.php');
					refresh();
				},200); //refeshing at every 200ms
			}
	
</script>
<!-- +++++++++++++++++++++++++++++++++++++++++++++++++++ --> 
<center><h1> Welcome to Global Message Chat </h1></center>
<?php 
echo "<h1><center>Welcome ".$_SESSION['username']."</center></h1>";
//.Your Session ID:.session_id()
?>
<div id="whole_body">
<div id="auto">
</div>
<div id="main">
<div id="message_area" class="message_scroll" >

<?php 
include 'display_global_chat_messages.php';
?>
</div>
<form method="POST">
<input id="clear_message" type="text" name="message" style="margin-left:5px; width:450px; height:40px;" placeholder="Type your message here....">
<input type="submit" name="submit" style="width: 120px;height:40px;" value="Send">
<input type="reset" value="Clear all"  style="margin-left:2px; height:40px; color:red"> 
<input type="submit" name="goback" style="margin: 2px;width:200px;height:40px;color:green" value="click here to go homepage">
</form>
</div>
</div>
<script>
    var element = document.getElementById("message_area");
    element.scrollTop = element.scrollHeight;
    /*function updateScroll(){
    var element = document.getElementById("yourDivID");
    element.scrollTop = element.scrollHeight;
}*/
    //setInterval(updateScroll,1000); //updating scroll bar every 1 sec
</script>
</body>
</html>
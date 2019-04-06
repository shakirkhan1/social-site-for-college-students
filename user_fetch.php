<?php
session_start();
require 'dbconfig/config.php';
if(!isset($_SESSION['username']))
{
	header("location:index.php");
}
if(isset($_POST["query"]))
{
    $search=mysqli_real_escape_string($con,$_POST["query"]);
    $query="SELECT * FROM user WHERE fullname LIKE '%".$search."%' OR username LIKE '%".$search."%'";
}
else
{
    echo '<script>alert("Something Went Wrong, Refresh the page please")';
}

$result=mysqli_query($con,$query);
while($row=mysqli_fetch_array($result))
{ ?>
<div><a style="text-decoration:none;color:black;" href="view_profile.php?username=<?php echo $row['username'];?>">
        <img class="user-img" src="<?php if($row['imagelink']=="uploads/")
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
 } ?>" width="70px" height="70px">
        <div class="user-details">Username: <a style="text-decoration:none;color:black;" href="view_profile.php?username=<?php echo $row['username'];?>"><?php echo $row['username'] ?><br>
                Fullname:
                <a style="text-decoration:none;color:black;" href="view_profile.php?username=<?php echo $row['username'];?>"><?php echo $row['fullname'] ?></a><br><br>
                <!--Gender:&nbsp;&nbsp; &nbsp;                -->
                <?//php echo $row['gender'] ?><br>
        </div>
</div>
<hr>
<?php }
if(mysqli_num_rows($result)==0)
{
    echo '<center>'."No Result Found".'</center>';
}
else
{
 echo '<center>'."End of Results".'</center>';   
}
?>
<!Doctype html>
<html>

<head>
    <title>user details</title>
    <link rel="stylesheet" href="css/user_fetch.css" type="text/css">
</head>

</html>
<?php 
    
	session_start();
   require 'dbconfig/config.php';
if(!isset($_SESSION['username'])){
 header('location:index.php');
}

//echo "success";
$username=$_SESSION['username'];
$post_id2=$_POST['post_id2'];
//echo $_POST['post_id2'];
$count=1;
$sql1="SELECT * FROM `likepage` where post_id='$post_id2' and username='$username'";
$result1=mysqli_query($con,$sql1);
if(mysqli_num_rows($result1)==0)
{
$sql="INSERT INTO `likepage` VALUES('','$post_id2','$username','$count')";
$result=mysqli_query($con,$sql);

//===============================================================================================
//                                 GETTING LIKE ID AFTER INSERTION                             //

	$get_like_id = " select id from likepage where post_id ='$post_id2' and username ='$username' ";
	$get_like_id1 = mysqli_query($con,$get_like_id);
    while( $rr =mysqli_fetch_array($get_like_id1) )
    {
         $like_id = $rr['id'] ;
         break;
    }
    echo '<script> alert("'.$like_id.'") </script>';
//                               GETTING OWNERNAME    FOR THIS POST                           //
    $ret_post_id = " select username from posts where post_id = '$post_id2' ";
    $ret_post_id1 = mysqli_query($con,$ret_post_id);

    while( $rr =mysqli_fetch_array($ret_post_id1) )
    {
         $owner_name = $rr['username'] ;
         break;
    }
    echo '<script> alert("'.$owner_name.'") </script>';

	$sql1 = "insert into noti_likes (post_id, like_id, owner_name, username ) values ('$post_id2', '$like_id', '$owner_name', '$username' ) ";
	$res = mysqli_query($con,$sql1);
//===========================================================================================//

	header('location:display_all_post.php');

}
else
{
    
    $sql3="DELETE FROM `likepage` WHERE post_id='$post_id2' and username='$username'";
    $result3=mysqli_query($con,$sql3);
    header('location:display_all_post.php');
}

?>
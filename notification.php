<?php 
  
  include 'dbconfig/config.php';
  session_start();
if(!isset($_SESSION['username']))
{
    header('location:index.php');
}
  $one = 1;
  $zero = 0;
  $uname = $_SESSION['username'];
  // echo $uname ;  
 //============================================================================================
 //                             FOR UPDATE                                                   //
 //========================================================================================
  if($_POST["view"] != '')
  {
    // update notification for posts viewed    
    $update_query =" update notification set notification_status = $one where notification_status =$zero and username = '$uname' ";
  	  mysqli_query($con, $update_query);

   // update notification for posts viewd
   $update_query11 =" update noti_comments set comment_status = $one where comment_status = $zero and comment_owner = '$uname' ";
     mysqli_query($con, $update_query11);

    // update the like notification table

    $update_like = " update noti_likes set status = $one where status =$zero and owner_name = '$uname' ";
    mysqli_query($con, $update_like);

    }
// ============================================================================================
   
           // getting unseen notifications related with posts for this users 

  $sql = " select * from notification where username = '$uname' order by notification_status DESC ";
  $result = mysqli_query($con,$sql);
   $sqlcount1 = " select * from notification where notification_status = $zero and username = '$uname' ";
  $resultcount = mysqli_query($con,$sqlcount1);
  

          
// ============================for comment notification ==================================
  
  $sql11 = " select * from noti_comments where comment_owner = '$uname' order by comment_status DESC";
  $result11 = mysqli_query($con,$sql11);

    $sql11count = " select * from noti_comments where comment_status = $zero and comment_owner = '$uname' ";
  $result11count = mysqli_query($con,$sql11count);

// ============================ for LIKES NOTI.  =========================================

 $sql22 = "select * from noti_likes where owner_name = '$uname' order by status DESC ";
 $result22 = mysqli_query($con, $sql22);
 $sql22count = "select * from noti_likes where status = '$zero' and owner_name = '$uname' ";
 $result22count = mysqli_query($con, $sql22count);


//==========================FOR NOTI_POSTS ===============================================
            $count = mysqli_num_rows($resultcount);
            $output = '' ;
            //echo '<script> alert("'.$count.'") </script>';
           if(mysqli_num_rows($result) > 0)
           {
             while( $row = mysqli_fetch_array($result) )
             {
                  $pos_id1 = $row['post_id'];
                  $get_date = " select date from posts where post_id = '$pos_id1' ";
                  $check = mysqli_query($con, $get_date);
                  while( $rr = mysqli_fetch_array($check))
                  {
                    $result_date = $rr['date'];
                    break;
                  }
                 // echo '<script> alert("'.$result_date.'") </script>';
                   $output .='<a href="#">'.$row['sender_post'].' has posted <em>'.$row['post_title'].' </em>
                        '.$result_date.'</a><hr style="border: 1px ridge grey;">';
             }
           }
           // else
           // {
           //  $output .='
           //       <a href="#"> </a> 
           //  ';
           
           // }
//==================================FOR COMMENTS ============================================

 
         $count11 = mysqli_num_rows($result11count);
        //echo '<script> alert("c1 '.$count11.'") </script>';
        $output11 = '';
       if( mysqli_num_rows($result11) > 0 )
       {
         while( $row = mysqli_fetch_array($result11) )
         {
              $comment_id11 = $row['noti_comment_id'];
              $get_date = " select date from comments where comment_id = '$comment_id11' ";
              $check = mysqli_query($con, $get_date);
              while( $rr = mysqli_fetch_array($check))
              {
                $result_date = $rr['date'];
                break;
              }
              //echo '<script> alert("'.$result_date.'") </script>';
               $output11 .='<a href="#">'.$row['comment_username'].' has commented on your <em>'.$row['comment_title'].' </em>'.$result_date.'</a><hr style="border: 1px ridge grey;">';
         }
       }
       // else
       // {
       //    $output11 .='
       //       <a href="#"> </a> 
       //  ';
       // }


//======================= FOR COMMENTS END ==================================================
 

         $count22 = mysqli_num_rows($result22count);
        //echo '<script> alert("c1 '.$count11.'") </script>';
        $output22 = '';
       if( mysqli_num_rows($result22) > 0 )
       {
         while( $row = mysqli_fetch_array($result22) )
         {
              $post_id22 = $row['post_id'];
              $get_date22 = " select date,post_title from posts where post_id = '$post_id22' ";
              $check = mysqli_query($con, $get_date22);
              while( $rr = mysqli_fetch_array($check))
              {
                $result_date = $rr['date'];
                $post_title = $rr['post_title'];
                break;
              }
              //echo '<script> alert("'.$result_date.'") </script>';
               $output22 .='<a href="#">'.$row['username'].' liked your <em>'.$post_title.' post </em>'.$result_date.'</a><hr style="border: 1px ridge grey;">';
         }
       }
       // else
       // {
       //    $output22 .='<a href="#"> </a> ';
       // }






 //============================  LIKES noti end =============================================
 if(mysqli_num_rows($result) == 0 && mysqli_num_rows($result11) == 0 && mysqli_num_rows($result22) == 0)
 {
    $final_output = '
             <a href="#">Nothing to display </a> 
        ';
 }
// else if($count == 0 )  // if there is only commnets noti
//  {
//     $final_output = $output11 ;
//  }
//  else if($count11 == 0) // if there is only posts noti
// {
//     $final_output = $output ;
// }
// else if($count != 0 && $count11 != 0)
// {
//   $final_output = $output.$output11 ;  
// }
else
   $final_output =$output.$output11.$output22 ;
$count += $count11  ;
 $count +=  $count22 ;
 // echo '<script> alert("'.$count.'") </script>';
  $data = array(
         'notification'         => $final_output,
         'unseen_notifications' => $count,
  );
// before sending backdata we json encode data 
 echo json_encode($data);

?>
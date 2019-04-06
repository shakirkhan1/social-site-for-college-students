<?php 
session_start();
require 'dbconfig/config.php';
if(!isset($_SESSION['username']))
{
	header("location:index.php");
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>homepage</title>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="css/notificationdropdown.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>
</head>

<body onload="loadpost()">
    <script>
        function loadpost() {
            document.getElementById("show_post").innerHTML = '<object type="text/php" data="display_all_post.php" style="width:100%; height:730px;"></object>';
        }
        window.setInterval("refreshDiv()", 100000);
        var w = document.getElementById("show_post");

        function refreshDiv() {

            document.getElementById("show_post").innerHTML = '<object type="text/php" data="display_all_post.php" style="width:100%; height:730px"></object>';
        }
    </script>
    <?php include 'navbar.php' ?>
    <div class="ui segment grid" style="width:90%;margin-left:5%;margin-top:1%;background-color: whitesmoke;">
        <div class="ui row">
            <div class="ui four wide column" style="margin-top: 1%;margin-left: 5%;">
                <img style="width:180px; height: 180px;" class="ui rounded bordered segment purple tiny image" src="<?php 
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
            <div class="ui ten wide column">
                <div class="ui header" style="font-size: 60px;margin-top:4%;margin-left:5%;text-transform: Capitalize;">
                    Welcome <?php echo ($_SESSION['fullname'])?>
                </div>
            </div>
        </div>

    </div>

    <div id="show_post" style="width: 50%;overflow-y: auto;float: left;margin-left:5%;" class="ui segment">


        <!-- ++++++++++++++++++++++++++++++ Displaying Post / Search Results++++++++++++++++++++++++++++++++++++++++  -->


        <!-- ++++++++++++++++++++++++++++++Displaying Post End ++++++++++++++++++++++++++++++++++++++++  -->
    </div>

    <div class="ui huge segment raised header" style="float: left;margin-left: 20%;text-align: center;width: 20%;height: auto;font-size:2.0rem;">
        Friend Lists
        <div class="ui grid" style="margin-top: 2%;">
            <div class="ui row" style="text-align:center;">

                <?php 
                    $q="SELECT * FROM `friends` WHERE user='".$_SESSION['username']."'";
                    $r=mysqli_query($con,$q);
                    if(mysqli_num_rows($r)>0)
                    {
                        while($rr=mysqli_fetch_assoc($r))
                        {
                            echo '<div class="ui thirteen wide column" style="margin:0px auto;">
                            <div class="ui segment" style="font-size:1.5rem;text-transform: Capitalize;">'.$rr['friendname'].'</div></div>';
                        }
                    }
                    $qq="SELECT * FROM `friends` WHERE  friendname='".$_SESSION['username']."'";
                    $rrr=mysqli_query($con,$qq);
                    if(mysqli_num_rows($rrr)>0)
                    {
                       while($rr=mysqli_fetch_assoc($rrr))
                        {
                           echo '<div class="ui thirteen wide column" style="margin:0px auto;">
                            <div class="ui segment" style="font-size:1.5rem;text-transform: Capitalize;">'.$rr['user'].'</div></div>';
                        } 
                    }
                    else if(mysqli_num_rows($r)==0 and mysqli_num_rows($rrr)==0)
                    {
                        echo '<div class="ui thirteen wide column" style="margin:0px auto;">
                            <div class="ui" style="font-size:1.3rem;text-transform: Capitalize;">
                            <div class="ui teal message">You Have No Friends!</div></div></div>';
                    }
                    
    
                    ?>

            </div>
        </div>
    </div>


    <!-- For fetching Search User information -->
    <script>
        $(document).ready(function() {
            function load_user(query) {
                $.ajax({
                    url: "user_fetch.php",
                    method: "post",
                    data: {
                        query: query
                    },
                    success: function(data) {
                        $('#show_post').html(data);
                    }
                });
            }
            $('#search_text').keyup(function() {
                var search = $(this).val();
                if (search != '') {
                    load_user(search);
                } else {
                    loadpost();
                }
            });

            //============================================================================================

            //              method to find info.  unseen Notifications                                   

            //  ================================================================================================
            //    start     //


            function unseen_notification(view = '') {
                $.ajax({
                    url: "notification.php",
                    method: "post",
                    data: {
                        view: view
                    },
                    datatype: "json",

                    success: function(data) {
                        s = JSON.parse(data);
                        //alert(s.count);

                        $(".dropdown-menunotification").html(s.notification);
                        // now checking if there is any unseen notification
                        if (s.unseen_notifications > 0) {
                            $(".countnotification").html(s.unseen_notifications);
                        }
                    }
                });
            }
            unseen_notification(); // calling this function for 1st on pageload 

            $(document).on('click', '.dropdown-togglenotification', function() {

                $(".countnotification").html('');

                //unseen_notification('yes');
                $(document).on('click', '.dropdown-togglenotification', function() {
                    unseen_notification('yes');
                });
            });

            setInterval(function() {
                unseen_notification();
            }, 5000);


        });
        //=============================================================================================
        //========================================================================================
    </script>
    </script>
    <script>
        $(document).ready(function() {
            $("#myDropdown2").load('friend_request1.php');
            $('.ui.dropdown').dropdown();
        });
    </script>
</body>

</html>
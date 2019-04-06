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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>
</head>

<body>
    <!--onload="JavaScript:AutoRefresh(5000);" -->
    <!--onload="clearmessage;-->
    <!-- function for refreshing the online users -->
    <script type='text/javascript'>
        $(document).ready(function() {
            $('#total_user').load('online_users.php');
            //$('#message').load('message.php');
            refresh();
        });

        function refresh() {
            setTimeout(function() {
                $('#total_user').load('online_users.php');
                refresh();
            }, 200); //refeshing at every 200ms
        }
    </script>
    <!-- +++++++++++++++++++++++++++++++++++++++++++++++++++ -->
    <div class="ui container" style="text-align:center;margin-top:2%;">
        <div class="ui segment">
            <div class="ui huge header" style="font-size: 2.5em;">Welcome to Global Message Chat <?php echo "<span style='text-transform: capitalize;'>".$_SESSION['username']."</div>"; ?></span>
            </div>
        </div>

        <div class="ui grid" style="margin-top: 5%;">
            <div class="row">
                <div class="ui three wide column" style="height: auto;">
                    <div id="total_user"> </div>
                </div>
                <div class="ui twelve wide column" style="height: auto;">
                    <div class="ui segment message_scroll" style=" max-height: 650px;
    overflow-y: scroll;
}">
                        <?php 
                include 'display_global_chat_messages.php';
                ?>
                    </div><br>
                    <form method="POST" class="ui form">
                        <div class="two fields">
                            <div class="field seven wide column">
                                <input id="clear_message" type="text" name="message" placeholder="Type your message here....">
                            </div>
                            <div class="field">
                                <div class="ui right icon input" style="width: 20%;">
                                    <input type="submit" name="submit" class="ui button large green" value="Send"><i class="send large icon"></i>
                                </div>
                                <div class="ui right icon input" style="width: 20%;">
                                    <input type="reset" value="Clear all" class="ui button large red"><i class="delete large icon"></i>
                                </div>
                                <div class="ui right icon input" style="width: 40%;">
                                    <input type="submit" name="goback" class="ui button large orange" value="Click here to go homepage"><i class="left large arrow icon"></i>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            var element = document.querySelector(".message_scroll");
            element.scrollTop = element.scrollHeight; //setting scroll bar height equals to scrollheight
            /*function updateScroll(){
    var element = document.getElementById("yourDivID");
    element.scrollTop = element.scrollHeight;
}*/
            //setInterval(updateScroll,1000); //updating scroll bar every 1 sec
        </script>
</body>

</html>
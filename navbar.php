<div class="ui menu" style="width: 90%;margin-left: 5%;font-size: 20px;">
    <div class="ui category search item">
        <div class="ui transparent icon input">
            <input type="text" name="search_text" id="search_text" placeholder="Search..." class="prompt">
            <i class="search link icon"></i>
        </div>
    </div>
    <div class="right menu">
        <div class="item">
            <a href="homepage.php"><img class="ui avatar image" src="<?php 
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
               ?>"><span style="text-transform:capitalize;"><?php echo($_SESSION['fullname'])?></span></a>

        </div>
        <div class="item">
            <div class="ui dropdown">
                <div class="text">Friend Request</div>
                <i class="dropdown icon"></i>
                <?php
                    $username1 = $_SESSION['username'];
                    $qqq = "SELECT * FROM `friendrequest` WHERE receiver='$username1' AND seen='0'";
                   $result1=mysqli_query($con,$qqq);
                   if(mysqli_num_rows($result1)>0)
                   {
                       $count_friends=mysqli_num_rows($result1);
                       echo $count_friends;  
                   }?>
                <div class="menu" style="width: 400px;">
                    <div class="item" id="myDropdown2">

                        <!-- -->
                    </div>
                </div>
            </div>
        </div>
        <div class="item">
            <a href="post.php">Post</a>
        </div>
        <div class="item">
            <a href="messagepage.php">Community Chat</a>
        </div>
        <div class="item">
            <div class="ui dropdown">
                <div class="text">Notifications</div>
                <i class="dropdown icon"></i>
                <span class="countnotification"> </span>
                <div class="menu" style="width: 400px;">
                    <div class="item" id="myDropdown2">
                        <div id="myDropdownnotification" class="dropdown-content d_not dropdown-menunotification"></div>
                        <!-- -->
                    </div>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="ui dropdown">
                <div class="text">Settings</div>
                <i class="dropdown icon"></i>
                <div class="menu">
                    <a href="profile.php" class="item">View Profile</a>
                    <a href="edit_settings.php" class="item">Edit Settings</a>
                    <div class="ui divider"></div>
                    <a href="logout.php" class="item">Logout</a>
                </div>
            </div>

        </div>
    </div>
</div>
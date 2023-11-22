<?php session_start(); ?>
<!-- header-wrap  -->
<div class="header-wrap">
    <!-- header-contents  -->
    <div class="header-contents">
        <!-- header-contents-left  -->
        <div class="header-contents-left">
            <div class="menu-button" onclick="Toggle('.menu-contents')">&#9776;</div>
        </div>
        <!-- header-contents-left ends -->
        <!-- header-contents-center  -->
        <div class="header-contents-center">
            <?php echo $_SESSION['Username']; ?>
        </div>
        <!-- header-contents-center ends -->
        <!-- header-contents-right  -->
        <div class="header-contents-right">
        </div>
        <!-- header-contents-right ends -->
    </div>
    <!-- header-contents ends  -->
</div>
<!-- header-wrap ends  -->
<!-- menu-contents  -->
<div class="menu-contents">
    <a href="home.html"><div>Home</div></a>
    <a href="./change_my_password.html"><div>Change my Password</div></a>
    <a href="./update_user.html"><div>Update my Info</div></a>
    <a href="./php/logout.php"><div>Logout</div></a>
</div>
<!-- menu-contents ends -->


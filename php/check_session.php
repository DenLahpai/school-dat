<?php
session_start();

if (isset($_SESSION['Username'])) {
    //zero is returned is session is set
    echo 0;
}
else {
    //one is returned if session is not set
    echo 1;
}
?>
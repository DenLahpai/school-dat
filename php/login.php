<?php
session_start();
require_once "handler.php";

if ($_POST['Username']) {

    $db = new database();
    $stm = "SELECT * FROM Users WHERE 
        BINARY Username = :Username AND
        BINARY Password = :Password
    ;";
    $db->query($stm);
    $db->bind(":Username", trim($_POST['Username']));
    $db->bind(":Password", md5($_POST['Password']));
    $row_count = $db->row_count();
    $rows = $db->resultset_array();

    if ($row_count == 1) {
        foreach ($rows as $row) {
            $_SESSION = $row;
        }
        //zero is returned for no error
        echo 0;
    }
    else {
        echo "Wrong Username or Password!";
    }
}
?>
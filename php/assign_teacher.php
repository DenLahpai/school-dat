<?php
require_once "functions.php";
if (isset($_POST['ClassesLink']) || !empty($_POST['ClassesLink'])) {
    $db = new database ();
    $Link = uniqid("Tch-Cls_", true);
    $stm = "INSERT INTO Teachers_Classes SET 
        Link = :Link, 
        TeachersLink = :TeachersLink, 
        ClassesLink = :ClassesLink
    ;";
    $db->query($stm);
    $db->bind(":Link", $Link);
    $db->bind(":TeachersLink", $_POST['TeachersLink']);
    $db->bind(":ClassesLink", $_POST['ClassesLink']);
    if ($db->execute()) {
        echo 0;
    }
    else {
        echo "There was a connection error! Please try again!";
    }
}
?>
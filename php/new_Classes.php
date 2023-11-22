<?php
require_once "functions.php";
if (isset ($_POST['Name']) || !empty($_POST['Name'])) {
    $Link = uniqid("Cls_", true);
    $db = new database();
    $stm = "INSERT INTO Classes SET 
        BranchesId = :BranchesId, 
        Link = :Link,
        Name = :Name, 
        Room = :Room, 
        CoursesLink = :CoursesLink, 
        StartDate = :StartDate, 
        EndDate = :EndDate, 
        Registration = :Registration, 
        Monthly = :Monthly
    ;";
    $db->query($stm);
    $db->bind(":BranchesId", $_SESSION['BranchesId']);
    $db->bind(":Link", $Link);
    $db->bind(":Name", trim($_POST['Name']));
    $db->bind(":Room", trim($_POST['Room']));
    $db->bind(":CoursesLink", trim($_POST['CoursesLink']));
    $db->bind(":StartDate", $_POST['StartDate']);
    $db->bind(":EndDate", $_POST['EndDate']);
    $db->bind(":Registration", trim($_POST['Registration']));
    $db->bind(":Monthly", trim($_POST['Monthly']));
    if ($db->execute()) {
        echo 0;
    }
    else {
        echo "There was a connection error! Please try again!";
    }
}
?>
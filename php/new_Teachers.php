<?php
require_once "functions.php";
if (isset($_POST['Name'])) {
    $db = new database();
    //generating a link 
    $Link = uniqid("Tch_", true);
    $stm = "INSERT INTO Teachers SET 
        BranchesId = :BranchesId, 
        Link = :Link, 
        Title = :Title, 
        Name = :Name, 
        EnglishName = :EnglishName, 
        DOB = :DOB, 
        Mobile = :Mobile, 
        Email = :Email, 
        StartDate = :StartDate, 
        Education = :Education
    ;";
    $db->query($stm);
    $db->bind(":BranchesId", $_SESSION['BranchesId']);
    $db->bind(":Link", $Link);
    $db->bind(":Title", $_POST['Title']);
    $db->bind(":Name", trim($_POST['Name']));
    $db->bind(":EnglishName", trim($_POST['EnglishName']));
    $db->bind(":DOB", $_POST['DOB']);
    $db->bind(":Mobile", trim($_POST['Mobile']));
    $db->bind(":Email", trim($_POST['Email']));
    $db->bind(":StartDate", trim($_POST['StartDate']));
    $db->bind(":Education", trim($_POST['Education']));
    if ($db->execute()) {
        echo 0;
    }
    else {
        echo "There was a connection error! Please try again!";
    }
}
?>
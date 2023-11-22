<?php
require_once "functions.php";
if (isset($_POST['Link'])) {
    $db = new database ();
    $stm = "UPDATE Teachers SET 
        Title = :Title, 
        Name = :Name, 
        EnglishName = :EnglishName, 
        DOB = :DOB, 
        Mobile = :Mobile, 
        Email = :Email, 
        StartDate = :StartDate, 
        Education = :Education WHERE
        Link = :Link
    ;";
    // print_r ($_POST);
    $db->query($stm);
    $db->bind(":Title", $_POST['Title']);
    $db->bind(":Name", trim($_POST['Name']));
    $db->bind(":EnglishName", trim($_POST['EnglishName']));
    $db->bind(":DOB", $_POST['DOB']);
    $db->bind(":Mobile", trim($_POST['Mobile']));
    $db->bind(":Email", trim($_POST['Email']));
    $db->bind(":StartDate", $_POST['StartDate']);
    $db->bind(":Education", trim($_POST['Education']));
    $db->bind(":Link", $_POST['Link']);
    if ($db->execute()) {
        echo 0;
    }
    else {
        echo "There was a connection! Please try again!";
    }
}

?>
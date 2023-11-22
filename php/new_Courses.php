<?php
require_once "functions.php";
if (isset($_POST['Name'])) {
    $db = new database();
    $Link = uniqid("Cos_", true);
    $stm = "INSERT INTO Courses SET
        Link = :Link, 
        Name = :Name, 
        Description = :Description, 
        Age = :Age, 
        Remark = :Remark
    ;";
    $db->query($stm);
    $db->bind(":Link", $Link);
    $db->bind(":Name", trim($_POST['Name']));
    $db->bind(":Description", trim($_POST['Description']));
    $db->bind(":Age", trim($_POST['Age']));
    $db->bind(":Remark", trim($_POST['Remark']));
    if ($db->execute()) {
        echo 0;
    }
    else {
        echo "There was a connection error! Please try again!";
    }
}
?>
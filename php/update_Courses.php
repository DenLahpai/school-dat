<?php
require_once "functions.php";
if (isset($_POST['Name'])) {
    $db = new database();
    $stm = "UPDATE Courses SET 
        Name = :Name, 
        Description = :Description, 
        Age = :Age, 
        Remark = :Remark WHERE Id = :Id
    ;";
    $db->query($stm);
    $db->bind(":Name", trim($_POST['Name']));
    $db->bind(":Description", trim($_POST['Description']));
    $db->bind(":Age", trim($_POST['Age']));
    $db->bind(":Remark", trim($_POST['Remark']));
    $db->bind(":Id", $_POST['Id']);
    if ($db->execute()) {
        echo 0;
    }
}
?>
<?php
require_once "functions.php";

if (isset($_POST['Link'])) {
    $db = new database();
    $stm = "UPDATE Invoices_Details SET 
        Description = :Description, 
        MMK = :MMK
        WHERE Link = :Link
    ;";
    $db->query($stm);
    $db->bind(":Description", trim($_POST['Description']));
    $db->bind(":MMK", trim($_POST['MMK']));
    $db->bind(":Link", $_POST['Link']);
    if ($db->execute()) {
        echo 0;
    }
    else {
        echo "There was a connection error! Please try agian!";
    }   
}
?>

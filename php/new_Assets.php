<?php
require_once "functions.php";

if (!empty($_POST['Name'])) {
    $db = new database();
    
    //generating a link
    $Link = uniqid("Ase_", true);

    //inseting data to the database 
    $stm = "INSERT INTO Assets SET 
        Link = :Link,
        Code = :Code,
        Type = :Type,
        Name = :Name,
        Vendor = :Vendor,
        Color = :Color,
        Add1 = :Add1,
        Add2 = :Add2,
        Qty = :Qty,
        UsersId = :UsersId
    ;";
    $db->query($stm);
    $db->bind(":Link", $Link);
    $db->bind(":Code", trim($_POST['Code']));
    $db->bind(":Type", 'Assets');
    $db->bind(":Name", trim($_POST['Name']));
    $db->bind(":Vendor", trim($_POST['Vendor']));
    $db->bind(":Color", trim($_POST['Color']));
    $db->bind(":Add1", trim($_POST['Add1']));
    $db->bind(":Add2", trim($_POST['Add2']));
    $db->bind(":Qty", $_POST['Qty']);
    $db->bind(":UsersId", $_SESSION['Id']);
    if ($db->execute()) {
        //zero is returned for no error
        echo 0;
    }
    else {
        echo $connection_error;
    }
}
?>

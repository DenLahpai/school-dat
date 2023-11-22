<?php
require_once "functions.php";
if (isset($_POST['Name'])) {
    $db = new database();

    if (!empty($_POST['Issue_Link'])) {
        //updating data to the table Issue_Toiletries
        $stm = "UPDATE Issue_Toiletries SET 
            Name = :Issue_Name WHERE
            Link = :Issue_Link
        ;";
        $db->query($stm);
        $db->bind(":Issue_Name", trim($_POST['Issue_Name']));
        $db->bind(":Issue_Link", trim($_POST['Issue_Link']));
        $db->execute();
    }

    $stm = "UPDATE Toiletries SET 
        Code = :Code,
        Name = :Name, 
        Vendor = :Vendor,
        Color = :Color,
        Add1 = :Add1, 
        Qty = :Qty, 
        UsersId = :UsersId WHERE
        Link = :Link
    ;";
    $db->query($stm);
    $db->bind(":Code", trim($_POST['Code']));
    $db->bind(":Name", trim($_POST['Name']));
    $db->bind(":Vendor", trim($_POST['Vendor']));
    $db->bind(":Color", trim($_POST['Color']));
    $db->bind(":Add1", trim($_POST['Add1']));
    $db->bind(":Qty", $_POST['Qty']);
    $db->bind(":UsersId", $_SESSION['Id']);
    $db->bind(":Link", $_POST['Link']);
    if ($db->execute()) {
        //zero is returned for no error
        echo 0;
    }
    else {
        echo $connection_error;
    }
}
?>

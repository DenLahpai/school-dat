<?php
require_once "functions.php";
if (isset($_POST['StudentsLink']) || !empty($_POST['StudentsLink'])) {
    $db = new database();
    //creating Invoices Link
    $InvoicesLink = uniqid("Inv_", true);
    //setting deadline
    $Deadline = date('Y-m-d', strtotime(" + 7 days"));
    //inserting data to the table Invoices
    $stm =  "INSERT INTO Invoices SET 
        Link = :InvoicesLink, 
        StudentsLink = :StudentsLink, 
        Deadline = :Deadline, 
        UsersId = :UsersId
    ;";
    $db->query($stm);
    $db->bind(":InvoicesLink", $InvoicesLink);
    $db->bind(":StudentsLink", $_POST['StudentsLink']);
    $db->bind(":Deadline", $Deadline);
    $db->bind(":UsersId", $_SESSION['Id']);
    if ($db->execute()) {
        //generating Invoices_Details Link
        $Link = uniqid("Inv_Dtl_", true);
        //inserting data to the table Invoices_Details
        $stm = "INSERT INTO Invoices_Details SET 
            Link = :Link, 
            InvoicesLink = :InvoicesLink, 
            Description = :Description, 
            MMK = :MMK, 
            UsersId = :UsersId
        ;";
        $db->query($stm);
        $db->bind(":Link", $Link);
        $db->bind(":InvoicesLink", $InvoicesLink);
        $db->bind(":Description", trim($_POST['Description']));
        $db->bind(":MMK", $_POST['MMK']);
        $db->bind(":UsersId", $_SESSION['Id']);
        if ($db->execute()){
            //InvoicesLink is returned for no error
            echo $InvoicesLink;     
        }
        else {
            echo 1;
            die();
        }
    }
}
else {
    echo 1;
    die();
}
?>

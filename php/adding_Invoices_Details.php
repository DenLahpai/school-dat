<?php
require_once "functions.php";
if (isset($_POST['InvoicesLink']) || !empty($_POST['InvoicesLink'])) {
    //generating Link
    $Link = uniqid("Inv_Dtl_", true);
    $db = new database();
    $stm = "INSERT INTO Invoices_Details SET 
       Link = :Link, 
       InvoicesLink = :InvoicesLink, 
       Description = :Description, 
       MMK = :MMK, 
       UsersId = :UsersId 
    ;";
    $db->query($stm);
    $db->bind(":Link", $Link);
    $db->bind(":InvoicesLink", $_POST['InvoicesLink']);
    $db->bind(":Description", trim($_POST['Description']));
    $db->bind(":MMK", $_POST['MMK']);
    $db->bind(":UsersId", $_SESSION['Id']);
    if ($db->execute()) {
        //zero is returned for no error
        echo 0;
    }
    else {
        echo "There was a connection error! Please try agian!";
    }
}
else {
    echo "There was a connection error! Please try agian!";
}
?>

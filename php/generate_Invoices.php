<?php
require_once "functions.php";

if (isset($_POST['Link']) || !empty($_POST['Link'])) {
    $db = new database();
    $InvoiceNo = generate_InvoiceNo ();
    $stm = "UPDATE Invoices SET 
        InvoiceNo = :InvoiceNo, 
        Status = :Status
        WHERE Link = :Link
    ;";
    $db->query($stm);
    $db->bind(":InvoiceNo", $InvoiceNo);
    $db->bind(":Status", '1');
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

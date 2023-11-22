<?php 
require_once "functions.php";
if (isset($_POST['table'])) {
    
    $db = new database();
    if ($_POST['table'] == "ProFormaInvoices" ) {
        $table = "Invoices";
        $stm = "SELECT * FROM $table WHERE Status = :Status ;";
        $db->query($stm);
        $db->bind(":Status", 0);
        echo $row_count = $db->row_count();
    }
    elseif ($_POST['table'] == "Invoices" ) {
        $table = "Invoices";
        $stm = "SELECT * FROM $table WHERE Status > 0 ;";
        $db->query($stm);
        echo $row_count = $db->row_count();
    } 
    else {
        $table = $_POST['table'];
        $stm = "SELECT * FROM $table ;";
        $db->query($stm);
        echo $row_count = $db->row_count();
    }
}
?>

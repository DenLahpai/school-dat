<?php
require_once "functions.php";
if (!empty($_POST['filteredItem'])) {
    $db = new database();
    $stm = "SELECT SUM(Qty) AS total FROM Inventory WHERE Code = :Code ;";
    $db->query($stm);
    $db->bind(":Code", $_POST['filteredItem']);
    $rows = $db->resultset();
    foreach ($rows as $row) {
        # code...
    }
    echo $row->total;
}
?>

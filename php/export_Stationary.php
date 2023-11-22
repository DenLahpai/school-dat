<?php
header ('Content-Type: text/csv; charset=utf-8');
header ('Content-Disposition: attachment; filename=Stationary.csv');
$output = fopen("php://output", "w");

require_once "handler.php";

$table_titles = array (
    'Code',
    'Name',
    'Vendor',
    'Color',
    'Additional',
    'Qty',
    'Entry'
);
fputcsv($output, $table_titles);

$db = new database();
$stm = "SELECT 
    Code,
    Name, 
    Vendor, 
    Color, 
    Add1, 
    Qty,
    Created
    FROM Stationary ORDER BY Created ASC
;";
$db->query($stm);
$rows = $db->resultset_array();
foreach ($rows as $row) {
    fputcsv($output, $row);
}
fclose($output);
?>

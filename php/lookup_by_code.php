<?php
require_once "functions.php";

if (!empty($_POST['code'])) {
	$db = new database();
	$col = $_POST['col'];
	$table = $_POST['table'];
	$stm = "SELECT $col FROM $table WHERE Code = :Code ;";
	$db->query($stm);
	$db->bind(":Code", trim($_POST['code']));
    $row_count = $db->row_count();
    if ($row_count < 1) {
        echo $row_count;
    }
    else {
	    $rows = $db->resultset();
	    foreach ($rows as $row) {
		    # code...
        }
	    echo $row->$col;
    }
}
?>

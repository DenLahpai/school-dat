<?php
require_once "functions.php";
$table = $_POST['table'];
$option = $_POST['option'];
$db = new database ();
$stm = "SELECT DISTINCT $option FROM $table ;";
$db->query($stm);
$rows = $db->resultset();
foreach ($rows as $row):
?>
    <option value="<?php echo $row->Link; ?>"><?php echo $row->$option; ?></option>
<?php endforeach; ?>

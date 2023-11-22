<?php 
require_once "functions.php";
if (!empty($_POST['Link'])) {
    $db = new database();
    $stm = "SELECT * FROM Stationary WHERE Issue_Link = :Issue_Link ;";
    $db->query($stm);
    $db->bind(":Issue_Link", $_POST['Link']);
    $rows_Stationary = $db->resultset();
    $i = 1;
}
?>
<!-- data-table -->
<div class="data-table">
    <table>
        <thead>
            <tr>
                <th>Sr.</th>
                <th>Item</th>
                <th>Qty</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($rows_Stationary as $row_Stationary): ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $row_Stationary->Name." ".$row_Stationary->Vendor." ".$row_Stationary->Color." ".$row_Stationary->Add1; ?></td>
                <td><?php echo $row_Stationary->Qty * -1; ?>
            </tr>
        <?php 
        $i++;
        endforeach;
        ?>
        </tbody>
    </table>
</div>
<!-- data-table ends -->
<div style="margin-top:120px; margin-left: 120px">
    Received By:
    <br><br><br><br><br><br>
    <?php
    //getting data from the table Issue_Stationary
    $stm = "SELECT * FROM Issue_Stationary WHERE Link = :Issue_Link ;";
    $db->query($stm);
    $db->bind(":Issue_Link", $_POST['Link']);
    $rows_Issue_Stationary = $db->resultset();
    foreach ($rows_Issue_Stationary as $row_Issue_Stationary) {
        echo $row_Issue_Stationary->Name;
    }
    echo "<br>".date("d-M-Y");
    ?>
</div>

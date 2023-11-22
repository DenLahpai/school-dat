<?php
require_once "functions.php";
if (isset($_POST['StudentsLink']) || !empty($_POST['StudentsLink'])) {
    //getting data from the table Invoices
    $db = new database ();
    $stm = "SELECT * FROM Invoices WHERE StudentsLink = :StudentsLink ;";
    $db->query($stm);
    $db->bind(":StudentsLink", $_POST['StudentsLink']);
    $rows_Invoices = $db->resultset();
}
?>
<div class="data-table">
    <table>
        <thead>
            <tr>
                <th>Invoice No</th>
                <th>Deadline</th>
                <th>MMK</th>
                <th>Status</th>
                <th>###</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($rows_Invoices as $row_Invoices): ?>
            <tr>
                <td><?php echo $row_Invoices->InvoiceNo; ?></td>
                <td><?php echo date('d-M-Y', strtotime($row_Invoices->Deadline)); ?></td>
                <td>
                <?php
                //getting sum of MMK for an invoice
                $stm = "SELECT SUM(MMK) as total FROM Invoices_Details 
                    WHERE InvoicesLink = :InvoicesLink
                ;";
                $db->query($stm);
                $db->bind(":InvoicesLink", $row_Invoices->Link);
                $rows_sum = $db->resultset();
                foreach ($rows_sum as $row_sum) {
                    echo $row_sum->total;
                }
                ?>
                </td>
                <td>
                <?php
                //getting data from the table Invoices_Status
                $stm = "SELECT * FROM Invoices_Status WHERE Code = :Code ;";
                $db->query($stm);
                $db->bind(":Code", $row_Invoices->Status);
                $rows_Invoices_Status = $db->resultset();
                foreach ($rows_Invoices_Status as $row_Invoices_Status) {
                    if ($row_Invoices->Status == 0) {
                        echo "<span style='color: red;'>".$row_Invoices_Status->Description."</span>";
                    }
                    else {
                        echo "<span style='color: blue;'>".$row_Invoices_Status->Description."</span>";
                    }
                }
                ?>
                </td>
                <td>
                    <a href="">
                        <button type="button" class="medium-button">View</button></a>
                    <a href="">
                        <button type="button" class="medium-button">Edit</button></a>
                </td>
            </tr>
        <?php endforeach; ?>
            <tr>
                <td colspan="5" style="text-align: center;">
                    <a href="new_Students_Pro_Forma_Invoices.html?StudentsLink=<?php echo $_POST['StudentsLink']; ?>">Create a new Pro Forma Invoice</a>
                </td>
            </tr>
            <tr>
                <th colspan="5">
                    Click on the "Edit" to finalize and a pro forma invoice.
                </th>
            </tr>
        </tbody>
    </table>
</div>

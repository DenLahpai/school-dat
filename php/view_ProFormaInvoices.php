<?php
require_once "functions.php";
if (isset($_POST['Link']) || !empty($_POST['Link'])) {
    $db = new database();
    //getting data from the table Invoices
    $stm = "SELECT * FROM Invoices WHERE Link = :Link ;";
    $db->query($stm);
    $db->bind(":Link", $_POST['Link']);
    $rows_Invoices = $db->resultset();
    foreach ($rows_Invoices as $row_Invoices) {
        #code...
    }
}
?>
<!-- invoice-head -->
<div class="invoice-head">
    <!-- data-table -->
    <div class="data-table">
        <table>
            <thead></thead>
            <tbody>
                <tr>
                    <td>
                        <span style="font-weight: bold;">Bill To:</span>
                        <?php
                        //getting data from the table Students
                        $stm = "SELECT * FROM Students WHERE Link = :StudentsLink ;";
                        $db->query($stm);
                        $db->bind(":StudentsLink", $row_Invoices->StudentsLink); 
                        $rows_Students = $db->resultset();
                        foreach ($rows_Students as $row_Students) {
                            echo $row_Students->Name.' @ '.$row_Students->EnglishName; 
                        }
                        ?>
                    </td>
                    <td>
                        <span style="font-weight: bold;">Due Date:</span>
                        <?php echo date('d-M-Y', strtotime($row_Invoices->Deadline)); ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- data-table ends -->
</div>
<!-- invoice-head ends -->
<!-- invoice-body -->
<div class="invoice-body">
    <!-- data-table -->
    <div class="data-table">
        <table>
            <thead>
                <tr>
                   <th>Description</th>
                   <th>Amount in MMK</th>
                   <th>######</th>
                </tr>
            </thead>
            <tbody>
            <?php
            //getting data from the table Invoices_Details
            $stm = "SELECT * FROM Invoices_Details WHERE InvoicesLink = :InvoicesLink ;";
            $db->query($stm);
            $db->bind(":InvoicesLink", $row_Invoices->Link);
            $rows_Invoices_Details = $db->resultset();
            foreach ($rows_Invoices_Details as $row_Invoices_Details):
            ?>
                <tr>
                    <td>
                        <?php echo $row_Invoices_Details->Description; ?>
                    </td>
                    <td>
                        <?php echo $row_Invoices_Details->MMK; ?>
                    </td>
                    <td>
                        <button type="button" class="medium-button" onclick="getInvoicesDetailsModal('<?php echo $row_Invoices_Details->Link; ?>');">Edit</button>
                    </td>
                </tr>
            <?php endforeach; ?>
                <tr>
                    <td colspan="3" style="text-align: center">
                        <div style="text-decoration: underline; color: blue; display: inline; cursor: pointer;" onclick="getNewInvoicesDetailsModal('<?php echo $_POST['Link'];?>');">
                            Add a line
                        </div> 
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: center">
                        <button type="button" class="medium-button" onclick="generateInvoice('<?php echo $_POST['Link']; ?>');">Generate Invoice</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- data-table ends -->
</div>
<!-- invoice-body ends -->

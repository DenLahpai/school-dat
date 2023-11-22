<?php
require_once "functions.php";
if (isset($_POST['Link']) || !empty($_POST['Link'])) {
    //getting data from the table Invoices
    $db = new database();
    $stm = "SELECT * FROM Invoices WHERE Link = :Link ;";
    $db->query($stm);
    $db->bind(":Link", $_POST['Link']);
    $rows_Invoices = $db->resultset();
    foreach ($rows_Invoices as $row_Invoices) {
        #code...
    }
     
}
?>
<!-- print-invoice -->
<div class="print-invoice">
    <!-- print-invoice-header -->
    <div class="print-invoice-header">
        <!-- invoice-logo -->
        <div class="invoice-logo">
            <img src="./Images/logo.jpg">
            <br>
            <h1>Green Hills Academy</h1>
        </div>
        <!-- invoice-logo ends -->
        <!-- invoice-address -->
        <div class="invoice-address">
           No.55, Shinsawpu Road, Sanchaung Township, Yangon 
        </div>
        <!-- invoice-address ends -->
    </div>
    <!-- print-invoice-header ends -->
    <!-- print-invoice-body -->
    <div class="print-invoice-body">
        <!-- print-inovice-body-title -->
        <div class="print-invoice-body-title">
            <h1>INVOICE</h1>
        </div>
        <!-- print-invoice-body-title ends -->
        <!-- print-invoice-body-table-head -->
        <div class="print-invoice-body-head-table">
            <table>
                <thead><thead>
                <tbody>
                    <tr>
                        <td>
                            <span style="font-weight: bold;">Bill To:</span>
                            <?php
                            //getting data from the tabke Students
                            $stm = "SELECT * FROM Students WHERE Link = :Link ;";
                            $db->query($stm);
                            $db->bind(":Link", $row_Invoices->StudentsLink);
                            $rows_Students = $db->resultset();
                            foreach ($rows_Students as $row_Students) {
                                #code...
                            }
                            echo $row_Students->Name.' @ '.$row_Students->EnglishName; 
                            ?>
                        </td>
                        <td>
                            <span style="font-weight: bold;">Date:</span>
                            <?php echo date("d-M-Y"); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span style="font-weight: bold;">Contact:</span>
                            <?php 
                            //getting data from the ParentsLink
                            $stm = "SELECT * FROM Students_Parents WHERE StudentsLink = :StudentsLink ;";
                            $db->query($stm);
                            $db->bind(":StudentsLink", $row_Invoices->StudentsLink);
                            $rows_Students_Parents = $db->resultset();
                            foreach ($rows_Students_Parents as $row_Students_Parents) {
                                #code...
                            }
                            //getting data from the table Parents
                            $stm = "SELECT * FROM Parents WHERE Link = :ParentsLink ;";
                            $db->query($stm);
                            $db->bind(":ParentsLink", $row_Students_Parents->ParentsLink);
                            $rows_Parents = $db->resultset();
                            foreach ($rows_Parents as $row_Parents) {
                                #code...
                            }
                            echo $row_Parents->Name.' | '.$row_Parents->Mobile;
                            ?> 
                        </td>
                        <td>
                            <span style="font-weight: bold;">Due Date</span>
                            <?php echo date('d-M-Y', strtotime('+ 7 days')); ?> 
                        </td>
                    </tr>
                </tbody>
            </table>            
        </div>
        <!-- print-invoice-body-table-head ends -->
        <!-- print-invoice-body-table -->
        <div class="print-invoice-body-table">
            <table>
                <thead>
                    <tr>
                        <td>###</td>
                        <td>Description</td>
                        <td>Amount in MMK</td>
                    </tr>
                </thead>
                <tbody>
                <?php
                //getting data from the table Invoices_Details
                $stm = "SELECT * FROM Invoices_Details WHERE InvoicesLink = :InvoicesLink ;";
                $db->query($stm);
                $db->bind(":InvoicesLink", $_POST['Link']);
                $rows_Invoices_Details = $db->resultset();
                $i = 1;
                foreach ($rows_Invoices_Details as $row_Invoices_Details):
                ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $row_Invoices_Details->Description; ?></td>
                        <td><?php echo $row_Invoices_Details->MMK; ?></td>
                    </tr>
                <?php
                $i++; 
                endforeach; 
                ?>
                <tr>
                    <td colspan="2" style="font-weight: bold; text-align: center;">
                        Total
                    </td>
                    <td style="font-weight: bold;">
                    <?php
                    //getting total SUM of invoice
                    $stm = "SELECT SUM(MMK) AS total FROM Invoices_Details  
                        WHERE InvoicesLink = :InvoicesLink 
                    ;";
                    $db->query($stm);
                    $db->bind(":InvoicesLink", $_POST['Link']);
                    $rows_sum = $db->resultset();
                    foreach ($rows_sum as $row_sum) {
                        #code...
                    }
                    echo $row_sum->total;
                    ?>
                    </td>
                </tr>
                </tbody>
            </table>
            <div style="padding-left: 36px;";>
                Amount in MMK: 
                <?php echo ucwords(convert_number_to_words ($row_sum->total)); ?>
                Only!
            </div>
        </div>
        <!-- print-invoice-body-table-body ends -->
    </div>
    <!-- print-inovoice-body ends -->
</div>
<!-- print-invoice ends -->

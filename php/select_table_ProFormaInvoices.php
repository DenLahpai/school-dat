<?php
require_once "functions.php";

if (empty($_POST['order'])) {
    $order = "ORDER BY Created DESC";
}
else {
    $order = $_POST['order'];
}

if (empty($_POST['limit'])) {
    $limit = 10;
}
else {
    $limit = $_POST['limit'];
}

if (empty($_POST['page'])) {
    $page = 1;
}
else {
    $page = $_POST['page'];
}

$offset = ($page * $limit) - $limit;

//getting data from the table Invoices
$db = new database ();
$stm = "SELECT 
    Invoices.InvoiceNo, 
    Invoices.Link, 
    Invoices.StudentsLink, 
    Invoices.Deadline, 
    Invoices.Received_by,
    Invoices.Status FROM Invoices 
    WHERE Invoices.Status = :Status
    $order LIMIT $limit OFFSET $offset
;";
$db->query($stm);
$db->bind(":Status", "0");
$rows_Invoices = $db->resultset();
?>
<!-- data-table -->
<div class="data-table">
    <table>
        <thead>
            <tr>
                <th>Sr.</th>
                <th>Addressee</th>
                <th>Deadline</th>
                <th>Status</th>
                <th>######</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            foreach ($rows_Invoices as $row_Invoices):
            ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td>
                <?php
                //getting data from the table Students
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
                <?php
                $today = date("d-M-Y");
                if ($today < $row_Invoices->Deadline) {
                    echo "<span style='color: red;'>".date("d-M-Y", strtotime($row_Invoices->Deadline))."</span>";
                }
                else {
                    echo date("d-M-Y", strtotime($row_Invoices->Deadline));
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
                    #code...
                }
                echo $row_Invoices_Status->Description;
                ?>
                </td>
                <td>
                    <a href="view_ProFormaInvoices.html?Link=<?php echo $row_Invoices->Link; ?>">
                        <button type="button" class="medium-button">View</button></a>
                </td>
            </tr>
            <?php 
            $i++;
            endforeach;
            ?>
        </tbody>
    </table>
</div>
<!-- data-table ends -->

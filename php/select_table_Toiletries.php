<?php
require_once "functions.php";

//getting data from the table Toiletries
$db = new database();

if (!isset($_POST['filter'])):
    $stm = "SELECT * FROM Toiletries WHERE Type = :Type ORDER BY Updated DESC ;";
    $db->query($stm);
    $db->bind(":Type", "Toiletries");
    
else:
    $col = $_POST['col'];
    $stm = "SELECT * FROM Toiletries WHERE Type = :Type AND $col = :Filter ORDER BY Updated DESC ;";
    $db->query($stm);
    $db->bind(":Type", "Toiletries");
    $db->bind(":Filter", $_POST['filter']);
    
endif;
$rows_Toiletries = $db->resultset();
?>
<!-- data-table -->
<div class="data-table">
    <table>
        <thead>
            <tr>
                <th>Sr.</th>
                <th>Code</th>
                <th>Name</th>
                <th>Color</th>
                <th>Additional</th>
                <th>Vendor</th>
                <th>Qty</th>
                <th>Issued to</th>
                <th>Entry</th>
                <th>######</td>
            </tr>
        </thead>
        <tbody>
        <?php
        $i = 1;
        foreach ($rows_Toiletries as $row_Toiletries):
        ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $row_Toiletries->Code; ?></td>
                <td><?php echo $row_Toiletries->Name; ?></td>
                <td><?php echo $row_Toiletries->Color; ?></td>
                <td><?php echo $row_Toiletries->Add1; ?></td>
                <td><?php echo $row_Toiletries->Vendor; ?></td>
                <td>
                <?php 
                if ($row_Toiletries->Qty >= 1) {
                    echo $row_Toiletries->Qty;
                }
                else {
                    echo "<span style='color: red;'>".$row_Toiletries->Qty."</span>";
                }
                ?>
                </td>
                <td>
                <?php 
                if (!empty($row_Toiletries->Issue_Link)) {
                    //getting data from the table Issue_Toiletries
                    $stm = "SELECT * FROM Issue_Toiletries WHERE Link = :Link ;";
                    $db->query($stm);
                    $db->bind(":Link", $row_Toiletries->Issue_Link);
                    $rows = $db->resultset();
                    foreach ($rows as $row) {
                        # code...
                    }
                    echo $row->Name;
                }                
                ?>
                </td>
                <td><?php echo $row_Toiletries->Created; ?></td>
                <td>
                    <a href="edit_Toiletries.html?Link=<?php echo $row_Toiletries->Link; ?>">Edit</a>
                </td>
            </tr>
        <?php
        $i++;
        endforeach; 
        ?>
        <tr>
            <?php
            if (!empty($_POST['col'])):
                $stm = "SELECT SUM(Qty) as total from Toiletries WHERE Code = :filter ;";
                $db->query($stm);
                $db->bind(":filter", $_POST['filter']);
                $rows_sum = $db->resultset();
                foreach ($rows_sum as $row_sum) {
                    #code
                }
            ?>
            <td colspan="6" style="font-weight: bold; font-size: 1.2em; text-align: right;">Total:</td>
            <td colspan="4">
            <?php
                echo $row_sum->total;
                endif;
            ?>
            </td>
        </tr>
        </tbody>
    </table>
</div>
<!-- data-table ends -->


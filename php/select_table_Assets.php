<?php
require_once "functions.php";

//getting data from the table Assets
$db = new database();

if (!isset($_POST['filter'])):
    $stm = "SELECT * FROM Assets WHERE Type = :Type ORDER BY Updated DESC ;";
    $db->query($stm);
    $db->bind(":Type", "Assets");
    
else:
    $col = $_POST['col'];
    $stm = "SELECT * FROM Assets WHERE Type = :Type AND $col = :Filter ORDER BY Updated DESC ;";
    $db->query($stm);
    $db->bind(":Type", "Assets");
    $db->bind(":Filter", $_POST['filter']);
    
endif;
$rows_Assets = $db->resultset();
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
                <th>Condition</th>
                <th>Qty</th>
                <th>Entry</th>
                <th>######</td>
            </tr>
        </thead>
        <tbody>
        <?php
        $i = 1;
        foreach ($rows_Assets as $row_Assets):
        ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $row_Assets->Code; ?></td>
                <td><?php echo $row_Assets->Name; ?></td>
                <td><?php echo $row_Assets->Color; ?></td>
                <td><?php echo $row_Assets->Add1; ?></td>
                <td><?php echo $row_Assets->Vendor; ?></td>
                <td><?php echo $row_Assets->Add2; ?></td>
                <td>
                <?php 
                if ($row_Assets->Qty >= 1) {
                    echo $row_Assets->Qty;
                }
                else {
                    echo "<span style='color: red;'>".$row_Assets->Qty."</span>";
                }
                ?>
                </td>
                <!--
                <td>
                <?php 
                /*if (!empty($row_Assets->Issue_Link)) {
                    //getting data from the table Issue_Stationary
                    $stm = "SELECT * FROM Issue_Assets WHERE Link = :Link ;";
                    $db->query($stm);
                    $db->bind(":Link", $row_Assets->Issue_Link);
                    $rows = $db->resultset();
                    foreach ($rows as $row) {
                        # code...
                    }
                    echo $row->Name;
                } */               
                ?>
                </td> -->
                <td><?php echo $row_Assets->Created; ?></td>
                <td>
                    <a href="edit_Assets.html?Link=<?php echo $row_Assets->Link; ?>">Edit</a>
                </td>
            </tr>
        <?php
        $i++;
        endforeach; 
        ?>
        <tr>
            <?php
            if (!empty($_POST['col'])):
                $stm = "SELECT SUM(Qty) as total from Assets WHERE Code = :filter ;";
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


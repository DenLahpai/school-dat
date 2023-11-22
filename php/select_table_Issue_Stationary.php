<?php
require_once "functions.php";

$db = new database();
$stm = "SELECT * FROM Issue_Stationary ORDER BY Created DESC ;";
$db->query($stm);
$rows_Issue_Stationary = $db->resultset();
?>
<!-- data-table -->
<div class="data-table">
    <table>
        <thead>
            <tr>
                <th>Sr.</th>
                <th>Name</th>
                <th>Date/Time</th>
                <th>###</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $i = 1;
            foreach ($rows_Issue_Stationary as $row_Issue_Stationary): 
            ?>
            <tr>
                <td><?php echo $i; ?>
                <td><?php echo $row_Issue_Stationary->Name; ?></td>
                <td><?php echo date("d-M-Y H:i", strtotime($row_Issue_Stationary->Created)); ?></td>
                <td>
                    <a href="view_one_Issue_Stationary.html?Link=<?php echo $row_Issue_Stationary->Link; ?>">View</a>
                    &nbsp;
                    <a href="edit_one_Issue_Stationary.html?Link=<?php echo $row_Issue_Stationary->Link; ?>">Edit</a>
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

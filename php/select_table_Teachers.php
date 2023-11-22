<?php
require_once "functions.php";

if (empty ($_POST['order'])) {
    $order = "ORDER BY Updated DESC";
}
else {
    $order = $_POST['order'];
}

if (empty ($_POST['limit'])) {
    $limit = 30;
}
else {
    $limit = $_POST['limit'];
}

if (empty ($_POST['page'])) {
    $page = 1;
}
else {
    $page = $_POST['page'];
}

$offset = ($page * $limit) - $limit;

//getting data from the table Students
$db = new database();
$stm = "SELECT * FROM Teachers WHERE
    BranchesId = :BranchesId
    $order LIMIT $limit OFFSET $offset 
;";
$db->query($stm);
$db->bind(":BranchesId", $_SESSION['BranchesId']);
$rows_Teachers = $db->resultset();
?>
<!-- data-table  -->
<div class="data-table">
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Name</th>
                <th>English Name</th>
                <th>DOB</th>
                <th>Mobile</th>
                <th>Email</th>
                <th>Start Date</th>
                <th>######</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($rows_Teachers as $row_Teachers):?>
            <tr>
                <td><?php echo $row_Teachers->Title; ?></td>
                <td><?php echo $row_Teachers->Name; ?></td>
                <td><?php echo $row_Teachers->EnglishName; ?></td>
                <td><?php echo date("d-M-Y", strtotime($row_Teachers->DOB)); ?></td>
                <td><?php echo $row_Teachers->Mobile; ?></td>
                <td>
                    <?php if (!empty($row_Teachers->Email)):?>
                    <a href="mailto: <?php echo $row_Teachers->Eamil?>"><?php echo $row_Teachers->Email; ?></a>
                    <?php endif; ?>
                </td>
                <td><?php echo date("d-M-Y", strtotime($row_Teachers->StartDate)); ?></td>
                <td>
                    <a href="view_Teachers.html?Link=<?php echo $row_Teachers->Link; ?>">
                        <button type="button" class="medium-button">View</button></a>
                    <a href="edit_Teachers.html?Link=<?php echo $row_Teachers->Link; ?>">
                        <button type="button" class="medium-button">Edit</button></a>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
</div>
<!-- data-table ends -->
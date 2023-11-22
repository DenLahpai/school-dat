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
$search = '%'.$_POST['search'].'%';

//getting data from the table Students
$db = new database();
$stm = "SELECT * FROM Students WHERE
    BranchesId = :BranchesId AND
    CONCAT(
        AdmissionNo,
        Name,
        EnglishName
    ) LIKE :search $order LIMIT $limit OFFSET $offset
;";
$db->query($stm);
$db->bind(":BranchesId", $_SESSION['BranchesId']);
$db->bind(":search", $search);
$rows_Students = $db->resultset();
?>
<!-- data-table  -->
<div class="data-table">
    <table>
        <thead>
            <tr>
                <th>Sr.</th>
                <th>Name</th>
                <th>Gender</th>
                <th>English Name</th>
                <th>D.O.B</th>
                <th>Township</th>
                <th>Admission No</th>
                <th>Admission Date</th>
                <th>######</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $i = 1;
            foreach ($rows_Students as $row_Students): 
            ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $row_Students->Name; ?></td>
                <td style="text-align: center;"><?php echo $row_Students->Gender; ?></td>
                <td><?php echo $row_Students->EnglishName; ?></td>  
                <td><?php echo date("d-M-y", strtotime($row_Students->DOB)); ?></td>
                <td><?php echo $row_Students->Township; ?></td>
                <td><?php echo $row_Students->AdmissionNo; ?></td>
                <td><?php echo date("d-M-y", strtotime($row_Students->AdmissionDate)); ?></td>
                <td>
                    <a href="view_Students.html?Link=<?php echo $row_Students->Link; ?>">
                        <button type="button" class="medium-button">View</button></a>
                    &nbsp; 
                    <a href="edit_Students.html?Link=<?php echo $row_Students->Link; ?>">
                        <button type="button" class="medium-button">Edit</button></a>
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
<?php
require_once "functions.php";
if (empty ($_POST['order'])) {
    $order = "ORDER BY Classes.Updated DESC";
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

//getting data from the table Classes
$db = new database();
$stm = "SELECT 
    Courses.Name as CoursesName, 
    Classes.Name as ClassesName, 
    Classes.Link as Link,
    Classes.Room, 
    Classes.StartDate, 
    Classes.EndDate, 
    Classes.Registration,
    Classes.Monthly
    FROM Classes LEFT OUTER JOIN Courses
    ON Courses.Link = Classes.CoursesLink 
    WHERE Classes.BranchesId = :BranchesId
    $order LIMIT $limit OFFSET $offset
;";
$db->query($stm);
$db->bind(":BranchesId", $_SESSION['BranchesId']);
$rows_Classes = $db->resultset();
?>
<!-- data-table -->
<div class="data-table">
    <table>
        <thead>
            <tr>
                <th>Course</th>
                <th>Class Name</th>
                <th>Room Name</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Registration Fees</th>
                <th>Montly Fees</th>
                <th>######</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($rows_Classes as $row_Classes):?>
            <tr>
                <td><?php echo $row_Classes->CoursesName; ?></td>
                <td><?php echo $row_Classes->ClassesName; ?></td>
                <td><?php echo $row_Classes->Room; ?></td>
                <td><?php echo date("d-M-Y", strtotime($row_Classes->StartDate)); ?></td>
                <td><?php echo date("d-M-Y", strtotime($row_Classes->EndDate)); ?></td>
                <td><?php echo $row_Classes->Registration; ?></td>
                <td><?php echo $row_Classes->Monthly; ?></td>
                <td>
                    <a href="view_Classes.html?Link=<?php echo $row_Classes->Link;?>">
                    <button type="button" class="medium-button">View</button></a>
                    <a href="edit_Classes.html?Link=<?php echo $row_Classes->Link; ?>">
                    <button type="button" class="medium-button">Edit</button></a>
                </td>
            </tr>    
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<!-- data-table ends -->
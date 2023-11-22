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

//getting data from the table Courses
$db = new database ();
$stm = "SELECT * FROM Courses $order LIMIT $limit OFFSET $offset ;";
$db->query($stm);
$rows_Courses = $db->resultset();
?>
<!-- data-table -->
<div class="data-table">
    <table>
        <thead>
            <tr>
                <th>Course</th>
                <th>Description</th>
                <th>Age</th>
                <th>Remark</th>
                <th>######</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($rows_Courses as $row_Courses): ?>
            <tr>
                <td>
                    <?php echo $row_Courses->Name; ?>
                </td>
                <td>
                    <?php echo $row_Courses->Description; ?>
                </td>
                <td>
                    <?php echo $row_Courses->Age; ?>
                </td>
                <td>
                    <?php echo $row_Courses->Remark; ?>
                </td>
                <td>
                    <a href="edit_Courses.html?CoursesId=<?php echo $row_Courses->Id; ?>">
                        <button type="button" class="medium-button">Edit</button>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<!-- data-table ends -->
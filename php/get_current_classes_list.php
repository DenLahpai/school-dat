<?php
require_once "functions.php";
//getting students List

$db = new database();
$stm = "SELECT
    Classes.Link, 
    Classes.Name, 
    Classes.Room, 
    Classes.StartDate, 
    Classes.EndDate,
    Courses.Name AS CoursesName
    FROM Classes LEFT OUTER JOIN Courses
    ON Classes.CoursesLink = Courses.Link
    WHERE Classes.StartDate > CURDATE()
    AND Classes.BranchesId = :BranchesId   
;";
$db->query($stm);
$db->bind(":BranchesId", $_SESSION['BranchesId']);
$rows_Classes = $db->resultset();
foreach ($rows_Classes as $row_Classes):
?>
<option value="<?php echo $row_Classes->Link; ?>">
    <?php echo $row_Classes->CoursesName.' - '.$row_Classes->Name;?>
    <?php echo "(".date("M-y", strtotime($row_Classes->StartDate))." - ". date("M-y", strtotime($row_Classes->EndDate)).")"; ?>
</option>
<?php endforeach; ?>
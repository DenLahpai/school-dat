<?php
require_once "functions.php";
if (isset($_POST['TeachersLink']) || !empty($_POST['TeachersLink'])) {
    //gettingd data from the table Students_Classes
    $db = new database ();
    $stm = "SELECT * FROM Teachers_Classes WHERE TeachersLink = :TeachersLink ;";
    $db->query($stm);
    $db->bind(":TeachersLink", $_POST['TeachersLink']);
    $rows_Teachers_Classes = $db->resultset();
}
?>
<ul>
<?php foreach ($rows_Teachers_Classes as $row_Teachers_Classes): ?>
<?php
//getting data from the table Classes
$stm = "SELECT 
    Classes.Name, 
    Classes.StartDate, 
    Classes.EndDate, 
    Classes.Registration, 
    Classes.Monthly, 
    Courses.Name AS CoursesName,
    Courses.Description, 
    Courses.Age, 
    Courses.Remark
    FROM Classes LEFT OUTER JOIN Courses 
    ON Classes.CoursesLink = Courses.Link 
    WHERE Classes.Link = :ClassesLink
    AND Classes.BranchesId = :BranchesId
;";
$db->query($stm);
$db->bind(":ClassesLink", $row_Teachers_Classes->ClassesLink);
$db->bind(":BranchesId", $_SESSION['BranchesId']);
$rows_Classes = $db->resultset();
foreach ($rows_Classes as $row_Classes) {
    #code...
}  
?>
    <li>
        <?php echo $row_Classes->CoursesName.' - '.$row_Classes->Name; ?>
        &nbsp;
        <?php echo "[".date("M-Y", strtotime($row_Classes->StartDate)); ?>
        <?php echo " - ".date("M-Y", strtotime($row_Classes->EndDate))."]"; ?>
    </li>
<?php endforeach; ?>
</ul>
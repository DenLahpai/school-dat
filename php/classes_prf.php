<?php
require_once "functions.php";
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
    ON Courses.Link = Classes.CoursesLink WHERE
    Classes.Link = :Link
;";
$db->query($stm);
$db->bind(":Link", $_POST['Link']);
$rows_Classes = $db->resultset();
foreach ($rows_Classes as $row_Classes) {
    #code...
}
?>
<!-- class-wrap -->
<div class="class-wrap">
    <!-- class-title -->
    <div class="class-title">
        <input type="hidden" id="ClassesLink" name="ClassesLink" value="<?php echo $_POST['Link']; ?>">
        <h3><?php echo $row_Classes->CoursesName.": ".$row_Classes->ClassesName; ?></h3>
        <p>
            <?php 
                echo "(From: ".date("d-M-Y", strtotime($row_Classes->StartDate)); 
                echo " Until: ".date("d-M-Y", strtotime($row_Classes->EndDate)).")";
            ?>
        </p>
    </div>
    <!-- class-title ends -->
    <!-- class-body -->
    <div class="class-body">
        <!-- class-teacher -->
        <div class="class-teacher">
            <h3>Teacher</h3>
            <div>
                <select name="TeachersLink" id="TeachersLink" style="display: none;">
                    <option value="">Please Select</option>
                <?php
                //getting data from the table Teachers
                $stm = "SELECT * FROM Teachers WHERE BranchesId = :BranchesId 
                    ORDER BY Created ASC 
                ;";
                $db->query($stm);
                $db->bind(":BranchesId", $_SESSION['BranchesId']);
                $rows_Teachers = $db->resultset();
                foreach ($rows_Teachers as $row_Teachers):
                ?>
                    <option value="<?php echo $row_Teachers->Link;?>"><?php echo $row_Teachers->Name." - ".$row_Teachers->EnglishName; ?></option>
                <?php endforeach; ?>
                </select>
            </div>
            <div>
                <?php
                //checking if there is a teacher assigned
                $stm = "SELECT * FROM Teachers_Classes 
                    WHERE ClassesLink = :ClassesLink
                    ORDER BY Created ASC 
                ;";
                $db->query($stm);
                $db->bind(":ClassesLink", $_POST['Link']);
                $row_count = $db->row_count();
                $rows_Teachers_Classes = $db->resultset();
                foreach ($rows_Teachers_Classes as $row_Teachers_Classes) {
                    #code...
                }
                if ($row_count == 0) {
                    echo "<div class='teachers-cmd'>Assign a Teacher</div>";
                }
                else {
                    //getting data from the table Teachers
                    $stm = "SELECT * FROM Teachers WHERE Link = :Link ;";
                    $db->query($stm);
                    $db->bind(":Link", $row_Teachers_Classes->TeachersLink);
                    $rows = $db->resultset();
                    foreach ($rows as $row) {
                        #code...
                    }
                    echo $row->Name." - ".$row->EnglishName."<br><br>";
                    echo "<div class='teachers-cmd'>Change Teacher</div>";
                }
                ?>
            </div>
        </div>
        <!-- class-teacher -->
        <!-- <div class="sys_msg"></div> -->
    </div>
    <!-- class-body ends -->
</div>
<!-- class-wrap ends -->
<script type="text/javascript">
$(".teachers-cmd").on("click", function () {
    Toggle("#TeachersLink");
});

$("#TeachersLink").on("change", function () {
    var TeachersLink = $("#TeachersLink").val();
    $.post("./php/assign_teacher.php", {
        ClassesLink: $("#ClassesLink").val(), 
        TeachersLink: $("#TeachersLink").val()
    },function (data) {
        if (data == 0) {
            location.reload();
        }
    });
});
</script>
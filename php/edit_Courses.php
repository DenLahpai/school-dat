<?php
require_once "functions.php";
if (isset($_POST['CoursesId'])) {
    //getting data from the table Courses
    $db = new database();
    $stm = "SELECT * FROM Courses WHERE Id = :Id ;";
    $db->query($stm);
    $db->bind(":Id", $_POST['CoursesId']);
    $rows_Courses = $db->resultset();
    foreach ($rows_Courses as $row_Courses) {
        #code...
    }
}
?>
<!-- form-wrap -->
<div class="form-wrap">
    <form action="#" id="myForm" method="post">
        <div>
            Course Name: <br>
            <input type="hidden" name="Id" id="Id" value="<?php echo $_POST['CoursesId']; ?>" readonly>
            <input type="text" name="Name" id="Name" value="<?php echo $row_Courses->Name; ?>">
        </div>
        <div>
            Description: <br>
            <input type="text" name="Description" id="Description" value="<?php echo $row_Courses->Description; ?>">
        </div>
        <div>
            Age Range: <br>
            <input type="text" name="Age" id="Age" value="<?php echo $row_Courses->Age; ?>">
        </div>
        <div>
            Remark: <br>
            <input type="text" name="Remark" id="Remark" value="<?php echo $row_Courses->Remark; ?> ">
        </div>
        <div>
            <button type="submit" class="medium-button">Update</button>
        </div>
    </form>
    <div class="sys_msg"></div>
</div>
<!-- form-wrap ends -->
<script type="text/javascript">
$("#myForm").submit(function () {
    event.preventDefault();
    var error = false;
    var Name = $("#Name");
    var Age = $("#Age");

    if (Name.val() == "" || Name.val() == " " || Name.val == null) {
        error = true;
        Name.addClass("input-error");
    }

    if (Age.val() == "" || Age.val() == " " || Age.val == null) {
        error = true;
        Age.addClass("input-error");
    }

    if (error == true) {
        $(".sys_msg").addClass("error-msg");
        $(".sys_msg").html("Please fill out all the field(s) in red!");
    }

    if (error == false) {
        $.ajax({
            url: "./php/update_Courses.php",
            type: "POST", 
            data: $(this).serialize(), 
            success: function (data) {
                if (data == 0) {
                    location.href = 'Courses.html';
                }
                else {
                    $(".sys_msg").addClass("error");
                    $(".sys_msg").html(data);
                }
            }
        });
    }
});
</script>
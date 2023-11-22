<?php
require_once "functions.php";
if (isset($_POST['Link'])) {
    
    //getting data from the table
    $db = new database();
    $stm = "SELECT * FROM Students WHERE Link = :Link ;";
    $db->query($stm);
    $db->bind(":Link", $_POST['Link']);
    $rows_Students = $db->resultset();
    foreach ($rows_Students as $row_Students) {
        # code...
    }
}
else {
    echo "There was a connection error!";
}
?>
<!-- form-wrap -->
<div class="form-wrap">
    <form action="#" id="myForm" method="post">
        <div>
            <?php if ($row_Students->Gender == "M"): ?>
                Gender: &nbsp;  
                <input type="radio" id="Male" name="Gender" value="M" checked="checked">
                <label for="Male">M</label>
                <input type="radio" id="Female" name="Gender" value="F">
                <label for="Female">F</label>
            <?php else: ?>
                Gender: &nbsp;
                <input type="radio" id="Male" name="Gender" value="M">
                <label for="Male">M</label>
                &nbsp;
                <input type="radio" id="Female" name="Gender" value="F" checked="checked">
                <label for="Female">F</label>
            <?php endif; ?>
            <input type="hidden" id="Link" Name="Link" value="<?php echo $_POST["Link"]; ?>">
        </div>
        <div>
            <input type="text" id="Name" name="Name" value="<?php echo $row_Students->Name; ?>">
        </div>
        <div>
            <input type="text" id="EnglishName" name="EnglishName" value="<?php echo $row_Students->EnglishName; ?>">
        </div>
        <div>
            Admission Date: <br>
            <input type="date" id="AdmissionDate" name="AdmissionDate" value="<?php echo $row_Students->AdmissionDate;?>">
        </div>
        <div>
            Admisson No: <br>
            <input type="text" id="AdmissionNo" name="AdmissionNo" value="<?php echo $row_Students->AdmissionNo; ?>">
        </div>
        <div>
            MOE Admission No: <br>
            <input type="text" id="MOE" name="MOE" value="<?php echo $row_Students->MOE;?>">
        </div>
        <div>
            Name of Previous School: <br>
            <input type="text" id="PreviousSchoolName" name="PreviousSchoolName" value="<?php echo $row_Students->PreviousSchoolName; ?>">
        </div>
        <div>
            Previous School's Township: <br>
            <input type="text" id="PreviousSchoolTownship" name="PreviousSchoolTownship" value="<?php echo $row_Students->PreviousSchoolTownship; ?>">
        </div>
        <div>
            Grade at Previous School: <br>
            <input type="text" id="PreviousGrade" name="PreviousGrade" value="<?php echo $row_Students->PreviousGrade; ?>">
        </div>
        <div>
            Date of Birth: <br>
            <input type="date" id="DOB" name="DOB" value="<?php echo $row_Students->DOB; ?>">
        </div>
        <div>
            Place of Birth: <br>
            <input type="text" id="PlaceOfBirth" name="PlaceOfBirth" value="<?php echo $row_Students->PlaceOfBirth; ?>">
        </div>
        <div>
            <input type="text" id="Nationality" name="Nationality" value="<?php echo $row_Students->Nationality; ?>">
        </div>
        <div>
            <input type="text" id="Ethnicity" name="Ethnicity" value="<?php echo $row_Students->Ethnicity; ?>">
        </div>
        <div>
            <input type="text" id="Religion" name="Religion" value="<?php echo $row_Students->Religion; ?>">
        </div>
        <div>
            Address Line 1: <br>
            <input type="text" id="Address1" name="Address1" value="<?php echo $row_Students->Address1; ?>">
        </div>
        <div>
            Address Line 2: <br>
            <input type="text" id="Address2" name="Address2" value="<?php echo $row_Students->Address2; ?>">
        </div>
        <div>
            Township: <br>
            <input type="text" id="Township" name="Township" value="<?php echo $row_Students->Township; ?>">
        </div>
        <div>
            <button type="submit" class="medium-button">Update</button>
        </div>
    </form>
    <div class="sys_msg"></div>
</div>
<!-- form-wrap ends -->
<script type="text/javascript">
    $("#myForm").on("submit", function () {
        event.preventDefault();
        var Gender = $('input[name="Gender"]:checked');
        var Name = $("#Name");
        var EnglishName = $("#EnglishName");
        var DOB = $("#DOB");
        var error = false;

        if (Gender.val() == "" || Gender.val() == null) {
            alert("Please select a gender!");
            error = true;   
        }

        if (Name.val() == "" || Name.val() == " " || Name.val() == null) {
            Name.addClass("input-error");
            $(".sys_msg").html("Please input all the field(s) in red!");
            error = true;
        }

        if (EnglishName.val() == "" || EnglishName.val() == " " || EnglishName.val == null) {
            EnglishName.addClass("input-error");
            $(".sys_msg").html("Please input all the fiedl(s) in red!");
            error = true;
        }

        if (DOB.val() == "") {
            DOB.addClass("input-class");
            $(".sys_msg").html("Please input all the fiedl(s) in red!");
            error = true;
        }
        
        if (error == false) {
            $.ajax({
                url: "./php/update_Students.php",
                type: "post",
                data: $("#myForm").serialize(),
                success: function (data) {
                    if (data == 0) {
                        //zero is returned for no error!
                        location.href = "Students.html";
                    }
                    else {
                        $(".sys_msg").html(data);
                    }
                }
            });
        }
    }); 
</script>

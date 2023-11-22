<?php
require_once "functions.php";
if (isset($_POST['Link'])) {
    //getting data from the table Teachers
    $db = new database ();
    $stm = "SELECT * FROM Teachers WHERE Link = :Link ;";
    $db->query($stm);
    $db->bind(":Link", $_POST['Link']);
    $rows_Teachers = $db->resultset();
    foreach ($rows_Teachers as $row_Teachers) {
        #code...
    }
}
else {
    echo "There was a connection error! Please try again!";
}
?>
<!-- form-wrap -->
<div class="form-wrap">
    <form action="#" id="myForm" method="post">
        <div>
            Title: <br>
            <select name="Title" id="Title">
            <?php
            switch ($row_Teachers->Title) {
                case 'Ms.':
                    echo "<option value='Ms.' selected>Ms.</option>";
                    echo "<option value='Mrs.'>Mrs.</option>";
                    echo "<option value='Dr.'>Dr.</option>";
                    echo "<option value='Mr.'>Mr.</option>";
                    break;
                case 'Mrs.':
                    echo "<option value='Ms.'>Ms.</option>";
                    echo "<option value='Mrs.' selected>Mrs.</option>";
                    echo "<option value='Dr.'>Dr.</option>";
                    echo "<option value='Mr.'>Mr.</option>";
                    break;
                case 'Mr':
                    echo "<option value='Ms.'>Ms.</option>";
                    echo "<option value='Mrs.'>Mrs.</option>";
                    echo "<option value='Dr.' selected>Dr.</option>";
                    echo "<option value='Mr.'>Mr.</option>";
                    break;
                case 'Dr.':
                    echo "<option value='Ms.'>Ms.</option>";
                    echo "<option value='Mrs.'>Mrs.</option>";
                    echo "<option value='Dr.'>Dr.</option>";
                    echo "<option value='Mr.' selected>Mr.</option>";
                    break;
                default:
                    break;
            }   
            ?>
            </select>
        </div>
        <div>
            Name: <br>
            <input type="hidden" id="Link" name="Link" value="<?php echo $_POST['Link']; ?>">
            <input type="text" id="Name" name="Name" value="<?php echo $row_Teachers->Name; ?>">
        </div>
        <div>
            English Name: <br>
            <input type="text" id="EnglishName" name="EnglishName" value="<?php echo $row_Teachers->EnglishName; ?>">
        </div>
        <div>
            DOB: <br>
            <input type="date" id="DOB" name="DOB" value="<?php echo $row_Teachers->DOB; ?>">
        </div>
        <div>
            Mobile: <br>
            <input type="text" id="Mobile" name="Mobile" value="<?php echo $row_Teachers->Mobile; ?>">
        </div>
        <div>
            Email: <br>
            <input type="text" id="Email" name="Email" value="<?php echo $row_Teachers->Email; ?>">
        </div>
        <div>
            Start Date: <br>
            <input type="text" id="StartDate" name="StartDate" value="<?php echo $row_Teachers->StartDate; ?>">
        </div>
        <div>
            Education: <br>
            <input type="text" id="Education" name="Education" value="<?php echo $row_Teachers->Education; ?>">
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
    var Mobile = $("#Mobile");

    if (Name.val() == "" || Name.val() == " " || Name.val() == null) {
        error = true;
        $("#Name").addClass("input-error");
    }

    if (Mobile.val() == "" || Mobile.val() == " " || Mobile.val() == null) {
        error = true;
        $("#Mobile").addClass("input-error");
    }

    if (error == true) {
        $(".sys_msg").addClass("error-msg");
        $(".sys_msg").html("Please fill out all the filed(s) in red!");
    }

    if (error == false) {
        $.ajax({
            url: "./php/update_Teachers.php",
            type: "POST",
            data: $(this).serialize(), 
            success: function (data) {
                if (data == 0) {
                    location.reload();
                }
                else {
                    $(".sys_msg").html(data);
                    $(".sys_msg").addClass("error-msg");
                }
            }
        });
    }
});
</script>
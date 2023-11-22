<?php
require_once "functions.php";
if (empty($_POST['StudentsLink'])) {
    echo "There was a connection error! Please try again!";
    die();
}
else {
    //trying to find if Students exists 
    $db = new database ();
    $stm = "SELECT * FROM Students WHERE Link = :StudentsLink ;";
    $db->query($stm);
    $db->bind(":StudentsLink", $_POST['StudentsLink']);
    $row_count = $db->row_count();
    $rows_Students = $db->resultset();
    foreach ($rows_Students as $row_Students) {
        #code...
    }
    if ($row_count == 0) {
        echo "There was a connection error! Please try again!";
        die();
    }
}
?>
<!-- form-wrap -->
<div class="form-wrap">
    <h3>Invoice: <?php echo $row_Students->Name." @ ".$row_Students->EnglishName; ?></h3>
    <form action="#" method="post" id="myForm">
        <div>
            <input type="hidden" id="StudentsLink" name="StudentsLink" value="<?php echo $_POST['StudentsLink']; ?>">
        </div>
        <div>
            Description: <br>
            <input type="text" id="Description" name="Description">
        </div>
        <div>
            Amount in MMK: <br>
            <input type="text" id="MMK" name="MMK" step="1">
        </div>
        <div>
            <button type="submit" class="medium-button">Submit</button>
        </div>
    </form>
    <div class="sys_msg"></div>
</div>
<!-- form-wrap ends -->
<script type="text/javascript">
$("#myForm").submit(function () {
    event.preventDefault();
    var error = false;
    var Description = $("#Description");
    var MMK = $("#MMK");

    if (Description.val().trim() == "" || Description.val().trim() == null) {
        error == true;
        $("#Description").addClass("input-error");
        $(".sys_msg").html("Please input all the fiedl(s) in red!");
        $(".sys_msg").addClass("error-msg");
    }

    if (MMK.val() < 0 || MMK.val() == "") {
        error == true;
        MMK.addClass("input-error");
        $(".sys_msg").html("Please input all the fiedl(s) in red!");
        $(".sys_msg").addClass("error-msg");
    }

    if (error == false) {
        $.ajax({
            url: "./php/submit_new_Students_Invoices.php",
            type: "POST",
            data: $(this).serialize(), 
            success: function (data) {
                if (data == 1) {
                    $(".sys_msg").html("There was a connection error!");
                }
                else {
                    location.href = "view_ProFormaInvoices.html?Link=" + data;
                }
            }
        });
    }
});
</script>

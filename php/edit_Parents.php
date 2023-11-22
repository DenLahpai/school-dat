<?php
require_once "functions.php";
if (isset($_POST['Link'])) {
    //getting data from the table Parents
    $db = new database();
    $stm = "SELECT * FROM Parents WHERE Link = :Link ;";
    $db->query($stm);
    $db->bind(":Link", $_POST['Link']);
    $rows_Parents = $db->resultset();
    foreach ($rows_Parents as $row_Parents) {
        # code...
    }
}
else {
    echo "There was a connection error!";
    die();
}
?>
<!-- form-wrap -->
<div class="form-wrap">
    <form action="#" id="myForm" method="post">
        <div>
            <?php if ($row_Parents->Title == "Mr."): ?>
                <input type="radio" id="Mr" name="Title" value="Mr." checked="checked">
                <label for="Mr">Mr</label>
                &nbsp;
                <input type="radio" id="Mrs" name="Title" value="Mrs.">
                <label for="Mrs">Mrs.</label>
            <?php else: ?>
                <input type="radio" id="Mr." name="Title" value="Mr.">
                <label for="Mr">Mr</label>
                &nbsp;
                <input type="radio" id="Mrs." name="Title" value="Mrs." checked="checked">
                <label for="Mrs">Mrs.</label>
            <?php endif; ?>
        </div>
        <div>
            <input type="hidden" id="Link" name="Link" value="<?php echo $_POST['Link']; ?>">
            <input type="text" id="Name" name="Name" value="<?php echo $row_Parents->Name; ?>" placeholder="Name">    
        </div>
        <div>
            <input type="text" id="Mobile" name="Mobile" value="<?php echo $row_Parents->Mobile; ?>" placeholder="Mobile No">
        </div>
        <div>
            <input type="text" id="Email" name="Email" value="<?php echo $row_Parents->Email; ?>" placeholder="Email">
        </div>
        <div>
            <input type="text" id="Relation" name="Relation" value="<?php echo $row_Parents->Relation; ?>" placeholder="Relation">
        </div>
        <div>
            <input type="text" id="Occupation" name="Occupation" value="<?php echo $row_Parents->Occupation; ?>" placeholder="Occupation">
        </div>
        <div>
            <button type="submit" class="medium-button">Update</button>
        </div>
    </form>
    <div class="sys_msg"></div>
</div>
<!-- form-wrap ends -->
<script type="text/javascript">
    $("#myForm").on("submit", function() {
        event.preventDefault();
        var Title = $('input[name="Title"]:checked');
        var Name = $("#Name");
        var Mobile = $("#Mobile");
        var Email = $("#Email");
        var Relation = $("#Relation");
        var error = false;
        
        if (Name.val().trim() == "" || Name.val().trim() == " " || Name.val().trim() == null) {
            Name.addClass("input-error");
            error = true;
        }

        if (Mobile.val().trim() == "" || Mobile.val().trim() == " " || Mobile.val().trim() == null) {
            Mobile.addClass("input-error");
            error = true;
        }

        if (Relation.val().trim() == "" || Relation.val().trim() == " " || Relation.val().trim() == null) {
            Relation.addClass("input-error");
            error = true;
        }

        if (error == false) {
            $.ajax({
                url: "./php/update_Parents.php",
                type: "post", 
                data: $("#myForm").serialize(),
                success: function (data) {
                    if (data == 0) {
                        //zero is returned for no error
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

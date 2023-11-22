<?php
require_once "functions.php";
if (isset($_POST['Link'])) {
    //getting data from the table Toiletries
    $db = new database();
    $stm = "SELECT * FROM Toiletries WHERE Link = :Link ;";
    $db->query($stm);
    $db->bind(":Link", $_POST['Link']);
    $rows_Toiletries = $db->resultset();
    foreach ($rows_Toiletries as $row_Toiletries) {
        # code...
    }
}
else {
    echo $connection_error;
}
?>
<!-- form-wrap -->
<div class="form-wrap">
    <form action="#" id="myForm" method="post">
        <div>
            <input type="hidden" id="Link" name="Link" value="<?php echo $_POST['Link']; ?>">
            <input type="text" id="Code" name="Code" placeholder="Code" value="<?php echo $row_Toiletries->Code; ?>">
        </div>
        <div>
            <input type="text" id="Name" name="Name" placeholder="Item Name" value="<?php echo $row_Toiletries->Name; ?>"> 
        </div>
        <div>
            <input type="text" id="Vendor" name="Vendor" placeholder="Vendor/Brand" value="<?php echo $row_Toiletries->Vendor; ?>">
        </div>
        <div>
            <input type="text" id="Color" name="Color" placeholder="Color" value="<?php echo $row_Toiletries->Color; ?>">
        </div>
        <div>
            <input type="text" id="Add1" name="Add1" placeholder="Additional" value="<?php echo $row_Toiletries->Add1; ?>">
        </div>
        <div>
            <input type="number" id="Qty" name="Qty" placeholder="Qty" value="<?php echo $row_Toiletries->Qty; ?>">
        </div>
        <div>
        <?php
        if (!empty($row_Toiletries->Issue_Link)):
            //getting data from the table Issue_Toiletries
            $stm = "SELECT * FROM Issue_Toiletries WHERE Link = :Link ;";
            $db->query($stm);
            $db->bind(":Link", $row_Toiletries->Issue_Link);
            $rows_Issue_Toiletries = $db->resultset();
            foreach ($rows_Issue_Toiletries as $row_Issue_Toiletries) {
                # code...
            }
        ?>
        </div>
            <input type="text" id="Issue_Name" name="Issue_Name" placeholder="Issue by" value="<?php echo $row_Issue_Toiletries->Name; ?>">
            <input type="hidden" id="Issue_Link" name="Issue_Link" value="<?php echo $row_Toiletries->Issue_Link; ?>">
        <?php endif; ?>
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
        var Name = $("#Name");
        var error = false;

        if (Name.val().trim() == "" || Name.val().trim() == null) {
            error = true;
            Name.addClass("input-error");
            $(".sys_msg").html("Please input all the field(s) in red!");
            $(".sys_msg").addClass("error-msg");
        }

        if (error == false) {
            $.ajax({
                url: "./php/update_Toiletries.php", 
                type: "POST",
                data: $("#myForm").serialize(),
                success: function (data) {
                    if (data == 0) {
                        location.href = 'view_Toiletries.html';
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

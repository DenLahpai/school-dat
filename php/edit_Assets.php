<?php
require_once "functions.php";
if (isset($_POST['Link'])) {
    //getting data from the table Inventory
    $db = new database();
    $stm = "SELECT * FROM Assets WHERE Link = :Link ;";
    $db->query($stm);
    $db->bind(":Link", $_POST['Link']);
    $rows_Assets = $db->resultset();
    foreach ($rows_Assets as $row_Assets) {
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
            <input type="hidden" id="Link" name="Link" value="<?php echo $_POST['Link']; ?>">
            <input type="text" id="Code" name="Code" value="<?php echo $row_Assets->Code; ?>" placeholder="Code">
        </div>
        <div>
            <input type="text" id="Name" name="Name" value="<?php echo $row_Assets->Name; ?>" placeholder="Item Name">
        </div>
        <div>
            <input type="text" id="Vendor" name="Vendor" value="<?php echo $row_Assets->Vendor; ?>" placeholder="Vendor/Brand">
        </div>
        <div>
            <input type="text" id="Color" name="Color" value="<?php echo $row_Assets->Color; ?>" placeholder="Color">
        </div>
        <div>
            <input type="text" id="Add1" name="Add1" value="<?php echo $row_Assets->Add1; ?>" placeholder="Additional Info">
        </div>
        <div>
            <input type="text" id="Add2" name="Add2" value="<?php echo $row_Assets->Add2; ?>" placeholder="Condition">
        </div>
        <div>
            <input type="number" id="Qty" name="Qty" value="<?php echo $row_Assets->Qty ?>" placeholder="Qty">
        </div>
        <div>
        <?php
        /*if (!empty($row_Stationary->Issue_Link)):
            //getting dta from the table Issue_Stationary
            $stm = "SELECT * FROM Issue_Stationary WHERE Link = :Issue_Link ;";
            $db->query($stm);
            $db->bind(":Issue_Link", $row_Stationary->Issue_Link);
            $rows_Issue_Stationary = $db->resultset();
            foreach ($rows_Issue_Stationary as $row_Issue_Stationary) {
                #code...
            }*/
        ?>
        <!--
        <input type="text" id="Issue_Name" name="Issue_Name" value="<?php echo $row_Issue_Stationary->Name; ?>">
        <input type="hidden" id="Issue_Link" name="Issue_Link" value="<?php echo $row_Stationary->Issue_Link; ?>">
        </div> -->
        <?php //endif; ?>
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
        var Qty = $("#Qty");
        var error = false;
        
        if (Name.val().trim() == "" || Name.val().trim() == null) {
            Name.addClass("input-error");
            $(".sys_msg").html("Please input all the field(s) in red!");
            $(".sys_msg").addClass("error-msg");
            error = true;
        }

        if (error == false) {
            $.ajax({
                url: "./php/update_Assets.php",
                type: "post",
                data: $("#myForm").serialize(),
                success: function (data) {
                    if (data == 0) {
                        location.href = 'view_Assets.html';
                    }
                    else {
                        $(".sys_msg").html(data);
                        $(".sys_msg").addClass("input-error");
                    }
                }
            });
        } 
    });
</script>

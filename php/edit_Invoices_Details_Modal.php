<?php
require_once "functions.php";
//getting data from the table Invoices_Details
$db = new database();
$stm = "SELECT * FROM Invoices_Details WHERE Link = :Link ;";
$db->query($stm);
$db->bind(":Link", $_POST['Link']);
$rows_Invoices_Details = $db->resultset();
foreach ($rows_Invoices_Details as $row_Invoices_Details) {
    #code...
}
?>
<!-- modal -->
<div class="modal" id="modal">
    <!-- modal-head -->
    <div class="modal-head">
        <button type="button" onclick="closeModal('modal');">X</button>
    </div>
    <!-- modal-head ends -->
    <!-- modal-body -->
    <div class="modal-body">
        <!-- form-wrap -->
        <div class="form-wrap">
            <form action="#" id="invoice-details" method="post">
                <div>
                    <input type="hidden" name="Link" id="Link" value="<?php echo $_POST['Link']; ?>">
                    <br/>
                    Description:<br/>
                    <input style="width: 360px;" type="text" name="Description" id="Description" value="<?php echo $row_Invoices_Details->Description; ?>">
                </div>
                <div>
                    Amount in MMK:<br/>
                    <input type="number" style="width: 360px;" name="MMK" id="MMK" value="<?php echo $row_Invoices_Details->MMK; ?>">
                </div>
                <div>
                    <button type="submit" class="medium-button">Update</button>
                </div>
            </form>
            <div class="sys_msg"></div>
        </div>
        <!-- form-wrap ends -->
    </div>
    <!-- modal-body ends  -->
</div>
<!-- modal ends -->
<script type="text/javascript">
$("#invoice-details").submit(function () {
    event.preventDefault();
    var Description = $("#Description");
    var MMK = $("#MMK");
    var error = false;

    if (Description.val().trim() == "" || Description.val().trim() == null) {
        error = true;
        Description.addClass("input-error");
        $(".sys_msg").html("Please fill out all the field(s) in red.");
        $(".sys_msg").addClass("error-msg");
    }

    if (MMK.val() == "" || MMK.val() <= 0) {
        error = true;
        $(".sys_msg").html("Please fill out the filed(s) in red.");
        $(".sys_msg").addCLass("error-msg");
    }

    if (error == false) {
        $.ajax({
            url: "./php/update_Invoices_Details.php", 
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

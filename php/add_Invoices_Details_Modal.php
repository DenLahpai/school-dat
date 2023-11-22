<?php
require_once "functions.php";
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
                    <input type="hidden" name="InvoicesLink" id="InvoicesLink" value="<?php echo $_POST['InvoicesLink']; ?>">
                    <br/>
                    Description: <br/>
                    <input type="text" style="width: 360px;" name="Description" id="Description">
                </div>
                <div>
                    Amount in MMK: <br/>
                    <input type="number" style="width: 360px;" name="MMK" id="MMK">
                </div>
                <div>
                    <button type="submit" class="medium-button">Submit</button>
                </div>
            </form>
            <div class="sys_msg"></div>
        </div>
        <!-- form-wrap ends -->
    </div>
    <!-- modal-body ends -->
</div>
<!-- modal ends -->
<script type="text/javascript">
$("#invoice-details").submit(function(){
    event.preventDefault();
    var Description = $("#Description");
    var MMK = $("#MMK");
    var error = false; 

    if (Description.val().trim() == "" || Description.val().trim() == null) {
        error = true;
        $(".sys_msg").html("Please fill out all the field(s) in red!");
        $(".sys_msg").addClass("input-error");
    }

    if (MMK.val().trim() == "" || MMK.val().trim() <= 0) {
        error = true;
        $(".sys_msg").html("Please fill out all the field(s) in red!");
        $(".sys_msg").addClass("input-error");
    }

    if (error == false) {
        $.ajax({
            url: "./php/adding_Invoices_Details.php",
            type: "POST", 
            data: $(this).serialize(),
            success: function (data) {
                if (data == 0) {
                    location.reload();
                }
                else {
                    $(".sys_msg").html(data);
                }
            }
        });
    }
});
</script>

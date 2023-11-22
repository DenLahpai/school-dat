<?php
require_once "functions.php";
if (isset($_POST['Link'])) {
    $db = new database ();
    $stm = "SELECT * FROM Teachers WHERE Link = :Link ;";
    $db->query($stm);
    $db->bind(":Link", $_POST['Link']);
    $rows_Teachers = $db->resultset();
    foreach ($rows_Teachers as $row_Teachers) {
        #code...
    }
}
?>
<!-- profile -->
<div class="profile">
    <!-- profile-pic-wrap -->
    <div class="profile-pic-wrap">
    <?php if (empty($row_Teachers->Photo)):?>
        <img src="./images/md-person.svg" id="ProfilePic" alt="">
        <br>
        <form action="#" class="myForm" method="post" enctype="multipart/form-data">
            <label for="Photo">Upload</label>
            <input type="file" id="Photo" name="Photo" style="display: none;">
            <input type="hidden" id="Link" name="Link" value="<?php echo $_POST['Link']; ?>">
        </form>
    <?php else: ?>
        <img src="./Teachers/<?php echo $row_Teachers->Photo; ?>" alt="">
        <br>
        <form action="#" class="myForm" method="post" enctype="multipart/form-data">
            <label for="Photo">Change</label>
            <input type="file" id="Photo" name="Photo" style="display: none;">
            <input type="hidden" id="Link" name="Link" value="<?php echo $_POST['Link']; ?>">
        </form>
    <?php endif; ?>
    </div>
    <!-- profile-pic-wrap ends -->
    <!-- profile-name -->
    <div class="profile-name">
        <?php echo $row_Teachers->Name." @ ".$row_Teachers->EnglishName; ?>
    </div>
    <!-- profile-name ends -->
</div>
<!-- profile ends -->
<!-- profile-details -->
<div class="profile-details">
    <!-- profile-details-table -->
    <div class="profile-details-table">
        <table>
            <thead></thead>
            <tbody>
                <tr>
                    <td>Mobile:</td>
                    <td><?php echo $row_Teachers->Mobile; ?></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><?php echo $row_Teachers->Email; ?></td>    
                </tr>
                <tr>
                    <td>DOB:</td>
                    <td><?php echo date("d-M-Y", strtotime($row_Teachers->DOB));?></td>
                </tr>
                <tr>
                    <td>Education:</td>
                    <td><?php echo $row_Teachers->Education; ?></td>
                </tr>
                <tr>
                    <td>Start Date:</td>
                    <td><?php echo date("d-M-Y", strtotime($row_Teachers->StartDate)); ?></td>
                </tr>
                <tr>
                    <td>Curriculum Vitae:</td>
                    <td>
                        <?php if (empty($row_Teachers->CV)): ?>
                            <form action="#" id="form2" method="post" enctype="multipart/form-data">
                                <label for="CV">Upload</label>
                                <input type="file" id="CV" name="CV" style="display: none;">
                                <input type="hidden" id="Link" name="Link" value="<?php echo $_POST['Link']; ?>">
                            </form>
                        <?php else: ?>
                            <form action="#" id="form2" method="post" enctype="multipart/form-data">
                                <a href="./cv/<?php echo $row_Teachers->CV; ?>">View</a>
                                &nbsp;
                                <label for="CV">Change</label>
                                <input type="file" id="CV" name="CV" style="display: none;">
                                <input type="hidden" id="Link" name="Link" value="<?php echo $_POST['Link']; ?>">
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td>Documents:</td>
                    <td>
                        <form action="#" id="form3" method="post" enctype="multipart/form-data">
                            <label for="Doc">Upload</label>
                            <input type="file" id="Doc" name="Doc" style="display: none;">
                            <input type="hidden" id="TeachersLink" name="TeachersLink" value="<?php echo $_POST['Link']; ?>">
                        </form>
                    </td>
                </tr>
                <?php
                //getting data from the table Teachers_Docs
                $stm = "SELECT * FROM Teachers_Docs WHERE TeachersLink = :TeachersLink ;";
                $db->query($stm);
                $db->bind(":TeachersLink", $_POST['Link']);
                $rows_Teachers_Docs = $db->resultset();
                $i = 1;
                ?>
                <?php foreach ($rows_Teachers_Docs as $row_Teachers_Docs):?>
                    <tr>
                        <td colspan="2">
                            <a href="./cv/<?php echo $row_Teachers_Docs->Doc; ?>" target="_blank">Document <?php echo $i;?></a>
                        </td>
                    </tr>
                <?php 
                endforeach; 
                $i++;
                ?>
            </tbody>
        </table>
    </div>
    <!-- profile-details-table ends -->
</div>
<!-- profile-detials ends -->
<script src="./js/jquery.js"></script>
<script src="./js/scripts.js"></script>
<script type="text/javascript">

$("#Photo").on("change", function () {
    //var checking the file extension 
    var img = document.getElementById("Photo").files[0];
    var imgExt = img.name.split(".").pop().toLowerCase();
    var formData = new FormData();
    var files = $("#Photo")[0].files[0];
    formData.append("Photo", files);
    
    //checking for proper file extensions
    if (jQuery.inArray(imgExt, ['jpg', 'jpeg', 'png']) == -1) {
        alert("Invalid image type! Only \".jpg\" or \".jpeg\" or \".png\" file types are allowed!");
    }
    else {
        //checking for file size
        if (img.size > 12000000) {
            alert("The file size is too large!");
        }
        else {
            //proceeding to insert the img
            $.ajax({
                url: "./php/upload_teachers_photo.php?Link=" + $("#Link").val(),
                type: "post",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data == 0) {
                        location.reload();
                    }
                    else {
                        alert(data);
                    }
                }
            });
        }
    }
});

$("#CV").on("change", function () {
    //var checking the file extension 
    var img = document.getElementById("CV").files[0];
    var imgExt = img.name.split(".").pop().toLowerCase();
    var formData = new FormData();
    var files = $("#CV")[0].files[0];
    formData.append("CV", files);
    
    //checking for proper file extensions
    if (jQuery.inArray(imgExt, ['pdf']) == -1) {
        alert("Please choose a PDF file!");
    }
    else {
        //checking for file size
        if (img.size > 12000000) {
            alert("The file size is too large!");
        }
        else {
            //proceeding to insert the img
            $.ajax({
                url: "./php/upload_teachers_cv.php?Link=" + $("#Link").val(),
                type: "post",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data == 0) {
                        location.reload();
                    }
                    else {
                        alert(data);
                    }
                }
            });
        }
    }
});

$("#Doc").on("change", function () {
    var Doc = document.getElementById("Doc").files[0];
    var formData = new FormData();
    var files = $("#Doc")[0].files[0];
    formData.append("Doc", files);
    if (Doc.size > 12000000) {
        alert("The file size is too large!");
    }
    else {
        $.ajax({
            url: "./php/upload_teachers_doc.php?TeachersLink=" + $("#TeachersLink").val(),
            type: "post", 
            data: formData, 
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data == 0){
                    location.reload();
                }
                else {
                    alert(data);
                }
            }
        });
    }
});
</script>
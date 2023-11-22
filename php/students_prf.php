<?php
require_once "functions.php";

if (isset($_POST['Link'])) {
    //getting data from the table Students
    $db = new database ();
    $stm = "SELECT * FROM Students WHERE Link = :Link ;";
    $db->query($stm);
    $db->bind(":Link", $_POST['Link']);
    $rows_Students = $db->resultset();
    foreach ($rows_Students as $row_Students) {
        //code...
    }
}
?>
<!-- profile-pic -->
<div class="profile">
    <div class="profile-pic-wrap" >
    <?php if (empty($row_Students->Photo)): ?>
        <img src="./images/md-person.svg" id="ProfilePic" alt="">
        <br>
        <form action="#" class="myForm" method="post" enctype="multipart/form-data">
            <label for="Photo">Upload</label>
            <input type="file" id="Photo" name="Photo" style="display: none;">
            <input type="hidden" id="Link" name="Link" value="<?php echo $_POST['Link']; ?>">
        </form>
    <?php else: ?>
        <img src="./Students/<?php echo $row_Students->Photo; ?>" alt="">
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
        <?php echo $row_Students->Name." @ ".$row_Students->EnglishName; ?>
    </div>
    <!-- profile-name ends -->
</div>
<!-- profile ends -->
<!-- profile-details  -->
<div class="profile-details">
    <div class="profile-details-table">
        <table>
            <thead></thead>
            <tbody>
                <tr>
                    <td>Gender: </td>
                    <td><?php echo $row_Students->Gender; ?></td>
                    <td>Previous School: </td>
                    <td><?php echo $row_Students->PreviousSchoolName; ?></td>
                </tr>
                <tr>
                    <td>Admission Date: </td>
                    <td><?php echo date("d-M-Y", strtotime($row_Students->AdmissionDate)); ?></td>
                    <td>Township: </td>
                    <td><?php echo $row_Students->PreviousSchoolTownship; ?></td>
                </tr>
                <tr>
                    <td>Admission No: </td>
                    <td><?php echo $row_Students->AdmissionNo; ?></td>
                    <td>Grade: </td>
                    <td><?php echo $row_Students->PreviousGrade; ?></td>
                </tr>
                <tr>
                    <td>MOE No: </td>
                    <td><?php echo $row_Students->MOE; ?></td>
                </tr>
                <tr>
                    <td>D.O.B: </td>
                    <td><?php echo date("d-M-Y", strtotime($row_Students->DOB)); ?></td>
                </tr>
                <tr>
                    <td>Place of Birth: </td>
                    <td><?php echo $row_Students->PlaceOfBirth; ?></td>
                </tr>
                <tr>
                    <td>Nationality: </td>
                    <td><?php echo $row_Students->Nationality; ?></td>
                </tr>
                <tr>
                    <td>Ethnicty: </td>
                    <td><?php echo $row_Students->Ethnicity; ?></td>
                </tr>
                <tr>
                    <td>Religion: </td>
                    <td><?php echo $row_Students->Religion; ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<!-- profile-details ends -->
<!-- siblings-details -->
<div class="siblings-details">
    <h3>Siblings</h3>
    <?php
    //checking for siblings details
    $stm = "SELECT * FROM Siblings WHERE Link1 = :Link ;";
    $db->query($stm);
    $db->bind(":Link", $_POST['Link']);
    $rows_Siblings = $db->resultset();
    ?>
    <div>
        <ul>
        <?php foreach ($rows_Siblings as $row_Siblings): ?>
            <li>
                <?php 
                //getting data from the table Students 
                $stm = "SELECT * FROM Students WHERE Link = :Link ;";
                $db->query($stm);
                $db->bind(":Link", $row_Siblings->Link2);
                $rows_Students2 = $db->resultset();
                foreach ($rows_Students2 as $row_Students2){
                    #code...
                }
                ?>
                <?php echo $row_Students2->Name." @ ".$row_Students2->EnglishName; ?> |
                <a href="view_Students.html?Link=<?php echo $row_Students2->Link; ?>">View</a>
            </li>
        <?php endforeach; ?>
        </ul>
    </div>
    <div style="text-align: center;">
        <a href="add_Siblings.html?Link=<?php echo $_POST['Link'];?>">Add Sibling</a>
    </div>
</div>
<!-- siblings-details ends -->
<!-- parents-details -->
<div class="parents-details">
    <h3>Parents</h3>
    <?php
    //checking for parents detail
    $stm = "SELECT * FROM Students_Parents WHERE 
        StudentsLink = :Link
    ;";
    $db->query($stm);
    $db->bind(":Link", $_POST['Link']);
    $row_count = $db->row_count();
    $rows = $db->resultset();
    ?>
        
    <?php if ($row_count < 1): ?>
        <div style="color: red; font-weight: bold; text-align: center;">Please enter parents info!</div>
    <?php else: ?>
        <div>
            <ul>
            <?php foreach ($rows as $row): ?>
                <li>
                    <?php
                    //getting data from the table Parents
                    $stm = "SELECT * FROM Parents WHERE Link = :Link ;";
                    $db->query($stm);
                    $db->bind(":Link", $row->ParentsLink);
                    $rows_Parents = $db->resultset();
                    foreach ($rows_Parents as $row_Parents){
                        #code...
                    }
                    ?>
                    <?php echo $row_Parents->Relation.": ".$row_Parents->Title." ".$row_Parents->Name." | ".$row_Parents->Mobile; ?>
                    &nbsp;
                    <a href="edit_Parents.html?Link=<?php echo $row_Parents->Link; ?>">View</a>
                </li>
            <? endforeach; ?>    
            </ul>
        </div>
    <?php endif; ?>
    <div style="text-align: center;">
        <a href="new_Parents.html?Link=<?php echo $_POST['Link']?>">Add Parent</a>
    </div>
</div>
<!-- parents-details ends -->
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
                url: "./php/upload_students_photo.php?Link=" + $("#Link").val(),
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
</script>

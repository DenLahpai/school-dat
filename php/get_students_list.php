<?php
require_once "functions.php";
if (isset($_POST['search'])) {
    $ClassesLink = $_POST['ClassesLink'];
    $search = '%'.trim($_POST['search']).'%';
    
    //getting the students list
    $db = new database ();
    $stm = "SELECT * FROM Students WHERE CONCAT (
        Name,
        AdmissionNo, 
        EnglishName
        ) LIKE :search
        AND BranchesId = :BranchesId
        ORDER BY AdmissionDate DESC;
    ;";
    $db->query($stm);
    $db->bind(":search", $search);
    $db->bind(":BranchesId", $_SESSION['BranchesId']);
    $rows_Students = $db->resultset();
}
?>
<!-- data-table -->
<div class="data-table">
    <table>
        <thead>
            <tr>
                <th>Sr.</th>
                <th>Name</th>
                <th>Gender</th>
                <th>English Name</th>
                <th>D.O.B</th>
                <th>Admission No</th>
                <th>Admission Date</th>
                <th>######</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($rows_Students as $row_Students): ?>
            <tr>
                <td><?php echo $row_Students->Id; ?></td>
                <td><?php echo $row_Students->Name; ?></td>
                <td style="text-align: center;"><?php echo $row_Students->Gender; ?></td>
                <td><?php echo $row_Students->EnglishName; ?></td>
                <td><?php echo date("d-M-Y", strtotime($row_Students->DOB)); ?></td>
                <td><?php echo $row_Students->AdmissionNo; ?></td>
                <td><?php echo $row_Students->AdmissionDate; ?></td>
                <td>
                    <form action="#" class="addStudentsForm" method="post">
                        <input type="hidden" name="ClassesLink" value="<?php echo $ClassesLink; ?>">
                        <input type="hidden" name="StudentsLink" value="<?php echo $row_Students->Link; ?>">
                        <button type="submit" class="medium-button">Add</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<!-- data-table ends -->
<script type="text/javascript">
$(".addStudentsForm").submit(function () {
    event.preventDefault();
    $.ajax ({
        url: "./php/add_students_classes.php",
        type: "post", 
        data: $(this).serialize(), 
        success: function (data) {
            if (data == 0) {
                location.reload();
            }
        }
    });
});
</script>
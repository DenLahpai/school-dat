<?php
require_once "functions.php";

if (isset($_POST['Link'])) {
    if ($_POST['search'] == "" || $_POST['search'] == null || empty($_POST['search']) || $_POST['search'] == " ") {
        //getting data from the table Students
        $db = new database ();
        $stm = "SELECT * FROM Students WHERE Link != :Link ORDER BY Id LIMIT 12 ;";
        $db->query($stm);
        $db->bind(":Link", $_POST['Link']);
        $rows_Students = $db->resultset();       
    }
    else {
        $search = '%'.trim($_POST['search']).'%';
        $db = new database();
        $stm = "SELECT * FROM Students WHERE 
            Link != :Link AND 
            CONCAT(
            AdmissionNo, 
            Name,
            EnglishName
            ) LIKE :search
        ;";
        $db->query($stm);
        $db->bind(":Link", $_POST['Link']);
        $db->bind(":search", $search);
        $rows_Students = $db->resultset();
    }
}
?>
<!-- data-table -->
<div class="data-table">
<?php
//getting data for current students
$stm = "SELECT * FROM Students WHERE Link = :Link ;";
$db->query($stm);
$db->bind(":Link", $_POST['Link']);
$rows_current_Students = $db->resultset();
foreach ($rows_current_Students as $row_current_Students) {
    #code...
}
?>
<div class="data-table">
    <h4 style="text-align: center;">Adding Sibling for: <?php echo $row_current_Students->Name.' @ '.$row_current_Students->EnglishName; ?></h4>
    <table>
        <thead>
            <tr>
                <th>Sr.</th>
                <th>Name</th>
                <th>Gender</th>
                <th>English Name</th>
                <th>D.O.B</th>
                <th>Township</th>
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
                <td><?php echo date("d-M-y", strtotime($row_Students->DOB)); ?></td>
                <td><?php echo $row_Students->Township; ?></td>
                <td><?php echo $row_Students->AdmissionNo; ?></td>
                <td><?php echo date("d-M-y", strtotime($row_Students->AdmissionDate)); ?></td>
                <td>
                    <a href="./php/adding_Siblings.php?Link1=<?php echo $_POST['Link']; ?>&Link2=<?php echo $row_Students->Link; ?>">
                        <button type="button" class="medium-button">Add</button>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<!-- data-table ends -->
<?php
require_once "functions.php";
if (isset($_POST['Link']) || !empty($_POST['Link'])) {
    $db = new database ();
    $stm = "SELECT * FROM Students_Classes WHERE ClassesLink = :ClassesLink ;";
    $db->query($stm);
    $db->bind(":ClassesLink", $_POST['Link']);
    $rows_Students_Classes = $db->resultset();
}
?>
<!-- data-table -->
<div class="data-table">
    <table>
        <thead>
            <tr>
                <th>###</th>
                <th>Gender</th>
                <th>English Name</th>
                <th>Name</th>
                <th>DOB</th>
                <th>Admission No</th>
                <th>Parent's Mobile</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $i = 1; 
        foreach ($rows_Students_Classes as $row_Students_Classes): 
        ?>
            <tr>
                <td style="text-align: center"><?php echo $i; ?></td>
                <?php
                //getting data from the table Students 
                $stm = "SELECT * FROM Students WHERE Link = :StudentsLink ;";
                $db->query($stm);
                $db->bind(":StudentsLink", $row_Students_Classes->StudentsLink);
                $rows_Students = $db->resultset();
                foreach ($rows_Students as $row_Students) {
                    #code...
                }
                ?>
                <td><?php echo $row_Students->Gender; ?></td>
                <td><?php echo $row_Students->EnglishName; ?></td>
                <td><?php echo $row_Students->Name; ?></td>
                <td><?php echo date("d-M-Y", strtotime($row_Students->DOB)); ?></td>
                <td><?php echo $row_Students->AdmissionNo; ?></td>
                <td>
                <?php
                //getting data from the table Students_Parents 
                $stm = "SELECT * FROM Students_Parents WHERE StudentsLink = :StudentsLink ;";
                $db->query($stm);
                $db->bind(":StudentsLink", $row_Students->Link);
                $rows_Students_Parents = $db->resultset();
                foreach ($rows_Students_Parents as $row_Students_Parents) {
                    $stm = "SELECT * FROM Parents WHERE Link = :ParentsLink ;";
                    $db->query($stm);
                    $db->bind(":ParentsLink", $row_Students_Parents->ParentsLink);
                    $rows_Parents = $db->resultset();
                    foreach ($rows_Parents as $row_Parents) {
                        echo $row_Parents->Mobile."&nbsp | ";
                    }
                }
                ?>
                </td>
                <td style="text-align: center">
                <?php
                switch ($row_Students_Classes->Status) {
                    case 0:
                        echo "<span style='color:red; font-weight: bold;'>CXL</span>";
                        break;
                    case 1:
                        echo "K";
                        break;
                    default:
                        break;
                }
                ?>
                </td>
            </tr> 
        <?php
        $i++; 
        endforeach; 
        ?>
        </tbody>
    </table>
</div>
<!-- data-table ends -->

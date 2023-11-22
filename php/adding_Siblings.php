<?php
require_once "functions.php";
if (isset($_REQUEST['Link1'])) {
    //adding 2nd student as 1st students sibling
    $db = new database ();
    $stm = "INSERT INTO Siblings SET 
        Link1 = :Link1,
        Link2 = :Link2
    ;";
    $db->query($stm);
    $db->bind(":Link1", $_REQUEST['Link1']);
    $db->bind(":Link2", $_REQUEST['Link2']);
    $db->execute();
    //adding 1st student as 2nd students sibling
    $stm = "INSERT INTO Siblings SET 
        Link1 = :Link2,
        Link2 = :Link1
    ;";
    $db->query($stm);
    $db->bind(":Link2", $_REQUEST['Link2']);
    $db->bind(":Link1", $_REQUEST['Link1']);
    $db->execute();

    //adding 1st student's parents as 2nd student's parent

    //getting data from the table Students_Parents
    $stm = "SELECT * FROM Students_Parents WHERE StudentsLink = :Link ;";
    $db->query($stm);
    $db->bind(":Link", $_REQUEST['Link1']);
    $rows_Students_Parents = $db->resultset();
    foreach ($rows_Students_Parents as $row_Students_Parents) {
        add_Students_Parents ($_REQUEST['Link2'], $row_Students_Parents->ParentsLink);
    }
    header("location: ./../view_Students.html?Link=".$_REQUEST['Link1']);
}
?>
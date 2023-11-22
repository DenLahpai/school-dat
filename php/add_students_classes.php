<?php
require_once "functions.php";
if (isset($_POST['StudentsLink']) || !empty($_POST['StudentsLink'])) {
    $db = new database ();
    
    //checking for duplication 
    $stm = "SELECT * FROM Students_Classes WHERE 
        StudentsLink = :StudentsLink AND
        ClassesLink = :ClassesLink 
    ;";
    $db->query($stm);
    $db->bind(":StudentsLink", $_POST['StudentsLink']);
    $db->bind(":ClassesLink", $_POST['ClassesLink']);
    $row_count = $db->row_count();

    if ($row_count == 0) {
        $Link = uniqid("Stu-Cls_", true);
        $stm = "INSERT INTO Students_Classes SET 
            Link = :Link, 
            StudentsLink = :StudentsLink, 
            ClassesLink = :ClassesLink
        ;";
        $db->query($stm);
        $db->bind(":Link", $Link);
        $db->bind(":StudentsLink", $_POST['StudentsLink']);
        $db->bind(":ClassesLink", $_POST['ClassesLink']);
        if ($db->execute()) {
            generate_pro_forma_invoice($_POST['StudentsLink'], $_POST['ClassesLink']);
            echo 0;
        }
        else {
            echo "There was a connection error! Please try again!";
        }
    }
    else {
        echo "Duplicate entry!";
    }
}
?>

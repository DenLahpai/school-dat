<?php
require_once "functions.php";
if (isset($_POST['search'])) {
    $search = '%'.trim($_POST['search']).'%';
    $db = new database ();
    $stm = "SELECT * FROM Students WHERE
        BranchesId = :BranchesId AND
        CONCAT(
            AdmissionNo,
            Name,
            EnglishName
        ) LIKE :search
    ;";
    $db->query($stm);
    $db->bind(":BranchesId", $_SESSION['BranchesId']);
    $db->bind(":search", $search);
    echo $row_count = $db->row_count();  
}

?>
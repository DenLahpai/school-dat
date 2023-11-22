<?php
require_once "functions.php";
if (isset($_POST['Link'])) {
    //checking for duplicate entry
    $db = new database();
    $stm = "SELECT * FROM Parents 
        WHERE Title = :Title 
        AND Name = :Name
        AND Mobile = :Mobile
        AND Link != :Link
    ;";
    $db->query($stm);
    $db->bind(":Title", $_POST['Title']);
    $db->bind(":Name", trim($_POST['Name']));
    $db->bind(":Mobile", trim($_POST['Mobile']));
    $db->bind(":Link", $_POST['Link']);
    $row_count = $db->row_count();

    if ($row_count == 0) {
        //updating data to the table Parents
        $stm = "UPDATE Parents SET 
            Title = :Title, 
            Name = :Name, 
            Mobile = :Mobile, 
            Email = :Email,
            Relation = :Relation, 
            Occupation = :Occupation
            WHERE Link = :Link
        ;";
        $db->query($stm);
        $db->bind(":Title", $_POST['Title']);
        $db->bind(":Name", trim($_POST['Name']));
        $db->bind(":Mobile", trim($_POST['Mobile']));
        $db->bind(":Email", trim($_POST['Email']));
        $db->bind(":Relation", trim($_POST['Relation']));
        $db->bind(":Occupation", trim($_POST['Occupation']));
        $db->bind(":Link", $_POST['Link']);
        if ($db->execute()) {
            //zero is returned for no error
            echo '0';
        }
        else {
            echo 'There was a connection error!';
        }
    }
    else {
        echo "Duplicate entry!";
    }
   
}
?>

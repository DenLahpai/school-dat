<?php
require_once "functions.php";
if (isset($_POST['StudentsLink'])) {
    $db = new database();

    //checking for duplicate entry
    $stm = "SELECT * FROM Parents WHERE 
        Title = :Title AND
        Name = :Name AND
        Mobile = :Mobile
    ;";
    $db->query($stm);
    $db->bind(":Title", $_POST['Title']);
    $db->bind(":Name", trim($_POST['Name']));
    $db->bind(":Mobile", trim($_POST['Mobile']));
    $row_count = $db->row_count();
    
    //generating Link for Parents 
    $Link = uniqid("Prt_", true);
    if ($row_count == 0) {
        
        $Name = ucwords(trim($_POST['Name']));
        //inserting data to the table Parents
        $stm = "INSERT INTO Parents SET 
            Title = :Title,
            Name = :Name, 
            Mobile = :Mobile,
            Email = :Email, 
            Relation = :Relation,
            Occupation = :Occupation,
            Link = :Link,
            UsersId = :UsersId
        ;";
        $db->query($stm);
        $db->bind(":Title", $_POST['Title']);
        $db->bind(":Name", $Name);
        $db->bind(":Mobile", trim($_POST['Mobile']));
        $db->bind(":Email", trim($_POST['Email']));
        $db->bind(":Relation", trim($_POST['Relation']));
        $db->bind(":Occupation", trim($_POST['Occupation']));
        $db->bind(":Link", $Link);
        $db->bind(":UsersId", $_SESSION['Id']);
        if ($db->execute()) {
            //inserting data to the table Students_Parents 
            $stm = "INSERT INTO Students_Parents SET 
                StudentsLink = :StudentsLink,
                ParentsLink = :ParentsLink,
                UsersId = :UsersId
            ;";
            $db->query($stm);
            $db->bind(":StudentsLink", $_POST['StudentsLink']);
            $db->bind(":ParentsLink", $Link);
            $db->bind(":UsersId", $_SESSION['Id']);
            if ($db->execute()) {
                //zero is returned for no error!
                echo 0;
            }
            else {
                echo "There was a connection error!";
            }
        }
        else {
            echo "There was a connection error!";
        }
    }
    else {
        //inserting data to the table Students_Parents 
        $stm = "INSERT INTO Students_Parents SET 
            StudentsLink = :StudentsLink,
            ParentsLink = :ParentsLink,
            UsersId = :UsersId
        ;";
        $db->query($stm);
        $db->bind(":StudentsLink", $_POST['StudentsLink']);
        $db->bind(":ParentsLink", $Link);
        $db->bind(":UsersId", $_SESSION['Id']);
        if ($db->execute()) {
            //zero is returned for no error!
            echo 0;
        }
        else {
            echo "There was a connection error!";
        }
    }
}
else {
    echo "There was a connection error!";
}
?>

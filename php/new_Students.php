<?php
require_once "functions.php";

if (!empty($_POST['Name'])) {

    $db = new database();
    $Name = ucwords(trim($_POST['Name']));
    $EnglishName = ucwords(trim($_POST['EnglishName']));

    //generating a link 
    $Link = uniqid("Std_", true);

    //checking for duplicate entry
    $stm = "SELECT * FROM Students WHERE 
        Name = :Name AND 
        EnglishName = :EnglishName AND
        DOB = :DOB AND 
        BranchesId = :BranchesId
    ;";
    $db->query($stm);
    $db->bind(":Name", $Name);
    $db->bind(":EnglishName", $EnglishName);
    $db->bind(":DOB", $_POST['DOB']);
    $db->bind(":BranchesId", $_SESSION['BranchesId']);
    $row_count = $db->row_count();

    if ($row_count == 0) {
        $stm = "INSERT INTO Students SET 
            Name = :Name, 
            Gender = :Gender, 
            EnglishName = :EnglishName, 
            DOB = :DOB, 
            AdmissionDate = :AdmissionDate, 
            AdmissionNo = :AdmissionNo,
            Address1 = :Address1,
            Address2 = :Address2,
            Township = :Township,
            Link = :Link,
            BranchesId = :BranchesId,
            MOE = :MOE, 
            PreviousSchoolName = :PreviousSchoolName,
            PreviousSchoolTownship = :PreviousSchoolTownship, 
            PreviousGrade = :PreviousGrade, 
            PlaceOfBirth = :PlaceOfBirth, 
            Nationality = :Nationality, 
            Ethnicity = :Ethnicity,
            Religion = :Religion,   
            UsersId = :UsersId  
        ;";
        $db->query($stm);
        $db->bind(":Name", $Name);
        $db->bind(":Gender", $_POST['Gender']);
        $db->bind(":EnglishName", $EnglishName);
        $db->bind(":DOB", $_POST['DOB']);
        $db->bind(":AdmissionDate", $_POST['AdmissionDate']);
        $db->bind(":AdmissionNo", trim($_POST['AdmissionNo']));
        $db->bind(":Address1", trim($_POST['Address1']));
        $db->bind(":Address2", trim($_POST['Address2']));
        $db->bind(":Township", trim($_POST['Township']));
        $db->bind(":Link", $Link);
        $db->bind(":BranchesId", $_SESSION['BranchesId']);
        $db->bind(":MOE", trim($_POST['MOE']));
        $db->bind(":PreviousSchoolName", trim($_POST['PreviousSchoolName']));
        $db->bind(":PreviousSchoolTownship",trim($_POST['PreviousSchoolTownship']));
        $db->bind(":PreviousGrade", trim($_POST['PreviousGrade']));
        $db->bind(":PlaceOfBirth", trim($_POST['PlaceOfBirth']));
        $db->bind(":Nationality", trim($_POST['Nationality']));
        $db->bind(":Ethnicity", trim($_POST['Ethnicity']));
        $db->bind(":Religion", trim($_POST['Religion']));
        $db->bind(":UsersId", $_SESSION['Id']);   
        if ($db->execute()) {
            //zero is returned for no error
            echo 0;
        }
        else {
            //one is returned for connection error
            echo "There was a connection error! Please try again!";
        }
    }
    else {
        echo "Duplicate entry!";
    }
}

?>

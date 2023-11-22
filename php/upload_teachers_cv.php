<?php
require_once "functions.php";
if (isset($_FILES['CV']) || !empty($_FILES['CV'])) {
    $file = $_FILES['CV'];
    if ($file['error'] == 0) {
        $ext = explode('.', $file['name']);
        $file_ext = strtolower(end($ext));

        //setting new file name 
        $new_file_name = uniqid('', true).'.'.$file_ext;
        $path = "./../cv/".$new_file_name;

        //uploading the file
        move_uploaded_file($file['tmp_name'], $path);
        //updating data to the table Teachers
        $db = new database();
        $stm = "UPDATE Teachers SET 
            CV = :CV WHERE 
            Link = :Link
        ;";
        $db->query($stm);
        $db->bind(":CV", $new_file_name);
        $db->bind(":Link", $_GET['Link']);
        if ($db->execute()) {
            //zero is returned for no error!
            echo 0;
        }
        else {
            echo "There was a connection error while connecting to the database!";
        }
    }
    else {
        echo "There was an error uploading the file!";
    }
}
?>
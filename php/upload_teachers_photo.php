<?php
require_once "functions.php";
if (isset($_FILES['Photo']) || !empty($_FILES['Photo'])) {
    $file = $_FILES['Photo'];
    if ($file['error'] == 0) {
        $ext = explode('.', $file['name']);
        $file_ext = strtolower(end($ext));

        //setting new file name 
        $new_file_name = uniqid('', true).'.'.$file_ext;
        $path = "./../Teachers/".$new_file_name;

        //uploading the file
        move_uploaded_file($file['tmp_name'], $path);

        //updating data to the table Teachers
        $db = new database();
        $stm = "UPDATE Teachers SET 
            Photo = :Photo WHERE 
            Link = :Link
        ;";
        $db->query($stm);
        $db->bind(":Photo", $new_file_name);
        $db->bind(":Link", $_GET['Link']);
        if ($db->execute()) {
            //zero is returned for no error!
            echo 0;
        }
        else {
            echo "There was a connection error while connecting to the database!";
        }
    }
}
?>
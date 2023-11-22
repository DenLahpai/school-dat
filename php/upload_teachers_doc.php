<?php
require_once "functions.php";

if (isset($_FILES['Doc']) || !empty($_FILES['Doc'])) {
	$file = $_FILES['Doc'];

	if ($file['error'] == 0) {
		$ext = explode('.', $file['name']);
		$file_ext = strtolower(end($ext));

		//setting new file name
		$new_file_name = uniqid("Crt_", true).'.'.$file_ext;
		$path = "./../cv/".$new_file_name;

		//uploading the file
		move_uploaded_file($file['tmp_name'], $path);
		//Inserting data to the table Teachers_Docs

		//creating Link
		$Link = uniqid("Tea_Doc_", true);
		$db = new database();
		$stm = "INSERT INTO Teachers_Docs SET 
			Link = :Link, 
			TeachersLink = :TeachersLink, 
			Doc = :Doc, 
			UsersId = :UsersId
		;";
		$db->query($stm);
		$db->bind(":Link", $Link);
		$db->bind(":TeachersLink", $_GET['TeachersLink']);
		$db->bind(":Doc", $new_file_name);
		$db->bind(":UsersId", $_SESSION['Id']);
		if ($db->execute()) {
			//zero is returned for no error!
			echo 0;
		}
		else {
			echo $connection_error;
		}
	}
	else {
		echo "There was an error upload the file!";
	}
}
?>
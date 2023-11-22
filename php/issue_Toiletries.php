<?php
require_once "functions.php";
if (!empty($_POST['Name'])) {
    $db = new database();
    
    //generating issue Link
    $Issue_Link = uniqid("Isu_", true);

    for ($i = 1; $i <= 10; $i++) {
        if (!empty($_POST["Code$i"])) {
            $Code = trim($_POST["Code$i"]);
            $Qty = $_POST["Qty$i"];
            if ($Qty <= 0 || empty($Qty) || $Qty == NULL) {
                $Qty = 1;
            }

            //generating Toiletries Link
            $Link = uniqid("Tol_", true);

            //getting data from the table Toiletries (Name, Vendor, Color, Add1)
            $stm = "SELECT * FROM Toiletries WHERE Code = :Code LIMIT 1;";
            $db->query($stm);
            $db->bind(":Code", $Code);
            $rows_Toiletries = $db->resultset();
            foreach ($rows_Toiletries as $row_Toiletries) {
                # code...
            }
            //inserting data to the table Toiletries
            $stm = "INSERT INTO Toiletries SET 
                Link = :Link,
                Code = :Code,
                Name = :Name,
                Type = :Type,
                Vendor = :Vendor,
                Color = :Color,
                Add1 = :Add1,
                Qty = :Qty,
                Issue_Link = :Issue_Link,
                UsersId = :UsersId    
            ;";
            $db->query($stm);
            $db->bind(":Link", $Link);
            $db->bind(":Code", $Code);
            $db->bind(":Name", $row_Toiletries->Name);
            $db->bind(":Type", "Stationary");
            $db->bind(":Vendor", $row_Toiletries->Vendor);
            $db->bind(":Color", $row_Toiletries->Color);
            $db->bind(":Add1", $row_Toiletries->Add1);
            $db->bind(":Qty", ($Qty * -1));
            $db->bind(":Issue_Link", $Issue_Link);
            $db->bind(":UsersId", $_SESSION['Id']);
            if ($db->execute()) {
                //nothing is returned for no error
            }
            else {
                echo $connection_error;
            }
        }
    }
    //inserting data to the table Issue_Toiletries
    $stm = "INSERT INTO Issue_Toiletries SET 
        Link = :Link,
        Name = :Name
    ;";
    $db->query($stm);
    $db->bind(":Link", $Issue_Link);
    $db->bind(":Name", trim($_POST['Name']));
    if ($db->execute()) {
        //zero is returned for no error
        echo 0;
    }
    else {
        echo $connection_error;
    }
}
else {
    echo $connection_error;
}
?>

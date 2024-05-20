<?php

session_start();
require_once '../DB.Conn.php';

try{
$id = (int)$_POST['id'];

echo $id;

$sql = "DELETE FROM Users WHERE userId = :userAccess";
$sql_smtp = $conn->prepare($sql);
$sql_smtp->bindParam(":userAccess" , $id);
$sql_smtp->execute();


if ($sql_smtp->rowCount() > 0) {
    $_SESSION['DeleteSucessFUll'] =1;
    header("Location: ../../UserPages/UserPage.php");
}

}catch (PDOException $e) {
    // Handle error
    echo "Error: " . $e->getMessage();
}


?>
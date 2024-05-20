<?php

session_start();
require_once '../DB.Conn.php';


$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$AdminAccess = (int)$_POST['admin_access'];

echo $AdminAccess;

$sql = "INSERT INTO Users( userName, userEmail, userPassword, userAccess) VALUES
 (:userName,:userEmail,:userPassword,:userAccess)";
 $sql_smtp = $conn->prepare($sql);
 $sql_smtp->bindParam(":userName" , $name);
 $sql_smtp->bindParam(":userEmail" , $email);
 $sql_smtp->bindParam(":userPassword" , $password);
 $sql_smtp->bindParam(":userAccess" , $AdminAccess , PDO::PARAM_INT);

 $sql_smtp->execute();

 if ($sql_smtp->rowCount() > 0) {
    $_SESSION['AddUserSucessFUll'] =1;
    $_SESSION['ShowUsers'] = 1;
    header("Location: ../../UserPages/UserPage.php");
 }


?>
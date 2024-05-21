<?php


require_once '../DB.Conn.php';
session_start();


$sql = "DELETE FROM `CurrentYearDelivery`";
$sql_smtp = $conn->prepare($sql);
$sql_smtp->execute();


$_SESSION['SuccessfullyDeleted'] = 1;
header("Location: ../../UserPages/UserPage.php");

?>
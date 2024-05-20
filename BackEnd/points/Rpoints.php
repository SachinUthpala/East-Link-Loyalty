<?php
require_once '../DB.Conn.php';
session_start();

// // Ensure session is valid
// if (!isset($_SESSION['logedInUser'])) {
//     die("Unauthorized access.");
// }

// Get POST data
$name = $_POST['id'];
$remainingPoints = (double)$_POST['remaing']; // Corrected the spelling from 'remaing' to 'remaining'
$used = (double)$_POST['used'];

echo $remainingPoints;
// Calculate new values
$newRemaining = $remainingPoints - 50.00;
$newUsed = $used + 50.00;


echo $newRemaining;
try {
    // Prepare SQL query
    $sql = "UPDATE `CurrentYearDelivery` SET `UsedPoints`= :UsedPoints, `RemainingPoints`= :RemainingPoints WHERE Name = :NameS";
    $sql_SMTP = $conn->prepare($sql);
    
    // Bind parameters
    $sql_SMTP->bindParam(":UsedPoints", $newUsed);
    $sql_SMTP->bindParam(":RemainingPoints", $newRemaining);
    $sql_SMTP->bindParam(":NameS", $name);
    
    // Execute the query
    $sql_SMTP->execute();

    echo "Update successful!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<?php
//db connections
require_once './DB.Conn.php';
session_start();


// API URL
$url = "http://10.0.0.237:3000/api/inv";

// Initialize cURL session
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// Execute cURL request
$response = curl_exec($ch);

// Check for errors
if (curl_error($ch)) {
    echo 'Error: '. curl_error($ch);
    header("Location: ../index.php");
    $_SESSION['API_NOT_WORKING'] = 1;
    exit;
}


if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(!$email || !$password){
        $_SESSION['credition_null'] = 1;
        header("Location: ../index.php");
    }

    //chek email exsist
    $sql_email = "SELECT * FROM Users WHERE userEmail = :usermail";

    try {
        $result = $conn->prepare($sql_email);
        // Bind the value of userMail to the placeholder
        $result->bindParam(':usermail', $email);
        $result->execute();

        if($result->rowCount() >0){
            $row = $result -> fetch(PDO::FETCH_ASSOC);
            $userPass = $row['userPassword'];
            $_SESSION['Admin'] = $row['userAccess'];

            if($password == $userPass){
                $_SESSION['login_sucessfull'] = 1;
                $_SESSION['logedInUser'] = $row['userName'];
                header("Location: ./InsetData.php");
                //F:\East Link Loyalty\UserPages\UserPage.html
            }else{
                $_SESSION['wrong_pass'] = 1;
                header("Location: ../index.php");
            }
        }else{
            $_SESSION['wrong_email'] = 1;
            header("Location: ../index.php");
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}







?>
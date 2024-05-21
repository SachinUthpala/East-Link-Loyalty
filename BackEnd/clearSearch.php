<?php

session_start();
$_SESSION['SearchClear'] = 1;
header("Location: ../UserPages/UserPage.php");


?>
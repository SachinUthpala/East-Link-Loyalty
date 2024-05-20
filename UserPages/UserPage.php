<?php

session_start();
require_once '../BackEnd/DB.Conn.php';

$customerCount = "SELECT COUNT(*) AS row_count FROM CurrentYearDelivery";
$customerCount_smtp = $conn->prepare($customerCount);
$customerCount_smtp->execute();
$customerCountValue_row = $customerCount_smtp->fetch(PDO::FETCH_ASSOC);


$UserCount = "SELECT COUNT(*) AS row_count_AL FROM Users";
$UserCount_smtp = $conn->prepare($UserCount);
$UserCount_smtp->execute();
$UserCount_row = $UserCount_smtp->fetch(PDO::FETCH_ASSOC);

$UserCount_ADMIN = "SELECT COUNT(*) AS row_count_A FROM Users WHERE userAccess = 1";
$UserCount_smtp_ADMIN = $conn->prepare($UserCount_ADMIN );
$UserCount_smtp_ADMIN->execute();
$UserCount_row_ADMIN = $UserCount_smtp_ADMIN->fetch(PDO::FETCH_ASSOC);

$UserCount_NonAdmin = "SELECT COUNT(*) AS row_count_N FROM Users WHERE userAccess = 0";
$UserCount_smtp_NonAdmin = $conn->prepare($UserCount_NonAdmin);
$UserCount_smtp_NonAdmin->execute();
$UserCount_row_NonAdmin = $UserCount_smtp_NonAdmin->fetch(PDO::FETCH_ASSOC);
?>


<!-- cheacking if api is working -->
<?php


// API URL
$url = "http://10.0.0.237:3000/api/inv";

// Get the current month (numeric representation)
$currentMonth = date('m');
$currentYear = date('y');
// Get the current date (day of the month)
$currentDate = date('d');

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

?>
<!-- end of api checking -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <title>East Link | Navala</title>
</head>

<body>

    <div class="container">

        <aside class="left-section">
            <div class="logo">
                <button class="menu-btn" id="menu-close">
                    <i class='bx bx-log-out-circle'></i>
                </button>
                <h2>East-<span style="color: rgb(253, 42, 42);">Link</span></h2>
            </div>

            <div class="sidebar">
                <div class="item" id="active" onclick="displyDash()">
                    <i class='bx bx-home-alt-2'></i>
                    <a href="#">Overview</a>
                </div>
                <div class="item" onclick="displyUsers()">
                    <i class='bx bx-grid-alt'></i>
                    <a href="#">Users</a>
                </div>
                <div class="item">
                    <i class='bx bx-folder'></i>
                    <a href="#">Resources</a>
                </div>
                <div class="item">
                    <i class='bx bx-message-square-dots'></i>
                    <a href="#">Message</a>
                </div>
                <div class="item">
                    <i class='bx bx-cog'></i>
                    <a href="#">Setting</a>
                </div>
            </div>

            <div class="pic">
                <img src="assets/pro.png">
            </div>

           

        </aside>

        <main id="Dashbord">
            <header>
                <button class="menu-btn" id="menu-open">
                    <i class='bx bx-menu'></i>
                </button>
                <h5>Hello <b><?php echo $_SESSION['logedInUser']; ?></b>, welcome back!</h5>
            </header>

           

            <div class="analytics">
                <div class="item">
                    <div class="progress">
                        <div class="info">
                            <h5>Locations</h5>
                            <p>35 Lessons</p>
                        </div>
                        
                    </div>
                    <i class='bx bx-map-pin'></i>
                </div>
                <div class="item">
                    <div class="progress">
                        <div class="info">
                            <h5>People</h5>
                            <p>30 Lessons</p>
                        </div>
                        
                    </div>
                    <i class='bx bx-user-voice'></i>
                </div>
                <div class="item">
                    <div class="progress">
                        <div class="info">
                            <h5>Airport</h5>
                            <p>45 Lessons</p>
                        </div>
                       
                    </div>
                    <i class='bx bxs-plane-land'></i>
                </div>
                <div class="item">
                    <div class="progress">
                        <div class="info">
                            <h5>Places</h5>
                            <p>20 Lessons</p>
                        </div>
                        
                    </div>
                    <i class='bx bxs-castle'></i>
                </div>
            </div>

            <div class="separator">
                <div class="info">
                    <h3>Planning</h3>
                    <a href="#">View All</a>
                </div>
                <input type="date" value="2023-10-15">
            </div>

            <div class="planning">
                <div class="item">
                    <div class="left">
                        <div class="icon">
                            <i class='bx bx-book-alt'></i>
                        </div>
                        <div class="details">
                            <h5>Reading - Topic 1</h5>
                            <p>8:00 - 10:00</p>
                        </div>
                    </div>
                    <i class='bx bx-dots-vertical-rounded'></i>
                </div>
                <div class="item">
                    <div class="left">
                        <div class="icon">
                            <i class='bx bx-edit-alt'></i>
                        </div>
                        <div class="details">
                            <h5>Writing - Topic 2</h5>
                            <p>13:00 - 14:00</p>
                        </div>
                    </div>
                    <i class='bx bx-dots-vertical-rounded'></i>
                </div>
                <div class="item">
                    <div class="left">
                        <div class="icon">
                            <i class='bx bx-headphone'></i>
                        </div>
                        <div class="details">
                            <h5>Listening - Topic 1</h5>
                            <p>15:00 - 16:00</p>
                        </div>
                    </div>
                    <i class='bx bx-dots-vertical-rounded'></i>
                </div>
                <div class="item">
                    <div class="left">
                        <div class="icon">
                            <i class='bx bx-volume-low'></i>
                        </div>
                        <div class="details">
                            <h5>Listening - Topic 2</h5>
                            <p>19:00 - 20:00</p>
                        </div>
                    </div>
                    <i class='bx bx-dots-vertical-rounded'></i>
                </div>
            </div>
        </main>
        <!-- end of dashbord -->
        <main id="users">
            <header>
                <button class="menu-btn" id="menu-open">
                    <i class='bx bx-menu'></i>
                </button>
                <h5>Hello <b><?php echo $_SESSION['logedInUser']; ?></b>, welcome back!</h5>
            </header>

           

            <div class="analytics">
                
                <div class="item">
                    <div class="progress">
                        <div class="info">
                            <h5>Admin Users</h5>
                            <h2 style="color: #fff;"><?php echo $UserCount_row_ADMIN['row_count_A'] ; ?></h2>
                        </div>
                    
                    </div>
                    <i class='bx bx-user-voice'></i>
                </div>

                <div class="item">
                    <div class="progress">
                        <div class="info">
                            <h5>System Users</h5>
                            <h2 style="color: #fff;"><?php echo $UserCount_row_NonAdmin['row_count_N'] ; ?></h2>
                        </div>
                        
                    </div>
                    <i class='bx bx-user-voice'></i>
                </div>

                <div class="item">
                    <div class="progress">
                        <div class="info">
                            <h5>All System Users</h5>
                            <h2 style="color: #fff;"><?php echo $UserCount_row['row_count_AL'] ; ?></h2>
                        </div>
                        
                    </div>
                    <i class='bx bx-user-voice'></i>
                </div>

                <div class="item">
                    <div class="progress">
                        <div class="info">
                            <h5>All Our Customers</h5>
                            <h2 style="color: #fff;"><?php echo $customerCountValue_row['row_count'] ; ?></h2>
                        </div>
                        
                    </div>
                    <i class='bx bx-user-voice'></i>
                </div>
                
                
            </div>

            <div class="separator">
                <div class="info">
                    <h3>Planning</h3>
                    <a href="#">View All</a>
                </div>
            </div>

            
        </main>

       

    </div>

    <script src="script.js"></script>
    <script>
        function displyUsers(){
            document.getElementById('users').style.display='block';
            document.getElementById('Dashbord').style.display='none';
        }

        function displyDash(){
            document.getElementById('users').style.display='none';
            document.getElementById('Dashbord').style.display='block';
        }
    </script>
</body>

</html>
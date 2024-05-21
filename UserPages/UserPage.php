<?php

session_start();

$year = date("Y");

if($_SESSION['logedInUser'] == null){
    header("Location: ../index.php");
}

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

<?php
// <!-- current year delivery changes -->
$CurentYearTotalSales_totaol = "SELECT SUM(AllDocTotal) AS total_sum FROM CurrentYearDelivery";
$CurentYearTotalSales_smtp_totaol = $conn->prepare($CurentYearTotalSales_totaol);
$CurentYearTotalSales_smtp_totaol->execute();
$CurentYearTotalSales_smtp_totaol_row = $CurentYearTotalSales_smtp_totaol->fetch(PDO::FETCH_ASSOC);


//SELECT SUM(RemainingPoints) AS total_points_sum FROM CurrentYearDelivery;
$CurentYearTotalSales_totaol_points = "SELECT SUM(RemainingPoints) AS total_points_sum FROM CurrentYearDelivery";
$CurentYearTotalSales_smtp_totaol_points = $conn->prepare($CurentYearTotalSales_totaol_points);
$CurentYearTotalSales_smtp_totaol_points->execute();
$CurentYearTotalSales_smtp_totaol_row_points = $CurentYearTotalSales_smtp_totaol_points->fetch(PDO::FETCH_ASSOC);

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
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
                <div class="item" onclick="displyInquires_c()">
                    <i class='bx bx-notepad'></i>
                    <a href="#"><?php echo $year.' ';  ?> Inquires</a>
                </div>
                <div class="item" onclick="displyUsers()" style="<?php if($_SESSION['AdminAccess'] == 1){echo 'display:flex;';} 
                else {echo 'display:none;';} ?>">
                    <i class='bx bx-grid-alt'></i>
                    <a href="#">Users</a>
                </div>
                <div class="item" onclick="displyUsers_Add()" style="<?php if($_SESSION['AdminAccess'] == 1){echo 'display:flex;';} 
                else {echo 'display:none;';} ?>">
                    <i class='bx bxs-add-to-queue'></i>
                    <a href="#">Add User</a>
                </div>
                <div class="item" onclick="ClearAllCurrentData()" style="<?php if($_SESSION['AdminAccess'] == 1){echo 'display:flex;';} 
                else {echo 'display:none;';} ?>">
                <span class="material-symbols-outlined">
                    sync_problem
                </span>
                    <a href="#">Clear <?php echo $year;?></a>
                </div>
                <div class="item" id="active" onclick="logoutfunction()">
                    <i class='bx bx-power-off'></i>
                    <a href="#">SignOut</a>
                </div>
            </div>

            <div class="pic">
                <img src="assets/pro.png">
            </div>

           

        </aside>

        <script>
           async function  ClearAllCurrentData(){
                const { value: password } = await Swal.fire({
                title: "Enter your password",
                input: "password",
                inputLabel: "Password",
                inputPlaceholder: "Enter your password",
                inputAttributes: {
                    maxlength: "100",
                    autocapitalize: "off",
                    autocorrect: "off"
                }
                });
                if (password === "ClearAll@2024") {

                    location.href="../BackEnd/Tables/ClearCurrent.php";
                }else{
                    Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Provide Correct Password To Continive this Task !",
                    });
                }
            }
        </script>

        <script>
            function logoutfunction(){
            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to LogOut ??!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Logout Now!"
                }).then((result) => {
                if (result.isConfirmed) {
                    location.href="../BackEnd/logOut.php"; 
                }
                });

        }
        </script>

        <main id="Dashbord"
        <?php
    if($_SESSION['ShowUsers'] == 1 || $_SESSION['ShowInquires'] == 1 || $_SESSION['SearchClear'] == 1){
        echo "style='display : none;'";
    }

?>
        
        >
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
                            <h5>All System Users</h5>
                            <h2 style="color: #fff;"><?php echo $UserCount_row['row_count_AL'] ; ?></h2>
                            
                        </div>
                        
                    </div>
                    <i class='bx bx-user-voice'></i>
                </div>
                <div class="item">
                    <div class="progress">
                        <div class="info">
                            <h5>All Sales</h5>
                            <h2 style="color: #fff;"><?php echo 'Rs. '.number_format($CurentYearTotalSales_smtp_totaol_row['total_sum']).'.00 /=' ; ?></h2>
                        </div>
                        
                    </div>
                    <i class='bx bxs-package'></i>
                </div>
                <div class="item">
                    <div class="progress">
                        <div class="info">
                            <h5>Total Customers</h5>
                            <h2 style="color: #fff;"><?php echo $customerCountValue_row['row_count'] ; ?></h2>
                        </div>
                       
                    </div>
                    <i class='bx bx-user-voice'></i>
                </div>
                <div class="item">
                    <div class="progress">
                        <div class="info">
                            <h5>Total Points</h5>
                            <h2 style="color: #fff;"><?php echo number_format($CurentYearTotalSales_smtp_totaol_row_points['total_points_sum']) ; ?></h2>
                        </div>
                        
                    </div>
                    <i class='bx bx-star'></i>
                </div>
            </div>

            <div class="separator">
                <div class="info">
                    <h3>Planning</h3>
                    <a href="#">View All</a>
                </div>
                <input type="date" value="2023-10-15">
            </div>

            <!-- <div class="planning">
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
            </div> -->
        </main>
        <!-- end of dashbord -->



        <!-- use data -->
        <?php
        $allSystemUsrsTable = "SELECT * FROM Users";
        $allSystemUsrsTable_smtp = $conn->prepare($allSystemUsrsTable);
        $allSystemUsrsTable_smtp->execute();
        ?>


        <main id="users" #
        <?php
    if($_SESSION['ShowUsers'] == 1){
        echo "style='display : block;'";
        $_SESSION['ShowUsers'] = null;
    }

?>
        >
            <header>
                <button class="menu-btn" id="menu-open">
                    <i class='bx bx-menu'></i>
                </button>
                <h5>Hello <b><?php echo $_SESSION['logedInUser']; ?></b>, welcome back!</h5>
            </header>

           

            <div class="analytics" style="display: flex;gap: 10px;">
                
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
            </div>

            <div class="separator">
                <div class="info">
                    <h3>System Users</h3>
                    <a href="#">View All</a>
                </div>

                <!-- table -->
                <!-- end table -->
            </div>
            <div class="table-container">
        <div class="search-bar">
            <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search for names..">
        </div>
        <table id="myTable">
            <thead>
                <tr class="header">
                    <th>UserName</th>
                    <th>User Email</th>
                    <th>User Password</th>
                    <th>Admin Access</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                </tbody>
                <?php while($allSystemUsrsTable_smtp_row = $allSystemUsrsTable_smtp->fetch(PDO::FETCH_ASSOC)) { ?>
                <tr>
                    <td><?php echo $allSystemUsrsTable_smtp_row['userName']; ?></td>
                    <td><?php echo $allSystemUsrsTable_smtp_row['userEmail']; ?></td>
                    <td><?php echo $allSystemUsrsTable_smtp_row['userPassword']; ?></td>
                    <td><?php 
                    
                    if( $allSystemUsrsTable_smtp_row['userAccess']==1){
                        echo "<p style='Padding: 10px;background-color:green;border-radius :5px;color:#fff'>Have</p>";
                    }else{
                        echo "<p style='Padding: 10px;background-color:red;border-radius: 5px;color:#fff'>Dont Have</p>";
                    }
                    
                    ?></td>
                    <td style="text-align: center;">
                        <form action="../BackEnd/UserFunctions/DeleteUser.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $allSystemUsrsTable_smtp_row['userId'] ; ?>">
                            <button type="submit" style="border: none;background-color: #ffffff00;"><i class='bx bx-trash' ></i></button>
                        </form>
                    </td>
                </tr>
                <?php } ?>
                <!-- Add more rows as needed -->
            </tbody>
        </table>
    </div>
            
        </main>
    <!-- script for search -->
    <script src="./tableSeach1.js"></script>  
    <?php

        if($_SESSION['DeleteSucessFUll'] == 1){
            echo '
                <script>
                Swal.fire({
                    title: "User Deleted!",
                    text: "User Already Deleted!",
                    icon: "success"
                  });
                  </script>
                '
                ;
                $_SESSION['DeleteSucessFUll'] = null;
        }else if($_SESSION['AddUserSucessFUll'] == 1){
            echo '
                <script>
                Swal.fire({
                    title: "User Added!",
                    text: "New User Already Added!",
                    icon: "success"
                  });
                  </script>
                '
                ;
                $_SESSION['AddUserSucessFUll'] = null;
        }else if($_SESSION['RedineSuccess'] == 1){
            echo '
                <script>
                Swal.fire({
                    title: "Updated!",
                    text: "User Point Updatd!",
                    icon: "success"
                  });
                  </script>
                '
                ;
                $_SESSION['RedineSuccess'] = null;
        }

    ?>     



<main id="add_user"  >
            <header>
                <button class="menu-btn" id="menu-open">
                    <i class='bx bx-menu'></i>
                </button>
                <h5>Hello <b><?php echo $_SESSION['logedInUser']; ?></b>, welcome back!</h5>
            </header>

           

            <div class="analytics" style="display: flex;gap: 10px;">
                
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
            </div>
            <br>
            <div class="separator">
                <div class="info">
                    <h3>Add System Users</h3>
                </div>

                <!-- table -->
                <!-- end table -->
            </div>
            <br>
            <div class="container_addUser">
        <form class="user-form_addUser" method="post" action="../BackEnd/UserFunctions/AddUser.php">
            <h2 class="form-title_addUser">User Details</h2>
            <div class="input-group_addUser">
                <input type="text" id="name" name="name" required>
                <label for="name">Name</label>
            </div>
            <div class="input-group_addUser">
                <input type="email" id="email" name="email" required>
                <label for="email">Email</label>
            </div>
            <div class="input-group_addUser">
                <input type="password" id="password" name="password" required>
                <label for="password">Password</label>
            </div>
            <div class="input-group_addUser">
                <select id="admin-access" name="admin_access" required>
                    <option value="" disabled selected>Select Access</option>
                    <option value="1">Give Admin Access</option>
                    <option value="0">Don't Give Admin Access</option>
                </select>
                <label for="admin-access">Admin Access</label>
            </div>
            <button type="submit" class="submit-btn_addUser">Submit</button>
        </form>
    </div>
         
        </main>


        <?php

        $currentYearInquires = "SELECT * FROM `CurrentYearDelivery` ORDER BY RemainingPoints DESC";
        $currentYearInquires_smtp = $conn->prepare($currentYearInquires);
        $currentYearInquires_smtp->execute();

        ?>



<main id="currentYearDeliveries"
<?php
    if($_SESSION['ShowInquires'] == 1 || $_SESSION['SearchClear'] == 1){
        echo "style='display : block;'";
        $_SESSION['ShowInquires'] = null;
        $_SESSION['SearchClear'] = null;
    }

?>

>
        <header>
            <button class="menu-btn" id="menu-open">
                <i class='bx bx-menu'></i>
            </button>
            <h5>Hello <b><?php echo $_SESSION['logedInUser']; ?></b>, welcome back!</h5>
        </header>
        <br>
        <div class="separator">
            <div class="info">
                <h3><?php echo $year . ' - Deliveries'; ?></h3>
            </div>
        </div>
        <br>
        <div class="table-container_2">
            <div class="search-bar" style="display: flex; gap: 10px;align-items: center;">
                <input type="text" id="searchInputss" onkeyup="searchTabless()" placeholder="Search for names..">
                <input type="button" onclick="clearSearch()" value="Clear Search" style="background-color: #1da0f2;color: #fff;cursor: pointer;">
                
            </div>

            <!-- 
                SCRIPT
             -->
                <script>
                            function clearSearch(){
                                Swal.fire({
                        title: "Are you sure?",
                        text: "Do you want to Clear Search ??!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Clear Now!"
                        }).then((result) => {
                        if (result.isConfirmed) {
                            location.href="../BackEnd/clearSearch.php"; 
                        }
                        });
                    }
                </script>
             <!-- 
                END OF SCRIPT
              -->
            <table id="myTable_2">
                <thead>
                    <tr class="header_2">
                        <th>Name</th>
                        <th>Contact Code</th>
                        <th>Card Name</th>
                        <th>Total Inquiries</th>
                        <th>Used Points</th>
                        <th>Remaining Points</th>
                        <th>Total Points</th>
                        <th>Redine</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($currentYearInquires_smtp_row = $currentYearInquires_smtp->fetch(PDO::FETCH_ASSOC)) { ?>
                    <tr <?php if($currentYearInquires_smtp_row['RemainingPoints'] >= 50){echo "style='background-color: rgba(172, 255, 47, 0.308);'";}else{echo "style='background-color: rgba(248, 0, 0, 0.308);'";} ?>>
                        <td><?php echo $currentYearInquires_smtp_row['Name']; ?></td>
                        <td><?php echo $currentYearInquires_smtp_row['CntctCode']; ?></td>
                        <td><?php echo $currentYearInquires_smtp_row['CardName']; ?></td>
                        <td><?php echo $currentYearInquires_smtp_row['AllDocTotal']; ?></td>
                        <td><?php echo $currentYearInquires_smtp_row['UsedPoints']; ?></td>
                        <td><?php echo $currentYearInquires_smtp_row['RemainingPoints']; ?></td>
                        <td><?php echo $currentYearInquires_smtp_row['RemainingPoints'] + $currentYearInquires_smtp_row['UsedPoints']; ?></td>
                        <td>
                            <form action="../BackEnd/points/Rpoints.php" method="post" <?php if($currentYearInquires_smtp_row['RemainingPoints'] >= 50){echo "style='display:block'";}else{echo "style='display:none'";} ?>>
                                <input type="hidden" name="id" value="<?php echo $currentYearInquires_smtp_row['Name'] ?>">
                                <input type="hidden" name="remaing" value="<?php echo $currentYearInquires_smtp_row['RemainingPoints'] ?>">
                                <input type="hidden" name="used" value="<?php echo $currentYearInquires_smtp_row['UsedPoints'] ?>">
                                <button type="submit" style="border: none;background-color: #ffffff00;"><i class='bx bxs-rename'></i></button>
                            </form>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="pagination">
                <button onclick="prevPage()" id="btn_prev">Prev</button>
                <span id="page"></span>
                <button onclick="nextPage()" id="btn_next">Next</button>
            </div>
        </div>
    </main>
    <script>
        let currentPage = 1;
        const rowsPerPage = 12;
        let rows = Array.from(document.querySelectorAll('#myTable_2 tbody tr'));

        function searchTabless() {
            const input = document.getElementById('searchInputss').value.toLowerCase();
            rows = Array.from(document.querySelectorAll('#myTable_2 tbody tr')).filter(row => {
                const cells = row.getElementsByTagName('td');
                return Array.from(cells).some(cell => cell.innerText.toLowerCase().includes(input));
            });
            currentPage = 1;
            displayRows();
        }

        function displayRows() {
            const tbody = document.querySelector('#myTable_2 tbody');
            tbody.innerHTML = '';

            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            const paginatedRows = rows.slice(start, end);

            paginatedRows.forEach(row => tbody.appendChild(row));

            document.getElementById('page').innerText = `Page ${currentPage}`;
            document.getElementById('btn_prev').disabled = currentPage === 1;
            document.getElementById('btn_next').disabled = end >= rows.length;
        }

        function prevPage() {
            if (currentPage > 1) {
                currentPage--;
                displayRows();
            }
        }

        function nextPage() {
            if ((currentPage * rowsPerPage) < rows.length) {
                currentPage++;
                displayRows();
            }
        }

        document.addEventListener('DOMContentLoaded', displayRows);
    </script>


    












    </div>

    <script src="script.js"></script>
    <script>
        function displyUsers(){
            document.getElementById('users').style.display='block';
            document.getElementById('Dashbord').style.display='none';
            document.getElementById('add_user').style.display='none';
            document.getElementById('currentYearDeliveries').style.display='none';
        }

        function displyDash(){
            document.getElementById('users').style.display='none';
            document.getElementById('Dashbord').style.display='block';
            document.getElementById('add_user').style.display='none';
            document.getElementById('currentYearDeliveries').style.display='none';
        }

        function displyUsers_Add(){
            document.getElementById('users').style.display='none';
            document.getElementById('Dashbord').style.display='none';
            document.getElementById('add_user').style.display='block';
            document.getElementById('currentYearDeliveries').style.display='none';
        }

        function displyInquires_c(){
            document.getElementById('users').style.display='none';
            document.getElementById('Dashbord').style.display='none';
            document.getElementById('add_user').style.display='none';
            document.getElementById('currentYearDeliveries').style.display='block';
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
</body>

</html>
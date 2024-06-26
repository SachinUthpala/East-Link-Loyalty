<?php
require_once './BackEnd/DB.Conn.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up Form by Colorlib</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="preloader" id="loader">
        <div class="content">
        <h1 style="font-size: 25px;color: rgb(252, 95, 95);">Setting Up Your Working Environment .. !</h1>
        <p style="font-size: 16px;color: #fff;">Just Wait a Second !!</p>
        <img src="./images/animi.gif" alt="" style="width: 200px;height: auto;">
        </div>
    </div>

    <script>
        var loader =document.getElementById("loader");
        window.addEventListener("load" , function() {
            loader.style.display = "none";
        })

        function displyLoader(){
            loader.style.display = "block";
        }
    </script>



    <div class="main">
        
        <!-- Sing in  Form -->
        <section class="sign-in">
            
            <div class="container">
                
                <div class="signin-content">
                    
                    <div class="signin-image">
                        <figure><img src="images/signin-image.jpg" alt="sing up image"></figure>
                        
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title" style="text-align: center;">East-<span style="color: rgb(253, 42, 42);">Link</span> Sign In</h2>
                        <form method="POST" class="register-form" id="login-form" action="./BackEnd/Login.php">
                            <div class="form-group">
                                <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="email" id="your_name" placeholder="Your Email"/>
                            </div>
                            <div class="form-group">
                                <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="your_pass" placeholder="Password"/>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="remember-me" id="remember-me" class="agree-term" />
                                <label for="remember-me" class="label-agree-term"><span><span></span></span>Remember me</label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="login" id="signin" onclick="displyLoader()" class="form-submit" value="Log in"/>
                            </div>
                        </form>
                       
                    </div>
                </div>
            </div>
        </section>

    </div>

    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
    <!-- sweet alert json -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js" ></script>

    <?php
    
    if($_SESSION['wrong_email'] == 1){
        echo '
                <script>
                Swal.fire({
					icon: "error",
					title: "Oops...",
					text: "Wrong Email !",
				  });
                  </script>
                '
                ;
	    $_SESSION['wrong_email'] = null;
    }else if($_SESSION['wrong_pass'] == 1){
        echo '
                <script>
                Swal.fire({
					icon: "error",
					title: "Oops...",
					text: "Wrong Password !",
				  });
                  </script>
                '
                ;
	    $_SESSION['wrong_pass'] = null;
    }else if($_SESSION['API_NOT_WORKING'] == 1){
      echo '
              <script>
              Swal.fire({
        icon: "error",
        title: "Api Is Not Working...",
        text: "Api Is Not Working. Please Contact Your System Administrator !",
        });
                </script>
              '
              ;
    $_SESSION['API_NOT_WORKING'] = null;
  }
    
    ?>




</body>
</html>
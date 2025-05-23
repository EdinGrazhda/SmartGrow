<?php

include "database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $surname = $_POST['surname'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $base_location = $_POST['base_location'] ?? '';

    if (empty($name) || empty($surname) || empty($email) || empty($password) || empty($base_location)) {
        die("All fields are required.");
    }

    // Check if email already exists
    $checkStmt = $conn->prepare("SELECT email FROM farmers WHERE email = ?");
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
    $checkStmt->close();
    header("Location: register.php?error=email");
    exit;
}
    $checkStmt->close();

    // Hash password and insert
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO farmers (name, surname, email, password, base_location) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $surname, $email, $hashedPassword, $base_location);
    $stmt->execute();
    $stmt->close();

    echo "<div class='success-notification'>Successfully registered</div>";
}
?>
<?php
if (isset($_GET['error']) && $_GET['error'] == 'email') {
    echo "<div class='warning'>Email already exists. Please use a different email.</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./images/icon.png">
    <title>Register</title>
      <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            --primary-green: #2baa7e;
            --dark-green: #0d5c36;
            --cream-bg: #f9f3e9;
            --button-green: #0d5c36;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--cream-bg);
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        
        .header, .footer {
            background-color: #308a56;
            padding: 20px 0;
            width: 100%;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
        }
        
        .logo-icon {
            color: var(--cream-bg);
            font-size: 24px;
            margin-right: 10px;
        }
        
        .logo-text {
            color: #333;
            font-size: 24px;
            font-weight: bold;
        }
        
        .nav-menu {
            display: flex;
            justify-content: flex-end;
        }
        
        .nav-link {
            color: #333;
            font-size: 18px;
            margin: 0 15px;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .nav-link:hover {
            color: var(--dark-green);
        }
        
        .main-content {
            padding: 50px 0;
            min-height: calc(100vh - 160px);
            display: flex;
            align-items: center;
        }
        
        .content-container {
            width: 100%;
        }
        
        .illustration-container {
            width: 100%;
            max-width: 450px;
            margin: 0 auto;
        }
        
        .circular-image {
            width: 100%;
            padding-bottom: 100%;
            position: relative;
            border-radius: 50%;
            overflow: hidden;
            background-color: #99d7b2;
        }
        
        .welcome-text {
            color: #308a56;
            font-size: 3.5rem;
            font-weight: bold;
            margin-bottom: 30px;
            line-height: 1.2;
        }
        
        .form-container {
            max-width: 450px;
        }
        
        .form-control {
            padding: 15px 15px 15px 50px;
            border-radius: 15px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
            font-size: 18px;
        }
        
        .input-icon {
            position: relative;
        }
        
        .input-icon i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--dark-green);
            font-size: 20px;
        }
        
        .btn-signin {
            background-color: #308a56;
            color: white;
            border: none;
            border-radius: 15px;
            padding: 15px;
            width: 100%;
            font-size: 20px;
            font-weight: bold;
            transition: background-color 0.3s;
            margin-top: 10px;
        }
        
        .btn-signin:hover {
            background-color: var(--button-green);
            color: white;
        }
        
        .forgot-password {
            text-align: center;
            margin-top: 20px;
        }
        
        .forgot-password a {
            color: #333;
            text-decoration: none;
            font-size: 16px;
        }
        
        .forgot-password a:hover {
            text-decoration: underline;
        }
        
        .footer {
            margin-top: auto;
        }
        
        /* Responsive styles */
        @media (max-width: 992px) {
            .welcome-text {
                font-size: 3rem;
            }
            
            .illustration-container {
                max-width: 400px;
                margin-bottom: 40px;
            }
        }
        
        @media (max-width: 768px) {
            .nav-link {
                margin: 0 10px;
                font-size: 16px;
            }
            
            .logo-text {
                font-size: 20px;
            }
            
            .welcome-text {
                font-size: 2.5rem;
                text-align: center;
            }
            
            .illustration-container {
                max-width: 350px;
                margin: 0 auto 40px;
            }
            
            .form-container {
                margin: 0 auto;
            }
            
            .main-content {
                padding: 30px 0;
            }
        }
        
        @media (max-width: 576px) {
            .nav-menu {
                justify-content: center;
                margin-top: 15px;
            }
            
            .logo-container {
                justify-content: center;
            }
            
            .welcome-text {
                font-size: 2rem;
            }
            
            .illustration-container {
                max-width: 280px;
            }
            
            .main-content {
                padding: 20px 0;
            }
        }

        .success-notification{
            position: fixed;
            top: 30px;
            left: 30px;
            width: 250px;
            height: 50px;
            font-weight: 500;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #308a56;
            text-align: center;
            color: white;
            border-radius: 10px
        }

        .warning{
            position: fixed;
            top: 30px;
            left: 30px;
            width: 300px;
            height: 50px;
            font-weight: 500;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color:rgb(137, 12, 12);
            text-align: center;
            color: white;
            border-radius: 10px
        }
    </style>
</head>
<body class="loading">
<?php
include "loading.php";?>
    <!-- Header -->
  
    
    <!-- Main Content -->
    <div class="main-content" data-aos="fade-up" data-aos-duration="2700">
        <div class="container">
            <div class="content-container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="illustration-container">
                            <div class="circular-image">
                                <img src="images/login-photo.webp" alt="Farm illustration with tractor" style="    
    position: absolute;
    width: 86%;
    height: 100%;
    object-fit: cover;
    margin-left: 13%; ">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="welcome-text">Welcome to<br>SmartGrow</div>
                        <div class="form-container">
                            <form id="loginForm" method="POST">
                                <div class="input-icon">
                                    <i class="far fa-user"></i>
                                    <input type="text"  name="name" class="form-control" placeholder="Name" required>
                                </div>
                                <div class="input-icon">
                                    <i class="far fa-user"></i>
                                    <input type="text" name="surname" class="form-control" placeholder="Surname" required>
                                </div>
                                <div class="input-icon">
                                    <i class="far fa-envelope"></i>
                                    <input type="Email" name="email" class="form-control" placeholder="Email" required>
                                </div>
                                <div class="input-icon">
                                    <i class="fas fa-lock"></i>
                                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                                </div>
                                <div class="input-icon">
                                <i class="fa-solid fa-location-dot"></i>
                                    <input type="text" name="base_location" class="form-control" placeholder="Base Location" required>
                                </div>
                                <button type="submit" class="btn btn-signin">Register</button>

                                <div class="forgot-password">
                                    <a href="login.php">Already have an account?</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Footer content can go here -->
                </div>
            </div>
        </div>
    </div>
    
    
    <!-- jQuery and Bootstrap JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    setTimeout(() => {
        const notif = document.querySelector('.success-notification, .warning');
        if (notif) notif.style.display = 'none';
    }, 3000);
</script>



</body>
</html>
<?php
session_start();
if (!isset($_SESSION['adminID'])) {
    header("Location: ./../index.php");
    exit;
}

include "./../database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $rate = $_POST["rate"];

    $checkStmt = $conn->prepare("SELECT categoryID FROM category WHERE name = ?");
    $checkStmt->bind_param("s", $name);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        $error_message = "A category with this name already exists.";
    } else {
        $stmt = $conn->prepare("INSERT INTO category (name, rate) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $rate);

        if ($stmt->execute()) {
            header("Location: categories.php");
            exit();
        } else {
            $error_message = "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $checkStmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category - SmartGrow</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-green: #2baa7e;
            --dark-green: #0d5c36;
            --cream-bg: #f9f3e9;
            --button-green: #0d5c36;
            --sidebar-width: 260px;
            --header-height: 70px;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--cream-bg);
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background-color: #308a56;
            color: white;
            transition: all 0.3s;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            padding-top: 20px;
        }

        .sidebar-header {
            padding: 20px 20px 30px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .logo-text {
            font-size: 24px;
            font-weight: bold;
            color: white;
            margin: 10px 0;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .menu-item {
            padding: 10px 20px;
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
            transition: all 0.3s;
            border-left: 4px solid transparent;
        }

        .menu-item:hover, .menu-item.active {
            background-color: rgba(255,255,255,0.1);
            border-left: 4px solid white;
        }

        .menu-item i {
            margin-right: 10px;
            width: 24px;
            text-align: center;
        }

        /* Main Content Styles */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            padding: 20px;
            transition: all 0.3s;
        }

        /* Header Styles */
        .header {
            height: var(--header-height);
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            margin-bottom: 20px;
            border-radius: 10px;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--dark-green);
        }

        .user-menu {
            display: flex;
            align-items: center;
        }

        .user-info {
            margin-right: 15px;
            text-align: right;
        }

        .user-name {
            font-weight: 600;
            color: var(--dark-green);
        }

        .user-role {
            font-size: 0.8rem;
            color: #777;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary-green);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        /* Hamburger Menu Styles */
        .toggle-sidebar {
            background: none;
            border: none;
            cursor: pointer;
            padding: 5px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 24px;
            width: 30px;
        }

        .toggle-sidebar span {
            display: block;
            width: 100%;
            height: 3px;
            background-color: var(--dark-green);
            border-radius: 3px;
            transition: all 0.3s;
        }

        .toggle-sidebar:hover span {
            background-color: var(--primary-green);
        }

        /* Form Styles */
        .form-container {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            max-width: 600px;
            margin: 0 auto;
        }

        .form-title {
            color: var(--dark-green);
            margin-bottom: 25px;
            font-weight: 600;
            text-align: center;
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-green);
            margin-bottom: 8px;
            display: block;
        }

        .form-control {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 20px;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: var(--primary-green);
            outline: none;
            box-shadow: 0 0 0 3px rgba(43, 170, 126, 0.2);
        }

        .btn-submit {
            background-color: var(--dark-green);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
        }

        .btn-submit:hover {
            background-color: #0b4a2b;
        }

        .btn-back {
            display: inline-block;
            margin-top: 15px;
            color: var(--dark-green);
            text-decoration: none;
            font-weight: 600;
        }

        .btn-back:hover {
            text-decoration: underline;
        }

        .error-message {
            color: #dc3545;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        /* Overlay for mobile */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 999;
            display: none;
        }

        /* Mobile styles */
        @media (max-width: 992px) {
            .sidebar {
                left: -260px;
            }
            
            .sidebar.active {
                left: 0;
            }
            
            .main-content {
                margin-left: 0;
                padding: 15px;
            }
            
            .main-content.sidebar-active {
                margin-left: 260px;
            }
            
            .header {
                padding: 0 15px;
            }
            
            .header-title {
                font-size: 1.2rem;
            }
            
            .form-container {
                padding: 20px;
            }
        }

        @media (max-width: 576px) {
            .header-title {
                font-size: 1rem;
            }
            
            .form-title {
                font-size: 1.3rem;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
        <img src="../img/logo-dashboard.png" alt="SmartGrow Logo" height="60">
            <div class="logo-text">SmartGrow</div>
        </div>
        <div class="sidebar-menu">
        <a href="dashboard.php" class="menu-item">
                <i class="fas fa-tachometer-alt"></i>
                Dashboard
            </a>
            <a href="users.php" class="menu-item">
                <i class="fas fa-users"></i>
                Users
            </a>
            <a href="categories.php" class="menu-item active">
                <i class="fa-solid fa-layer-group"></i>
                Category
            </a>
            <a href="settings.php" class="menu-item">
                <i class="fas fa-cog"></i>
                Settings
            </a>
            <a href="./../logout.php" class="menu-item">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </a>
        </div>
    </div>
    <!-- Overlay for mobile -->
    <div class="sidebar-overlay"></div>
    <!-- Overlay for mobile -->
    <div class="sidebar-overlay"></div>
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <button class="toggle-sidebar">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <div class="header-title">Admin Dashboard</div>
            </div>
            <div class="user-menu">
                <div class="user-info">
                    <div class="user-name"><?php echo $_SESSION['username']; ?></div>
                    <div class="user-role">Admin</div>
                </div>
                <div class="avatar">
                    <?php echo substr($_SESSION['username'], 0, 1); ?>
                </div>
            </div>
        </div>

        <div class="form-container">
            <h2 class="form-title">Add New Category</h2>
            
            <?php if(isset($error_message)): ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php endif; ?>
            
            <form method="post" action="">
                <div class="form-group">
                    <label for="name" class="form-label">Category Name</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Enter category name" required>
                </div>
                
                <div class="form-group">
                    <label for="rate" class="form-label">Rate (seed/ari)</label>
                    <input type="text" id="rate" name="rate" class="form-control" placeholder="Enter rate" required>
                </div>
                
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Save Category
                </button>
                
                <a href="categories.php" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Back to Categories
                </a>
            </form>
        </div>
    </div>

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Toggle sidebar on mobile
            $('.toggle-sidebar').on('click', function() {
                $('.sidebar').toggleClass('active');
                $('.sidebar-overlay').toggle();
                $('.main-content').toggleClass('sidebar-active');
            });
            
            // Close sidebar when clicking overlay
            $('.sidebar-overlay').on('click', function() {
                $('.sidebar').removeClass('active');
                $('.sidebar-overlay').hide();
                $('.main-content').removeClass('sidebar-active');
            });
            
            // Responsive check
            function checkWidth() {
                if ($(window).width() > 992) {
                    $('.sidebar').addClass('active');
                    $('.main-content').addClass('sidebar-active');
                    $('.sidebar-overlay').hide();
                    $('.toggle-sidebar').hide();
                } else {
                    $('.sidebar').removeClass('active');
                    $('.main-content').removeClass('sidebar-active');
                    $('.toggle-sidebar').show();
                }
            }
            
            // Check on load
            checkWidth();
            
            // Check on resize
            $(window).resize(function() {
                checkWidth();
            });
        });
    </script>
</body>
</html>

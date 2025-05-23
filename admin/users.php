<?php
session_start();
if (!isset($_SESSION['adminID'])) {
    header("Location: ./../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories - SmartGrow</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="categories.css?v=<?php echo time(); ?>">
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

        /* Content Styles */
        .content-container {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .page-title {
            color: var(--dark-green);
            margin-bottom: 25px;
            font-weight: 600;
        }

        /* Table Styles */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            min-width: 600px;
        }

        .table th {
            background-color: var(--dark-green);
            color: white;
            padding: 12px 15px;
            text-align: left;
        }

        .table td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }

        .table tr:hover {
            background-color: rgba(43, 170, 126, 0.05);
        }

        /* Button Styles */
        .btn-add {
            background-color: var(--dark-green);
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 20px;
            transition: background-color 0.3s;
        }

        .btn-add:hover {
            background-color: #0b4a2b;
            color: white;
        }

        .btn-action {
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-edit {
            background-color: #0b4a2b;
            color: white;
            margin-right: 5px;
        }

        .btn-edit:hover {
            background-color: #0d5c36;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background-color: #c82333;
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
            
            .content-container {
                padding: 15px;
            }
            
            .page-title {
                font-size: 1.5rem;
                margin-bottom: 15px;
            }
        }

        @media (max-width: 576px) {
            .header-title {
                font-size: 1rem;
            }
            
            .user-name {
                font-size: 0.9rem;
            }
            
            .user-role {
                font-size: 0.7rem;
            }
            
            .avatar {
                width: 35px;
                height: 35px;
                font-size: 0.9rem;
            }
            
            .btn-add {
                padding: 8px 15px;
                font-size: 0.9rem;
            }
            
            .btn-action {
                padding: 5px 8px;
                font-size: 0.8rem;
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
            <a href="users.php" class="menu-item active">
                <i class="fas fa-users"></i>
                Users
            </a>
            <a href="categories.php" class="menu-item">
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

        <div class="content-container">
            <h1 class="page-title">Farmer Management</h1>
            
            <a href="add_category.php" class="btn-add">
                <i class="fas fa-plus"></i> Add New Farmer
            </a>
            
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Surname</th>
                            <th>Email</th>
                            <th>Base Location</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include "./../database.php";

                        $result = $conn->query("SELECT farmerID, name, surname,email,base_location FROM farmers");

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["farmerID"] . "</td>";
                                echo "<td>" . $row["name"] . "</td>";
                                echo "<td>" . $row["surname"] . "</td>";
                                echo "<td>" . $row["email"] . "</td>";
                                echo "<td>" . $row["base_location"] . "</td>";
                                echo "<td>";
                                echo "<a href='update_users.php?id=" . $row["farmerID"] . "' class='btn-action btn-edit'><i class='fas fa-edit'></i> Edit</a>";
                                echo "<a href='delete_users.php?id=" . $row["farmerID"] . "' class='btn-action btn-delete' onclick=\"return confirm('Are you sure you want to delete this category?')\"><i class='fas fa-trash-alt'></i> Delete</a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4' class='text-center'>No categories found</td></tr>";
                        }

                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
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

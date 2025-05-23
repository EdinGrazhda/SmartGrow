<?php
session_start();
if (!isset($_SESSION['adminID'])) {
    header("Location: ./../index.php");
    exit;
}

include "./../database.php";

// Get statistics from database
$adminCount = $conn->query("SELECT COUNT(*) FROM admins")->fetch_row()[0];
$farmerCount = $conn->query("SELECT COUNT(*) FROM farmers")->fetch_row()[0];
$categoryCount = $conn->query("SELECT COUNT(*) FROM category")->fetch_row()[0];
$farmCount = $conn->query("SELECT COUNT(*) FROM farms")->fetch_row()[0];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartGrow - Admin Dashboard</title>
    <link rel="icon" href="./../images/icon.png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

        /* Stats Cards */
        .dashboard-cards {
            margin-bottom: 20px;
        }

        .stat-card {
            display: flex;
            align-items: center;
            padding: 15px;
            border-radius: 10px;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: rgba(43, 170, 126, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: var(--primary-green);
            font-size: 1.5rem;
        }

        .stat-info .number {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--dark-green);
        }

        .stat-info .text {
            color: #666;
            font-size: 0.9rem;
        }

        /* Card Styles */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            color: var(--dark-green);
            font-weight: 600;
            margin-bottom: 20px;
        }

        /* Table Styles */
        .table {
            width: 100%;
        }

        .table th {
            background-color: #f8f9fa;
            color: var(--dark-green);
            font-weight: 600;
        }

        /* Activity Item */
        .activity-item {
            display: flex;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(43, 170, 126, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: var(--primary-green);
        }

        .activity-title {
            font-weight: 600;
            color: #333;
        }

        .activity-time {
            font-size: 0.8rem;
            color: #777;
        }

        /* Footer */
        .footer {
            padding: 20px 0;
            text-align: center;
            color: #666;
            font-size: 0.9rem;
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
            
            .stat-card {
                padding: 10px;
            }
            
            .stat-icon {
                width: 50px;
                height: 50px;
                font-size: 1.2rem;
            }
            
            .stat-info .number {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .header-title {
                font-size: 1rem;
            }
            
            .stat-card {
                flex-direction: column;
                text-align: center;
            }
            
            .stat-icon {
                margin-right: 0;
                margin-bottom: 10px;
            }
            
            .stat-info .number {
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
        <a href="dashboard.php" class="menu-item active">
                <i class="fas fa-tachometer-alt"></i>
                Dashboard
            </a>
            <a href="users.php" class="menu-item">
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
        
        <!-- Dashboard Content -->
        <div class="container-fluid">
            <!-- Stats Cards -->
            <div class="row dashboard-cards">
                <div class="col-md-6 col-lg-3">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div class="stat-info">
                            <div class="number"><?php echo $adminCount; ?></div>
                            <div class="text">Administrators</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="stat-info">
                            <div class="number"><?php echo $farmerCount; ?></div>
                            <div class="text">Farmers</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-tractor"></i>
                        </div>
                        <div class="stat-info">
                            <div class="number"><?php echo $farmCount; ?></div>
                            <div class="text">Farms</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-layer-group"></i>
                        </div>
                        <div class="stat-info">
                            <div class="number"><?php echo $categoryCount; ?></div>
                            <div class="text">Categories</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main Row -->
            <div class="row">
                <!-- Recent Farmers -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Recent Farmers</h5>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Location</th>
                                            <th>Farms</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $recentFarmers = $conn->query("SELECT name, surname, email, base_location FROM farmers ORDER BY farmerID DESC LIMIT 5");
                                        while($farmer = $recentFarmers->fetch_assoc()):
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($farmer['name'] . ' ' . $farmer['surname']); ?></td>
                                            <td><?php echo htmlspecialchars($farmer['email']); ?></td>
                                            <td><?php echo htmlspecialchars($farmer['base_location']); ?></td>
                                            <td>
                                                <?php 
                                                $farmCount = $conn->query("SELECT COUNT(*) FROM farms WHERE farmerID = (SELECT farmerID FROM farmers WHERE email = '".$conn->real_escape_string($farmer['email'])."')")->fetch_row()[0];
                                                echo $farmCount;
                                                ?>
                                            </td>
                                            <td><span class="badge bg-success">Active</span></td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Activities -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Recent Activities</h5>
                            <div class="activity-item">
                                <div class="activity-icon">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                                <div class="activity-details">
                                    <div class="activity-title">New farmer registered</div>
                                    <div class="activity-time">Today, 10:30 AM</div>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon">
                                    <i class="fas fa-tractor"></i>
                                </div>
                                <div class="activity-details">
                                    <div class="activity-title">New farm added</div>
                                    <div class="activity-time">Yesterday, 03:45 PM</div>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon">
                                    <i class="fas fa-layer-group"></i>
                                </div>
                                <div class="activity-details">
                                    <div class="activity-title">Category updated</div>
                                    <div class="activity-time">Yesterday, 11:20 AM</div>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon">
                                    <i class="fas fa-user-shield"></i>
                                </div>
                                <div class="activity-details">
                                    <div class="activity-title">Admin login</div>
                                    <div class="activity-time">May 22, 2025</div>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon">
                                    <i class="fas fa-cog"></i>
                                </div>
                                <div class="activity-details">
                                    <div class="activity-title">System settings updated</div>
                                    <div class="activity-time">May 21, 2025</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- System Overview Row -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">System Overview</h5>
                            <div class="row text-center">
                                <div class="col-md-3">
                                    <div class="p-3">
                                        <div class="fw-bold">Total Admins</div>
                                        <div class="display-4"><?php echo $adminCount; ?></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="p-3">
                                        <div class="fw-bold">Total Farmers</div>
                                        <div class="display-4"><?php echo $farmerCount; ?></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="p-3">
                                        <div class="fw-bold">Total Farms</div>
                                        <div class="display-4"><?php echo $farmCount; ?></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="p-3">
                                        <div class="fw-bold">Total Categories</div>
                                        <div class="display-4"><?php echo $categoryCount; ?></div>
                                    </div>
                                </div>
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
                        &copy; 2025 SmartGrow | All Rights Reserved
                    </div>
                </div>
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

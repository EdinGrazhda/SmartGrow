<?php
session_start();
if (!isset($_SESSION['adminID'])) {
    header("Location: ./../index.php");
    exit;
}

include '../database.php';

$adminID = $_SESSION['adminID'];
$successMessage = '';
$errorMessage = '';

// Fetch farmer data
$stmt = $conn->prepare("SELECT * FROM admins WHERE adminID = ?");
$stmt->bind_param("i", $adminID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $admin = $result->fetch_assoc();
} else {
    $errorMessage = "Error: Farmer data not found.";
}
$stmt->close();

// Handle form submission
if (isset($_POST['update_profile'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Check if email already exists for another farmer
    $stmt = $conn->prepare("SELECT adminID FROM admins WHERE username = ? AND adminID != ?");
    $stmt->bind_param("si", $username, $adminID);
    $stmt->execute();
    $emailResult = $stmt->get_result();
    
    if ($emailResult->num_rows > 0) {
        $errorMessage = "Email already in use by another account.";
    } else {
        // If password is changed, hash it
        $passwordChanged = false;
        if ($password !== $admin['password']) {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $passwordChanged = true;
        }
        
        // Update farmer data
        $updateStmt = $conn->prepare("UPDATE admins SET username = ?, " . ($passwordChanged ? ", password = ?" : "") . " WHERE adminID = ?");
        
        if ($passwordChanged) {
            $updateStmt->bind_param("sssssi", $username, $password, $adminID);
        } else {
            $updateStmt->bind_param("ssssi", $username, $email, $adminID);
        }
        
        if ($updateStmt->execute()) {
            $successMessage = "Profile updated successfully!";
            
            // Refresh farmer data
            $stmt = $conn->prepare("SELECT * FROM admins WHERE adminID = ?");
            $stmt->bind_param("i", $adminID);
            $stmt->execute();
            $result = $stmt->get_result();
            $admin = $result->fetch_assoc();
            $stmt->close();
            
            // Update session data
            $_SESSION['farmerusername'] = $username . ' ';
        } else {
            $errorMessage = "Error updating profile: " . $conn->error;
        }
        $updateStmt->close();
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta username="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartGrow - Account Settings</title>
    <link rel="icon" href="./../images/icon.png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="settings.css?v=<?php echo time(); ?>">
</head>
<body>
    <!-- Success Notification -->
    <?php if (!empty($successMessage)): ?>
    <div class="success-notification">
        <i class="fas fa-check-circle"></i>
        <span><?php echo $successMessage; ?></span>
    </div>
    <?php endif; ?>
    
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
            <a href="categories.php" class="menu-item">
                <i class="fa-solid fa-layer-group"></i>
                Category
            </a>
            <a href="settings.php" class="menu-item active">
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
                    <i class="fas fa-bars"></i>
                </button>
                <div class="header-title">Account Settings</div>
            </div>
            <div class="user-menu">
                <div class="user-info">
                    <div class="user-username"><?php echo $admin['username'] ?></div>
                    <div class="user-role">Admin</div>
                </div>
                <div class="avatar">
                    <?php echo substr($admin['username'], 0, 1); ?>
                </div>
            </div>
        </div>
        
        <!-- Settings Content -->
        <div class="container-fluid">
            <?php if (!empty($errorMessage)): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?php echo $errorMessage; ?>
            </div>
            <?php endif; ?>
            
            <div class="settings-container">
                <h2 class="settings-title">Profile Information</h2>
                
                <form method="post" action="settings.php">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($admin['username']); ?>" required>
                            </div>
                        </div>
                        
                    
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="password-container">
                            <input type="password" class="form-control" id="password" name="password" required>
                            <button type="button" class="password-toggle" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <small class="text-muted">Note: If you change your password, you'll need to log in again.</small>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" username="update_profile" class="btn btn-update">
                            <i class="fas fa-save me-2"></i> Update Profile
                        </button>
                    </div>
                </form>
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
            
            // Toggle password visibility
            $('#togglePassword').on('click', function() {
                const passwordInput = $('#password');
                const icon = $(this).find('i');
                
                if (passwordInput.attr('type') === 'password') {
                    passwordInput.attr('type', 'text');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    passwordInput.attr('type', 'password');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });
            
            // Responsive check
            function checkWidth() {
                if ($(window).width() > 992) {
                    $('.sidebar').addClass('active');
                    $('.main-content').addClass('sidebar-active');
                    $('.sidebar-overlay').hide();
                    $('.toggle-sidebar').hide(); // Hide hamburger on large screens
                } else {
                    $('.sidebar').removeClass('active');
                    $('.main-content').removeClass('sidebar-active');
                    $('.toggle-sidebar').show(); // Show hamburger on small screens
                }
            }
            
            // Check on load
            checkWidth();
            
            // Check on resize
            $(window).resize(function() {
                checkWidth();
            });
            
            // Auto-hide success notification
            setTimeout(function() {
                $('.success-notification').fadeOut('slow');
            }, 3000);
        });
    </script>
</body>
</html>
<?php
$conn->close();
?>

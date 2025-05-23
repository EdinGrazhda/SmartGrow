<?php
include "./../database.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        die("username and password are required.");
    }

    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['adminID'] = $user['adminID'];
            $_SESSION['username'] = $user['username'];
            header("Location: ./dashboard.php");
            exit;
        } else {
            echo "<div class='error-notification'>Invalid username or password.</div>";
        }
    } else {
        echo "<div class='error-notification'>Invalid username or password.</div>";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="icon" href="./images/icon.png">
    <style>
    body {
        background-color: #ffffff;
        font-family: Arial, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    form {
        background-color: #fff;
        border: 1px solid #e0e0e0;
        padding: 30px 40px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        width: 100%;
        max-width: 320px;
    }

    label {
        display: block;
        margin-bottom: 15px;
        color: #333;
        font-size: 14px;
    }

    input[type="text"],
    input[type="password"] {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }

    button {
        background-color: #377f2b;
        color: white;
        font-size: 15px;
        padding: 10px;
        width: 100%;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 10px;
        transition: background-color 0.2s ease-in-out;
    }

    button:hover {
        background-color: #134c1f;
    }

    .error-notification {
        background-color: #54341d;
        color: white;
        padding: 10px;
        margin-bottom: 15px;
        text-align: center;
        border-radius: 5px;
        font-size: 14px;
    }
</style>
<link rel="icon" href="./../images/icon.png">
</head>
<body>
    <form action="" method="POST">
        <h3>Admin login</h3>
        <label><input type="text" placeholder="Username" name="username" required></label><br>
        <label><input type="password" placeholder="Password" name="password" required></label><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>

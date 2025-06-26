<?php
session_start();
require_once '../includes/db_connection.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        header("Location: admin_page.php?error=emptyfields");
        exit();
    }

    $stmt = $conn->prepare("SELECT id, name, username, password FROM users WHERE username = ? AND user_type = 'admin'");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();

        // Secure password check
        if (password_verify($password, $admin['password'])) {
            session_regenerate_id();

            $_SESSION['admin_loggedin'] = true;
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            $_SESSION['admin_name'] = $admin['name'];
            $_SESSION['user_type'] = 'admin';

            header("Location: admin_dashboard.php");
            exit();
        }
    }

    header("Location: admin_page.php?error=invalidcredentials");
    exit();
} else {
    header("Location: admin_page.php");
    exit();
}

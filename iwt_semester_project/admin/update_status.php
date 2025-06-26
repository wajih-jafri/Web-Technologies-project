<?php
require_once '../includes/db_connection.php';
if (isset($_GET['id'], $_GET['status'])) {
    $id = (int)$_GET['id'];
    $status = $_GET['status'];

    $allowed = ['pending', 'in_progress', 'resolved', 'rejected'];
    if (!in_array($status, $allowed)) {
        die("Invalid status.");
    }

    $stmt = $conn->prepare("UPDATE complaints SET status = ? WHERE complaint_id = ?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
}

header("Location: admin_dashboard.php");
exit();

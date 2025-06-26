<?php
session_start();
require_once '../includes/db_connection.php';

// Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input
    $category       = trim($_POST['category']);
    $location       = trim($_POST['location']);
    $title          = trim($_POST['title']);
    $priority       = $_POST['priority'] ?? 'medium'; // default
    $mobile         = trim($_POST['mobile']);
    $incident_date  = $_POST['incident_date'] ?? null;
    $gender         = trim($_POST['gender']);
    $description    = trim($_POST['description']);
    $user_id        = $_SESSION['user_id']; // assume already set at login

    // Validate required fields
    if (empty($category) || empty($location) || empty($title) || empty($mobile) || empty($gender) || empty($description)) {
        $_SESSION['submission_message'] = "Please fill in all required fields.";
        header("Location: complaint_form.php");
        exit();
    }

    // Handle file upload (optional)
    $file_path = null;
    if (!empty($_FILES['attachment']['name'])) {
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) mkdir($upload_dir);

        $file_name = basename($_FILES['attachment']['name']);
        $file_path = $upload_dir . time() . "_" . $file_name;

        if (!move_uploaded_file($_FILES['attachment']['tmp_name'], $file_path)) {
            $file_path = null; // Reset if upload fails
        }
    }

    // Prepare and execute SQL
    $query = "INSERT INTO complaints (
        user_id, category, location, title, priority, mobile, incident_date, gender, description, attachment_path, created_at
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

    $stmt = $conn->prepare($query);
$stmt->bind_param("isssssssss", $user_id, $category, $location, $title, $priority, $mobile, $incident_date, $gender, $description, $file_path);

    if ($stmt->execute()) {
        $complaint_id = $stmt->insert_id;
        $_SESSION['submission_message'] = "Complaint submitted successfully. Your Complaint ID is: " . $complaint_id;
    } else {
        $_SESSION['submission_message'] = "Error submitting complaint. Please try again.";
    }

    $stmt->close();
    $conn->close();

    header("Location: complaint_form.php");
    exit();
} else {
    header("Location: complaint_form.php");
    exit();
}
?>

<?php
session_start();
require_once '../includes/db_connection.php';
if (!isset($_SESSION['admin_loggedin'])) {
    header("Location: admin_page.php");
    exit();
}

// Get complaint data if ID is provided
$complaint = [];
if (isset($_GET['id'])) {
    $complaint_id = (int)$_GET['id'];
    $stmt = $conn->prepare("
        SELECT * FROM complaints 
        WHERE complaint_id = ?
    ");
    $stmt->bind_param("i", $complaint_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $complaint = $result->fetch_assoc();
    $stmt->close();
}

// If no complaint found, redirect back
if (empty($complaint)) {
    header("Location: admin_dashboard.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category = trim($_POST['category']);
    $location = trim($_POST['location']);
    $title = trim($_POST['title']);
    $priority = $_POST['priority'] ?? 'medium';
    $mobile = trim($_POST['mobile']);
    $incident_date = $_POST['incident_date'] ?? null;
    $gender = trim($_POST['gender']);
    $description = trim($_POST['description']);
    
    // Update in database
    $stmt = $conn->prepare("
        UPDATE complaints SET
        category = ?,
        location = ?,
        title = ?,
        priority = ?,
        mobile = ?,
        incident_date = ?,
        gender = ?,
        description = ?,
        updated_at = NOW()
        WHERE complaint_id = ?
    ");
    
    $stmt->bind_param(
        "ssssssssi",
        $category,
        $location,
        $title,
        $priority,
        $mobile,
        $incident_date,
        $gender,
        $description,
        $complaint_id
    );
    
    if ($stmt->execute()) {
        $_SESSION['submission_message'] = "Complaint #$complaint_id updated successfully";
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Error updating complaint: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Complaint</title>
    <link rel="stylesheet" href="../assets/css/project.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    
 <nav class="navbar">
        <div class="navbar_logo">
            <img src="../assets/img/FUSST_logo.jpg" alt="logo" onclick="window.location.href='admin_logout.php'">
        </div>
        <div class="navbar-links">
                <button class="logout-btn" onclick="window.location.href='./admin_logout.php'">
                    <i class="fas fa-sign-out-alt"></i> LOGOUT
                </button>
        </div>
    </nav>

    <div style="padding: 20px; font-size: 18px;">
        Welcome, <strong><?= htmlspecialchars($_SESSION['admin_name'] ?? 'Admin') ?></strong>
    </div>

    <div id="complaintForm">
        <div class="form-wrapper">
            <h2>Edit Complaint #<?= $complaint['complaint_id'] ?></h2>
            
            <?php if (isset($error)): ?>
                <div class="error-message"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST" action="update_complaint.php?id=<?= $complaint['complaint_id'] ?>">
                <!-- Row 1: Complaint Category, Department/Location, Title -->
                <div class="form-row">
                    <div class="form-group">
                        <label>Complaint Category <span class="required">*</span></label>
                        <select name="category" required>
                            <option value="">Select Option</option>
                            <option value="internet" <?= $complaint['category'] == 'internet' ? 'selected' : '' ?>>Internet</option>
                            <option value="behavior" <?= $complaint['category'] == 'behavior' ? 'selected' : '' ?>>Behavior</option>
                            <option value="electricity" <?= $complaint['category'] == 'electricity' ? 'selected' : '' ?>>Electricity</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Location / Department <span class="required">*</span></label>
                        <input type="text" name="location" value="<?= htmlspecialchars($complaint['location']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Complaint Title / Subject <span class="required">*</span></label>
                        <input type="text" name="title" value="<?= htmlspecialchars($complaint['title']) ?>" required>
                    </div>
                </div>

                <!-- Row 2: Priority, Mobile Number, Date -->
                <div class="form-row">
                    <div class="form-group">
                        <label>Priority Level</label>
                        <select name="priority">
                            <option value="medium" <?= $complaint['priority'] == 'medium' ? 'selected' : '' ?>>Medium</option>
                            <option value="low" <?= $complaint['priority'] == 'low' ? 'selected' : '' ?>>Low</option>
                            <option value="high" <?= $complaint['priority'] == 'high' ? 'selected' : '' ?>>High</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Mobile Number <span class="required">*</span></label>
                        <input type="text" name="mobile" value="<?= htmlspecialchars($complaint['mobile']) ?>" pattern="[0-9]{11}" title="11-digit phone number" required>
                    </div>
                    <div class="form-group">
                        <label>Date of Incident</label>
                        <input type="date" name="incident_date" value="<?= $complaint['incident_date'] ?>">
                    </div>
                </div>

                <!-- Row 3: Gender -->
                <div class="form-row">
                    <div class="form-group">
                        <label>Gender <span class="required">*</span></label>
                        <select name="gender" required>
                            <option value="">Select Option</option>
                            <option value="male" <?= $complaint['gender'] == 'male' ? 'selected' : '' ?>>Male</option>
                            <option value="female" <?= $complaint['gender'] == 'female' ? 'selected' : '' ?>>Female</option>
                            <option value="other" <?= $complaint['gender'] == 'other' ? 'selected' : '' ?>>Other</option>
                        </select>
                    </div>
                </div>

                <!-- Row 4: Description -->
                <div class="form-row">
                    <div class="form-group full-width">
                        <label>Complaint Description <span class="required">*</span></label>
                        <textarea name="description" style="height: 100px; resize: none; padding: 10px;" required><?= 
                            htmlspecialchars($complaint['description']) 
                        ?></textarea>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="form-row">
                    <button type="submit" class="submit-btn">Update Complaint</button>
                    <a href="admin_dashboard.php" class="action-btn reject-btn" style="margin-left: 10px;">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
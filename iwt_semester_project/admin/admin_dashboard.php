<?php

session_start();
require_once '../includes/db_connection.php';

if (!isset($_SESSION['admin_loggedin'])) {
    header("Location: admin_page.php");
    exit();
}

$result = $conn->query("
    SELECT c.*, u.name as user_name 
    FROM complaints c
    JOIN users u ON c.user_id = u.id
    ORDER BY c.created_at DESC
");

$categories = $conn->query("SELECT DISTINCT category FROM complaints")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/project.css">
    <style>
        .dashboard-wrapper { display: flex;
             min-height: calc(100vh - 60px);
             }
        .sidebar { width: 140px;
             background: #153d69;
              color: white; padding: 20px; }
        .sidebar-menu { list-style: none;
             padding: 0; }
        .sidebar-menu li { padding: 10px 0;
             border-bottom: 1px solid rgba(255,255,255,0.1);
             }
        .sidebar-menu a { color: white;
             text-decoration: none;
             display: block; }
        .sidebar-menu a:hover { color: #f8f9fa;
         }
        .main-content { flex: 1;
             padding: 20px;
         }

        .complaints-table { width: 100%;
             border-collapse: collapse;
              margin-top: 20px; }
        .complaints-table th { background-color: #153d69;
             color: white; padding: 12px; }
        .complaints-table td { padding: 12px; 
            border-bottom: 1px solid #ddd; text-align: center; }

        .status-badge { 
            padding: 5px 10px; border-radius: 20px; font-size: 0.8em; 
            display: inline-block; min-width: 80px; text-align: center;
        }
        .status-pending { background-color: #fff3cd; color: #856404; }
        .status-in_progress { background-color: #cce5ff; color: #004085; }
        .status-resolved { background-color: #d4edda; color: #155724; }
        .status-rejected { background-color: #f8d7da; color: #721c24; }

        .action-btn {
            padding: 6px 12px; margin: 0 2px; border: none; border-radius: 4px;
            cursor: pointer; font-size: 0.8em; transition: all 0.2s;
            text-decoration: none;
        }
        .in-progress-btn { background-color: #17a2b8; color: white; }
        .resolve-btn { background-color: #28a745; color: white; }
        .reject-btn { background-color: #ffc107; color: #212529; }
        .delete-btn { background-color: #dc3545; color: white; }
        .edit-btn { background-color: #ff7043; color: #212529;
}


    </style>
</head>
<body>

 <nav class="navbar">
        <div class="navbar_logo">
            <img src="../assets/img/FUSST_Logo.jpg" alt="FUSST Logo" onclick="window.location.href='admin_logout.php'">
        </div>
        <div class="navbar-links">
                <button class="logout-btn" onclick="window.location.href='./admin_logout.php'">
                    <i class="fas fa-sign-out-alt"></i> LOGOUT
                </button>
        </div>
    </nav>

    <div class="dashboard-wrapper">
        <div class="sidebar">
            <h3>Categories</h3>
            <ul class="sidebar-menu">
                <li><a href="admin_dashboard.php">All Complaints</a></li>
                <?php foreach ($categories as $category): ?>
                    <li><a href="admin_dashboard.php?category=<?= urlencode($category['category']) ?>">
                        <?= ucfirst($category['category']) ?>
                    </a></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="main-content">
            <h2>Complaint Management</h2>
            <table class="complaints-table">
                <thead>
                    <tr>
                        <th>ID</th><th>User</th><th>Title</th><th>Category</th><th>Status</th><th>Date</th><th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): 
                        if (isset($_GET['category']) && $_GET['category'] !== $row['category']) continue;
                    ?>
                    <tr>
                        <td><?= $row['complaint_id'] ?></td>
                        <td><?= htmlspecialchars($row['user_name']) ?></td>
                        <td><?= htmlspecialchars($row['title']) ?></td>
                        <td><?= ucfirst($row['category']) ?></td>
                        <td><span class="status-badge status-<?= $row['status'] ?>">
                            <?= ucwords(str_replace('_', ' ', $row['status'])) ?>
                        </span></td>
                        <td><?= date('M d, Y', strtotime($row['created_at'])) ?></td>
                        <td>
                <a class="action-btn edit-btn" href="update_complaint.php?id=<?= $row['complaint_id'] ?>">Edit</a>
                            <a class="action-btn in-progress-btn" href="update_status.php?id=<?= $row['complaint_id'] ?>&status=in_progress">In Progress</a>
                            <a class="action-btn resolve-btn" href="update_status.php?id=<?= $row['complaint_id'] ?>&status=resolved">Resolve</a>
                            <a class="action-btn reject-btn" href="update_status.php?id=<?= $row['complaint_id'] ?>&status=rejected">Reject</a>
                            <a class="action-btn delete-btn" href="delete_complaint.php?id=<?= $row['complaint_id'] ?>" onclick="return confirm('Delete complaint #<?= $row['complaint_id'] ?>?')">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
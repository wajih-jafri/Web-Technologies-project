<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../index.php");
    exit();
}

$name = $_SESSION["name"] ?? 'User';
$user_type = $_SESSION["user_type"] ?? 'user';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Check Complaint Status</title>
    <link rel="stylesheet" href="../assets/css/project.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
</head>
<body>
   <?php 
   $page = 'status';
require_once '../includes/navbar.php' ?>

    <div style="padding: 20px; font-size: 18px;">
         Welcome, <strong><?php echo htmlspecialchars($name); ?></strong> 
        (<?php echo ucfirst($user_type); ?>)
    </div>

    <div class="simple-status-container">
        <h2>Check Your Complaint Status</h2>
        
        <form method="get" action="check_status.php">
            <div class="simple-form-group">
                <input type="text" name="id" placeholder="Enter your Complaint ID" required>
                <button type="submit">Check</button>
            </div>
        </form>

        <div id="status-result">
            <?php if(isset($_GET['id']) && empty($_GET['id'])): ?>
                <p class="error">Please enter a complaint ID</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Simple AJAX to load status without page refresh
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            fetch('check_status.php?' + new URLSearchParams(formData))
                .then(response => response.text())
                .then(html => {
                    document.getElementById('status-result').innerHTML = html;
                });
        });
    </script>
</body>
</html>
<?php  ?>
<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/project.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- JS Function -->
<script>
function requireLogin() {
  Swal.fire({
    icon: 'info',
    title: 'Login Required',
    text: 'You have to login first to access the admin site.',
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'OK'
  });
}


</script>

</head>
<body>
    <nav class="navbar">
        <div class="navbar_logo">
            <img src="../assets/img/FUSST_Logo.jpg" alt="FUSST Logo" />
        </div>
        <div class="navbar-links">
            <button class="statusButton" onclick="requireLogin()">
                <i class="fas fa-check-circle"></i> Admin Portal
            </button>
        </div>
    </nav>

    <div class="container">
        <div class="section" id="welcomeSection">
            <h1>Welcome to FUSST Admin Portal</h1>
            <h4>Login to access the Portal!</h4>
            <div class="loginButtons">
                <button onclick="openModal('adminModal')" class="admin-login-btn">
                    <i class="fas fa-lock"></i> ADMIN LOGIN
                </button>
            </div>
        </div>
    </div>

    <div id="adminModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('adminModal')">&times;</span>
            <h2>Admin Login</h2>
            <form action="admin_login.php" method="POST">
                <input type="text" name="username" placeholder="Admin username" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="hidden" name="user_type" value="admin" />
                <button type="submit" class="login-submit">Login</button>
            </form>
            <?php
            if (isset($_GET['error'])) {
                echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'error',
                title: 'Login Failed',
                text: 'Invalid username or password! ',
                confirmButtonColor: '#3085d6'
            }).then(() => {
                window.history.back();
            });
        });
    </script>";
            }
            ?>
        </div>
    </div>

    

    <script>
        function openModal(id) {
            document.getElementById(id).style.display = "block";
        }
        function closeModal(id) {
            document.getElementById(id).style.display = "none";
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    
    </script>
</body>
</html>

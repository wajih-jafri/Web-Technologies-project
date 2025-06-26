<?php
?>
<!DOCTYPE html>
<html>
<head>
    <title>FUSST Complaint Portal</title>
    <link rel="stylesheet" href="project.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- SweetAlert2 CDN for pop up message at pressing buttons as guest  -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- JS Function -->
<script>
function requireLogin() {
  Swal.fire({
    icon: 'info',
    title: 'Login Required',
    text: 'You have to login first to check complaint status.',
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'OK'
  });
}

function requireLoginComplaint() {
  Swal.fire({
    icon: 'info',
    title: 'Login Required',
    text: 'You have to login first to register your complaint.',
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'OK'
  });
}
</script>
</head>

<body>
    <nav class="navbar">
        <div class="navbar_logo">
        <img src="/iwt_semester_project_structured/assets/img/FUSST_Logo.jpg" alt="FUSST Logo" onclick="window.location.href='/iwt_semester_project_structured../logout.php'">
        </div>
        <div class="navbar-links">
             <?php if (isset($_SESSION['user_id'])): ?>  <!-- checking user logged in  -->
        <!-- Logged-in user -->
        <?php if ($page === 'complaint_form'): ?>
            <button class="statusButton" onclick="window.location.href='status.php'"> 
                <i class="fas fa-check-circle"></i> COMPLAINT STATUS
            </button>
        <?php elseif ($page === 'status'): ?>
            <button class="registerButton" onclick="window.location.href='complaint_form.php'"> 
                <i class="fas fa-edit"></i> REGISTER COMPLAINT
            </button>
        <?php endif; ?>

        <button class="logout-btn" onclick="window.location.href='../logout.php'">
            <i class="fas fa-sign-out-alt"></i> LOGOUT
        </button>
    <?php else: ?>
                <!-- Guest user -->
                <button class="registerButton" onclick="requireLoginComplaint()"> 
                    <i class="fas fa-edit"></i> REGISTER COMPLAINT
                </button>
                <button class="statusButton" onclick="requireLogin()">
                    <i class="fas fa-check-circle"></i> COMPLAINT STATUS
                </button>
            <?php endif; ?>
        </div>
    </nav>

    <!-- Modal HTML -->
<div id="loginModal" class="modal">
  <div class="modal-content">
    <span class="close-btn" onclick="closeModal('loginModal')">&times;</span>
    <p>You must login first to check the complaint status.</p>
  </div>
</div>


    <script>
    // Modal functions used in index.html
    function openModal(id) {
        document.getElementById(id).style.display = "block";
    }
    function closeModal(id) {
        document.getElementById(id).style.display = "none";
    }
    </script>
</body>
</html>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FUSST Complaint Portal</title>
    <link rel="stylesheet" href="assets/css/project.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <?php require_once 'includes/navbar.php'; ?>

    <div class="container">
        <div class="section" id="welcomeSection">
            <h1>Welcome to FUSST Complaint Portal</h1>
            <h4>Login to Register your Complaint!</h4>
            <div class="loginButtons">
                <button onclick="openModal('studentModal')">
                    <i class="fas fa-user-graduate"></i> LOGIN AS STUDENT
                </button>
                <button onclick="openModal('employeeModal')">
                    <i class="fas fa-user-tie"></i> LOGIN AS EMPLOYEE
                </button>
            </div>
        </div>
    </div>

    <!-- Student Login Modal without action and method-->
    <div id="studentModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('studentModal')">&times;</span>
            <h2>Student Login</h2>
            <form action="login.php" method="POST" >
                <input type="text" name="username" placeholder="Student username" required />
                <input type="password" name="password" placeholder="Password" required />
                <input type="hidden" name="user_type" value="student" />
                <button type="submit" class="login-submit">Login</button>
            </form>
            
        </div>
    </div>

    <!-- Employee Login Modal without action and method -->
    <div id="employeeModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('employeeModal')">&times;</span>
            <h2>Employee Login</h2>
            <form action="login.php" method="POST">
                <input type="text" name="username" placeholder="Employee username" required />
                <input type="password" name="password" placeholder="Password" required />
                <input type="hidden" name="user_type" value="employee" />
                <button type="submit" class="login-submit">Login</button>
            </form>
        </div>
    </div>

    <script>
    window.onclick = function(event) {
        const student = document.getElementById('studentModal');
        const employee = document.getElementById('employeeModal');
        if (event.target === student) student.style.display = "none";
        if (event.target === employee) employee.style.display = "none";
    }
    </script>
</body>
</html>
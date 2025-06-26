<?php
session_start();
require_once 'includes/db_connection.php';


function showError($message) {
      echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'error',
                title: 'Login Failed',
                text: '$message',
                confirmButtonColor: '#3085d6'
            }).then(() => {
                window.history.back();
            });
        });
    </script>";
    exit();
}


if($_SERVER['REQUEST_METHOD'] == 'POST') {
      $username = trim($_POST['username']);
      $password = trim($_POST['password']);
      $user_type = trim($_POST['user_type']);

      if(empty($username) || empty($password) || empty($user_type)){
       die("All Fields are Required!");
      }

      $sql = "SELECT id,name,username ,password,user_type FROM users WHERE username = ? AND user_type = ?";
      $stmt = $conn->prepare($sql);

   if(!$stmt){
    die("Prepare failed!" . $conn->error);
   }

      $stmt->bind_param("ss", $username , $user_type);
      $stmt->execute();
      $result = $stmt->get_result();

   if($result->num_rows > 0){
   $row = $result->fetch_assoc();


         if(password_verify($password , $row["password"])){
              $_SESSION["user_id"] = $row["id"];
              $_SESSION["username"] = $row["username"];
              $_SESSION["user_type"] = $row["user_type"];
              $_SESSION["name"] = $row["name"];

              if($row["user_type"] == 'admin'){
                 header("Location: admin/admin_dashboard.php");
              }else{
                 header("Location: user/complaint_form.php");
              }
         exit();
         }
         else{
             showError("Invalid username or password.");
         } 
   }else{
   showError("No Matching Account Found!");
   }


  $stmt->close();

}

$conn->close();
?>
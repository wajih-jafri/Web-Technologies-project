<?php
session_start();
 if(!isset($_SESSION["username"])) {
    header("Location: ../index.php");
    exit();
 }

 // Get user info from session
 $name = $_SESSION["name"] ?? 'User'; //says user if not set
 $user_type = $_SESSION["user_type"] ?? 'user'; //says user if not set
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Form</title>
    <link rel="stylesheet" href="../assets/css/project.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
   
   <style>
    .form-group small {
  color: #777;
  font-size: 13px;
  display: block;
  margin-top: 4px;
}

   </style>
</head>


<body>
   <?php
   $page = 'complaint_form';
 require_once '../includes/navbar.php' ?>

    <div style="padding: 20px; font-size: 18px;">
         Welcome, <strong><?php echo htmlspecialchars($name); ?></strong> 
        (<?php echo ucfirst($user_type); ?>)
    </div>                                                

      <?php 
// Place this RIGHT AFTER your submit button in complaint_form.php
if (isset($_SESSION['submission_message'])) {
    echo <<<HTML
    <div class="submission-message">
        <p>{$_SESSION['submission_message']}</p>
        <small>Use this ID to track your complaint status</small>
    </div>
HTML;
    unset($_SESSION['submission_message']);
}
?>                                                        

    
<div id="complaintForm" >
  <div class="form-wrapper">
    <h2>Complaint Registration Form</h2>
    <p class="form-subtext">
      All fields marked with <span class="required">*</span> are mandatory.
    </p>

    <form method="POST" action="submit_complaint.php" enctype="multipart/form-data" >
  <!-- Row 1: Complaint Category, Department/Location, Title -->
  <div class="form-row">
    <div class="form-group">
      <label>Complaint Category <span class="required">*</span></label>
      <select name="category" required>
        <option value="">Select Option</option>
        <option value="internet">Internet</option>
        <option value="behavior">Behavior</option>
        <option value="electricity">Electricity</option>
      </select>
    </div>
    <div class="form-group">
      <label>Location / Department <span class="required">*</span></label>
      <input type="text" name="location" placeholder="Admin Block, Hostel, Library, Lab 3" required />
    </div>
    <div class="form-group">
      <label>Complaint Title / Subject <span class="required">*</span></label>
      <input type="text" name="title" placeholder="Wi-Fi Not Working in Lab 3" required />
    </div>
  </div>

  <!-- Row 2: Priority, Mobile Number, Date -->
  <div class="form-row">
    <div class="form-group">
      <label>Priority Level</label>
      <select name="priority">
        <option value="medium">Medium</option>
        <option value="low">Low</option>
        <option value="high">High</option>
      </select>
    </div>
    <div class="form-group">
      <label>Mobile Number <span class="required">*</span></label>
      <input type="text" name="mobile"  placeholder="03001234567" pattern="[0-9]{11}" title="11-digit phone number" required>
    </div>
    <div class="form-group">
      <label>Date of Incident</label>
      <input type="date" name="incident_date" />
    </div>
  </div>

  <!-- Row 3: File Upload, Gender -->
 <div class="form-row">
  <div class="form-group">
    <label>Upload Screenshot / File (Optional)</label>
    <input type="file" name="attachment" id="attachment" accept=".jpg,.jpeg,.png,.pdf" />
    <small id="fileError" style="color: red; font-size: 13px;"></small>
    <small style="color: #555; font-size: 13px; display: block; margin-top: 4px;">
      Allowed formats: JPG, JPEG, PNG, PDF only. Max size: 5MB.
    </small>
  </div>

  <div class="form-group">
    <label>Gender <span class="required">*</span></label>
    <select name="gender" required>
      <option value="">Select Option</option>
      <option value="male">Male</option>
      <option value="female">Female</option>
      <option value="other">Other</option>
    </select>
  </div>
</div>


  <!-- Row 4: Description -->
  <div class="form-row">
    <div class="form-group full-width">
      <label>Complaint Description <span class="required">*</span></label>
      <textarea name="description"
        style="height: 100px; resize: none; padding: 10px;"
        placeholder="Enter your complaint description here"
        required></textarea>
    </div>
  </div>

 

      <!-- Submit Button -->
      <div class="form-row">
        <button type="submit" class="submit-btn">Submit Complaint</button>
      </div>
     
    </form>
  </div>
</div>

</div>
</body>
<script>
  document.querySelector("form").addEventListener("submit", function (e) {
    const fileInput = document.getElementById("attachment");
    const errorText = document.getElementById("fileError");
    errorText.textContent = ""; 

    const allowedTypes = ["image/jpeg", "image/jpg", "image/png", "application/pdf"];
    const maxSize = 5 * 1024 * 1024; 
    if (fileInput.files.length > 0) {
      const file = fileInput.files[0];

      // Check file type
      if (!allowedTypes.includes(file.type)) {
        errorText.textContent = "Invalid file type. Only JPG, JPEG, PNG, and PDF are allowed.";
        e.preventDefault(); 
      }

      // Check file size
      if (file.size > maxSize) {
        errorText.textContent = "File size exceeds 5MB limit.";
        e.preventDefault(); 
        return;
      }
    }
  });
</script>
</html>


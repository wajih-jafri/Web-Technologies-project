<?php
session_start();
require_once "../includes/db_connection.php";

if (!isset($_GET['id'])) {
    die("No ID provided");
}

$complaint_id = (int)$_GET['id'];
$user_id = $_SESSION['user_id'] ?? 0;


$sql = "SELECT title, status, created_at FROM complaints 
        WHERE complaint_id = ? AND user_id = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $complaint_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $complaint = $result->fetch_assoc();
    echo '<div class="status-card">
            <h3>'.$complaint['title'].'</h3>
            <p>Status: <span class="status-'.$complaint['status'].'">'
                .ucwords($complaint['status']).
            '</span></p>
            <p>Submitted: '.date('d M Y', strtotime($complaint['created_at'])).'</p>
          </div>';
} else {
    echo '<p class="error">No complaint found with that ID</p>';
}
?>
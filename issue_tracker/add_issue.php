<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $description = $_POST['description'];
    $severity = $_POST['severity'];

    $stmt = $conn->prepare("INSERT INTO tbl_issues (description, severity, status, resolution) VALUES (?, ?, 'Open', '')");
    $stmt->bind_param("ss", $description, $severity);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit();
    } else {
        $error_message = "Failed to add issue";
    }
    $stmt->close();
}
?>

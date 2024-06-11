<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $issue_id = $_GET['id'];

    $sql = "DELETE FROM tbl_issues WHERE issue_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $issue_id);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

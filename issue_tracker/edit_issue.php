<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $issue_id = $_POST['issue_id'];
    $description = $_POST['description'];
    $severity = $_POST['severity'];
    $status = $_POST['status'];
    $resolution = $_POST['resolution'];
    $resolved_by = $_POST['resolved_by'];
    $resolved_date = $_POST['resolved_date'];

    $sql = "UPDATE tbl_issues SET description=?, severity=?, status=?, resolution=?, resolved_by=?, resolved_date=? WHERE issue_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $description, $severity, $status, $resolution, $resolved_by, $resolved_date, $issue_id);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    $issue_id = $_GET['id'];
    $issue = $conn->query("SELECT * FROM tbl_issues WHERE issue_id = $issue_id")->fetch_assoc();
}

$users = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Issue</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Edit Issue</h2>
        <form method="POST">
            <input type="hidden" name="issue_id" value="<?php echo $issue['issue_id']; ?>">
            <label>Description:</label>
            <textarea name="description" required><?php echo $issue['description']; ?></textarea><br>
            <label>Severity:</label>
            <select name="severity" required>
                <option value="Low" <?php if ($issue['severity'] == 'Low') echo 'selected'; ?>>Low</option>
                <option value="Medium" <?php if ($issue['severity'] == 'Medium') echo 'selected'; ?>>Medium</option>
                <option value="High" <?php if ($issue['severity'] == 'High') echo 'selected'; ?>>High</option>
            </select><br>
            <label>Status:</label>
            <select name="status" required>
                <option value="Open" <?php if ($issue['status'] == 'Open') echo 'selected'; ?>>Open</option>
                <option value="In Progress" <?php if ($issue['status'] == 'In Progress') echo 'selected'; ?>>In Progress</option>
                <option value="Closed" <?php if ($issue['status'] == 'Closed') echo 'selected'; ?>>Closed</option>
            </select><br>
            <label>Resolution:</label>
            <textarea name="resolution"><?php echo $issue['resolution']; ?></textarea><br>
            <label>Resolved By:</label>
            <select name="resolved_by">
                <option value="">None</option>
                <?php while ($user = $users->fetch_assoc()): ?>
                <option value="<?php echo $user['id']; ?>" <?php if ($issue['resolved_by'] == $user['email']) echo 'selected'; ?>><?php echo $user['email']; ?></option>
                <?php endwhile; ?>
            </select><br>
            <label>Resolved Date:</label>
            <input type="date" name="resolved_date" value="<?php echo $issue['resolved_date']; ?>"><br>
            <button type="submit">Update</button>
        </form>
        <a href="dashboard.php"><button>Back to Dashboard</button></a>
    </div>
</body>
</html>

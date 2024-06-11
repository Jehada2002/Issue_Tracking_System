<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Query modified to join tbl_issues with users table to get resolved_by email
$issues = $conn->query("SELECT i.*, u.email AS resolved_email 
                        FROM tbl_issues i 
                        LEFT JOIN users u ON i.resolved_by = u.id");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" type="text/css" href="table.css">
</head>
<body>
    <div class="container">
        <h2>Dashboard</h2>
        <div class="header">
            <h3>Report a New Issue</h3>
            <a href="add_issue.html">Add Issue</a>
        </div>

        <h3>All Issues</h3>
        <table>
            <tr>
                <th>Issue ID</th>
                <th>Description</th>
                <th>Severity</th>
                <th>Status</th>
                <th>Resolution</th>
                <th>Resolved By</th>
                <th>Resolved Date</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $issues->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['issue_id']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td><?php echo $row['severity']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td><?php echo $row['resolution']; ?></td>
                <td><?php echo $row['resolved_email']; ?></td>
                <td><?php echo date('Y-m-d H:i:s', strtotime($row['resolved_date'])); ?></td>
                <td>
                    <a href="edit_issue.php?id=<?php echo $row['issue_id']; ?>"><button>Edit</button></a>
                    <a href="delete_issue.php?id=<?php echo $row['issue_id']; ?>" onclick="return confirm('Are you sure?')"><button>Delete</button></a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        <br>
        <div class="header">
        <br><br><a href="logout.php">Logout</a>
        </div>
    </div>
</body>
</html>

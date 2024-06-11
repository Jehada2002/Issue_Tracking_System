CREATE DATABASE issue_tracking;

USE issue_tracking;

-- Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Issues Table
CREATE TABLE tbl_issues (
    issue_id INT AUTO_INCREMENT PRIMARY KEY,
    description TEXT NOT NULL,
    severity ENUM('Low', 'Medium', 'High') NOT NULL,
    status ENUM('Open', 'In Progress', 'Closed') DEFAULT 'Open',
    resolution TEXT,
    resolved_by INT,
    resolved_date TIMESTAMP,
    FOREIGN KEY (resolved_by) REFERENCES users(id)
);

<?php
// Database configuration
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'complaint_db';

// Create connection
$conn = new mysqli($host, $user, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if not exists
$sql = "CREATE DATABASE IF NOT EXISTS $database";
if ($conn->query($sql) === TRUE) {
    // Select database
    $conn->select_db($database);
    
    // Create table if not exists
    $table_sql = "CREATE TABLE IF NOT EXISTS complaints (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        category VARCHAR(50) NOT NULL,
        subject VARCHAR(150) NOT NULL,
        description TEXT NOT NULL,
        status ENUM('Open','Resolved') DEFAULT 'Open',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    if ($conn->query($table_sql) === FALSE) {
        die("Error creating table: " . $conn->error);
    }
    
} else {
    die("Error creating database: " . $conn->error);
}

// Set charset
$conn->set_charset("utf8mb4");
?>
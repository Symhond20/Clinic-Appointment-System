<?php

$server = "localhost";
$user = "root";
$password = "";
$db_name = "clinic_db";
$conn = "";

$conn = mysqli_connect($server, $user, $password, $db_name);

// For checkking the connection 
if ($conn->connect_error){
    die("Connection failed: ". $connect_error);
}

/** Database table 
     * Users
     * specialization -> doctors
     * users -> patients*/ 
     
    $sql = "CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY, 
                username VARCHAR(100) NOT NULL UNIQUE, 
                password VARCHAR(255) NOT NULL,
                role ENUM('admin','patient') NOT NULL DEFAULT 'patient',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";

    $sql = "CREATE TABLE IF NOT EXISTS patients (
                id INT AUTO_INCREMENT PRIMARY KEY, 
                user_id INT NULL, 
                full_name VARCHAR(150) NOT NULL,
                contact_number VARCHAR(50),
                full_address VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            )";

    $sql = "CREATE TABLE IF NOT EXISTS specializations (
                id INT AUTO_INCREMENT PRIMARY KEY, 
                name VARCHAR(150) NOT NULL UNIQUE, 
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
     
    $sql = "CREATE TABLE IF NOT EXISTS doctors (
                id INT AUTO_INCREMENT PRIMARY KEY, 
                full_name VARCHAR(150) NOT NULL UNIQUE, 
                specialization_id INT NULL,
                contact_number VARCHAR(150),
                full_address VARCHAR(150),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (specialization_id) REFERENCES specializations(id) ON DELETE SET NULL
            )";
?>
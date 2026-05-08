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
    // Note!!! remove the comments for the code below to create the tables in the database "//".

    $sql = "CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY, 
                username VARCHAR(100) NOT NULL UNIQUE, 
                password VARCHAR(255) NOT NULL,
                role ENUM('admin','patient') NOT NULL DEFAULT 'patient',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
    //if (mysqli_query($conn, $sql)) {
    //   echo "Table users was successfully created!";
    //} 
    //else {
    //    echo "Error creating table: " . mysqli_error($conn);
    //}
    $sql = "CREATE TABLE IF NOT EXISTS patients (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                full_name VARCHAR(150) NOT NULL UNIQUE, 
                age INT,
                gender ENUM('Male','Female','Other') NOT NULL,
                date_of_birth DATE NOT NULL,
                contact_number VARCHAR(50),
                email VARCHAR(150) UNIQUE,
                address VARCHAR(150),
                medical_history TEXT,
                blood_type VARCHAR(10) NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            )";
         
    //if (mysqli_query($conn, $sql)) {
    //   echo "Table patients was successfully created!";
    //} 
    //else {
    //    echo "Error creating table: " . mysqli_error($conn);
    //}

    $sql = "CREATE TABLE IF NOT EXISTS specializations (
                id INT AUTO_INCREMENT PRIMARY KEY, 
                name VARCHAR(150) NOT NULL UNIQUE, 
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
    //if (mysqli_query($conn, $sql)) {
    //    echo "Table specializations was successfully created!";
    //} 
    //else {
    //     echo "Error creating table: " . mysqli_error($conn);
    //} 
    $sql = "CREATE TABLE IF NOT EXISTS doctors (
                id INT AUTO_INCREMENT PRIMARY KEY, 
                full_name VARCHAR(150) NOT NULL UNIQUE, 
                specialization_id INT NULL,
                contact_number VARCHAR(150),
                full_address VARCHAR(150),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (specialization_id) REFERENCES specializations(id) ON DELETE SET NULL
            )";
    //if (mysqli_query($conn, $sql)) {
    //    echo "Table doctors was successfully created!";
    //} 
    //else {
    //     echo "Error creating table: " . mysqli_error($conn);
    //}

    $sql = "CREATE TABLE IF NOT EXISTS appointments (
                id INT AUTO_INCREMENT PRIMARY KEY, 
                patient_id INT NOT NULL,
                doctor_id INT NOT NULL, 
                appointment_date DATE NOT NULL,
                appointment_time TIME NOT NULL,
                status ENUM('Pending','Confirmed','Completed','Cancelled') NOT NULL DEFAULT 'Pending',
                notes TEXT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
                FOREIGN KEY (doctor_id) REFERENCES doctors(id) ON DELETE CASCADE
            )";
    //if (mysqli_query($conn, $sql)) {
    //    echo "Table appointments was successfully created!";
    //} 
    //else {
    //     echo "Error creating table: " . mysqli_error($conn);
    //}
    $sql = "CREATE TABLE IF NOT EXISTS consultation_records (
                id INT AUTO_INCREMENT PRIMARY KEY,
                appointment_id INT NOT NULL,
                doctor_id INT NOT NULL,
                patient_id INT NOT NULL,
                diagnosis TEXT NOT NULL,
                prescription TEXT,
                treatment_plan TEXT,
                notes TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (appointment_id) REFERENCES appointments(id) ON DELETE CASCADE,
                FOREIGN KEY (doctor_id) REFERENCES doctors(id) ON DELETE CASCADE,
                FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE
            )";
    //if (mysqli_query($conn, $sql)) {
    //    echo "Table consultation_records was successfully created!";
    //} 
    //else {
    //     echo "Error creating table: " . mysqli_error($conn);
    //}

    // This one is  for crating default admin remove all the "//" below so it will execute the insertion.
    //$sql = "INSERT INTO users (username, password, role) VALUES 
    //            ('admin', '" . password_hash("admin123", PASSWORD_DEFAULT) . "', 'admin')
    //            ";
    //    if (mysqli_query($conn, $sql)) {
    //        echo "Admin user was successfully created!";
    //    } 
    //    else {
    //        echo "Error creating admin user: " . mysqli_error($conn);
    //    }   
?>
 
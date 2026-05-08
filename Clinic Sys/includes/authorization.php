<?php

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

require_once __DIR__ . '/../db_conn.php';

function current_user(){
    global $conn;

    if (empty($_SESSION["user_id"])) {
        return null;
    }

    $userId = $_SESSION["user_id"];
    $query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$userId'");

    if ($query && mysqli_num_rows($query) > 0) {
        $result = mysqli_fetch_assoc($query);
        return $result;
    }
    return null;
}

function is_admin() {
    $user = current_user();
    return $user && $user["role"] === "admin";
}

function is_patient() {
    $user = current_user();
    return $user && $user["role"] === "patient";
}

function required_login() {
    if (empty($_SESSION["user_id"])) {
        header("Location: /Clinic Sys/login.php");
    }
}

function required_role($role) {
    required_login();
    $user = current_user();
    if (!$user || $user["role"] !== $role) {
        header("Location: /Clinic Sys/login.php");
        exit;
    }
}

function patient_profile($user_id) {
    global $conn;

    if (empty($_SESSION["user_id"])) {
        return null;
    }

    $userId = $_SESSION["user_id"];
    $query = mysqli_query($conn, "SELECT * FROM patients WHERE user_id = $userId");

    if ($query && mysqli_num_rows($query) > 0) {
        $result = mysqli_fetch_assoc($query);
        return $result;
    }
    return null;
}
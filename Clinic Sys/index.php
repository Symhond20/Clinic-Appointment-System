<?php

// Itong page nato yuung nag ma-manage ng redirections after logging in.

require_once __DIR__ . "/includes/authorization.php";


// if no one logged in or the user_id is missing, it will go back to the login page.
if (empty($_SESSION["user_id"])) {
    header("Location: /Clinic Sys/login.php");
    exit;
}

// Retrieves the logged in user's details (like yung role) from the db.
$user = current_user();

// If the user is the admin they will be redirected to the admin page
if ($user["role"] === "admin") {
    header("Location: /Clinic Sys/for_admin/doctor.php");
    exit;
}

// and if not they will be redirected to the patient page
if ($user["role"] === "patient") {
    header("Location: /Clinic Sys/for_patient/booking.php");
    exit;
}

// Pangsalo lang to if my error na nag occur, or not existing yung role
header("Location: /Clinic Sys/login.php");

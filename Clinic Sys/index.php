<?php

require_once __DIR__ . "/includes/authorization.php";

if (empty($_SESSION["user_id"])) {
    header("Location: /Clinic Sys/login.php");
    exit;
}

$user = current_user();
if ($user["role"] === "admin") {
    header("Location: /Clinic Sys/for_admin/doctor.php");
    exit;
}

if ($user["role"] === "patient") {
    header("Location: /Clinic Sys/for_patient/booking.php");
    exit;
}

header("Location: /Clinic Sys/login.php");

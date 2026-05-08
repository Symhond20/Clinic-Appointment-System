<?php

require_once __DIR__ . '/../includes/authorization.php';
required_role("patient");

$success = null;
$error = null;

$profile = patient_profile($_SESSION["user_id"]);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $doctor_id = $_POST["doctor_id"] ?? null;
    $appointment_date = $_POST["appointment_date"] ?? '';
    $appointment_time = $_POST["appointment_time"] ?? '';
    $consultation_notes = $_POST["consultation_notes"] ?? '';

    // Validation
    if (!$doctor_id || !$appointment_date || !$appointment_time) {
        $error = "Please fill in required fields";
    }
    else {
        $sql = "SELECT id FROM appointments WHERE doctor_id = $doctor_id AND appointment_date = '$appointment_date' AND appointment_time = '$appointment_time'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0){    
            $error = "This doctor already has an appointment at the selected date and time.";
        }
        else {
            $sql = "INSERT INTO appointments 
                        (patient_id, doctor_id, appointment_date, appointment_time, status, notes)
                    VALUES ('{$profile['id']}', '$doctor_id', '$appointment_date', '$appointment_time', 'Pending', '$consultation_notes')";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $docRes = mysqli_query($conn, "SELECT full_name FROM doctors WHERE id = $doctor_id");
                $docRow = mysqli_fetch_assoc($docRes);
                $success = "Appointment booked with Dr. {$docRow['full_name']} on $appointment_date at $appointment_time.";
            }
            else {
                $error = "Booking appointment failed: " . mysqli_error($conn);
            }
        }
    }
}
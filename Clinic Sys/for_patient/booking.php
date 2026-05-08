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

?>
<!DOCTYPE html>
<html lang="en">
    <head> 
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Book Appointment </title>
    </head>

<body>
    <?php include __DIR__ . '/../includes/header.php'?> 
    <div class="card">
        <h2> Book Appointment </h2>

            <?php if ($error) { ?>
                    <div class="error-box"> 
                        <?= htmlspecialchars($error); ?>
                    </div>
            <?php } ?>

            <?php if ($success) { ?>
                <div class="success-box"> 
                    <?= htmlspecialchars($success); ?> 
                </div>
            <?php } ?>

        <form action="" method="post">
            <label> Doctor* </label>
            <select name="doctor_id" required>
                <option value=""> Select a Doctor </option>
                <?php 
                    $sql = "SELECT * FROM doctors ORDER BY full_name";
                    $result = mysqli_query($conn, $sql);

                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <option value="<?php echo $row["id"]; ?>"
                            <?php if (!empty($editing['doctor_id']) && 
                                      $editing['doctor_id'] == $row['id']) echo 'selected'; ?>>
                            <?php echo $row['full_name'];?> 
                        </option>
                <?php } ?>
            </select>

            <label> Appointment Date* </label>
            <input type="date" name="appointment_date" value="<?= htmlspecialchars($_POST['appintment_date'] ?? '') ?>" required>

            <label> Appointment Time* </label>
            <input type="time" name="appointment_time" value="<?= htmlspecialchars($_POST['appintment_time'] ?? '') ?>" required>

            <label> Reasons* </label>
            <textarea id="notes" name="consultation_notes" rows="3" cols="40" placeholder="E.g. Heart Problem"></textarea>

            <button type="submit" class="add_btn"> Confirm Booking </button>
        </form>
    </div>
</body>
</html>
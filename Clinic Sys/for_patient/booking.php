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

        <form action="" method="post">

            <label> Full Name </label>
            <input type="text" name="full_name" value="" required>

            <label> Contact Number </label>
            <input type="text" name="contact_number" value="" required>

            <label> Doctor </label>
            <select name="doctor_id" required>
                <option value=""> Select a Doctor </option>
                <?php 
                    // To get every column in every row to display to the table
                    $sql = "SELECT * FROM doctors ORDER BY name";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <option value="<?php echo $row["id"]; ?>"
                            <?php if (!empty($editing['doctor_id']) && 
                                      $editing['doctor_id'] == $row['id']) echo 'selected'; ?>>
                            <?php echo $row['name'];?> 
                        </option>
                <?php } ?>

            </select>

            <label> Appointment Date </label>
            <input type="date" name="appointment_date" value="" required>

            <label> Appointment Time </label>
            <input type="time" name="appointment_time" value="" required>



            <button type="submit" class="add_btn"> Request Appointment </button>
        </form>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
    <head> 
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Appoinments Page </title>
    </head>
<body>
    <?php include __DIR__ . '/../includes/header.php'?> 

    <div class="card">
        <h2> Appointments </h2>
        <table>
            <tr>
                <th> Date/Time </th>
                <th> Patient </th>
                <th> Doctor </th>
                <th> Reason </th>
                <th> Status </th>
                <th> Actions </th>
            </tr>
            <?php 
            // To get every column in every row to display to the table
                $sql = "SELECT 
                            a.appointment_date,
                            a.appointment_time,
                            p.full_name AS patient_name,
                            d.full_name AS doctor_name,
                            a.notes AS reason,
                            a.status
                        FROM appointments a
                        JOIN patients p ON a.patient_id = p.id
                        JOIN doctors d ON a.doctor_id = d.id
                        ORDER BY a.appointment_date, a.appointment_time";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    $specializations
            ?>
                <tr>
                    <td> <?= date("F j, Y", strtotime($row["appointment_date"])) ?> <br> <?= date("g:i A", strtotime($row["appointment_time"])) ?></td>
                    <td> <?php echo $row["patient_name"] ?> </td>
                    <td> <?php echo $row["doctor_name"] ?> </td>
                    <td> <?php echo $row["reason"] ?> </td>
                    <td> <?php echo $row["status"] ?> </td>

                    <td> 
                        <div class="actions">
                            
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
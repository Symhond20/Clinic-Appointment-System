<?php

// Problem: The program crashes when I enter the same name but different specialization

require_once __DIR__ . '/../includes/authorization.php';
required_role("admin");

$success = null;
$error = null;

if (isset($_POST["submit"])) {
    $full_name = $_POST['full_name'] ?? '';
    $specialization_id = $_POST['specialization_id'] ?? null;
    $contact_number = $_POST['contact_number'] ?? '';
    $full_address = $_POST['address'] ?? '';

    if (!empty($full_name) && $specialization_id) {
        if (!empty($_POST["doctor_id"])) {
            $doctor_id = $_POST['doctor_id'];
    
            $sql = "UPDATE doctors
                    SET full_name = '$full_name', 
                        specialization_id = $specialization_id,
                        contact_number = '$contact_number',
                        full_address = '$full_address'
                    WHERE id = $doctor_id";
            if (mysqli_query($conn, $sql)) {
                header('Location: /Clinic Sys/for_admin/doctor.php');
            }
            else {
                $error = "Error updating doctor";
            }
        }
        else {
         // For insering 
            $duplicate = mysqli_query($conn, "SELECT * FROM doctors WHERE full_name = '$full_name' AND specialization_id = $specialization_id");
            if (mysqli_num_rows($duplicate) > 0) {
                $error = "Doctor already exits.";
            }
            else {
                $sql = "INSERT INTO doctors (full_name, specialization_id, contact_number, full_address)
                        VALUES ('$full_name', $specialization_id, '$contact_number', '$full_address')";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    $success = "Doctor is added";
                }
                else {
                    $error = "Adding a new doctor failed.";
                }
            }
        }
    }

}

// for delete
if (!empty($_POST["delete_id"])) {
    $doctorID = $_POST["delete_id"];
    $sql = "DELETE FROM doctors WHERE id = $doctorID";
    if (mysqli_query($conn, $sql)) {
            $success = "Doctor deleted successfully.";
    }
    else {
        $error = "Error deleting doctor";
    }
}

// Loads the input field when you click edit
$editing = null;
if (isset($_GET["edit"])) {
    $doctorID = $_GET["edit"];

    $sql = "SELECT * FROM doctors WHERE id = $doctorID LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0){
        $editing = mysqli_fetch_assoc($result); 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head> 
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Doctor Management </title>
    </head>

<body>
    <?php include __DIR__ . '/../includes/header.php'?> 

    <div class="card">
        <h2> Add Doctor </h2>
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
            <?php if(isset($editing['id'])) { ?>
                <input type="hidden" name="doctor_id" value="<?php echo $editing['id']; ?>"> 
            <?php } ?>

            <label> Full Name </label>
            <input type="text" name="full_name" value="<?php echo $editing ? $editing['full_name'] : ''; ?>" required>

            <label> Specialization </label>
            <select name="specialization_id" required>
                <option value=""> Choose Specialization </option>
                <?php 
                    // To get every column in every row to display to the table
                    $sql = "SELECT * FROM specializations ORDER BY name";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <option value="<?php echo $row["id"]; ?>"
                            <?php if (!empty($editing['specialization_id']) && 
                                      $editing['specialization_id'] == $row['id']) echo 'selected'; ?>>
                            <?php echo $row['name'];?> 
                        </option>
                <?php } ?>
            </select>

            <label> Contact Number </label>
            <input type="text" name="contact_number" value="<?php echo $editing ? $editing['contact_number'] : ''; ?>" required>

            <label> Address </label>
            <input type="text" name="address" value="<?php echo $editing ? $editing['full_address'] : ''; ?>" required>

            <button type="submit" name="submit" class="add_btn"><?= $editing ? 'Update' : 'Add Doctor' ?></button>
        </form>
    </div>

    <div class="card">
        <h3> Medical Staff (Doctors) </h3>
        <table>
            <tr>
                <th> ID </th>
                <th> Name </th>
                <th> Specialization </th>
                <th> Contact </th>
                <th> Address </th>
                <th> Actions </th>
            </tr>

            <?php 
            // To get every column in every row to display to the table
                $sql = "SELECT d.id, d.full_name, d.contact_number, d.full_address, s.name AS specialization_name
                        FROM doctors d 
                            LEFT JOIN specializations s 
                            ON d.specialization_id = s.id 
                        ORDER BY d.full_name";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    $specializations
            ?>
                <tr>
                    <td> <?php echo $row["id"] ?> </td>
                    <td> <?php echo $row["full_name"] ?> </td>
                    <td> <?php echo $row["specialization_name"] ?> </td>
                    <td> <?php echo $row["contact_number"] ?> </td>
                    <td> <?php echo $row["full_address"] ?> </td>

                    <td> 
                        <div class="actions">
                            <!--edit-->
                            <a href="?edit=<?php echo $row["id"]; ?>"> Edit </a>

                            <form action="" method="post">
                                 <!--delete-->
                                <input type="hidden" name="delete_id" value="<?php echo $row["id"]; ?>">
                                <button type="submit" class="delete" onclick="return confirm('Delete this specialization?')"> Delete </button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>



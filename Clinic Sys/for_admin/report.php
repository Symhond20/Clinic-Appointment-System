<?php

require_once __DIR__ . '/../includes/authorization.php';
required_role("admin");


$success = null;
$error = null;

$editing =null;
?>

<!DOCTYPE html>
<html lang="en">
    <head> 
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Report Page </title>
    </head>

<body>
    <?php include __DIR__ . '/../includes/header.php'?> 

    <div class="card">
        <h2> Generate Reports </h2>
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



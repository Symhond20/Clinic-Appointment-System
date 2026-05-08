<?php

require_once __DIR__ . '/../includes/authorization.php';
required_role("admin");

$success = null;
$error = null;

if (isset($_POST["submit"])) {
    $name = $_POST["name"] ?? '';

    if (!empty($name)) {
        if (!empty($_POST["specialization_id"])) {
            $id = $_POST['specialization_id'];

    
            $sql = "UPDATE specializations SET name = '$name' WHERE id = $id";
            if (mysqli_query($conn, $sql)) {
                $success = "Specialization updated successfully.";
                header('Location: /Clinic Sys/for_admin/specialization.php');
                exit;
            }
            else {
                $error = "Error updating specialization";
            }
        }
        else {
         // For inserting 
            $duplicate = mysqli_query($conn, "SELECT * FROM specializations WHERE name = '$name'");
            if (mysqli_num_rows($duplicate) > 0) {
                $error = "Specialization already exits.";
            }
            else {
                $sql = "INSERT INTO specializations (name) VALUES ('$name')";
                $result = mysqli_query($conn, $sql);

                if ($result) {
                    $success = "Specialization is added";
                }
                else {
                    $error = "Adding a new specialization failed.";
                }
            }
        }
    }

}

// for delete
if (!empty($_POST["delete_id"])) {
    $specID = $_POST["delete_id"];
    $sql = "DELETE FROM specializations WHERE id = $specID";
    if (mysqli_query($conn, $sql)) {
            $success = "Specialization deleted successfully.";
    }
    else {
        $error = "Error deleting specialization";
    }
}

// Loads the input field when you click edit
$editing = null;
if (isset($_GET["edit"])) {
    $id = $_GET["edit"];

    $sql = "SELECT * FROM specializations WHERE id = $id LIMIT 1";
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
        <title> Specializations Management </title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=close" />
    </head>
<body>
    <?php include __DIR__ . '/../includes/header.php'?> 

    <div class="card">
        <h2> Specialization </h2>
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
                <input type="hidden" name="specialization_id" value="<?php echo $editing['id']; ?>"> 
            <?php } ?>

            <label> Specialization Name </label>
            <input type="text" name="name" value="<?php echo $editing ? $editing['name'] : ''; ?>" required>
            <button type="submit" name="submit" class="add_btn"><?= $editing ? 'Update' : 'Add Specialization' ?></button>
        </form>
    </div>

    <div class="card">
        <h3> Specializations </h3>
        <table>
            <tr>
                <th> ID </th>
                <th> Name </th>
                <th> Doctor </th>
                <th> Actions </th>
            </tr>

            <?php 
            // To get every column in every row to display to the table
                $sql = "SELECT * FROM specializations ORDER BY name";
                $result = mysqli_query($conn, $sql);
                $count_sql ="SELECT s.id, s.name, COUNT(d.id) AS doctor_count 
                            FROM specializations s
                            LEFT JOIN doctors d ON s.id = d.specialization_id 
                            GROUP BY s.id, s.name 
                            ORDER BY s.name";
                $result = mysqli_query($conn, $count_sql);
                while ($row = mysqli_fetch_assoc($result)) {           
            ?>
                <tr>
                    <td> <?php echo $row["id"] ?> </td>
                    <td> <?php echo $row["name"] ?> </td>
                    <td><?php echo $row["doctor_count"]; ?> </td>
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
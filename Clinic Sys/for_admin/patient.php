<?php

require_once __DIR__ . '/../includes/authorization.php';
required_role("admin");

?>

<!DOCTYPE html>
<html lang="en">
    <head> 
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Patient Management </title>
        
    </head>

<body>
    <?php include __DIR__ . '/../includes/header.php'?> 

    <div class="card">
        <h3> Patients </h3>
        <table>
            <tr>
                <th> Patient ID </th>
                <th> Full Name </th>
                <th> Age</th>
                <th> Gender </th>
                <th> Contact Number </th>
                <th> Blood Type </th>
                <th> Actions </th>
            </tr>
            <?php 
            // To get every column in every row to display to the table
                $sql = "SELECT * FROM patients ORDER BY full_name";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    $specializations
            ?>
                <tr>
                    <td class="id"> <?php echo $row["id"] ?> </td>
                    <td> <?php echo $row["full_name"] ?> </td>
                    <td> <?php echo $row["age"] ?> </td>
                    <td> <?php echo $row["gender"] ?> </td>
                    <td> <?php echo $row["contact_number"] ?> </td>
                    <td> <?php echo $row["blood_type"] ?> </td>

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



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

        <form action="" method="post" style="margin-bottom: 20px; padding: 15px; border: 1px solid #ddd; border-radius: 5px; background-color: #f9f9f9;">
            <h3> Filter By </h3>
            
            <div style="display: flex; gap: 20px; align-items: center;">
                <label> Doctor </label>
                <select name="doctor_id" required>
                    <option value=""> All Doctors </option>
                </select>

                <label> Specialization </label>
                <select name="specialization" required>
                    <option value=""> All Specialization </option>
                </select>

                <label> Status </label>
                <select name="status" required>
                    <option value=""> All Statuses </option>
                </select>
                
            </div>
       
            <button type="submit"> Apply Filters </button>
   
        </form>
    </div>

    <div class="card">
        <h3> Doctor List </h3>

        <table>
            <tr>
                <th> ID </th>
                <th> Name </th>
                <th> Specialization </th>
                <th> Contact </th>
                <th> Address </th>
                <th> Actions </th>
            </tr>
        </table>
    </div>
</body>
</html>
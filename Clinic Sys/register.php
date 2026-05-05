<?php

require_once __DIR__ . "/includes/authorization.php";

if (!empty($_SESSION["user_id"])) {
    header("Location: /Clinic Sys/index.php");
    exit;
}

$error = null;
$success = null;

if(isset($_POST['submit'])){
    // Grabbiing the data
    $full_name = $_POST["full_name"];
    $contact_number = $_POST["contact_number"];
    $address = $_POST["address"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirm_pass = $_POST["confirm_pass"];

    // Validates the input
    if (empty($full_name) || empty($contact_number) || empty($address) || empty($username) || empty($password) || empty($confirm_pass)){
        $error = "All fields must be filled in.";
    } 
    elseif (strlen($username) < 5) {
        $error = "Username must be at least 5 characters long..";
    }
    elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters long..";
    }

    else{
        // Checks if the username already exists.
        $duplicate = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
        if (mysqli_num_rows($duplicate) > 0) {
            $error = "Username is already taken.";
        }
        else {
            if ($password == $confirm_pass) {
                $hashedPass = password_hash($password, PASSWORD_DEFAULT);

                // Insert into users table
                $userQuery = "INSERT INTO users (username, password, role) VALUES ('$username', '$hashedPass', 'patient')"; 
                        mysqli_query($conn, $userQuery);
                        
                // Get new user id
                $newUser = mysqli_query($conn, "SELECT id FROM users WHERE username = '$username'");
                if ($newUser && mysqli_num_rows($newUser) > 0) {
                    $userResult = mysqli_fetch_assoc($newUser);
                    $userId = $userResult['id'];

                    // Insert into patients table
                    $patientQuery = "INSERT INTO patients (user_id, full_name, contact_number, full_address) VALUES ('$userId', '$full_name', '$contact_number', '$address')"; 
                    mysqli_query($conn, $patientQuery);

                    $success = "Registration successful! You can now login with your credentials.";
                }
                else {
                    $error = "Registration failed. Please try again.";
                }
            }
            else {
                $error = "Password do not match.";
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
        <title> Register Page </title>

        <style>
            *{
                margin: 0;
                padding: 0;
            }
            body{
                background: #f4f7fb;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                color: #333;
            }
            .container{
                margin: 0 15px;
            }
            .form-box{
                width: 450px;
                max-width: 500px;
                background: #fff;
                box-shadow: 0 20px 35px rgba(0,0,0,0.1);
                border-radius: 8px;
                padding: 30px;
            }
            .form-box.active{
                display: block;
            }
            h2{
                font-family: 'Poppins', sans-serif;
                font-size: 40px;
                text-align: center;
                margin-bottom: 25px;
            }
            p{
                font-size: 14px;
                text-align: center;
                margin-bottom: 10px 0;
                font-family: 'Poppins', sans-serif;
            }
            p a{
                color: #7494ec;
                text-decoration: none;
            }
            p a:hover{
                text-decoration: underline;
            }
            label{
                display: block;
                margin-top: 15px;
                font-family: 'Poppins', sans-serif;
                font-weight: 600;   
            }
            input, select{
                width: 100%;
                padding: 10px;
                margin-top: 10px;
                border: 1px solid #c4c8d5;
                border-radius: 5px;
                box-sizing: border-box;
            }
            button{
                width: 100%;
                padding: 12px;
                font-size: 15px;
                color: #fff;
                font-weight: 550;
                border: none;
                border-radius: 10px; 
                background: #3871c1;
                transition: 0.3s;
                margin: 20px 0;
            }
            button:hover{
                background: #00adef; 
            }

            .error-box{
                background: #ffe9e9;
                color: #8b0000;
                font-size: 17px;
                text-align: center;
                padding: 10px 14px;
                border-radius: 4px;
                margin-bottom: 14px;
            }

            .success-box{
                background: #e9ffe9;
                color: #008b00;
                font-size: 17px;
                text-align: center;
                padding: 10px 14px;
                border-radius: 4px;
                margin-bottom: 14px;
            }
        </style>

    </head>
<body>
    <div class="container">
        <!-- For the Register Form -->
        <div class="form-box" id="register-form">
            <h2> Register as a Patient </h2>

                <?php if ($error) { ?>
                    <div class="error-box"> <?= htmlspecialchars($error); ?> </div>
                <?php } ?>

                <?php if ($success) { ?>
                    <div class="success-box"> <?= htmlspecialchars($success); ?> </div>
                    <p style="text-align: center; margin-top: 20px;">
                        <a href="/Clinic Sys/login.php" style="color: #007bff; text-decoration: none;"> Go to Login </a>

                <?php } else { ?>

                    <form action="" method="post">

                        <label> Full name </label>
                        <input type="text" name="full_name" required>

                        <label> Contact Number </label>
                        <input type="text" name="contact_number" required>

                        <label> Address </label>
                        <input type="text" name="address" required>

                        <label> Username </label>
                        <input type="text" name="username" required>

                        <label> Password </label>
                        <input type="password" name="password" required>

                        <label> Confirm Password  </label>
                        <input type="password" name="confirm_pass">

                        <button type="submit" name="submit"> Register </button>
                        
                        <hr style="margin: 30px 0; border: none; border-top: 1px solid #ddd;">
                        <p> Already have an account? <a href="login.php"> Login here </a></p>
                    </form>
                <?php } ?>
        </div>

    </div>    
</body>
</html>
    
    
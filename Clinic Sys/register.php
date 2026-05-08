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
    $age = $_POST["age"];
    $gender = $_POST["gender"];
    $dob = $_POST["dob"];
    $contact_number = $_POST["contact_number"];
    $email = $_POST["email"];
    $address = $_POST["address"];
    $blood_type = $_POST["blood_type"];
    $nmedical_history = $_POST["medical_history"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirm_pass = $_POST["confirm_pass"];

    // Validates the input
    if (empty($full_name) || empty($contact_number) || empty($email) || empty($blood_type) || 
        empty($username) || empty($password) || empty($confirm_pass)){
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
                $userQuery = "INSERT INTO users (username, password) VALUES ('$username', '$hashedPass')"; 
                        mysqli_query($conn, $userQuery);
                        
                // Get new user id
                $newUser = mysqli_query($conn, "SELECT id FROM users WHERE username = '$username'");
                if ($newUser && mysqli_num_rows($newUser) > 0) {
                    $userResult = mysqli_fetch_assoc($newUser);
                    $userId = $userResult['id'];

                    // Insert into patients table
                    $patientQuery = "INSERT INTO patients 
                                        (user_id, full_name, age, gender, date_of_birth, contact_number, email, address, medical_history, blood_type) 
                                    VALUES ('$userId', '$full_name', $age, '$gender', '$dob', '$contact_number', '$email', '$address', '$nmedical_history', '$blood_type')"; 
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
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
            text-decoration: none;
            }
            body {
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
                background: #e8e8e8;
            }
            .container {
                position: relative;
                max-width: 700px;
                width: 100%;
                background: #fff;
                padding: 25px;
                border-radius: 8px;
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            }
            .container h2 {
                font-size: 1.5rem;
                color: #333;
                font-weight: 500;
                text-align: center;
            }
            .container p {
                text-align: center;
                font-size: 0.95rem;
                color: #555;
            }
            .container p a:hover {
                text-decoration: underline;
            }
            .container .register-form {
                margin-top: 30px;
            }
            .register-form .input-box {
                width: 100%;
                margin-top: 20px;
            }
            .register-form :where(.input-box input, .select-box, textarea) {
                position: relative;
                height: 50px;
                width: 100%;
                outline: none;
                font-size: 1rem;
                color: #707070;
                margin-top: 8px;
                border: 1px solid #ddd;
                border-radius: 6px;
                padding: 0 15px;
            }
            textarea {
                height: auto;
                resize: vertical;
                padding: 10px;
            }
            .register-form .column {
                display: flex;
                column-gap: 15px;
            }
            .register-form .gender-sec{
                margin-top: 20px;
            }
            .gender-sec h3 {
                color: #333;
                font-size: 1rem;
                font-weight: 400;
                margin-bottom: 8px;
            }
            .register-form :where(.options, .gender) {
                display: flex;
                align-items: center;
                column-gap: 50px;
                flex-wrap: wrap;
            }
            .register-form .gender {
                column-gap: 5px;
            }
            .gender-sec input {
                accent-color: rgb(130, 106, 251);
            }
            .register-form :where(.gender input, .gender label) {
                cursor: pointer;
            }
            .gender-sec label {
                color: #707070;
            }
            .register-form button {
                height: 55px;
                width: 100%;
                color: #fff;
                font-size: 16px;
                font-weight: 400;
                margin: 30px 0;
                border: none;
                border-radius: 5px;
                background: #1a73e8;
                transition: all 0.2s ease;
            }
            .register-form button:hover {
                background: #00adef;
                cursor: pointer;
            }

            .error-box {
                background: #ffe9e9;
                color: #8b0000;
                font-size: 17px;
                font-family: 'Poppins', sans-serif;
                text-align: center;
                padding: 20px 14px;
                border-radius: 4px;
                margin-bottom: 14px;
            }
            .success-box{
                background: #e9ffe9;
                color: #008b00;
                font-size: 17px;
                font-family: 'Poppins', sans-serif;
                text-align: center;
                padding: 20px 14px;
                border-radius: 4px;
                margin-bottom: 14px;           
            }
            .error-box {
                background: #ffe9e9;
                color: #8b0000;
                font-size: 17px;
                font-family: 'Poppins', sans-serif;
                text-align: center;
                padding: 10px 14px;
                border-radius: 4px;
                margin-bottom: 14px;
            }
            .success-box{
                background: #e9ffe9;
                color: #008b00;
                font-size: 17px;
                font-family: 'Poppins', sans-serif;
                text-align: center;
                padding: 10px 14px;
                border-radius: 4px;
                margin-bottom: 14px;           
            }
                    
            @media screen and (max-width: 500px) {
                .register-form .column {
                    flex-wrap: wrap;
                }
                .form :where(.gender-option, .gender) {
                    row-gap: 15px;
                }
            }
        </style>
    </head>
<body>
    <div class="container">
        <h2> Patient Registration Form</h2>

        <?php if ($error) { ?>
            <div class="error-box"> <?= htmlspecialchars($error); ?> </div>
        <?php } ?>

        <?php if ($success) { ?>
            <div class="success-box"> <?= htmlspecialchars($success); ?> </div>
            <p style="text-align: center; margin-top: 20px;">
            <a href="/Clinic Sys/login.php" style="color: #007bff; text-decoration: none;"> Go to Login </a>
        <?php } else { ?>
            
            <form action="" class="register-form" method="post">

                <div class="input-box">
                    <label> Full Name </label>
                    <input type="text" name="full_name"  placeholder="Enter full name" required/>
                </div>

                <div class="input-box">
                    <label> Address </label>
                    <input type="text" name="address" placeholder="Enter your address" required />
                </div>

                <div class="input-box">
                    <label> Email Address </label>
                    <input type="email" name="email" placeholder="Enter email address" required />
                </div>

                <div class="column">
                    <div class="input-box">
                        <label> Phone </label>
                        <input type="text" name="contact_number" placeholder="Enter contact number" required />
                    </div>

                    <div class="input-box">
                        <label> Age </label>
                        <input type="number" name="age" placeholder="Enter age" required />
                    </div>

                    <div class="input-box">
                        <label> Birth Date </label>
                        <input type="date" name="dob" placeholder="Enter birth date" required />
                    </div>
                </div>

                <div class="gender-sec">
                    <h3> Gender </h3>
                    <div class="options">
                        <div class="gender">
                            <input type="radio" id="male" name="gender" value="Male"  checked />
                            <label> Male </label>
                        </div>
                        <div class="gender">
                            <input type="radio" id="female" name="gender" value= "Female"/>
                            <label> Female </label>
                        </div>
                        <div class="gender">
                            <input type="radio" id="other" name="gender" value="Other"/>
                            <label> Others </label>
                        </div>
                    </div>
                </div>

                <div class="input-box">
                    <label> Blood Type </label>
                    <input type="text" name="blood_type" placeholder="Enter blood type" required />
                </div>

                <div class="input-box">
                    <label> Medical History </label>
                    <textarea rows="3" name="medical_history" placeholder="E.g. Heart Problem"> </textarea>
                </div>

                <div class="user-pass">
                    <div class="input-box">
                        <label> Username </label>
                        <input type="text" name="username" placeholder="Enter username" required />
                    </div>
                    <div class="input-box">
                        <label> Password </label>
                        <input type="password" name="password" placeholder="Enter password" required />
                    </div>
                </div>

                <div class="input-box">
                    <label> Confirm Password </label>
                    <input type="password" name="confirm_pass" placeholder="Confirm password" required />
                </div>

                <button type="submit" name="submit"> Register </button>
                <p> Already have an account? <a href="login.php"> Login </a></p>
            </form>
        <?php } ?>
    </div>
</body>
</html>
    
    
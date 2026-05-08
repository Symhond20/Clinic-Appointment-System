<?php

require_once __DIR__ . "/includes/authorization.php";

if (!empty($_SESSION["user_id"])) {
    header("Location: /Clinic Sys/index.php");
    exit;
}

$error = null;

if(isset($_POST['submit'])){
    // Grabbiing the data
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Looks user by username
    $user = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    if ($user && mysqli_num_rows($user) > 0) {
        $result = mysqli_fetch_assoc($user);
        
        // Password verification
        if ($result && password_verify($password, $result['password'])) {
            $_SESSION["user_id"] = $result["id"];
            // This will access the index.php file, para ma determine which page yung dapat gamitin.
            header("Location: /Clinic Sys/index.php");
            exit;
        }
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Login </title>

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
            .container .login-form {
                margin-top: 30px;
            }
            .login-form .input-box {
                width: 100%;
                margin-top: 20px;
            }
            .login-form :where(.input-box input) {
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
            .login-form button {
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
            .login-form button:hover {
                background: #00adef;
                cursor: pointer;
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
            <h2> Login Form </h2>

            <form action="" method="post" class="login-form">

                <?php if ($error) { ?>
                    <div class="error-box"> <?= htmlspecialchars($error); ?> </div>
                <?php } ?>

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

                <button type="submit" name="submit"> Login </button>
                <p> Don't have an account? <a href="register.php"> Resgister as a Patient </a></p>
            </form>
        </div>

</body>
</html>
    
    

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
            header("LOcation: /Clinic Sys/index.php");
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
                margin-bottom: 14px
            }
        </style>

    </head>
<body>
    <div class="container">
        <!-- For the Login Form -->
        <div class="form-box active" id="login-form">

            <form action="" method="post"> 
                <h2> Login </h2>

                <?php if ($error) { ?>
                    <div class="error-box"> <?= htmlspecialchars($error); ?> </div>
                <?php } ?>

                <label> Username </label>
                <input type="text" name="username" required>

                <label> Password </label>
                <input type="password" name="password" required>

                <button type="submit" name="submit" class="login"> Login </button>

                <hr style="margin: 27px 0; border: none; border-top: 1px solid #ddd;">
                <p> Don't have an account? <a href="register.php"> Register </a></p>

            </form> 
        </div>
    </div>    

</body>
</html>
    
    

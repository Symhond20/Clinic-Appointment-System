<?php

require_once __DIR__ . "/authorization.php";

$user = current_user();

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Header </title>
        <link rel="stylesheet" href="/Clinic Sys/design.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=search" />

    </head>
<body>
    
    <div class="top-nav">
        <div class="page-title">
            <h1>
                <span class="clinic"> Clinic </span>
                    <?php if ($user && $user["role"] === "admin") {?>
                        <span class="admin"> Admin Page</span>
                    <?php } else { ?>
                        <span class="admin"> Patient Page</span>
                    <?php } ?>
            </h1>
            
        </div>

        <div class="right-col">
            <div class="message-search">
                <div class="message">

                    <?php if ($user && $user["role"] === "admin") {?>
                        <h4> Here's your Dashboard Overview</h4>
                    <?php } else { ?>
                        <h4 >Welcome, </h4>
                    <?php } ?>

                </div>

                <div class="search"> 
                    <form class="search-box">
                        <input class="search-input" type="text" placeholder="Seacrh here">
                        <button type="submit" class="search-btn">
                            <span class="material-symbols-outlined">search</span>
                        </button>
    
                    </form>
                </div> 
            </div>

            <div class="nav-page">
                <nav>
                    <?php if ($user && $user["role"] === "admin")  {?>
                        <a href="/Clinic Sys/for_admin/admin_dash.php">Dashboard</a>
                        <a href="/Clinic Sys/for_admin/appointement.php">Appointments </a>
                        <a href="/Clinic Sys/for_admin/doctor.php">Doctors </a>
                        <a href="/Clinic Sys/for_admin/patient.php">Patients</a>
                        <a href="/Clinic Sys/for_admin/specialization.php">Specializations</a>
                        <a href="/Clinic Sys/for_admin/report.php">Reports</a>
                    <?php } else { ?>
                        <a href="/Clinic Sys/for_patient/user_dash.php"> Dashboard </a>
                        <a href="/Clinic Sys/for_patient/patient_history.php"> Booking Appointment </a>
                        <a href="/Clinic Sys/for_patient/booking.php"> Patient History </a>
                    <?php } ?>
                        <a href="/Clinic Sys/logout.php"> Logout </a>
                </nav>
            </div>
        </div>

    </div>
    
</body>
</html>
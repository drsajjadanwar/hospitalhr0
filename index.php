<?php
// Modified index.php
session_start();
require_once 'includes/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work & Life — hospitalhr0</title>
    <link rel="icon" href="media/sitelogo.png" type="image/png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        html, body {
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
        }
        body {
            position: relative;
        }
        .sidenav-overlay {
            transition: opacity 0.2s ease-out;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
        }
        .sidenav {
            -webkit-transform: translate3d(0,0,0);
            transform: translate3d(0,0,0);
        }
        /* Additional explicit fix for white-block issue on iOS */
        .transparent-layer, .card, nav, footer {
            -webkit-transform: translate3d(0,0,0);
            transform: translate3d(0,0,0);
        }
        /* Style for mobile button spacing */
        @media (max-width: 600px) { /* Adjust breakpoint as needed */
            .mobile-button-spacing {
                margin-bottom: 15px; /* Adjust spacing as needed */
            }
        }
    </style>
</head>
<body>
    <?php include_once 'includes/header.php'; ?>

    <div class="container transparent-layer">
        <br>
        <h1 class="center-align">hospitalhr0</h1>
        <!-- First Alert -->
        <div class="card-panel green lighten-4 center-align" style="margin-top: 20px;">
            <span style="color: black;">
Vacancies are available. Last updated on the 3rd of November, 2025.               
            </span>
        </div>
<div class="card-panel blue lighten-4 center-align" style="margin-top: 2px;">
            <span style="color: black;">
                Eligibility extends to nurses, dispensers, and midwives. Furthermore, dental assistants are also deemed eligible for the assistant roles.
            </span>
        </div>
        
        
        <h5 class="center-align" style="font-weight:300;">
            Please note that the hiring at our company is completely based on merit. We would immediately disqualify any candidates who try to bring in any influential references. Trying to influence the recruitment process through contacts, bribery or any other means shall result in legal proceedings.
        </h5>
        <br>
        <hr style="border: none; height: 2px; background-color: white; width: 75%; margin: 20px auto;">
        <br>

        <h5 class="center-align" style="font-weight:300;">
            Current openings in a glance...
        </h5>
        <br>

        <div class="row center-align">
            <div class="col s12 m4">
                <h3>Up to 100%</h3>
                <hr style="border:none; height:2px; background:white; width:60%; margin:5px auto;">
                <h6>Medical & Health Coverage</h6>
            </div>

            <div class="col s12 m4">
                <h3>Short & Easy</h3>
                <hr style="border:none; height:2px; background:white; width:60%; margin:5px auto;">
                <h6>Working hours</h6>
            </div>

            <div class="col s12 m4">
                <h3>More than 50%</h3>
                <hr style="border:none; height:2px; background:white; width:60%; margin:5px auto;">
                <h6>Number of women</h6>
            </div>
        </div>

        <div class="row center-align">
            <div class="col s12 m4">
                <h3>PKR 100,000</h3>
                <hr style="border:none; height:2px; background:white; width:60%; margin:5px auto;">
                <h6>Estimated annual benefits</h6>
            </div>

            <div class="col s12 m4">
                <h3>Transport Allowance</h3>
                <hr style="border:none; height:2px; background:white; width:60%; margin:5px auto;">
                <h6>Included for all employees</h6>
            </div>

            <div class="col s12 m4">
                <h3>Job Security</h3>
                <hr style="border:none; height:2px; background:white; width:60%; margin:5px auto;">
                <h6>Work with a peaceful mind</h6>
            </div>
        </div>
        <br>
        <div class="row center-align">
            <div class="col s12 m6 mobile-button-spacing">
                <a href="vacancies.php" class="waves-effect waves-light btn grey darken-3" style="width:100%;">View Available Openings</a>
            </div>
            <div class="col s12 m6">
                <a href="subscribe.php" class="waves-effect waves-light btn grey darken-3" style="width:100%;">Get Alerts</a>
            </div>
        </div>
        <br>
    </div>

    <?php include_once 'includes/footer.php'; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>

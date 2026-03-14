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
        <h5 class="center-align" style="font-weight:300;">
            We’re here to help and always happy to hear from you. For any queries or assistance, feel free to reach out to us at contact@hospitalhr0 or give us a call at +00 000 0000000. <br>
<br>
You may also drop us a message on WhatsApp for your convenience. We promise to get back to you as quickly as possible — usually within a few hours.
        </h5>
        <br>
        <hr style="border: none; height: 2px; background-color: white; width: 75%; margin: 20px auto;">
        <br>

            </div>

    <?php include_once 'includes/footer.php'; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>
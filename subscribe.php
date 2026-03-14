<?php
session_start();
require_once 'includes/db.php';

// Initialize variables
$subscriptionSuccess = false;
$errorMessage = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and validate email
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    if ($email) {
        // Insert into the 'subscribers' table
        try {
            $stmt = $pdo->prepare("INSERT INTO subscribers (email) VALUES (:email)");
            $stmt->execute([':email' => $email]);
            $subscriptionSuccess = true;
        } catch (PDOException $e) {
            // Handle duplicates or DB errors gracefully
            $errorMessage = "Could not subscribe. Perhaps you're already subscribed or there's a database error.";
        }
    } else {
        $errorMessage = "Please enter a valid email address.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- IMPORTANT for mobile responsiveness -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>hospitalhr0 - Subscribe — hospitalhr0</title>
    <link rel="icon" href="media/sitelogo.png" type="image/png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .center-buttons {
            display: flex;
            gap: 2px;
            justify-content: center;
            margin-top: 20px;
        }
        .center-buttons .btn {
            width: 140px;
        }
        /* Make the text inside the email field appear white */
        input[type="email"] {
            color: white;
        }
    </style>
</head>
<body>
    <?php include_once 'includes/header.php'; ?>

    <div class="container transparent-layer">
        <br>
        <h1 class="center-align">hospitalhr0</h1>

        <?php if ($subscriptionSuccess): ?>
            <!-- SHOW SUCCESS MESSAGE -->
            <h3 class="center-align">You have subscribed successfully and will be receiving alerts by email.</h3>
            <br>
            <div class="row center-align">
                <div class="col s12">
                    <a href="index.php" class="btn grey darken-3 white-text">Go Back to Home</a>
                </div>
            </div>
        <?php else: ?>
            <!-- SHOW SUBSCRIPTION FORM -->
            <h3 class="center-align">Subscribe to Get Job Alerts Via Email</h3>
            <hr style="border: none; height: 2px; background-color: white; width: 75%; margin: 20px auto;">
            <br>
            <!-- If there's an error (e.g. invalid email, DB error), show it in red text -->
            <?php if (!empty($errorMessage)): ?>
                <h6 class="center-align red-text"><?= htmlspecialchars($errorMessage) ?></h6>
            <?php endif; ?>

            <h6 class="center-align" style="font-weight:300;">
                Please enter your email address:
            </h6>
            <div class="row center-align">
                <div class="col s12 m6 offset-m3">
                    <form method="POST" action="">
                        <div class="input-field">
                            <input type="email" name="email" placeholder="Enter valid email here" required>
                        </div>
                        <div class="center-buttons">
                            <button type="submit" class="btn grey darken-3 white-text">Subscribe</button>
                            <!-- The simplest "go back" is just a link that uses JavaScript history or a previous page link -->
                            <a href="javascript:history.back()" class="btn grey darken-3 white-text">Go Back</a>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <?php include_once 'includes/footer.php'; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize the Materialize sidenav (hamburger) on the right
        var sidenavElems = document.querySelectorAll('.sidenav');
        M.Sidenav.init(sidenavElems, {
            edge: 'right'
        });
    });
    </script>
</body>
</html>

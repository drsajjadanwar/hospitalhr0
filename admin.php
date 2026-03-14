<?php
session_start();
require_once 'includes/db.php';

// If not logged in, redirect
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Fetch vacancies
$stmt = $pdo->query("SELECT id, role, status FROM vacancies ORDER BY role");
$vacancies = $stmt->fetchAll();

// Update vacancy statuses if form was submitted
$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {
    foreach ($_POST['status'] as $id => $newStatus) {
        $updateStmt = $pdo->prepare("UPDATE vacancies SET status = ? WHERE id = ?");
        $updateStmt->execute([$newStatus, $id]);
    }
    $success = true;
    // Refresh the $vacancies array to show updated statuses
    $stmt = $pdo->query("SELECT id, role, status FROM vacancies ORDER BY role");
    $vacancies = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- IMPORTANT for mobile responsiveness -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>hospitalhr0 - Admin Panel — hospitalhr0</title>
    <link rel="icon" href="media/sitelogo.png" type="image/png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .btn-pair {
            display: flex;
            justify-content: center;
            gap: 5px;
            margin-top: 20px;
        }
        .btn-pair a, .btn-pair button {
            width: 160px;
        }
        select {
            color: white;
            background-color: #37474F;
        }
        option {
            background-color: #263238;
            color: white;
        }
    </style>
</head>
<body>
    <?php include_once 'includes/header.php'; ?>

    <div class="container transparent-layer">
        <br><br>
        <h4 class="center-align">Welcome, Chief Medical Officer...</h4>
        <br>
        <hr style="border: none; height: 2px; background-color: white; width: 75%; margin: 20px auto;">
        <br>
        <?php if ($success): ?>
            <h5 class="center-align green-text">Changes saved successfully.</h5>
        <?php endif; ?>

        <!-- Vacancies Status Form -->
        <form method="POST">
            <ul class="collection">
                <?php foreach ($vacancies as $vacancy): ?>
                    <li class="collection-item grey darken-4 white-text">
                        <div class="row" style="margin-bottom: 0;">
                            <div class="col s12 m6">
                                <?= htmlspecialchars($vacancy['role']) ?>
                            </div>
                            <div class="col s12 m6">
                                <div class="input-field" style="margin: 0;">
                                    <select name="status[<?= $vacancy['id'] ?>]">
                                        <option value="Open"   <?= $vacancy['status'] === 'Open'   ? 'selected' : '' ?>>Open</option>
                                        <option value="Closed" <?= $vacancy['status'] === 'Closed' ? 'selected' : '' ?>>Closed</option>
                                        <option value="On Hold" <?= $vacancy['status'] === 'On Hold' ? 'selected' : '' ?>>On Hold</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="btn-pair">
                <a href="vacancies.php" class="btn grey darken-3 white-text">Go Back</a>
                <button type="submit" class="btn grey darken-3 white-text">Save</button>
            </div>
        </form>
        <br><br>
    </div>

    <?php include_once 'includes/footer.php'; ?>

    <!-- Materialize JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Materialize select fields
        var selectElems = document.querySelectorAll('select');
        M.FormSelect.init(selectElems);

        // Initialize the Materialize sidenav (hamburger) on the right
        var sidenavElems = document.querySelectorAll('.sidenav');
        M.Sidenav.init(sidenavElems, {
            edge: 'right'
        });
    });
    </script>
</body>
</html>

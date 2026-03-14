<?php
session_start();
require_once 'includes/db.php';

// Allowed vacancy titles (now includes 'Others')
$allowedTitles = [
    'Aesthetician',
    'Dentist',
    'Medical Officers',
    'Consultants',
    'Operations Manager',
    'Nursing Staff',
    'Pharmacist',
    'Receptionists',
    'Housekeeping',
    'Lab Technicians',
    'OT Assistants',
    'Others'
];

// Fetch vacancies matching allowed titles in specified order
$stmt = $pdo->query("SELECT title, icon, status FROM vacancies
    WHERE title IN ('" . implode("','", $allowedTitles) . "')
    ORDER BY FIELD(title, '" . implode("','", $allowedTitles) . "')");
$vacancies = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <!-- IMPORTANT for mobile responsiveness -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>hospitalhr0 - Available Openings — hospitalhr0</title>
  <link rel="icon" href="media/sitelogo.png">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    /* Make each vacancy item a horizontal bar with slight rounding + 2px space */
    .vacancy-row {
      display: flex;
      align-items: center;
      justify-content: space-between;  /* ensures the Apply button is on the right */
      padding: 1rem;
      margin-bottom: 2px; /* 2px space between bars */
      border-radius: 5px; /* small rounding on corners */
      color: white;
    }
    .open-status {
      background-color: #0a0f2c;
    }
    .closed-status {
      background-color: #424242;
    }
    .left-section {
      display: flex;
      align-items: center;
    }
    .left-section img {
      width: 70px;
      height: 70px;
      object-fit: contain;
    }
    .vacancy-info {
      margin-left: 20px;
    }
    .vacancy-info h5 {
      margin: 0 0 5px 0;
    }

    /* Apply button styling: sky blue background, black text */
    .apply-btn {
      background-color: skyblue !important;
      color: black !important;
    }

    @media (max-width: 600px) {
      .vacancy-row {
        flex-direction: column;
        align-items: flex-start;
      }
      .left-section {
        margin-bottom: 10px;
      }
      .vacancy-info {
        margin-left: 10px;
      }
    }
  </style>
</head>
<body>

  <?php include_once 'includes/header.php'; ?>

  <div class="container transparent-layer">
    <div class="row">
      <div class="col s12">
        <h4 class="center-align">Current Vacancies</h4>
      </div>
    </div>

    <?php foreach ($vacancies as $vacancy): ?>
      <div class="vacancy-row <?= $vacancy['status'] === 'Open' ? 'open-status' : 'closed-status' ?>">
        <!-- Left side: icon + role info -->
        <div class="left-section">
          <img src="media/<?= htmlspecialchars($vacancy['icon']) ?>" alt="<?= htmlspecialchars($vacancy['title']) ?>">
          <div class="vacancy-info">
            <h5><?= htmlspecialchars($vacancy['title']) ?></h5>
            <small>Status: <?= htmlspecialchars($vacancy['status']) ?></small>
          </div>
        </div>

        <!-- Right side: Apply button if status is Open -->
        <?php if ($vacancy['status'] === 'Open'): ?>
          <a href="apply.php" class="btn apply-btn">Apply</a>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>

  <?php include_once 'includes/footer.php'; ?>

  <!-- Materialize JavaScript -->
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

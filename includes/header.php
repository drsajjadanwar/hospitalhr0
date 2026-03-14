<?php
$isLoggedIn = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
?>
<nav class="transparent z-depth-0">
  <div class="nav-wrapper container">
    <a href="index.php" class="brand-logo">
      <img src="media/LogoWork.png" alt="Logo">
    </a>
    <a href="#" data-target="mobile-nav" class="sidenav-trigger right">
      <i class="material-icons">menu</i>
    </a>
    <ul class="right hide-on-med-and-down" style="margin-right:50px;">
      <li><a href="index.php">Home</a></li>
<li><a href="vacancies.php">Vacancies</a></li>
      <li><a href="https://hospitalhr0">Main Site</a></li>
      <li><a href="https://portal.hospitalhr0">Staff Portal</a></li>
<?php if ($isLoggedIn): ?>
<li><a href="logout.php">Logout</a></li>
<?php else: ?>
<li><a href="login.php">Login</a></li>
    <?php endif; ?>
      <li><a href="complaints.php">Complaints</a></li>
      <li><a href="contact.php">Contact Us</a></li>
    </ul>
  </div>
</nav>

<ul class="sidenav" id="mobile-nav">
  <li><a href="index.php">Home</a></li>
<li><a href="vacancies.php">Vacancies</a></li>
  <li><a href="https://hospitalhr0">Main Site</a></li>
  <li><a href="https://portal.hospitalhr0">Staff Portal</a></li>
<?php if ($isLoggedIn): ?>
<li><a href="logout.php">Logout</a></li>
<?php else: ?>
<li><a href="login.php">Login</a></li>
    <?php endif; ?>
  <li><a href="complaints.php">Complaints</a></li>
  <li><a href="contact.php">Contact Us</a></li>
</ul>

<?php
ob_start();
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'includes/db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    if (empty($username) || empty($password)) {
        $error = "Username and password are required.";
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();
            if ($user && password_verify($password, $user['password'])) {
                session_regenerate_id(true);
                $_SESSION['admin_logged_in'] = true;
                header("Location: admin.php");
                exit();
            } else {
                $error = "Invalid username or password.";
            }
        } catch (PDOException $e) {
            $error = "Database error: " . $e->getMessage();
        }
    }
}
ob_end_flush();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>hospitalhr0 - Admin Login — hospitalhr0</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
<link rel="icon" href="media/sitelogo.png" type="image/png">
<style>
input[type=text], input[type=password] {
color: white;
}
input[type=text]:focus, input[type=password]:focus {
border-bottom: 1px solid white;
box-shadow: 0 1px 0 0 white;
}
input[type=text]:focus + label, input[type=password]:focus + label {
color: white;
}
.center-btn {
display: flex;
justify-content: center;
}
</style>
</head>
<body>
<?php include_once 'includes/header.php'; ?>
<div class="container">
<div class="row">
<div class="col s12 m6 offset-m3">
<div class="card">
<div class="card-content">
<span class="card-title">Admin Login</span>
<?php if (isset($error)): ?>
<p class="red-text"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>
<form method="post">
<div class="input-field">
<input type="text" name="username" id="username" required>
<label for="username">Username</label>
</div>
<div class="input-field">
<input type="password" name="password" id="password" required>
<label for="password">Password</label>
</div>
<div class="center-btn">
<button class="btn waves-effect waves-light grey darken-3" type="submit">Login</button>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
<?php include_once 'includes/footer.php'; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script src="assets/js/script.js"></script>
</body>
</html>

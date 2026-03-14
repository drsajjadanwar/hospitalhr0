<?php
session_start();
require_once 'includes/db.php';

// 1) Fetch "open" vacancies for the dropdown
$queryVacancies = $pdo->prepare("SELECT title FROM vacancies WHERE status = 'Open' ORDER BY title");
$queryVacancies->execute();
$openVacancies = $queryVacancies->fetchAll(PDO::FETCH_COLUMN);

// Initialize variables
$uploadSuccess = false;
$errorMessage = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_application'])) {
    $fullName = trim($_POST['full_name'] ?? '');
    $phone    = trim($_POST['phone'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $vacancy  = trim($_POST['vacancy'] ?? '');
    
    // Basic validations (e.g., fields not empty)
    if (empty($fullName) || empty($phone) || empty($email) || empty($vacancy)) {
        $errorMessage = "Please fill out all fields.";
    } else {
        // Check if file was uploaded
        if (!isset($_FILES['application_file']) || $_FILES['application_file']['error'] !== UPLOAD_ERR_OK) {
            $errorMessage = "Please attach a valid PDF/JPG file.";
        } else {
            // Validate file size (up to 10MB)
            if ($_FILES['application_file']['size'] > 10 * 1024 * 1024) {
                $errorMessage = "File exceeds 10MB size limit.";
            } else {
                // Validate file type (PDF or JPG/JPEG)
                $allowedTypes = ['application/pdf', 'image/jpeg'];
                $fileType = mime_content_type($_FILES['application_file']['tmp_name']);
                if (!in_array($fileType, $allowedTypes)) {
                    $errorMessage = "Only PDF or JPG files are allowed.";
                } else {
                    // Build the target filename: "FullName_VacancyName.ext"
                    $cleanName    = str_replace(' ', '_', $fullName);
                    $cleanVacancy = str_replace(' ', '_', $vacancy);
                    $extension    = pathinfo($_FILES['application_file']['name'], PATHINFO_EXTENSION);
                    
                    // Directory for storing applications
                    $uploadDir  = __DIR__ . '/applications/';
                    $targetFile = $cleanName . '_' . $cleanVacancy . '.' . $extension;
                    $targetPath = $uploadDir . $targetFile;
                    
                    // Attempt to move the uploaded file
                    if (!move_uploaded_file($_FILES['application_file']['tmp_name'], $targetPath)) {
                        $errorMessage = "Could not save the file. Check folder permissions.";
                    } else {
                        // Create a text file with user details
                        $detailsFileName = $cleanName . '_' . $cleanVacancy . '.txt';
                        $detailsFilePath = $uploadDir . $detailsFileName;
                        $detailsContent  = "Name: $fullName\nPhone: $phone\nEmail: $email\nVacancy: $vacancy\nFile uploaded: $targetFile\n";
                        
                        if (file_put_contents($detailsFilePath, $detailsContent) === false) {
                            $errorMessage = "Could not create the details text file.";
                        } else {
                            // At this point, file and details were successfully saved.
                            // Now insert the record into the database table `applications`
                            try {
                                $insertApp = $pdo->prepare("
                                    INSERT INTO applications (fullname, phone, email, post)
                                    VALUES (:fullname, :phone, :email, :post)
                                ");
                                $insertApp->execute([
                                    ':fullname' => $fullName,
                                    ':phone'    => $phone,
                                    ':email'    => $email,
                                    ':post'     => $vacancy
                                ]);

                                // If insert is successful, mark the upload as successful
                                $uploadSuccess = true;
                            } catch (Exception $e) {
                                // If something goes wrong here, show an error
                                $errorMessage = "Database error: " . $e->getMessage();
                            }
                        }
                    }
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>hospitalhr0 - Apply — hospitalhr0</title>
  <link rel="icon" href="media/sitelogo.png" type="image/png">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    .btn-pair {
      display: flex;
      justify-content: center;
      gap: 2px;
      margin-top: 20px;
    }
    .btn-pair .btn {
      width: 150px;
    }
    /* Style the upload "logo" (which is just a label wrapping an input) */
    .file-upload-logo {
      display: inline-block;
      cursor: pointer;
      border: 2px dashed white;
      padding: 10px;
      border-radius: 5px;
      text-align: center;
      margin-top: 10px;
    }
    .file-upload-logo:hover {
      background: rgba(255,255,255,0.1);
    }
    .file-upload-logo img {
      width: 60px;
      height: 60px;
      object-fit: contain;
      display: block;
      margin: 0 auto 5px auto;
    }
    /* Hide the actual input */
    .file-upload-logo input[type="file"] {
      display: none;
    }
    /* Display selected file name */
    #fileNameDisplay {
      margin-bottom: 5px;
      font-style: italic;
    }
  </style>
</head>
<body>

  <?php include_once 'includes/header.php'; ?>

  <div class="container transparent-layer">
    <br>
    <h1 class="center-align">hospitalhr0</h1>

    <?php if ($uploadSuccess): ?>
      <!-- SHOW SUCCESS MESSAGE -->
      <h4 class="center-align">Your application has been submitted and is under review. You may expect a response from us within 72 working hours.</h4>
      <br>
      <div class="row center-align">
        <div class="col s12">
          <a href="index.php" class="btn grey darken-3 white-text">Home</a>
        </div>
      </div>
    <?php else: ?>
      <!-- SHOW APPLICATION FORM -->
      <h4 class="center-align">Thank you for your interest in working at hospitalhr0. Please see below to proceed.</h4>
      <hr style="border: none; height: 2px; background-color: white; width: 75%; margin: 20px auto;">
      <br>

      <?php if (!empty($errorMessage)): ?>
        <h6 class="center-align red-text"><?= htmlspecialchars($errorMessage) ?></h6>
        <br>
      <?php endif; ?>
      
      <form method="POST" enctype="multipart/form-data">
        <div class="row">
          <div class="col s12 m6 offset-m3">
            <!-- Full Name -->
            <div class="input-field">
              <label for="full_name" class="white-text">Full name:</label>
              <input type="text" id="full_name" name="full_name" class="white-text" required>
            </div>
            
            <!-- Phone -->
            <div class="input-field">
              <label for="phone" class="white-text">Phone:</label>
              <input type="text" id="phone" name="phone" class="white-text" required>
            </div>
            
            <!-- Email -->
            <div class="input-field">
              <label for="email" class="white-text">Email Address:</label>
              <input type="email" id="email" name="email" class="white-text" required>
            </div>

            <br>
            <!-- Applying For (Dropdown) -->
            <label for="vacancy" class="white-text">Applying for:</label>
            <div class="input-field">
              <select id="vacancy" name="vacancy" class="browser-default grey darken-4 white-text" required>
                <option value="" disabled selected>-- Select an Open Vacancy --</option>
                <?php foreach ($openVacancies as $openV): ?>
                  <option value="<?= htmlspecialchars($openV) ?>"><?= htmlspecialchars($openV) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <br>
            <!-- File Upload Logo with dynamic file name display -->
            <label class="file-upload-logo white-text">
              <img src="media/upload.png" alt="Upload">
              <!-- The paragraph to show the selected file name -->
              <div id="fileNameDisplay"></div>
              Click to upload your CV in PDF/JPG format (max 10MB).
              <input
                type="file"
                name="application_file"
                accept=".pdf,.jpg,.jpeg"
                required
                onchange="updateFileNameDisplay(this)"
              >
            </label>

            <div class="btn-pair">
              <button type="submit" name="submit_application" class="btn grey darken-3 white-text">Submit</button>
              <a href="javascript:history.back()" class="btn grey darken-3 white-text">Go Back</a>
            </div>

          </div>
        </div>
      </form>
    <?php endif; ?>
  </div>

  <?php include_once 'includes/footer.php'; ?>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Initialize side nav
      var sidenavElems = document.querySelectorAll('.sidenav');
      M.Sidenav.init(sidenavElems, {
        edge: 'right'
      });
    });

    function updateFileNameDisplay(input) {
      var fileNameDisplay = document.getElementById('fileNameDisplay');
      if (input.files && input.files.length > 0) {
        fileNameDisplay.textContent = 'Selected file: ' + input.files[0].name;
      } else {
        fileNameDisplay.textContent = '';
      }
    }
  </script>
</body>
</html>

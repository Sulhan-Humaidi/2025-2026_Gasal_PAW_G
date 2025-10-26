<?php
require 'validate.inc';

$errors = [];
$is_valid = true; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Formulir Pendaftaran (Self-Submission)</title>
    <style>
        .error { color: red; }
    </style>
</head>
<body>
    <h2>Formulir Pendaftaran</h2>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if (!validateName($errors, $_POST, 'firstname', 'First Name')) {
        $is_valid = false;
    }
    
    if (!validateName($errors, $_POST, 'surname', 'Surname')) {
        $is_valid = false;
    }
    
    if ($is_valid) {
        echo "<p style='color:green;'>Proses Berhasil: Form submitted successfully with no errors.</p>";
    } else {
        echo "<h3>Data Invalid!</h3>";
        foreach ($errors as $error_message) {
            echo "<p class='error'>$error_message</p>";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' || !$is_valid) {
    require 'form.inc';
}
?>
    
</body>
</html>
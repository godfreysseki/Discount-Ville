<?php
  
  include_once "includes/config.inc.php";
  
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $role     = $_POST['register-role'];
    $fullName = $_POST['register-full_name'];
    $email    = $_POST['register-email'];
    $username = $_POST['register-username'];
    $password = $_POST['register-password'];
    
    $login = new Users();
    $login->registerUser($fullName, $email, $username, $password, $role);
  } else {
    echo "This script should only be accessed via a POST request.";
  }
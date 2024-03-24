<?php
  
  include_once "includes/config.inc.php";
  
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $username = $_POST['singin-email'];
    $password = $_POST['singin-password'];
    
    $login = new Users();
    $login->loginUser($username, $password);
  } else {
    echo "This script should only be accessed via a POST request.";
  }
<?php
  
  include_once "includes/config.inc.php";
  
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $username = $_POST['singin-email'];
    $password = $_POST['singin-password'];
    $remember_me = isset($_POST['remember_me']) && $_POST['remember_me'] === "on"; // Check if "Remember Me" checkbox is checked
  
    $login = new Users();
    $login->loginUser($username, $password, $remember_me);
  } else {
    echo "This script should only be accessed via a POST request.";
  }
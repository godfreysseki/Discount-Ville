<?php
  
  header('Content-Type: application/javascript');
  
  include_once "config.inc.php";
  // Define javascript constants
  echo 'const COMPANY = "' . COMPANY . '";';
  echo 'const MOTTO = "' . MOTTO . '";';
  echo 'const LOCATION = "' . LOCATION . '";';
  echo 'const COMPANYEMAIL = "' . COMPANYEMAIL . '";';
  echo 'const COMPANYPHONE = "' . COMPANYPHONE . '";';
  echo 'const COMPANYPHONE2 = "' . COMPANYPHONE2 . '";';
  echo 'const CURRENCY = "' . CURRENCY . '";';
  echo 'const USER = "'.(isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null).'"';
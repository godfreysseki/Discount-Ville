<?php
  
  header('Content-type: application/json');
  
  include_once "../includes/config.inc.php";
  
  $data = new Users();
  echo $data->resetPassword($_POST['email'], $_POST['newPassword'], $_POST['verificationCode']);
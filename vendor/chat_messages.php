<?php
  
  include_once "../includes/config.inc.php";
  
  if (isset($_POST['username'])) {
    $data = new Chat();
    echo $data->getAdminMessages(esc($_SESSION['username']), esc($_POST['username']));
  }
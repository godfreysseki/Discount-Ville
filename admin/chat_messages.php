<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Chat();
  echo $data->getAdminMessages(esc($_SESSION['username']), esc($_POST['username']));
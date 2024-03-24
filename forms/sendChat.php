<?php
  
  header("Content-type:application/json");
  
  include_once "../includes/config.inc.php";
  
  $data = new Chat();
  echo $data->sendMessage(esc($_SESSION['username']), esc($_POST['receiver']), esc($_POST['message']));
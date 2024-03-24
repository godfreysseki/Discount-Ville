<?php
  
  header('Content-type: application/json');
  
  include_once "../includes/config.inc.php";
  
  $data = new Orders();
  echo $data->changeOrderItemStatus($_POST['itemId'], $_POST['status']);
<?php
  
  header("Content-type:application/json");
  
  include_once "../includes/config.inc.php";
  
  $data = new Orders();
  echo $data->checkOut($_POST['formData']);
<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Shopping();
  echo $data->displayAllProducts($_POST ?? null, $_POST['category'] ?? null);
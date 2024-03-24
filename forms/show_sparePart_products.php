<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Shopping();
  echo $data->displayAllSparePartsProducts($_POST ?? null, $_GET['id'] ?? null);
<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Shopping();
  echo $data->displayAllSecondHandProducts($_POST ?? null, $_GET['id'] ?? null);
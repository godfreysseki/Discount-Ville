<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Jobs();
  echo $data->jobForm($_POST['dataId'] ?? null);
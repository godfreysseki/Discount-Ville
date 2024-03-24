<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Config();
  echo $data->markAlertAsSeen($_POST['dataId'] ?? null);
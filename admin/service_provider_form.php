<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new ServiceProviders();
  echo $data->providerForm($_POST['dataId'] ?? null);
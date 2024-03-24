<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Address();
  echo $data->addAddressForm($_POST['dataId'] ?? null);
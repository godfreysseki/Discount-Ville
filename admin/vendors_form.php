<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Vendors();
  echo $data->addVendorForm($_POST['dataId'] ?? null);
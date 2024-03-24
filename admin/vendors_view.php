<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Vendors();
  echo $data->getVendorData($_POST['dataId']);
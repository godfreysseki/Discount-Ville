<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Vendors();
  echo $data->deleteVendor($_POST['dataId']);
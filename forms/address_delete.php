<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Address();
  echo $data->deleteAddress($_POST['dataId']);
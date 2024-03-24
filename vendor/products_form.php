<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Products();
  echo $data->productFormClient($_POST['dataId'] ?? null);
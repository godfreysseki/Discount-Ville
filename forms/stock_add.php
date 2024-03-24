<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Stock();
  echo $data->addStockForm($_POST['dataId']);
<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Orders();
  echo $data->generateReceiptPrintout($_GET['id']);
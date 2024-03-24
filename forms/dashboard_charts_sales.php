<?php
  
  include_once "../includes/config.inc.php";
  
  $dashboard = new Dashboard();
  $salesData = $dashboard->getRealTimeSalesData();
  
  header('Content-type: application/json');
  echo json_encode($salesData);
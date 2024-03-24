<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Dashboard();
  echo $data->totalCounts();
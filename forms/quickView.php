<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Frontend();
  $data->productViewed($_POST['dataId']);
  echo $data->quickProductView($_POST['dataId']);
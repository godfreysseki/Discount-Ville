<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Jobs();
  echo $data->deleteJob($_POST['dataId']);
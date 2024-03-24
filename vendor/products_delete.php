<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Products();
  echo $data->deleteProduct($_POST['dataId']);
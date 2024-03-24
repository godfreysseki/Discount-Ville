<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Products();
  echo $data->deleteProductAdmin($_POST['dataId']);
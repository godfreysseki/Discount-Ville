<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Category();
  echo $data->deleteCategory($_POST['dataId']);
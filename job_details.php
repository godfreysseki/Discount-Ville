<?php
  
  include_once "includes/config.inc.php";
  
  $data = new Jobs();
  echo $data->clientJobDetails($_POST['dataId']);
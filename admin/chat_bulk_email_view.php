<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Contacts();
  echo $data->bulkEmailView($_POST['dataId']);
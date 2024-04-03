<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Notification();
  echo $data->deleteNotification($_POST['dataId']);
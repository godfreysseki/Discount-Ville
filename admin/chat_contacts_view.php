<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Contacts();
  $data->markAsRead($_POST['dataId']);
  echo $data->viewSingleContact($_POST['dataId']);
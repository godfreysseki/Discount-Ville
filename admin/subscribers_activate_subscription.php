<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Subscription();
  echo $data->subscribeUser($_POST['dataId']);
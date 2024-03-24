<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Subscription();
  echo $data->subscriptionForm($_POST['dataId'] ?? null);
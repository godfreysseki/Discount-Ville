<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Subscription();
  echo $data->subscriptionEditForm($_POST['dataId']);
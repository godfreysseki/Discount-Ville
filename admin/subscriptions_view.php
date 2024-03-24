<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Subscription();
  echo $data->viewSubscriptionPlan($_POST['dataId']);
<?php
  
  include_once "includes/config.inc.php";
  
  $data = new ServiceProviders();
  echo $data->getServiceProviderDetails($_POST['dataId']);
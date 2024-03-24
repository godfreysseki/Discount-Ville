<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Country();
  echo $data->getCountryCities($_POST['country']);
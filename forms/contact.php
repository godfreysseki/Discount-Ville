<?php
  
  header('Content-type:application/json');
  
  include_once "../includes/config.inc.php";
  
  $data = new Contacts();
  echo $data->sendContact($_POST);
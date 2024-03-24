<?php
  
  header("Content-type:application/json");
  
  include_once "../includes/config.inc.php";
  
  $data = new Newsletters();
  echo $data->subscribe($_POST['email']);
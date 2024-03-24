<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Chat();
  echo $data->userDetails($_POST['user']);
<?php
  
  include_once "includes/config.inc.php";
  
  $data = new Users();
  $data->logoutUser();
<?php
  
  include_once "../includes/config.inc.php";
  
  $check = new Users();
  $check->checkUser(ROLE);
  
  $data = new Blogs();
  echo $data->deleteBlog($_POST['dataId']);
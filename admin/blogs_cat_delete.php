<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Blogs();
  echo $data->deleteBlogCat($_POST['dataId']);
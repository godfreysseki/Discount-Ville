<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Blogs();
  echo $data->listSingleBlog($_POST['dataId']);
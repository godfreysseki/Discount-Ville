<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Blogs();
  echo $data->newBlogForm($_POST['dataId'] ?? null);
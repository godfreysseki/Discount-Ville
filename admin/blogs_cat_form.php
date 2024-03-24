<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Blogs();
  echo $data->blogCategoryForm($_POST['dataId'] ?? null);
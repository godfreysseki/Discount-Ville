<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Blogs();
  echo $data->writeComment($_POST['post'], $_POST['commentId'], $_POST['name'], $_POST['email'], $_POST['comment']);
  echo "<script>window.history.back()</script>";
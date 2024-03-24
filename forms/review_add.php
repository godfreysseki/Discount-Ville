<?php
  
  header("Content-type:application/json");
  
  include_once "../includes/config.inc.php";
  
  $data = new Products();
  echo $data->addProductReview($_POST['full_name'], $_POST['states'], $_POST['stars'], $_POST['review'], $_POST['productId']);
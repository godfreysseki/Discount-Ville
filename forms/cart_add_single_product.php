<?php
  
  header("Content-type:application/json");
  
  include_once "../includes/config.inc.php";
  
  $data = new Frontend();
  echo $data->addToShoppingCartSingleProduct($_POST['productId'], $_POST['quantity'], $_POST['color'], $_POST['size']);
<?php
  
  header("Content-type:application/json");
  
  include_once "../includes/config.inc.php";
  
  $data = new Frontend();
  echo $data->addToShoppingCartFromWishlist($_POST['dataId']);
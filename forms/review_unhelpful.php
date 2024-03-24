<?php
  
  header("Content-type:application/json");
  
  include_once "../includes/config.inc.php";
  
  $data = new Products();
  echo $data->addUnHelpfulReview($_POST['reviewId']);
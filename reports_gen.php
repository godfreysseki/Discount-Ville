<?php
  
  include_once "includes/config.inc.php";
  
  $data = new Reports();
  echo $data->generateReport($_POST['reportCategory'], $_POST['start_date'], $_POST['end_date']);
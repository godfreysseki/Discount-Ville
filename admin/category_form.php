<?php
  
  require_once '../includes/config.inc.php';
  
  $categoryManager = new Category();
  echo $categoryManager->renderCategoryForm($_POST['dataId'] ?? null);
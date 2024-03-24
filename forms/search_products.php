<?php
  
  include_once "../includes/config.inc.php";
  $data = new Frontend();
  
  // Fetch search term from GET request
  $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
  
  // Fetch products based on the search term
  $products = $data->perfectSearch($searchTerm);
  
  // Filter products based on the search term
  $filteredProducts = [];
  foreach ($products as $product) {
    if (stripos($product['name'], $searchTerm) !== false) {
      $filteredProducts[] = $product;
    }
  }
  
  // Return filtered products in JSON format
  echo json_encode($filteredProducts);
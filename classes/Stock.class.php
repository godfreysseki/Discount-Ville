<?php
  
  class Stock extends Config
  {
    private $auditTrail;
  
    public function __construct()
    {
      parent::__construct();
      $this->auditTrail = new AuditTrail();
    }
    
    public function addStock($productId, $quantity)
    {
      $sql = "update products set quantity_in_stock=quantity_in_stock+? where product_id=?";
      $params = [$quantity, $productId];
      if ($this->updateQuery($sql, $params)) {
        return alert('success', 'Product Quantity Updated Successfully.');
      } else {
        return alert('warning', 'Product Quantity Failed to Update.');
      }
    }
  
    public function addStockForm($productId)
    {
      $sql = "select * FRom products where product_id=?";
      $params = [$productId];
      $result = $this->selectQuery($sql, $params)->fetch_assoc();
      
      return '<form method="post">
                <input type="hidden" name="product_id" value="'.$productId.'">
                <p>You are adding quantity for <b>'.$result['product_name'].'</b></p>
                <div class="form-group">
                  <label for="quantity">Quantity to Add</label>
                  <input type="number" id="quantity" name="quantity" class="form-control">
                </div>
                <div class="form-group">
                  <input type="submit" value="Add Stock" class="btn btn-primary">
                </div>
              </form>';
    }
    
    public function showStock()
    {
      $stock = [];
      $vendor = new Vendors();
      $user = $vendor->getVendorId();
      $sql = 'select * from products where vendor_id=?';
      $params = [$user];
      $result = $this->selectQuery($sql,$params);
      while ($row = $result->fetch_assoc()) {
        $stock[] = $row;
      }
      return $stock;
    }
    
    public function getStockQuantity($productId)
    {
      // Logic to retrieve the current stock quantity for a specific product.
      // Query the database for the stock quantity.
    }
    
    public function isProductInStock($productId)
    {
      // Logic to check if a product is in stock.
      // Determine if the product's stock quantity is sufficient for an order.
    }
    
    // Add more methods for specific stock-related features, such as restocking alerts and managing multiple warehouses.
  }

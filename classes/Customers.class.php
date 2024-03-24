<?php
  
  
  class Customers extends Config
  {
    private $auditTrail;
    
    public function __construct()
    {
      parent::__construct();
      $this->auditTrail = new AuditTrail();
    }
    
    public function listCustomers()
    {
      $sql    = "SELECT * FROM users WHERE role=?";
      $params = ['Customer'];
      $result = $this->selectQuery($sql, $params);
      
      $data = [];
      while ($row = $result->fetch_assoc()) {
        $data[] = $row;
      }
      return $data;
    }
    
    public function showMyCustomers()
    {
      $userId = esc($_SESSION['user_id']);
      $sql    = "SELECT *, salesorders.status AS statuses, COUNT(salesorders.order_id) AS orders FROM salesorders
                    INNER JOIN salesorderitems ON salesorders.order_id=salesorderitems.order_id
                    INNER JOIN products ON salesorderitems.product_id=products.product_id
                    INNER JOIN vendors ON vendors.vendor_id=products.vendor_id
                    INNER JOIN users ON users.user_id=vendors.user_id
                    WHERE users.user_id=? GROUP BY customer_phone";
      $params = [$userId];
      return $this->selectQuery($sql, $params);
    }
    
  }
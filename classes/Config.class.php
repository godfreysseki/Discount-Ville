<?php
  
  class Config
  {
    private $connection;
    private $data = [];
    private $encryptionKey;
    
    public function __construct()
    {
      $this->connection = Database::getInstance()->getConnection();
      $this->fetchCompanyConstants();
      $this->encryptionKey = ENC_SECRET_KEY;
    }
  
    public function encrypt($data)
    {
      $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
      $encryptedData = openssl_encrypt($data, 'aes-256-cbc', $this->encryptionKey, 0, $iv);
    
      return base64_encode($iv . $encryptedData);
    }
  
    public function decrypt($encryptedData)
    {
      $data = base64_decode($encryptedData);
      $ivSize = openssl_cipher_iv_length('aes-256-cbc');
      $iv = substr($data, 0, $ivSize);
      $encryptedData = substr($data, $ivSize);
    
      return openssl_decrypt($encryptedData, 'aes-256-cbc', $this->encryptionKey, 0, $iv);
    }
    
    // Function to sanitize user inputs
    private function sanitizeInput($data)
    {
      return $this->connection->real_escape_string($data);
    }
    
    // Template for SELECT query
    public function selectQuery($sql, $params = [])
    {
      $stmt = $this->connection->prepare($sql);
      
      if ($stmt === false) {
        die('Error in SELECT query preparation: ' . $this->connection->error);
      }
      
      if (!empty($params)) {
        $paramTypes = str_repeat('s', count($params));
        $stmt->bind_param($paramTypes, ...$params);
      }
      
      $stmt->execute();
      $result = $stmt->get_result();
      $stmt->close();
      
      return $result;
    }
    
    // Template for INSERT query
    public function insertQuery($sql, $params = [])
    {
      $stmt = $this->connection->prepare($sql);
      
      if ($stmt === false) {
        die('Error in INSERT query preparation: ' . $this->connection->error);
      }
      
      if (!empty($params)) {
        $paramTypes = str_repeat('s', count($params));
        $stmt->bind_param($paramTypes, ...$params);
      }
      
      $stmt->execute();
      $insertedId = $stmt->insert_id;
      $stmt->close();
      
      return $insertedId;
    }
    
    // Template for UPDATE query
    public function updateQuery($sql, $params = [])
    {
      $stmt = $this->connection->prepare($sql);
      
      if ($stmt === false) {
        die('Error in UPDATE query preparation: ' . $this->connection->error);
      }
      
      if (!empty($params)) {
        $paramTypes = str_repeat('s', count($params));
        $stmt->bind_param($paramTypes, ...$params);
      }
      
      $stmt->execute();
      $updatedRows = $stmt->affected_rows;
      $stmt->close();
      
      return $updatedRows;
    }
    
    // Template for DELETE query
    public function deleteQuery($sql, $params = [])
    {
      $stmt = $this->connection->prepare($sql);
      
      if ($stmt === false) {
        die('Error in DELETE query preparation: ' . $this->connection->error);
      }
      
      if (!empty($params)) {
        $paramTypes = str_repeat('s', count($params));
        $stmt->bind_param($paramTypes, ...$params);
      }
      
      $stmt->execute();
      $deletedRows = $stmt->affected_rows;
      $stmt->close();
      
      return $deletedRows;
    }
    
    public function beginTransaction()
    {
      $this->connection->begin_transaction();
    }
    
    public function commitTransaction()
    {
      $this->connection->commit();
    }
    
    public function rollbackTransaction()
    {
      $this->connection->rollback();
    }
    
    public function closeConnection()
    {
      $this->connection->close();
    }
    
    public function get($key)
    {
      // Return the configuration value based on the given key
      return isset($this->data[$key]) ? $this->data[$key] : null;
    }
    
    // Working on notifications and system alerts and vitals of the system for better performance
    public function checkVitals()
    {
      // Check Stock levels and add stock notification
      $sql    = "SELECT products.*, suppliers.*, if(reorder_level<=quantity_in_stock, 'High', 'Low') AS levels FROM products JOIN suppliers ON products.supplier_id=suppliers.supplier_id";
      $result = $this->selectQuery($sql);
      $items  = [];
      while ($row = $result->fetch_assoc()) {
        $items[] = $row;
      }
      return $items;
    }
    
    public function addAlerts()
    {
      $products = $this->checkVitals();
      foreach ($products as $product) {
        if ($product['levels'] === "Low") {
          // check notification existance
          // 3 Days ago
          $days   = date("Y-m-d H:i:s", strtotime("-3 days", $_SERVER['REQUEST_TIME']));
          $check  = "SELECT * FROM stockalerts WHERE product_id=? && alert_quantity=? && alert_date>=? ";
          $params = [$product['product_id'], $product['quantity_in_stock'], $days];
          $result = $this->selectQuery($check, $params);
          if ($result->num_rows === 0) {
            // Insert if new notification
            $sql    = "INSERT INTO stockalerts (product_id, alert_quantity, alert_date, seen) VALUES (?, ?, ?, ?)";
            $params = [$product['product_id'], $product['quantity_in_stock'], date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']), "No"];
            $this->insertQuery($sql, $params);
          }
        }
      }
    }
    
    public function countNewAlerts()
    {
      $sql    = "SELECT count(alert_id) AS alerts FROM stockalerts WHERE seen='No' ";
      $result = $this->selectQuery($sql)->fetch_assoc();
      return $result['alerts'];
    }
    
    // list a few alerts or count and group them as in 3 products out of stock, 2 new users etc
    public function showAlertCategories()
    {
      $sql    = "SELECT stockalerts.*, products.* FROM stockalerts JOIN products ON stockalerts.product_id = products.product_id WHERE seen='No' ";
      $result = $this->selectQuery($sql);
      $no     = 1;
      $alerts = '';
      while (($row = $result->fetch_assoc()) && ($no <= 5)) {
        $alerts = '<a href="javascript:void(0)" class="dropdown-item">
                    <b>' . $row['product_name'] . '</b> needs restocking.
                  </a>
                  <div class="dropdown-divider"></div>';
        $no++;
      }
      
      return $alerts;
    }
    
    public function showAlerts()
    {
      $sql    = "SELECT stockalerts.*, products.* FROM stockalerts JOIN products ON stockalerts.product_id=products.product_id ORDER BY alert_id DESC, seen ASC ";
      $result = $this->selectQuery($sql);
      
      $alerts = [];
      while ($row = $result->fetch_assoc()) {
        $alerts[] = $row;
      }
      
      return $alerts;
    }
    
    public function markAlertAsSeen($alertId = null)
    {
      if ($alertId !== null) {
        $sql    = "UPDATE stockalerts SET seen='Yes' WHERE alert_id=?";
        $params = [$alertId];
        $id     = $this->updateQuery($sql, $params);
        return alert('success', 'Notification Seen. Id' . $id);
      } else {
        $sql = "UPDATE stockalerts SET seen='Yes' WHERE seen='No' ";
        $this->updateQuery($sql);
        return alert('success', 'All notifications seen successfully.');
      }
    }
    
    // Others for receipt formatting
    public function receiptHeaded()
    {
      $data   = [];
      $sql    = "SELECT * FROM general_settings";
      $result = $this->selectQuery($sql);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $data = $row;
        }
      }
      return $data;
    }
    
    public function signature($person, $fullname)
    {
      $line = "<div class='container-fluid'>
                <div class='row'>
                  <div class='col-sm-3'>
                    <div style='border-bottom: 1px solid darkgrey; padding-top: 30px;'></div>
                    <div>" . ucwords(strtolower($fullname)) . "<br>" . strtoupper($person) . "</div>
                  </div>
                  <div class='col-sm-3'></div>
                  <div class='col-sm-3'></div>
                  <div class='col-sm-3'></div>
                </div>
               </div>";
      
      return $line;
    }
    
    // Products Management
    public function top10($productId)
    {
      $data   = [];
      $sql    = "SELECT product_id FROM products ORDER BY total_views DESC, average_stars DESC LIMIT 10";
      $result = $this->selectQuery($sql);
      while ($row = $result->fetch_assoc()) {
        $data[] = $row;
      }
      if (in_array($productId, $data)) {
        return true;
      } else {
        return false;
      }
    }
    
    public function discounted($productId)
    {
      $sql    = 'SELECT * FROM deals WHERE product_id=? && (start_date <= now() && end_date >= now())';
      $params = [$productId];
      $result = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        return true;
      } else {
        return false;
      }
    }
    
    public function productDiscount($productId)
    {
      $sql    = 'SELECT * FROM deals WHERE product_id=?';
      $params = [$productId];
      $result = $this->selectQuery($sql, $params)->fetch_assoc();
      return $result['discount'];
    }
    
    public function productDiscountTimeLeft($productId)
    {
      $sql    = 'SELECT * FROM deals WHERE product_id=?';
      $params = [$productId];
      $result = $this->selectQuery($sql, $params)->fetch_assoc();
      return $result['end_date'];
    }
    
    // Session management for guests
    public function sessionManager()
    {
      if (!isset($_SESSION['role'])) {
        $_SESSION['username'] = "GUEST_".randomCode(8);
        $_SESSION['role']     = 'Guest';
        // Initiate Message Sessions
        $_SESSION['sender'] = $_SESSION['username'];
      }
    }
    
    // Get Constants
    public function fetchCompanyConstants()
    {
      // Query the database to fetch company constants
      $query  = "SELECT * FROM company_constants";
      $result = $this->selectQuery($query);
      
      if ($result) {
        $constants = $result->fetch_assoc();
        // Define the constants
        if (!defined('COMPANY')) define('COMPANY', $constants['company_name']);
        if(!defined('COMPANYSHORT')) define('COMPANYSHORT', $constants['company_short']);
        if(!defined('MOTTO')) define('MOTTO', $constants['motto']);
        if(!defined('LOCATION')) define('LOCATION', $constants['location']);
        if(!defined('COMPANYEMAIL')) define('COMPANYEMAIL', $constants['company_email']);
        if(!defined('COMPANYPHONE')) define('COMPANYPHONE', $constants['company_phone']);
        if(!defined('COMPANYPHONE2')) define('COMPANYPHONE2', $constants['company_phone2']);
        if(!defined('COMPANY_POST_NO')) define('COMPANY_POST_NO', $constants['company_post_no']);
        if(!defined('CURRENCY')) define('CURRENCY', $constants['default_currency']);
        if(!defined('DESCRIPTION')) define('DESCRIPTION', $constants['default_description']);
        if(!defined('KEYWORDS')) define('KEYWORDS', $constants['default_keywords']);
        if(!defined('ROBOT')) define('ROBOT', $constants['default_robot']);
        if(!defined('FACEBOOK')) define('FACEBOOK', $constants['facebook']);
        if(!defined('TWITTER')) define('TWITTER', $constants['twitter']);
        if(!defined('INSTAGRAM')) define('INSTAGRAM', $constants['instagram']);
        if(!defined('YOUTUBE')) define('YOUTUBE', $constants['youtube']);
        if(!defined('MAP')) define('MAP', $constants['location_iframe']);
        if(!defined('ENC_SECRET_KEY')) define('ENC_SECRET_KEY', $constants['enc_secret_key']);
      }
    }
    
    // Get city and country names using their codes
    public function cityName($code)
    {
      $sql    = "SELECT name FROM cities WHERE code=?";
      $params = [$code];
      $result = $this->selectQuery($sql, $params)->fetch_assoc();
      return $result['name'] ?? $code;
    }
    
    public function countryName($code)
    {
      $sql    = "SELECT name FROM countries WHERE alpha_2=?";
      $params = [$code];
      $result = $this->selectQuery($sql, $params)->fetch_assoc();
      return $result['name'] ?? $code;
    }
  
    public function getUserProfilePic($username)
    {
      $data = new Users();
      return $data->getUserProfilePic($username);
    }
  
    public function getVendorId()
    {
      $sql    = "SELECT * FROM vendors WHERE user_id=?";
      $params = [esc($_SESSION['user_id'])];
      $result = $this->selectQuery($sql, $params)->fetch_assoc();
      return $result['vendor_id'] ?? false;
    }
  
    public function getSubscriptionPlansComboOptions($selectedId = null)
    {
      // Fetch animal data from the database
      $sql    = "SELECT * FROM subscription_plans";
      $result = $this->selectQuery($sql);
    
      // Generate HTML options
      $options = '';
      while ($row = $result->fetch_assoc()) {
        $selected = ($row['subscription_id'] == $selectedId) ? 'selected' : '';
        $options  .= '<option value="' . $row['subscription_id'] . '" ' . $selected . ' data-price="'.$row['price'].'">' . $row['name'] . ' - '.number_format($row['price']).'</option>';
      }
    
      return $options;
    }
    
    // Working on Notifications
    public function notificationCreator()
    {
      // Profile Completion Notifications
      // Sales Orders Notifications
      // Stock Notifications
      // Subscription Notifications
      // Chat new messages Notifications
      $user = $_SESSION['user_id'];
    }
    
  }
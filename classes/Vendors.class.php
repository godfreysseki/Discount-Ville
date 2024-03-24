<?php
  
  
  class Vendors extends Config
  {
    private $auditTrail;
    
    public function __construct()
    {
      parent::__construct();
      $this->auditTrail = new AuditTrail();
    }
    
    public function addVendor($vendorData)
    {
      //dnd($vendorData);
      $vendorData['user_id'] = esc($_SESSION['user_id']);
      if (isset($vendorData['vendor_id']) && $vendorData['vendor_id'] !== "") {
        if (!empty($_FILES['shop_logo']['name'])) {
          $uploadDir      = 'assets/img/shop_logos/';
          $uniqueFilename = uniqid() . '.' . pathinfo($_FILES['shop_logo']['name'], PATHINFO_EXTENSION);
          $uploadFile     = $uploadDir . $uniqueFilename;
          
          if (move_uploaded_file($_FILES['shop_logo']['tmp_name'], $uploadFile)) {
            // Image uploaded successfully, save the unique filename to the database
            $productImage = $uniqueFilename;
          } else {
            // Image upload failed
            $productImage = $this->vendorLogo($vendorData['vendor_id']);
          }
        } else {
          $productImage = $this->vendorLogo($vendorData['vendor_id']);
        }
        // Insert to the database
        $sql    = "UPDATE vendors SET user_id=?, shop_name=?, description=?, business_phone=?, whatsapp=?, business_email=?, country=?, city=?, address=?, iframe_code=?, shop_logo=? WHERE vendor_id=?";
        $params = [
          $vendorData['user_id'],
          $vendorData['shop_name'],
          $vendorData['description'],
          $vendorData['business_phone'],
          $vendorData['whatsapp'],
          $vendorData['business_email'],
          $vendorData['country'],
          $vendorData['city'],
          $vendorData['address'],
          $vendorData['iframe_code'],
          $productImage,
          $vendorData['vendor_id']
        ];
        return $this->updateQuery($sql, $params);
      } else {
        if (!empty($_FILES['shop_logo']['name'])) {
          $uploadDir      = 'assets/img/shop_logos/';
          $uniqueFilename = uniqid() . '.' . pathinfo($_FILES['shop_logo']['name'], PATHINFO_EXTENSION);
          $uploadFile     = $uploadDir . $uniqueFilename;
          
          if (move_uploaded_file($_FILES['shop_logo']['tmp_name'], $uploadFile)) {
            // Image uploaded successfully, save the unique filename to the database
            $productImage = $uniqueFilename;
          } else {
            // Image upload failed
            $productImage = ''; // or set to a default image
          }
        } else {
          $productImage = ''; // No image provided
        }
        $sql    = "INSERT INTO vendors (user_id, shop_name, description, business_phone, whatsapp, business_email, country, city, address, iframe_code, shop_logo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $params = [
          $vendorData['user_id'],
          $vendorData['shop_name'],
          $vendorData['description'],
          $vendorData['business_phone'],
          $vendorData['whatsapp'],
          $vendorData['business_email'],
          $vendorData['country'],
          $vendorData['city'],
          $vendorData['address'],
          $vendorData['iframe_code'],
          $productImage
        ];
        return $this->insertQuery($sql, $params);
      }
    }
    
    public function vendorLogo($vendorId)
    {
      $sql    = "SELECT * FROM vendors WHERE vendor_id=?";
      $params = [$vendorId];
      $result = $this->selectQuery($sql, $params)->fetch_assoc();
      return $result['shop_logo'];
    }
    
    public function addVendorForm($vendorId = null)
    {
      
      $category = [
        'vendor_id' => '',
        'user_id' => '',
        'shop_name' => '',
        'description' => '',
        'shop_logo' => ''
      ];
      
      if ($vendorId !== null) {
        $category['vendor_id'] = $this->getVendorById($vendorId);
      }
      
      
      $usersCombo = '';
      $vendors    = new Users();
      $users      = $vendors->getUsers();
      foreach ($users as $user) {
        if ($category['user_id'] === $user['user_id']) {
          $usersCombo .= '<option value="' . $user['user_id'] . '" selected>' . $user['full_name'] . '</option>';
        } else {
          $usersCombo .= '<option value="' . $user['user_id'] . '">' . $user['full_name'] . '</option>';
        }
      }
      
      $form = '<form method="post" enctype="multipart/form-data">
                <input type="text" name="vendor_id" value="' . $category['vendor_id'] . '">
                <div class="form-group">
                  <label for="shop_logo">Shop Logo: <small><i>(Optional)</i></small></label>
                  <input type="file" name="shop_logo" id="shop_logo" value="' . $category['shop_logo'] . '" class="form-control">
                </div>
                <div class="form-group">
                  <label for="shop_name">Shop Name:</label>
                  <input type="text" name="shop_name" id="shop_name" value="' . $category['shop_name'] . '" class="form-control">
                </div>
                <div class="form-group">
                  <label for="description">Description:</label>
                  <textarea name="description" id="description" class="form-control" required>' . $category['description'] . '</textarea>
                </div>
                <div class="form-group">
                  <label for="user_id">Vendor:</label>
                  <select name="user_id" id="user_id" class="custom-select select2">
                    <option value="">-- Select Vendor --</option>
                    ' . $usersCombo . '
                  </select>
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-primary float-right">' . (($vendorId !== null) ? "Edit" : "Add") . ' Vendor</button>
                </div>
              </form>';
      return $form;
    }
    
    private function getVendorById($vendorId)
    {
      $sql    = "SELECT * FROM vendors WHERE vendor_id=?";
      $param  = [$vendorId];
      $result = $this->selectQuery($sql, $param)->fetch_assoc();
      return $result['vendor_id'];
    }
    
    public function getAllVendors()
    {
      $data   = [];
      $sql    = "SELECT * FROM vendors LEFT JOIN users ON vendors.user_id=users.user_id";
      $result = $this->selectQuery($sql);
      while ($row = $result->fetch_assoc()) {
        $data[] = $row;
      }
      return $data;
    }
    
    private function vendorProducts($vendorId)
    {
      $data   = [];
      $sql    = "SELECT * FROM products WHERE vendor_id=?";
      $params = [$vendorId];
      $result = $this->selectQuery($sql, $params);
      while ($row = $result->fetch_assoc()) {
        $data[] = $row;
      }
      return $data;
    }
    
    private function productSales($productId)
    {
      $sql    = "SELECT COUNT(item_id) AS sales, SUM(total_amount) AS amount FROM salesorderitems WHERE product_id=?";
      $params = [$productId];
      return $this->selectQuery($sql, $params)->fetch_assoc();
    }
    
    private function vendorChat($vendorId)
    {
      $data     = [];
      $username = $this->vendorUserName($vendorId);
      $sql      = "SELECT * FROM chat_messages WHERE receiver_id=? || sender_id=?";
      $params   = [$username, $username];
      $result   = $this->selectQuery($sql, $params);
      while ($row = $result->fetch_assoc()) {
        $data[] = $row;
      }
      return $data;
    }
    
    public function getVendorData($vendorId)
    {
      // Products Part
      $no          = 1;
      $productData = '';
      $products    = $this->vendorProducts($vendorId);
      foreach ($products as $product) {
        $sales       = $this->productSales($product['product_id']);
        $productData .= '<tr>
                          <td>' . $no . '</td>
                          <td>' . $product['product_name'] . '</td>
                          <td class="text-right">' . (!empty($product['total_views']) ? number_format($product['total_views']) : 0) . '</td>
                          <td class="text-right">' . (!empty($sales['sales']) ? number_format($sales['sales']) : 0) . '</td>
                          <td class="text-right">' . (!empty($sales['amount']) ? number_format($sales['amount']) : 0) . '</td>
                        </tr>';
        $no++;
      }
      
      // Chat Part
      $chat = '';
      $items = $this->vendorChat($vendorId);
      foreach ($items as $item) {
        $chat .= '<li class="list-group-item d-flex justify-content-between align-items-center py-1">
                    '.(!empty($item['message_content']) ? $item['message_content'] : '<img src="../assets/img/chat/'.$item['uploads'].'" alt="uploaded image" width="150px">').'
                    <small class="text-muted"><span>'.$item['sender_id'].' to '.$item['receiver_id'].'</span></small>
                  </li>';
      }
      
      return '<div class="row">
                <div class="col-sm-5">
                  <h5>Products</h5>
                  <div class="table-responsive">
                    <table class="table table-striped table-sm table-hover table-bordered">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Product</th>
                          <th>Views</th>
                          <th>Orders</th>
                          <th>Total Amount</th>
                        </tr>
                      </thead>
                      <tbody>
                        ' . $productData . '
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="col-sm-7 overflow-auto" style="max-height: 400px">
                  <h5>Chats</h5>
                  <ul class="list-group list-group-flush">
                    '.$chat.'
                  </ul>
                </div>
              </div>';
    }
    
    public function vendorUserName($vendorId)
    {
      $sql    = "SELECT username FROM users INNER JOIN vendors ON users.user_id = vendors.user_id WHERE vendors.user_id=?";
      $params = [$vendorId];
      $row    = $this->selectQuery($sql, $params)->fetch_assoc();
      return $row['username'];
    }
    
    public function vendorUserId($vendorId)
    {
      $sql    = "SELECT user_id FROM vendors WHERE vendor_id=?";
      $params = [$vendorId];
      $row    = $this->selectQuery($sql, $params)->fetch_assoc();
      return $row['user_id'];
    }
    
    public function deleteVendor($vendorId)
    {
      $vendor = $this->vendorUserName($vendorId);
      $userId = $this->vendorUserId($vendorId);
      // Remove vendor chat
      $sql    = "DELETE FROM chat_messages WHERE receiver_id=? || sender_id=?";
      $params = [$vendor, $vendor];
      $this->deleteQuery($sql, $params);
      
      // Remove Vendor Audit Trails
      $sql    = "DELETE FROM audittrail WHERE user_id=?";
      $params = [$userId];
      $this->deleteQuery($sql, $params);
      
      // Remove Vendor products and their images
      $sql    = "SELECT * FROM products WHERE vendor_id=?";
      $params = [$vendorId];
      $result = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          // Delete the product images, then delete the products
          $images = explode(", ", $row['product_image']);
          foreach ($images as $image) {
            if (file_exists('../assets/img/products/' . $image)) {
              unlink('../assets/img/products/' . $image);
            }
          }
          // Remove the product
          $this->deleteQuery("DELETE FROM products WHERE product_id=?", [$row['product_id']]);
        }
      }
      
      // Remove vendor from users table
      $sql    = "DELETE FROM users WHERE user_id=?";
      $params = [$userId];
      $this->deleteQuery($sql, $params);
      
      // Remove Vendor
      $sql    = "DELETE FROM vendors WHERE vendor_id=?";
      $params = [$vendorId];
      $this->deleteQuery($sql, $params);
      return alert("success", "vendor Deleted Successfully.");
    }
    
    public function getVendorId()
    {
      $data = new Config();
      return $data->getVendorId();
    }
    
    public function loginVendor($email, $password)
    {
      // Logic to authenticate and log in a vendor.
      // Verify credentials and create a session for the vendor.
    }
    
    public function updateVendorProfile($vendorId, $newData)
    {
      // Logic to update vendor profile information.
      // Update vendor data in the database.
    }
    
    public function deactivateVendor($vendorId)
    {
      // Logic to deactivate a vendor's account.
      // Set the vendor's status to inactive in the database.
    }
    
    public function listVendorProducts($vendorId)
    {
      // Logic to retrieve a list of products associated with a vendor.
      // Query the database to get the vendor's products.
    }
    
    public function addProduct($vendorId, $productData)
    {
      // Logic to add a new product to a vendor's shop.
      // Insert the product data into the database.
    }
    
    public function editProduct($vendorId, $productId, $newData)
    {
      // Logic to edit an existing product.
      // Update the product data in the database.
    }
    
    public function deleteProduct($vendorId, $productId)
    {
      // Logic to delete a product from a vendor's shop.
      // Remove the product data from the database.
    }
    
    public function listVendorOrders($vendorId)
    {
      // Logic to retrieve a list of orders related to a vendor's products.
      // Query the database to get the vendor's orders.
    }
    
    public function respondToCustomerInquiries($vendorId)
    {
      // Logic to handle customer inquiries and messages for a vendor.
      // Implement a messaging system for vendors.
    }
    
    // Update Vendor Account
    public function updateAccount($data)
    {
      $user = esc($_SESSION['user_id']);
      if ((($data['old_password'] && $data['new_password'] && $data['retype_password']) !== "") && !empty($data['old_password']) && !empty($data['new_password']) && !empty($data['retype_password'])) {
        // Update Password too but first verify old password
        // Check if the passwords match and then check with the database too for the old password
        $userData = $this->vendorData();
        if (($data['new_password'] === $data['retype_password']) && password_verify($userData['password'], password_hash($data['old_password'], PASSWORD_DEFAULT))) {
          // All are okay, then update the password too
          $sql    = "UPDATE users SET username=?, full_name=?, phone=?, email=?, password=? WHERE user_id=?";
          $params = [$data['username'], $data['full_name'], $data['phone'], $data['email'], password_hash($data['new_password'], PASSWORD_DEFAULT), $user];
          if ($this->updateQuery($sql, $params)) {
            return alert('success', 'Details Saved Successfully.');
          } else {
            return alert('warning', 'Details Failed to be Saved.');
          }
        } else {
          return alert('warning', 'Passwords did not match');
        }
      } else {
        // Update other information without password changing
        $sql    = "UPDATE users SET username=?, full_name=?, phone=?, email=? WHERE user_id=?";
        $params = [$data['username'], $data['full_name'], $data['phone'], $data['email'], $user];
        if ($this->updateQuery($sql, $params)) {
          return alert('success', 'Details Saved Successfully.');
        } else {
          return alert('warning', 'Details Failed to be Saved.');
        }
      }
    }
    
    // Check if the vendor has a shop registered
    public function checkVendorShop()
    {
      $user   = esc($_SESSION['user_id']);
      $sql    = "SELECT * FROM vendors WHERE user_id=?";
      $params = [$user];
      $result = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        return true;
      } else {
        echo '<div class="alert alert-warning alert-dismissible text-left fade show" role="alert">
                <strong>Info!</strong> You need to complete your shop profile before continuing from <a href="vendor_shop.php">Shop Management.</a><br>Thank you.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
      }
    }
    
    // All information about the vendor
    public function vendorData()
    {
      $user   = esc($_SESSION['user_id']);
      $sql    = "SELECT * FROM users LEFT JOIN vendors ON users.user_id=vendors.user_id WHERE users.user_id=?";
      $params = [$user];
      return $this->selectQuery($sql, $params)->fetch_assoc();
    }
    
    // Display avendor list to clients
    public function showVendors()
    {
      $data   = '';
      $sql    = "SELECT * FROM vendors";
      $result = $this->selectQuery($sql);
      while ($row = $result->fetch_assoc()) {
        $data .= '<div class="vendors col-lg-2 col-sm-4 align-self-stretch" data-aos="fade-down" data-aos-delay="100">
                    <div class="icon-box icon-box-circle text-center">
                      <span class="icon-box-icon bg-transparent">
                        <img src="assets/img/shop_logos/' . $row['shop_logo'] . '" alt="Shop Logo">
                      </span>
                      <div class="icon-box-content">
                        <a href="vendor.php?id=' . $row['vendor_id'] . '" class="stretched-link"><h3 class="icon-box-title text-truncate">' . $row['shop_name'] . '</h3></a><!-- End .icon-box-title -->
                        <p class="text-truncate text-wrap text-muted">' . reduceWords($row['description'], 120) . '</p>
                      </div><!-- End .icon-box-content -->
                    </div><!-- End .icon-box -->
                  </div><!-- End .col-lg-2 .col-sm-4 -->';
      }
      return $data;
    }
    
    // Get other vendor details
    public function vendorDetails($vendorId)
    {
      $sql    = "SELECT * FROM vendors WHERE vendor_id=?";
      $params = [$vendorId];
      $row    = $this->selectQuery($sql, $params)->fetch_assoc();
      return '<img src="assets/img/shop_logos/' . $row['shop_logo'] . '" alt="Shop Logo" style="height:150px">
              <h5 class="font-weight-bold text-center">' . $row['shop_name'] . '</h5>
              <p>' . $row['description'] . '</p>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">Telephone <span>' . phone($row['business_phone']) . '</span></li>
                <li class="list-group-item">WhatsApp <span>' . phone($row['whatsapp']) . '</span></li>
                <li class="list-group-item">Email <span>' . email($row['business_email']) . '</span></li>
                <li class="list-group-item">Address <span>' . $row['address'] . '</span></li>
                <li class="list-group-item">City <span>' . $this->cityName($row['city']) . '</span></li>
                <li class="list-group-item">Country <span>' . $this->countryName($row['country']) . '</span></li>
              </ul>
              <div class="row">
                <div class="col-12">
                  ' . $row['iframe_code'] . '
                </div>
              </div>';
    }
    
    // Get only products by a specific vendor
    public function showVendorProducts($vendorId)
    {
      $content = "<div class='col-12 w-100 text-center mb-2 bg-primary'><p class='text-center text-white'>Vendors has not yet uploaded products for sale. We apologize for the inconveniences caused.</p></div>";
      $sql     = "SELECT * FROM products INNER JOIN categories ON products.category_id=categories.category_id WHERE vendor_id=?";
      $params  = [esc($vendorId)];
      $result  = $this->selectQuery($sql, $params);
      
      $top          = "";
      $new          = "";
      $discount     = "";
      $productCount = 0;
      if ($result->num_rows > 0) {
        $content = '';
        while ($row = $result->fetch_assoc()) {
          // Increase product count
          $productCount++;
          $imgs = explode(", ", $row['product_image']);
          // Check if product was added in less that 7 days
          if (daysBack($row['created_at']) <= 7) {
            $new = '<span class="product-label label-new">New Arrival</span>';
          }
          // Check if the product is among the top rated and viewed
          if ($this->top10($row['product_id'])) {
            $top = '<span class="product-label label-top">TOP</span>';
          }
          // Check if the product is among the top rated and viewed
          if ($this->discounted($row['product_id'])) {
            $top       = '<span class="product-label label-sale">' . $this->productDiscount($row['product_id']) . '% OFF</span>';
            $hoursLeft = '<div class="product-countdown" data-until="+' . HoursLeft($this->productDiscountTimeLeft($row['product_id'])) . 'h" data-relative="true" data-labels-short="true"></div><!-- End .product-countdown -->';
          } else {
            $top       = "";
            $hoursLeft = "";
          }
          
          if ($this->discounted($row['product_id'])) {
            $currentPrice = CURRENCY . " " . number_format(($row['current_price'] - ($row['current_price'] * ($this->productDiscount($row['product_id']) / 100))));
          } else {
            $currentPrice = CURRENCY . " " . number_format($row['current_price']);
          }
          
          // Display search results, e.g., product names and links
          $content .= '<div class="col-6 col-md-4 col-lg-4 col-xl-3">
                          <div class="product text-center">
                            <figure class="product-media p-0">
                              ' . $top . $new . $discount . '
                              <a href="product.php?id=' . $row['product_id'] . '">
                                <img src="assets/img/products/' . $imgs[0] . '" alt="Product image" class="product-image">
                                <img src="assets/img/products/' . $imgs[1] . '" alt="Product image" class="product-image-hover">
                              </a>
                              ' . $hoursLeft . '
                              <div class="product-action-vertical">
                                <a href="javascript:void(0)" class="btn-product-icon btn-wishlist wishlistBtn" data-id="' . $row['product_id'] . '" data-toggle="tooltip" title="Add to wishlist"><span>Add to wishlist</span></a>
                                <a href="javascript:void(0)" class="btn-product-icon btn-quickview quickviewBtn" data-id="' . $row['product_id'] . '" data-toggle="tooltip" title="Quick view"><span>Quick view</span></a>
                                <a href="javascript:void(0)" class="btn-product-icon btn-compare compareBtn" data-id="' . $row['product_id'] . '" data-toggle="tooltip" title="Compare"><span>Compare</span></a>
                              </div><!-- End .product-action-vertical -->
                              <div class="product-action product-action-dark">
                                <a href="javascript:void(0)" class="btn-product btn-cart cartBtn" data-id="' . $row['product_id'] . '"><span>Cart</span></a>
                                <a href="chat.php?vendor=' . $row['vendor_id'] . '&prod=' . $row['product_id'] . '" class="btn-product btn-chat" title="Chat with Vendor"><span class="icon-comments">&nbsp;&nbsp;Chat</span></a>
                              </div><!-- End .product-action -->
                            </figure><!-- End .product-media -->
                            <div class="product-body">
                              <div class="product-cat">
                                <a href="category.php?id=' . $row['category_id'] . '">' . $row['category_name'] . '</a>
                              </div><!-- End .product-cat -->
                              <h3 class="product-title"><a href="product.php?id=' . $row['product_id'] . '">' . $row['product_name'] . '</a></h3><!-- End .product-title -->
                              <div class="product-price">
                                <span class="new-price">' . $currentPrice . '</span>
                              </div><!-- End .product-price -->
                              <div class="ratings-container">
                                <div class="ratings" data-toggle="tooltip" title="' . $row['average_stars'] . ' Stars">
                                  <div class="ratings-val" style="width: ' . (($row['average_stars'] / 5) * 100) . '%;"></div><!-- End .ratings-val -->
                                </div><!-- End .ratings -->
                                <span class="ratings-text">( ' . number_format($row['total_reviews']) . ' Reviews )</span>
                              </div><!-- End .rating-container -->
                            </div><!-- End .product-body -->
                          </div><!-- End .product -->
                        </div><!-- End .col-6 -->';
        }
      }
      
      return $content;
    }
    
  }
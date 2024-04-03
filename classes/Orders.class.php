<?php
  
  class Orders extends Config
  {
    public function createOrder($customerId, $products, $totalAmount)
    {
      // Logic to create a new order.
      // Store order details and products in the database.
    }
    
    public function getOrderDetails($orderId)
    {
      // Logic to retrieve order details for a specific order.
      // Query the database for order information, including products and customer details.
    }
    
    public function listOrders()
    {
      // Logic to list all orders.
      // Query the database for order details and customer information.
    }
    
    public function updateOrderStatus($orderId, $status)
    {
      $sql    = "UPDATE salesorders SET status=? WHERE order_id=?";
      $params = [$status, $orderId];
      $result = $this->updateQuery($sql, $params);
      return json_encode(['status' => 'success', 'message' => 'Order status changes successfully to ' . $status]);
    }
    
    public function cancelOrder($orderId)
    {
      // Logic to cancel an order.
      // Update the order status and notify the customer about the cancellation.
    }
    
    public function calculateOrderTotal($products)
    {
      // Logic to calculate the total amount for an order based on selected products.
    }
    
    public function listVendorOrders($vendorId = null)
    {
      $data   = [];
      $userId = esc($_SESSION['user_id']);
      $sql    = "SELECT *, salesorders.status AS statuses FROM salesorders
                INNER JOIN salesorderitems ON salesorders.order_id=salesorderitems.order_id
                INNER JOIN products ON salesorderitems.product_id=products.product_id
                INNER JOIN vendors ON vendors.vendor_id=products.vendor_id
                INNER JOIN users ON users.user_id=vendors.user_id
                WHERE users.user_id=? GROUP BY salesorders.order_number ORDER BY salesorders.seen";
      $params = [$userId];
      $data   = $this->selectQuery($sql, $params);
      return $data;
    }
    
    public function listOtherVendorsOrders()
    {
      $data   = [];
      $userId = esc($_SESSION['user_id']);
      $sql    = "SELECT *, salesorders.status AS statuses FROM salesorders
                INNER JOIN salesorderitems ON salesorders.order_id=salesorderitems.order_id
                INNER JOIN products ON salesorderitems.product_id=products.product_id
                INNER JOIN vendors ON vendors.vendor_id=products.vendor_id
                INNER JOIN users ON users.user_id=vendors.user_id
                WHERE users.user_id!=? GROUP BY salesorders.order_number ORDER BY salesorders.seen";
      $params = [$userId];
      $data   = $this->selectQuery($sql, $params);
      return $data;
    }
    
    public function changeOrderStatus($orderId)
    {
      // Assuming you have a database connection, fetch the vendor-specific status of items from the salesorderitems table
      $vendorItemStatus = $this->getVendorItemStatus($orderId);
      // Define the sales order statuses
      $status = [
        'pending',
        'invoiced',
        'accepted',
        'partially accepted',
        'processing',
        'partial processing',
        'processed',
        'partially processed',
        'completed',
        'partially completed',
        'packaging',
        'partial packaging',
        'packaged',
        'partially packaged',
        'transporting',
        'partial transporting',
        'delivered',
        'partial delivery',
        'canceled'
      ];
      // Iterate through the statuses and check if any vendor has items with the corresponding status
      foreach ($status as $orderStatus) {
        $allVendorsHaveStatus = true;
        
        foreach ($vendorItemStatus as $vendorStatus) {
          if (!in_array($orderStatus, $vendorStatus)) {
            $allVendorsHaveStatus = false;
            break;
          }
        }
        
        // If all vendors have items with the current status, set it as the sales order status
        if ($allVendorsHaveStatus) {
          // Update the sales order status in the database
          $this->updateOrderStatus($orderId, $orderStatus);
          break; // Exit the loop once the status is determined
        }
      }
    }
    
    // Function to fetch vendor-specific item statuses from the salesorderitems table
    private function getVendorItemStatus($orderId)
    {
      // Implement logic to fetch vendor-specific item statuses from the salesorderitems table based on $orderId
      // Return an array of statuses for each vendor
      $data   = [];
      $userId = esc($_SESSION['user_id']);
      $sql    = "SELECT * FROM salesorderitems
                  INNER JOIN products ON salesorderitems.product_id=products.product_id
                  INNER JOIN vendors ON vendors.vendor_id=products.vendor_id
                  INNER JOIN users ON users.user_id=vendors.user_id
                  WHERE users.user_id=? && order_id=?";
      $params = [$userId, $orderId];
      $stmt   = $this->selectQuery($sql, $params);
      
      while ($row = $stmt->fetch_assoc()) {
        $data[$userId][] = $row['status'];
      }
      
      return $data;
    }
    
    public function viewClientOrder($orderId)
    {
      $data   = '';
      $userId = esc($_SESSION['user_id']);
      $sql    = "SELECT *, salesorderitems.size AS sizes, salesorderitems.color AS colors, salesorderitems.status AS state FROM salesorderitems
                INNER JOIN salesorders ON salesorderitems.order_id=salesorders.order_id
                INNER JOIN products ON salesorderitems.product_id=products.product_id
                INNER JOIN vendors ON vendors.vendor_id=products.vendor_id
                INNER JOIN users ON users.user_id=vendors.user_id
                WHERE salesorderitems.order_id=? && users.user_id=?";
      $params = [$orderId, $userId];
      $result = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        $no   = 1;
        $data = '<div class="table-responsive">
                  <table class="table table-sm table-striped table-hover">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Size</th>
                        <th>Color</th>
                        <th>Status</th>
                        <th>Change Status</th>
                      </tr>
                    </thead>
                    <tbody>';
        while ($row = $result->fetch_assoc()) {
          $data .= '<tr>
                      <td>' . $no . '</td>
                      <td>' . $row['product_name'] . '</td>
                      <td>' . $row['quantity'] . '</td>
                      <td>' . $row['sizes'] . '</td>
                      <td><a href="javascript:void(0)" style="background: ' . $row['colors'] . '" class="color-display"></td>
                      <td class="orderProductStatus" data-item="' . $row['item_id'] . '">' . $row['state'] . '</td>
                      <td>
                        <select id="orderProductStatusChanger" data-item="' . $row['item_id'] . '">
                          <option value="Processing" ' . (($row['state'] === 'Processing') ? "selected" : "") . '>Processing</option>
                          <option value="Processed" ' . (($row['state'] === 'Processed') ? "selected" : "") . '>Processed</option>
                          <option value="Verifying" ' . (($row['state'] === 'Verifying') ? "selected" : "") . '>Verifying</option>
                          <option value="Verified" ' . (($row['state'] === 'Verified') ? "selected" : "") . '>Verified</option>
                          <option value="Packaging" ' . (($row['state'] === 'Packaging') ? "selected" : "") . '>Packaging</option>
                          <option value="Packed" ' . (($row['state'] === 'Packed') ? "selected" : "") . '>Packed</option>
                          <option value="Rejected" ' . (($row['state'] === 'Rejected') ? "selected" : "") . '>Rejected</option>
                          <option value="Viewed" ' . (($row['state'] === 'Viewed') ? "selected" : "") . '>Viewed</option>
                          <option value="Pending" ' . (($row['state'] === 'Pending') ? "selected" : "") . '>Pending</option>
                        </select>
                      </td>
                    </tr>';
          $no++;
        }
        $data .= '</tbody></table></div>';
      }
      return $data;
    }
    
    public function changeOrderItemStatus($itemId, $status)
    {
      // Update Order Status
      $get = $this->selectQuery("SELECT order_id FROM salesorderitems WHERE item_id=?", [$itemId])->fetch_assoc();
      $this->changeOrderStatus($get['order_id']);
      // Update Order Item Status
      $sql    = "UPDATE salesorderitems SET status=? WHERE item_id=?";
      $params = [$status, $itemId];
      if ($this->updateQuery($sql, $params)) {
        return json_encode(['status' => 'success', 'message' => 'Order item status changed successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Order item status failed to be changed.']);
      }
    }
    
    public function rejectOrder($orderId)
    {
      $userId = esc($_SESSION['user_id']);
      $sql    = "UPDATE salesorders SET status='canceled' WHERE order_id=? ";
      $params = [$orderId];
      if ($this->updateQuery($sql, $params)) {
        return json_encode(['status' => 'success', 'message' => 'Order rejected successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Order already rejected.']);
      }
    }
    
    public function orderProductsVendor($orderId)
    {
      $data   = 0;
      $userId = esc($_SESSION['user_id']);
      $sql    = "SELECT COUNT(salesorderitems.product_id) AS num FROM salesorders
                INNER JOIN salesorderitems ON salesorders.order_id=salesorderitems.order_id
                INNER JOIN products ON salesorderitems.product_id=products.product_id
                INNER JOIN vendors ON vendors.vendor_id=products.vendor_id
                INNER JOIN users ON users.user_id=vendors.user_id
                WHERE users.user_id=? && salesorderitems.order_id=? GROUP BY salesorders.order_number ORDER BY salesorders.seen";
      $params = [$userId, $orderId];
      $data   = $this->selectQuery($sql, $params)->fetch_assoc();
      return $data['num'];
    }
    
    public function orderQuantityVendor($orderId)
    {
      $data   = 0;
      $userId = esc($_SESSION['user_id']);
      $sql    = "SELECT SUM(salesorderitems.quantity) AS num FROM salesorders
                INNER JOIN salesorderitems ON salesorders.order_id=salesorderitems.order_id
                INNER JOIN products ON salesorderitems.product_id=products.product_id
                INNER JOIN vendors ON vendors.vendor_id=products.vendor_id
                INNER JOIN users ON users.user_id=vendors.user_id
                WHERE users.user_id=? && salesorderitems.order_id=? GROUP BY salesorders.order_number ORDER BY salesorders.seen";
      $params = [$userId, $orderId];
      $data   = $this->selectQuery($sql, $params)->fetch_assoc();
      return $data['num'];
    }
    
    public function orderAmountVendor($orderId)
    {
      $data   = 0;
      $userId = esc($_SESSION['user_id']);
      $sql    = "SELECT SUM(quantity * current_price) AS num FROM salesorders
                INNER JOIN salesorderitems ON salesorders.order_id=salesorderitems.order_id
                INNER JOIN products ON salesorderitems.product_id=products.product_id
                INNER JOIN vendors ON vendors.vendor_id=products.vendor_id
                INNER JOIN users ON users.user_id=vendors.user_id
                WHERE users.user_id=? && salesorderitems.order_id=? GROUP BY salesorders.order_number ORDER BY salesorders.seen";
      $params = [$userId, $orderId];
      $data   = $this->selectQuery($sql, $params)->fetch_assoc();
      return $data['num'];
    }
    
    public function listCustomerOrders($clientId = null)
    {
    
    }
    
    public function productPrice($productId)
    {
      $sql    = "SELECT current_price FROM products WHERE product_id=?";
      $params = [$productId];
      $row    = $this->selectQuery($sql, $params)->fetch_assoc();
      return $row['current_price'];
    }
  
    public function checkOut($formData)
    {
      // Transfer Address by testing if it is a customer or a guest
      // Transfer the order from cart to orders for processing
      // Create the order number and tracking number
      // Create an invoice for the order which will be used for payments
      $user_id     = isset($_SESSION['user_id']) ?? null;
      $user        = esc($_SESSION['username']);
      $orderNo     = randomCode(6);
      $trackingNo  = randomCode(8);
      $totalAmount = $this->orderTotalAmount();
      $date        = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
      $data        = [];
      foreach ($formData as $item) {
        $name  = $item['name'];
        $value = $item['value'];
        // Check if the value is not empty before adding to the array
        if ($value !== '') {
          $data[$name] = $value;
        }
      }
      if (!isset($data['billingAddress'])) {
        return json_encode(['status' => 'warning', 'message' => 'Please fill-out all the fields correctly to complete your order.']);
      } else {
        // Check if the user is a customer or vendor
        if ($user_id !== null) {
          // If new billing address, add it to the user addresses or quest addresses
          if ($data['billingAddress'] === 'Add New Address') {
            $billing = $this->insertQuery("INSERT INTO useraddresses
                    (user_id, address_line1, address_line2, city, postal_code, country)
                    VALUES (?, ?, ?, ?, ?, ?)", [$user_id, $data['address_line'], $data['address_line_2'], $data['city'], $data['postal_code'], $data['country']]);
          } else {
            $billing = $data['billingAddress'];
          }
          // if New delivery address add it to the address book
          if ($data['deliveryAddress'] === 'Add New Delivery Address' && !isset($data['sameAddress'])) {
            // If new delivery address
            $delivery = $this->insertQuery("INSERT INTO useraddresses
                    (user_id, address_line1, address_line2, city, postal_code, country)
                    VALUES (?, ?, ?, ?, ?, ?)", [$user_id, $data['d_address_line'], $data['d_address_line2'], $data['deliveryCity'], $data['d_postal_code'], $data['deliveryCountry']]);
          } elseif ($data['deliveryAddress'] !== 'Add New Delivery Address' && !isset($data['sameAddress'])) {
            // If Other billing address
            $delivery = $data['deliveryAddress'];
          } else {
            // Same as the billing address
            $delivery = $billing;
          }
          // Add order
          $transfer = $this->insertQuery("INSERT INTO salesorders
                        (user, order_date, order_number, tracking_number, customer_name, customer_email, customer_phone, total_amount, contact_person, contact_phone, billing, delivery, more_info, status)
                        VALUES
                        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
            [$user, $date, $orderNo, $trackingNo, $data['full_name'], $data['email'], $data['telephone'], $totalAmount, $data['contact_person'], $data['contactPhone'], $billing, $delivery, $data['notes'], 'pending']);
          // Transfer order items from cart
          $sql = $this->insertQuery("INSERT INTO salesorderitems (order_id, product_id, quantity, unit_price, total_amount, color, size)
                            SELECT ?, product_id, quantity, unit_price, total_amount, color, size  FROM cart WHERE user=?", [$transfer, $user]);
          if ($transfer && $sql) {
            $this->deleteQuery("DELETE FROM cart WHERE user=?", [$user]);
            return json_encode(['status' => 'success', 'message' => 'Your order is made successfully.']);
          } else {
            return json_encode(['status' => 'warning', 'message' => 'Ordering Totally Failed.']);
          }
        } else {
          // Guest User
          $billing = "";
          // If new billing address, add it to the user addresses or quest addresses
          if ($data['billingAddress'] === 'Add New Address') {
            $billing = $this->insertQuery("INSERT INTO guest_addresses
                    (guest, address_type, address_line_1, address_line_2, city, postal_code, country)
                    VALUES (?, ?, ?, ?, ?, ?, ?)", [$user, "Billing Address", $data['address_line'], $data['address_line_2'], $data['city'], $data['postal_code'], $data['country']]);
          }
          // if New delivery address add it to the address book
          if ($data['deliveryAddress'] === 'Add New Delivery Address' && !isset($data['sameAddress'])) {
            $delivery = $this->insertQuery("INSERT INTO guest_addresses
                    (guest, address_type, address_line_1, address_line_2, city, postal_code, country)
                    VALUES (?, ?, ?, ?, ?, ?, ?)", [$user, "Delivery Address", $data['d_address_line'], $data['d_address_line2'], $data['deliveryCity'], $data['d_postal_code'], $data['deliveryCountry']]);
          } else {
            // Same as the billing address
            $delivery = $billing;
          }
          // Add other values to the database
          // Add order
          $transfer = $this->insertQuery("INSERT INTO salesorders
                  (user, order_date, order_number, tracking_number, customer_name, customer_email, customer_phone, total_amount, contact_person, contact_phone, billing, delivery, more_info, status)
                  VALUES
                  (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
            [$user, $date, $orderNo, $trackingNo, $data['full_name'], $data['email'], $data['telephone'], $totalAmount, $data['contact_person'], $data['contactPhone'], "g_" . $billing, "g_" . $delivery, $data['notes'], 'pending']);
          // Transfer order items from cart
          $sql = $this->insertQuery("insert into salesorderitems (order_id, product_id, quantity,unit_price, total_amount, color, size)
                        SELECT " . $transfer . ", product_id, quantity, unit_price, total_amount, color, size  from cart where user=?", [$user]);
          if ($transfer && $sql) {
            $this->deleteQuery("DELETE FROM cart WHERE user=?", [$user]);
            return json_encode(['status' => 'success', 'message' => 'Your order is made successfully.']);
          } else {
            return json_encode(['status' => 'warning', 'message' => 'Ordering Totally Failed.']);
          }
          
          
        }
      }
    }
    
    public function checkoutDetails()
    {
      $amount = 0;
      $data   = '<div class="summary">
                <h3 class="summary-title">Your Order</h3><!-- End .summary-title -->
                <table class="table table-summary">
                  <thead>
                    <tr>
                      <th>Product</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody>';
      $user   = esc($_SESSION['username']);
      $sql    = "SELECT * FROM cart INNER JOIN products ON cart.product_id=products.product_id WHERE user=?";
      $params = [$user];
      $result = $this->selectQuery($sql, $params);
      while ($row = $result->fetch_assoc()) {
        $data   .= '<tr>
                    <td><a href="product.php?id=' . $row['product_id'] . '">' . $row['product_name'] . '</a></td>
                    <td>' . CURRENCY . ' ' . number_format($row['current_price'], 2) . '</td>
                  </tr>';
        $amount += $row['current_price'];
      }
      $data .= '<tr class="summary-subtotal">
                  <td>Subtotal:</td>
                  <td>' . CURRENCY . ' ' . number_format($amount, 2) . '</td>
                </tr><!-- End .summary-subtotal -->
                <tr>
                  <td>Transportation:</td>
                  <td>Depends on Vendor</td>
                </tr>
                <tr class="summary-total">
                  <td>Total:</td>
                  <td>' . CURRENCY . ' ' . number_format($amount, 2) . '</td>
                </tr><!-- End .summary-total -->
                </tbody>
              </table><!-- End .table table-summary -->
									
              <div class="accordion-summary" id="accordion-payment">
                <div class="card">
                  <div class="card-header" id="heading-1">
                    <h2 class="card-title">
                      <a role="button" data-toggle="collapse" href="#collapse-1" aria-expanded="true" aria-controls="collapse-1">
                        Cash on delivery
                      </a>
                    </h2>
                  </div><!-- End .card-header -->
                  <div id="collapse-1" class="collapse show" aria-labelledby="heading-1" data-parent="#accordion-payment">
                    <div class="card-body">
                      You will make payments once the order is on your door.
                    </div><!-- End .card-body -->
                  </div><!-- End .collapse -->
                </div><!-- End .card -->
                
                <!--<div class="card">
                  <div class="card-header" id="heading-2">
                    <h2 class="card-title">
                      <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-2" aria-expanded="false" aria-controls="collapse-2">
                        Check payments
                      </a>
                    </h2>
                  </div>
                  <div id="collapse-2" class="collapse" aria-labelledby="heading-2" data-parent="#accordion-payment">
                    <div class="card-body">
                      Ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis.
                    </div>
                  </div>
                </div>-->
                
                <!--<div class="card">
                  <div class="card-header" id="heading-3">
                    <h2 class="card-title">
                      <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-3" aria-expanded="true" aria-controls="collapse-3">
                        Direct bank transfer
                      </a>
                    </h2>
                  </div>
                  <div id="collapse-3" class="collapse" aria-labelledby="heading-1" data-parent="#accordion-payment">
                    <div class="card-body">
                      Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order will not be shipped until the funds have cleared in our account.
                    </div>
                  </div>
                </div>-->
                
                <!--<div class="card">
                  <div class="card-header" id="heading-4">
                    <h2 class="card-title">
                      <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-4" aria-expanded="false" aria-controls="collapse-4">
                        PayPal <small class="float-right paypal-link">What is PayPal?</small>
                      </a>
                    </h2>
                  </div>
                  <div id="collapse-4" class="collapse" aria-labelledby="heading-4" data-parent="#accordion-payment">
                    <div class="card-body">
                      Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede. Donec nec justo eget felis facilisis fermentum.
                    </div>
                  </div>
                </div>-->
                
                <!--<div class="card">
                  <div class="card-header" id="heading-5">
                    <h2 class="card-title">
                      <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-5" aria-expanded="false" aria-controls="collapse-5">
                        Credit Card (Stripe)
                        <img src="assets/images/payments-summary.png" alt="payments cards">
                      </a>
                    </h2>
                  </div>
                  <div id="collapse-5" class="collapse" aria-labelledby="heading-5" data-parent="#accordion-payment">
                    <div class="card-body"> Donec nec justo eget felis facilisis fermentum.Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Lorem ipsum dolor sit ame.
                    </div
                  </div>
                </div>
              </div>-->
              
              <button type="submit" class="btn btn-outline-primary-2 btn-order btn-block">
                <span class="btn-text">Place Order</span>
                <span class="btn-hover-text">Complete Your Order</span>
              </button>
            </div><!-- End .summary -->';
      return $data;
    }
    
    public function userAddresses()
    {
      $data   = [];
      $user   = esc($_SESSION['username']);
      $sql    = "SELECT * FROM useraddresses INNER JOIN users ON useraddresses.user_id=users.user_id WHERE username=?";
      $params = [$user];
      $result = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $data[] = $row;
        }
      }
      return $data;
    }
    
    public function addressDetails($addressId)
    {
      $sql    = "SELECT * FROM useraddresses WHERE address_id=?";
      $params = [$addressId];
      $row    = $this->selectQuery($sql, $params)->fetch_assoc();
      
      return $row['postal_code'] . ", " . $row['address_line1'] . ", " . $this->cityName($row['city']) . "";
    }
    
    // Invoice Master
    public function invoiceDetails()
    {
      $data = '';
      $user = esc($_SESSION['username']);
      if (isset($_SESSION['user_id'])) {
        // For a logged in user
        $sql = "SELECT * FROM salesorders INNER JOIN users ON salesorders.user=users.username INNER JOIN useraddresses ON users.user_id=useraddresses.user_id WHERE salesorders.user=? ORDER BY order_id DESC LIMIT 1";
      } else {
        // For guest customer
        $sql = "SELECT * FROM salesorders INNER JOIN guest_addresses ON salesorders.user=guest_addresses.guest WHERE salesorders.user=? ORDER BY order_id DESC LIMIT 1";
      }
      $params = [$user];
      $result = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          // Update order status to invoiced
          $this->updateOrderStatus($row['order_id'], 'invoiced');
          // Run more data to display the invoice
          $data .= '<div class="container-fluid">
                      <div class="row">
                        <div class="col-sm-2">
                          <img src="' . FAVICON . '" alt="Your Company Logo" class="company-logo">
                        </div>
                        <div class="col-sm-4">
                          <h3 class="m-0 p-0"><strong>' . strtoupper(COMPANY) . '</strong></h3>
                          <p class="m-0 p-0" style="line-height: 1"><q><i>' . MOTTO . '</i></q></p>
                          <p class="m-0 p-0" style="line-height: 1">' . COMPANY_POST_NO . ', ' . LOCATION . '</p>
                          <p class="m-0 p-0" style="line-height: 1">Phone: ' . COMPANYPHONE . ', Email: ' . COMPANYEMAIL . '</p>
                        </div>
                        <div class="col-sm-6 text-right invoice-header">
                          <h1 class="m-0 p-0" style="line-height: 1">Invoice ' . $row['order_number'] . '</h1>
                          <ul class="list-unstyled mb0">
                            <li class="m-0 p-0" style="line-height: 1.3;"><strong>Order Date:</strong> ' . datel($row['order_date']) . '</li>
                            <li class="m-0 p-0" style="line-height: 1.3;"><strong>Tracking No.:</strong> ' . $row['tracking_number'] . '</li>
                            <li class="m-0 p-0" style="line-height: 1.3;"><strong>Status:</strong> <span class="label label-danger">' . ucwords($row['status']) . '</span></li>
                          </ul>
                        </div>
                      </div>
                      
                      <div class="row mt-3 bill-to-header">
                        <div class="col-sm-6">
                          <h5 class="m-0 p-0">Bill To</h5>
                          <ul class="list-unstyled">
                            <li class="m-0 p-0" style="line-height: 1.5;">' . strtoupper($row['customer_name']) . '</li>
                            <li class="m-0 p-0" style="line-height: 1.5;">' . $row['customer_phone'] . '</li>
                              <li class="m-0 p-0" style="line-height: 1.5;">' . $this->addressLine($row['billing']) . '</li>
                            <li class="m-0 p-0" style="line-height: 1.5;">' . $this->addressCityCountry($row['billing']) . '</li>
                          </ul>
                        </div>
                        <div class="col-sm-6 text-right">
                          <h5 class="m-0 p-0">Deliver To</h5>
                          <ul class="list-unstyled">
                            <li class="m-0 p-0" style="line-height: 1.5;">' . strtoupper($row['contact_person']) . '</li>
                            <li class="m-0 p-0" style="line-height: 1.5;">' . $row['contact_phone'] . '</li>
                              <li class="m-0 p-0" style="line-height: 1.5;">' . $this->addressLine($row['delivery']) . '</li>
                            <li class="m-0 p-0" style="line-height: 1.5;">' . $this->addressCityCountry($row['delivery']) . '</li>
                          </ul>
                        </div>
                      </div>
                      
                      ' . $this->orderItems($row['order_id']) . '
                      
                      <div class="row mt-3 total-section">
                        <div class="col-sm-8">
                          <p><strong>Notes:</strong></p>
                          <p class="font-weight-normal text-muted note-text">
                            <i>
                              Thank you for choosing Discount Ville for your service needs. We value your business and appreciate the opportunity to serve you.
                              Your invoice <b>' . $row['order_number'] . '</b> and order tracking <b>' . $row['tracking_number'] . '</b> is prepared, and we\'d like to inform you that payments are set for
                              delivery. We hope our services bring you utmost satisfaction. Should you require any further information or assistance, please feel free to reach out to our customer support team.
                            </i>
                          </p>
                        </div>
                        <div class="col-sm-4 text-right">
                          ' . $this->orderTotals($row['order_id']) . '
                        </div>
                      </div>
                    </div>';
        }
      }
      
      return $data;
    }
    
    private function orderItems($order_no)
    {
      $data   = '';
      $sql    = "SELECT * FROM salesorderitems
            INNER JOIN products ON salesorderitems.product_id=products.product_id
            INNER JOIN vendors ON products.vendor_id=vendors.vendor_id
            WHERE order_id=? ORDER BY vendors.vendor_id";
      $params = [$order_no];
      $result = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        $data = '<table class="table table-striped mt-3">
                  <thead>
                    <tr>
                      <th>Vendor</th>
                      <th>Description</th>
                      <th>Quantity</th>
                      <th>Price (' . CURRENCY . ')</th>
                      <th>Amount (' . CURRENCY . ')</th>
                    </tr>
                  </thead>
                  <tbody>';
        while ($row = $result->fetch_assoc()) {
          $data .= '<tr>
                      <td class="text-left">' . $row['shop_name'] . '</td>
                      <td class="text-left">' . $row['product_name'] . '</td>
                      <td class="text-right">' . number_format($row['quantity']) . '</td>
                      <td class="text-right">' . number_format($row['current_price'], 2) . '</td>
                      <td class="text-right">' . number_format($row['quantity'] * $row['current_price'], 2) . '</td>
                    </tr>';
        }
        $data .= '</tbody></table>';
      }
      
      return $data;
    }
    
    private function orderTotals($order_no)
    {
      $amount = 0;
      $sql    = "SELECT * FROM salesorderitems
            INNER JOIN products ON salesorderitems.product_id=products.product_id
            INNER JOIN vendors ON products.vendor_id=vendors.vendor_id
            WHERE order_id=? ORDER BY vendors.vendor_id";
      $params = [$order_no];
      $result = $this->selectQuery($sql, $params);
      while ($row = $result->fetch_assoc()) {
        $amount += ($row['quantity'] * $row['current_price']);
      }
      return '<p><strong>Subtotal:</strong> ' . CURRENCY . ' ' . number_format($amount, 2) . '</p>
              <p><strong>Tax:</strong> ' . CURRENCY . ' ' . number_format(0, 2) . '</p>
              <!--<p><strong>Transportation:</strong> $210.00</p>-->
              <p><strong>Total:</strong> ' . CURRENCY . ' ' . number_format($amount, 2) . '</p>';
    }
    
    private function addressLine($address_no)
    {
      $data = '';
      if (str_contains($address_no, 'g_')) {
        $sql = "SELECT * FROM guest_addresses WHERE gaid=?";
      } else {
        $sql = "SELECT * FROM useraddresses WHERE address_id=?";
      }
      $params = [str_replace('g_', '', $address_no)];
      $result = $this->selectQuery($sql, $params);
      while ($row = $result->fetch_assoc()) {
        $data = $row['postal_code'] . ', ' . (($row['address_line_1'] ?? $row['address_line1']));
      }
      return $data;
    }
    
    private function addressCityCountry($address_no)
    {
      $data = '';
      if (str_contains($address_no, 'g_')) {
        $sql = "SELECT * FROM guest_addresses WHERE gaid=?";
      } else {
        $sql = "SELECT * FROM useraddresses WHERE address_id=?";
      }
      $params = [str_replace('g_', '', $address_no)];
      $result = $this->selectQuery($sql, $params);
      while ($row = $result->fetch_assoc()) {
        $data = $this->cityName($row['city']) . ', ' . $this->countryName($row['country']);
      }
      return $data;
    }
    
    // Print the order receipt
    public function generateReceiptPrintout($order_number)
    {
      // Fetch stock movement data for the specified track number
      $sql    = "SELECT * FROM salesorders WHERE order_number = ?";
      $params = [$order_number];
      $row    = $this->selectQuery($sql, $params)->fetch_assoc();
      
      $getItems   = "SELECT * FROM salesorders so
                  INNER JOIN salesorderitems s ON so.order_id = s.order_id
                  INNER JOIN products p ON s.product_id = p.product_id
                  INNER JOIN vendors v ON v.vendor_id = p.vendor_id
                  INNER JOIN users u ON u.user_id = v.user_id
                  WHERE order_number=? && u.user_id=?";
      $itemParams = [$order_number, $_SESSION['user_id']];
      $data       = $this->selectQuery($getItems, $itemParams);
      $items      = [];
      while ($rowed = $data->fetch_assoc()) {
        $items[] = $rowed;
      }
      $no        = 1;
      $subTotal  = 0;
      $itemsRows = '';
      foreach ($items as $item) {
        $itemsRows .= '<tr>
                          <td>' . $no . '</td>
                          <td>' . $item['product_name'] . '</td>
                          <td>' . $item['quantity'] . '</td>
                          <td>' . (!empty($item['unit_price']) ? number_format($item['unit_price'], 2) : '0.00') . '</td>
                          <td>' . (!empty($item['total_amount']) ? number_format($item['total_amount'], 2) : '0.00') . '</td>
                        </tr>';
        $subTotal  += $item['total_amount'];
        $no++;
      }
      
      $no       = 1;
      $printout = '<!DOCTYPE html>
                    <html lang="en">
                      <head>
                      <meta charset="utf-8">
                      <meta name="viewport" content="width=device-width, initial-scale=1">
                      <title>' . COMPANY . ' | Receipt Print</title>
                    
                      <!-- Google Font: Source Sans Pro -->
                      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
                      <!-- Font Awesome -->
                      <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
                      <!-- Theme style -->
                      <link rel="stylesheet" href="../assets/css/adminlte.min.css">
                      <style>
                        .header {
                          padding: 10px;
                          text-align: center;
                          border-bottom: 2px solid #ccc; /* Add a border for separation */
                          overflow: hidden; /* Clear floats */
                        }
                        .header h1 {
                          margin: 0;
                          font-size: 26px;
                          text-transform: uppercase;
                        }
                        .header h3 {
                          margin: 0;
                          font-size: 20px;
                          text-transform: uppercase;
                        }
                        .header p {
                          margin: 0;
                          font-size: 16px;
                        }
                        .logo {
                          max-width: 100px; /* Limit the logo size */
                          margin-bottom: 10px; /* Add space between logo and text */
                          float: left; /* Float the logo to the left */
                        }
                        .header-text {
                          margin-left: 120px; /* Adjust the left margin to accommodate the logo */
                        }
                        table {
                          width: 100%;
                          border-collapse: collapse;
                        }
                        th, td {
                          border: 1px solid #ddd;
                          padding: 3px;
                        }
                      </style>
                    </head>
                      <body>
                        <div class="wrapper">
                          <!-- Main content -->
                          <section class="invoice">
                            <!-- title row -->
                            <div class="row">
                              <div class="col-12">
                                <div class="header">
                                  <img src="' . FAVICON . '" alt="Company Logo" class="logo">
                                  <h1>' . str_replace(" ", "-", COMPANY) . '</h1>
                                  <p><em><small><q>' . MOTTO . '</q></small></em></p>
                                  <p><b>Web: </b>' . URL . ', <b>Email: </b>' . COMPANYEMAIL . ', <b>Phone: </b>' . COMPANYPHONE . '</p>
                                  <h3>RECEIPT</h3>
                                </div>
                              </div>
                              <!-- /.col -->
                            </div>
                            <!-- info row -->
                            <div class="row invoice-info">
                              <div class="col invoice-col">
                                From
                                <address>
                                  ' . $this->vendorDetails($_SESSION['user_id']) . '
                                </address>
                              </div>
                              <!-- /.col -->
                              <div class="col invoice-col">
                                Bill To
                                <address>
                                  <strong>' . $row['customer_name'] . '</strong><br>
                                  ' . $this->addressDetails($row['billing']) . '<br>
                                  Phone: ' . $row['customer_phone'] . '<br>
                                  Email: ' . $row['customer_email'] . '
                                </address>
                              </div>
                              <!-- /.col -->
                              <div class="col invoice-col">
                                Deliver To
                                <address>
                                  <strong>' . $row['contact_person'] . '</strong><br>
                                  ' . $this->addressDetails($row['delivery']) . '<br>
                                  Phone: ' . $row['contact_phone'] . '
                                </address>
                              </div>
                              <!-- /.col -->
                              <div class="col invoice-col">
                                <b>Receipt #' . orderNumbering($row['order_id']) . '</b><br>
                                <br>
                                <b>Order No:</b> ' . $order_number . '<br>
                                <b>Order Date:</b> ' . dates(date('Y-m-d', $_SERVER['REQUEST_TIME'])) . '<br>
                                <b>Date:</b> ' . dates(date('Y-m-d', $_SERVER['REQUEST_TIME'])) . '
                              </div>
                              <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        
                            <!-- Table row -->
                            <div class="row">
                              <div class="col-12 table-responsive">
                                <table class="table table-sm table-striped">
                                  <thead>
                                  <tr>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Subtotal</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                    ' . $itemsRows . '
                                  </tbody>
                                </table>
                              </div>
                              <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        
                            <div class="row">
                              <!-- accepted payments column -->
                              <div class="col-8">
                                <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                  Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg dopplr
                                  jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                                </p>
                              </div>
                              <!-- /.col -->
                              <div class="col-4">
                        
                                <div class="table-responsive">
                                  <table class="table">
                                    <tr>
                                      <th style="width:50%">Subtotal:</th>
                                      <td>' . CURRENCY . ' ' . number_format($subTotal, 2) . '</td>
                                    </tr>
                                    <tr>
                                      <th>Tax (9.3%)</th>
                                      <td></td>
                                    </tr>
                                    <tr>
                                      <th>Transport:</th>
                                      <td></td>
                                    </tr>
                                    <tr>
                                      <th>Total:</th>
                                      <td>' . CURRENCY . ' ' . number_format($subTotal, 2) . '</td>
                                    </tr>
                                  </table>
                                </div>
                              </div>
                              <!-- /.col -->
                            </div>
                            <!-- /.row -->
                          </section>
                          <!-- /.content -->
                        </div>
                        <!-- ./wrapper -->
                        <!-- Page specific script -->
                        <script>
                          window.addEventListener("load", window.pr/assets());
                        </script>
                      </body>
                    </html>
                    ';
      return $printout;
    }
    
    private function vendorDetails($user_id)
    {
      $sql    = "SELECT * FROM users INNER JOIN vendors v ON users.user_id = v.user_id WHERE users.user_id=?";
      $params = [$user_id];
      $row    = $this->selectQuery($sql, $params)->fetch_assoc();
      return '<strong>' . $row['shop_name'] . '</strong><br>
              ' . $row['address'] . ', ' . $this->cityName($row['city']) . ', ' . $this->countryName($row['country']) . '<br>
              Phone: ' . $row['business_phone'] . '<br>
              Email: ' . $row['business_email'];
    }
    
    // Order Tracking
    public function orderTracking($trackingNumber)
    {
      // Define the sales order statuses
      $steps  = [
        'pending',
        'invoiced',
        'accepted',
        'processing',
        'completed',
        'packaging',
        'transporting',
        'delivered',
      ];
      $icon   = [
        'pending' => '<i class="fas fa-clock"></i>',
        'invoiced' => '<i class="fas fa-file-invoice"></i>',
        'accepted' => '<i class="fas fa-check"></i>',
        'processing' => '<i class="fas fa-cogs"></i>',
        'completed' => '<i class="fas fa-check-circle"></i>',
        'packaging' => '<i class="fas fa-box"></i>',
        'transporting' => '<i class="fas fa-truck"></i>',
        'delivered' => '<i class="fas fa-check-double"></i>',
      ];
      $sql    = "SELECT * FROM salesorders WHERE order_number=? || tracking_number=?";
      $params = [esc($trackingNumber), esc($trackingNumber)];
      $result = $this->selectQuery($sql, $params);
      
      if ($result->num_rows > 0) {
        $row              = $result->fetch_assoc();
        $state            = "";
        $runningStepFound = false; // Flag to check if running step is found
        
        foreach ($steps as $step) {
          // Check if the step matches the current order status
          $completedClass = ($row['status'] === $step) ? "completed" : "";
          
          // Check if the step is the current running step
          $runningClass = ($row['status'] === $step) ? "running" : "";
          
          // Check if the step is before the current running step
          if ($row['status'] !== $step && !$runningStepFound) {
            $completedClass = "completed";
          }
          
          // Check if the step is after the current running step
          if ($row['status'] === $step) {
            $runningStepFound = true;
          }
          
          $state .= '<div class="step ' . $completedClass . ' ' . $runningClass . '">
                            <div class="step-icon-wrap">
                                <div class="step-icon">' . $icon[$step] . '</div>
                            </div>
                            <h4 class="step-title">' . ucwords($step) . '</h4>
                        </div>';
        }
        return '<div class="p-4 text-center text-white text-lg bg-primary rounded-top">
                  <span class="text-uppercase font-weight-bold">Tracking / Order No - </span><span class="text-medium">' . esc($trackingNumber) . '</span>
                </div>
                <div class="d-flex flex-wrap flex-sm-nowrap justify-content-between py-3 px-2 bg-secondary">
                  <div class="w-100 text-center font-weight-bold py-1 px-2"><span class="font-weight-normal text-medium">Transporting Via:</span> UPS Ground</div>
                  <div class="w-100 text-center font-weight-bold py-1 px-2"><span class="font-weight-normal text-medium">Status:</span> ' . ucwords($row['status']) . '</div>
                  <div class="w-100 text-center font-weight-bold py-1 px-2"><span class="font-weight-normal text-medium">Order Date:</span> ' . datel($row['order_date']) . '</div>
                  <div class="w-100 text-center font-weight-bold py-1 px-2"><span class="font-weight-normal text-medium">Expected At:</span> ' . datel(date("Y-m-d H:i:sA", strtotime("+45 min", strtotime($row['order_date'])))) . '</div>
                </div>
                <div class="card-body">
                  <div class="steps d-flex flex-wrap flex-sm-nowrap justify-content-between padding-top-2x padding-bottom-1x">
                    ' . $state . '
                  </div>
                </div>';
      } else {
        return 'The order number or tracking number entered does not match our database. Try again with a correct number';
      }
    }
    
    // More Configurations
    public function cityCountries()
    {
      $countries = new Country();
      
      return '<div class="col-md-6">
                <div class="form-group">
                  <label for="country">Country *</label>
                  <select id="country" name="country" class="form-control custom-select select-custom select2">
                    ' . $countries->countiesCombo() . '
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="city">City *</label>
                  <select id="city" name="city" class="form-control custom-select select-custom select2">
                    ' . $countries->getCountryCities() . '
                  </select>
                </div>
              </div>';
    }
    
    public function cityCountriesDelivery()
    {
      $countries = new Country();
      
      return '<div class="col-md-6">
                <div class="form-group">
                  <label for="dcountry">Country *</label>
                  <select id="dcountry" name="deliveryCountry" class="form-control custom-select select-custom select2">
                    ' . $countries->countiesCombo() . '
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="dcity">City *</label>
                  <select id="dcity" name="deliveryCity" class="form-control custom-select select-custom select2">
                    ' . $countries->getCountryCities() . '
                  </select>
                </div>
              </div>';
    }
    
    public function cityName($code)
    {
      $data = new Config();
      return $data->cityName($code);
    }
    
    public function countryName($code)
    {
      $data = new Config();
      return $data->countryName($code);
    }
    
    private function orderTotalAmount()
    {
      $user   = esc($_SESSION['username']);
      $sql    = "SELECT sum(quantity * current_price) AS totals FROM cart INNER JOIN products ON cart.product_id=products.product_id WHERE cart.user=? ";
      $params = [$user];
      $result = $this->selectQuery($sql, $params)->fetch_assoc();
      return $result['totals'];
    }
    
  }

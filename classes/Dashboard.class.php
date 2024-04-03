<?php
  
  class Dashboard extends Config
  {
    private $auditTrail;
    
    public function __construct()
    {
      parent::__construct();
      $this->auditTrail = new AuditTrail();
    }
    
    public function getTotalSales()
    {
      $data   = 0;
      $sql    = "SELECT sum(total_amount) AS amounts FROM salesorders WHERE status='completed' ";
      $result = $this->selectQuery($sql)->fetch_assoc();
      return (($result['amounts'] > 0) ? $result['amounts'] : $data);
    }
    
    public function getTotalCustomers()
    {
      $data   = 0;
      $sql    = "SELECT count(order_id) AS customers FROM salesorders WHERE status!='canceled' GROUP BY customer_phone";
      $result = $this->selectQuery($sql);
      while ($row = $result->fetch_assoc()) {
        $data += $row['customers'];
      }
      return $data;
    }
    
    public function getTotalProducts()
    {
      $data   = 0;
      $sql    = "SELECT count(product_id) AS nums FROM products";
      $result = $this->selectQuery($sql)->fetch_assoc();
      return (($result['nums'] > 0) ? $result['nums'] : $data);
    }
    
    public function getTotalOrders()
    {
      $data   = 0;
      $sql    = "SELECT count(order_id) AS nums FROM salesorders";
      $result = $this->selectQuery($sql)->fetch_assoc();
      return (($result['nums'] > 0) ? $result['nums'] : $data);
    }
    
    public function getPendingOrders()
    {
      $data   = 0;
      $sql    = "SELECT count(order_id) AS nums FROM salesorders WHERE status='processing' ";
      $result = $this->selectQuery($sql)->fetch_assoc();
      return (($result['nums'] > 0) ? $result['nums'] : $data);
    }
    
    public function getCompletedOrders()
    {
      $data   = 0;
      $sql    = "SELECT count(order_id) AS nums FROM salesorders WHERE status='completed' ";
      $result = $this->selectQuery($sql)->fetch_assoc();
      return (($result['nums'] > 0) ? $result['nums'] : $data);
    }
    
    public function getTotalSuppliers()
    {
      $data   = 0;
      $sql    = "SELECT count(user_id) AS nums FROM users";
      $result = $this->selectQuery($sql)->fetch_assoc();
      return (($result['nums'] > 0) ? $result['nums'] : $data);
    }
    
    public function getTotalUsers()
    {
      $sql    = "SELECT count(user_id) AS nums FROM users";
      $result = $this->selectQuery($sql)->fetch_assoc();
      return $result['nums'];
    }
    
    public function getTotalProfit($startDate, $endDate)
    {
      // Logic to calculate and return the total profit for the specified period
      // You can consider subtracting total costs from total revenue to calculate profit
    }
    
    // Other methods for KPIs...
    
    // Method to handle profit management (as requested)
    public function manageProfits($startDate, $endDate)
    {
      // Logic to manage profits, e.g., track expenses and calculate net profit
      // You can also consider generating profit reports for the specified period
    }
    
    // VENDOR's DASHBOARD
    public function getRealTimeSalesData()
    {
      // Perform database query to fetch real-time sales data
      // Ensure you format the data as an array, e.g., ['timestamp' => '2023-08-01 12:00:00', 'sales' => 100]
      $sql    = "SELECT * FROM salesorders";
      $result = $this->selectQuery($sql);
      
      $salesData = [];
      while ($row = $result->fetch_assoc()) {
        $salesData[] = ['timestamp' => dates($row['order_date']), 'sales' => $row['total_amount']];
      }
      
      return $salesData;
    }
    
    public function totalCounts()
    {
      return '<div class="col-sm-3">
									<div class="card bg-danger text-white">
										<div class="card-body">
										  <p>
                        <a href="orders.php">New Orders</a><br>
                        <span>3</span>
											</p>
                      <i class="icon fa fa-user"></i>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="card bg-warning">
										<div class="card-body">
										  <p>
                        <a href="orders.php">Total Orders</a><br>
                        <span>3</span>
											</p>
                      <i class="icon fa fa-user"></i>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="card bg-success">
										<div class="card-body">
										  <p>
                        <a href="products.php">Products</a><br>
                        <span>3</span>
											</p>
                      <i class="icon fa fa-user"></i>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="card bg-info">
										<div class="card-body">
										  <p>
                        <a href="customers.php">Customers</a><br>
                        <span>3</span>
											</p>
                      <i class="icon fa fa-user"></i>
										</div>
									</div>
								</div>';
    }
    
    public function latestSales()
    {
      $sql    = "SELECT * FROM salesorders
                    INNER JOIN salesorderitems s ON salesorders.order_id = s.order_id
                    INNER JOIN products p ON s.product_id = p.product_id
                    INNER JOIN vendors v ON p.vendor_id = v.vendor_id
                    WHERE v.vendor_id=?
                    GROUP BY order_number ORDER BY salesorders.order_id DESC LIMIT 10";
      $params = [$this->getVendorId()];
      $result = $this->selectQuery($sql, $params);
      $orders = "";
      while ($row = $result->fetch_assoc()) {
        $orders .= '<tr>
											<td><a href="javascript:void(0)">' . orderNumbering($row['order_id']) . '</a></td>
											<td>' . $row['customer_name'] . '<br>' . phone($row['customer_phone']) . '</td>
											<td>' . $row['total_amount'] . '</td>
											<td>' . $row['status'] . '</td>
										</tr>';
      }
      return $orders;
    }
    
    public function profileCompletionChart()
    {
      // check user profile completion
      // Check shop details
      // Check product upload
      $user     = (($this->selectQuery("SELECT * FROM users WHERE user_id=?", [$_SESSION['user_id']])->num_rows > 0) ? 1 : 0);
      $address  = (($this->selectQuery("SELECT * FROM useraddresses WHERE user_id=?", [$_SESSION['user_id']])->num_rows > 0) ? 1 : 0);
      $shop     = (($this->selectQuery("SELECT * FROM vendors WHERE user_id=?", [$_SESSION['user_id']])->num_rows > 0) ? 1 : 0);
      $products = (($this->selectQuery("SELECT * FROM products INNER JOIN vendors v ON products.vendor_id = v.vendor_id INNER JOIN users u ON v.user_id = u.user_id WHERE u.user_id=?", [$_SESSION['user_id']])->num_rows > 0) ? 1 : 0);
      $count    = ($user + $address + $shop + $products);
      // Test the cases while enabling the user to complete the steps with a link
      if ($count === 0 || $count === 1) {
        $action = '<a href="profile.php" class="btn btn-xs btn-block mt-3 btn-primary">Complete Your Profile.</a>';
      } elseif ($count === 2) {
        $action = '<a href="shop.php" class="btn btn-xs btn-block mt-3 btn-primary">Complete Shop Details.</a>';
      } elseif ($count === 3) {
        $action = '<a href="products.php" class="btn btn-xs btn-block mt-3 btn-primary">Add a Product.</a>';
      } else {
        $action = '100% Completed';
      }
      
      return '<h5 class="card-title text-center w-100">Profile Completion</h5>
              <canvas id="profileChart"></canvas>
              <p class="card-text text-center w-100">' . $action . '</p>
              <script>
                var config = {
                  type: "pie",
                  data: {
                    datasets: [{
                      data: [
                        ' . $count . ', ' . (4 - $count) . '
                      ],
                      backgroundColor: ["#007a00"],
                      borderColor: "transparent",
                    }],
                    labels: ["Completed", "Waiting Setup"],
                  },
                  options: {
                    responsive: true,
                    legend: {
                      display: false
                    },
                    tooltips: {
                      enabled: true,
                    }
                  }
                };
                
                window.onload = function() {
                  var ctx = document.getElementById("profileChart").getContext("2d");
                  window.myPie = new Chart(ctx, config);
                };
              </script>';
    }
    
  }
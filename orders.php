<?php
  
  include_once "includes/header.inc.php";
  
  $data = new Orders();

?>
  
  <main class="main">
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
      <div class="container">
        <ol class="breadcrumb navbar navbar-expand-lg">
          <li class="breadcrumb-item"><a href="./">Home</a></li>
          <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
          <li class="breadcrumb-item active" aria-current="page">Orders</li>
	
	        <button class="ml-auto navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		        <span class="navbar-toggler-icon"></span>
	        </button>
        </ol>
      </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->
    
    <div class="page-content">
      <div class="dashboard">
        <div class="container">
          <div class="row">
              <?php
                
                include_once "includes/userMenu.inc.php";
              
              ?>
            
            <div class="col-md-9">
              <div class="row">
                <div class="col-6">
                  <h4>Order Management</h4>
                </div>
                <div class="col-12 systemMsg"></div>
                <div class="col-12">
                  <div class="table-responsive">
                    <table class="table table-bordered table-sm table-hover table-condensed table-striped dataTable">
                      <thead>
                      <tr>
                        <th>#</th>
                        <th>Order Date</th>
                        <th>Order No</th>
                        <th>Products</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                        <!--<th>Status</th>-->
                        <th>New?</th>
                        <th>Action</th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php
                        
                        $no       = 1;
                        $orders = $data->listVendorOrders();
                        foreach ($orders as $order) {
                          $img = explode(", ", $order['product_image'])[0];
                          $new  = (($order['seen'] === 'Yes')? "Seen" : "Yes");
                          echo '<tr>
																	<td>' . $no . '</td>
																	<!--<td><img src="./assets/img/products/' . $img . '" alt="' . $order['product_name'] . ' Image"></td>-->
																	<td>' . date('h:iA', strtotime($order['order_date'])) . '<br>' . date('d/m/Y', strtotime($order['order_date'])) . '</td>
																	<td>' . $order['order_number'] . '</td>
																	<td>' . number_format($data->orderProductsVendor($order['order_id'])) . '</td>
																	<td>' . number_format($data->orderQuantityVendor($order['order_id'])) . '</td>
																	<td>' . number_format($data->orderAmountVendor($order['order_id']), 2) . '</td>
																	<!--<td>' . ucwords($order['statuses']) . '</td>-->
																	<td>' . $new . '</td>
																	<td>
																		<button class="viewOrderBtn btn btn-xs btn-rounded btn-secondary" data-id="' . esc($order['order_id']) . '">View</button>
																		<button class="receiptBtn btn btn-xs btn-rounded btn-success" data-id="' . esc($order['order_id']) . '">Receipt</button>
																		<button class="btn btn-xs btn-rounded btn-danger" onclick="if (confirm(\'Are you sure you want to cancel this order, this can be done if you do not have products?\')) {$(this).addClass(\'rejectOrderBtn\');}" data-id="' . esc
	                          ($order['order_id']) . '">Reject</button>
																	</td>
																</tr>';
                          $no++;
                        }
                      
                      ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div><!-- End .col-lg-9 -->
          </div><!-- End .row -->
        </div><!-- End .container -->
      </div><!-- End .dashboard -->
    </div><!-- End .page-content -->
  </main><!-- End .main -->

<?php
  
  include_once "includes/footer.inc.php";

?>
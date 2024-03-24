<?php
  
  include_once "../includes/adminHeader.inc.php";
  
  $data = new Orders();

?>
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?= PAGE ?> Management</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active"><?= PAGE ?></li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="systemMsg"></div>
        <?php
          
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $addProduct = new Frontend();
            $id         = $addProduct->addProductClient($_POST);
            echo alert($id['status'], $id['message']);
          }
        
        ?>
        <!-- Card with Card Tool -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"><?= PAGE ?> List</h3>
          </div>
          <div class="card-body">
            <div class="table-responsive">
	            <div class="table-responsive">
		            <table class="table table-bordered table-sm table-hover table-condensed table-striped dataTable">
			            <thead>
			            <tr>
				            <th>#</th>
				            <th>Order Date</th>
				            <th>Order No</th>
				            <th>Customer</th>
				            <th>Contact Person</th>
				            <th>Address</th>
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
																	<td>' . $order['customer_name'] . '<br>' . phone($order['customer_phone']) . '<br>' . email($order['customer_email']) . '</td>
																	<td>' . $order['contact_person'] . '<br>' . phone($order['contact_phone']) . '</td>
																	<td><b>Billing: </b>' . $data->addressDetails($order['billing']) . '<hr class="bg-primary my-1"><b>Delivery: </b>' . $data->addressDetails($order['delivery']) . '</td>
																	<td>' . number_format($data->orderProductsVendor($order['order_id'])) . '</td>
																	<td>' . number_format($data->orderQuantityVendor($order['order_id'])) . '</td>
																	<td>' . number_format($data->orderAmountVendor($order['order_id']), 2) . '</td>
																	<!--<td>' . ucwords($order['statuses']) . '</td>-->
																	<td>' . $new . '</td>
																	<td>
																		<button class="viewOrderBtn btn btn-xs btn-rounded btn-secondary" data-id="' . esc($order['order_id']) . '">View</button>
																		<a href="receipt.php?id=' . $order['order_number'] . '" target="_blank" class="btn btn-xs btn-rounded btn-success" data-id="' . esc($order['order_id']) . '">Receipt</a>
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
        </div>
        <!-- End Card with Card Tool -->
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
  
  include_once "../includes/adminFooter.inc.php";

?>
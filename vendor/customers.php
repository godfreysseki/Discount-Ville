<?php
  
  include_once "../includes/adminHeader.inc.php";
  
  $data = new Customers();
  $check = new Vendors();

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
        <!-- Card with Card Tool -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"><?= PAGE ?> List</h3>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-sm table-hover table-condensed table-striped dataTable">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Customer</th>
                  <th>Phone</th>
                  <th>Email</th>
                  <th>Address</th>
                  <th>Orders</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                  
                  $no       = 1;
                  $products = $data->showMyCustomers();
                  foreach ($products as $product) {
                    $img = explode(", ", $product['product_image'])[0];
                    echo '<tr>
																	<td>' . $no . '</td>
																	<td>' . $product['customer_name'] . '</td>
																	<td>' . phone($product['customer_phone']) . '</td>
																	<td>' . email($product['customer_email']) . '</td>
																	<td>' . $product['billing'] . '</td>
																	<td>' . $product['orders'] . '</td>
																	<td>
																		<button class="viewCustomerBtn btn btn-xs btn-rounded btn-secondary" data-id="' . esc($product['product_id']) . '">View</button>
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
        <!-- End Card with Card Tool -->
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
  
  include_once "../includes/adminFooter.inc.php";

?>
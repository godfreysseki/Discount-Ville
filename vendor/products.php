<?php
  
  include_once "../includes/adminHeader.inc.php";
  
  $data = new Frontend();
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
        <?php
    
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $addProduct = new Products();
            $id         = $addProduct->addProductClient($_POST);
            echo alert($id['status'], $id['message']);
          }
  
        ?>
        <!-- Card with Card Tool -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"><?= PAGE ?> List</h3>
            <div class="card-tools">
              <!-- Dropdown Menu -->
              <div class="dropdown">
                <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                  <i class="fas fa-wrench"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                  <a href="javascript:void(0)" class="addProductBtn dropdown-item">Add Product</a>
                </div>
              </div>
              <!-- End Dropdown Menu -->
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-sm table-hover table-condensed table-striped dataTable">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Image</th>
                  <th>Product</th>
                  <th>Category</th>
                  <th>Stock</th>
                  <th>Reorder Level</th>
                  <th>Original Price</th>
                  <th>Selling Price</th>
                  <th>Views</th>
                  <th>Reviews</th>
                  <th>Stars</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
        
                  $no       = 1;
                  $products = $data->listMyProducts();
                  foreach ($products as $product) {
                    $img = explode(", ", $product['product_image'])[0];
                    echo '<tr>
																	<td>' . $no . '</td>
																	<td><img src="../assets/img/products/' . $img . '" alt="' . $product['product_name'] . ' Image"></td>
																	<td>' . $product['product_name'] . '</td>
																	<td>' . $product['category_name'] . '</td>
																	<td>' . $product['quantity_in_stock'] . '</td>
																	<td>' . $product['reorder_level'] . '</td>
																	<td>' . $product['original_price'] . '</td>
																	<td>' . $product['current_price'] . '</td>
																	<td>' . $product['total_views'] . '</td>
																	<td>' . $product['total_reviews'] . '</td>
																	<td>' . $product['average_stars'] . '</td>
																	<td>
																		<button class="viewProductBtn btn btn-xs btn-rounded btn-secondary" data-id="' . esc($product['product_id']) . '">View</button>
																		<button class="editProductBtn btn btn-xs btn-rounded btn-success" data-id="' . esc($product['product_id']) . '">Edit</button>
																		<button class="btn btn-xs btn-rounded btn-danger" onclick="if (confirm(\'Are you sure you want to delete this record?\')) {$(this).addClass(\'deleteProductBtn\');}" data-id="' . esc($product['product_id']) . '">Delete</button>
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
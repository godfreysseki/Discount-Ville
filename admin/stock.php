<?php
  
  include_once "../includes/adminHeader.inc.php";
  
  $data = new Stock();

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
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
              echo $data->addStock($_POST['product_id'], $_POST['quantity']);
            }
          }
        
        ?>
        <!-- Card with Card Tool -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"><?= PAGE ?> Levels</h3>
          </div>
          <div class="card-body">
	          <div class="table-responsive">
		          <table class="table table-sm table-hover table-condensed table-striped dataTable">
			          <thead>
			          <tr>
				          <th>#</th>
				          <th>Image</th>
				          <th>Product</th>
				          <th>Measurements</th>
				          <th>Stock</th>
				          <th>Reorder Level</th>
				          <th>Status</th>
				          <th>Action</th>
			          </tr>
			          </thead>
			          <tbody>
                <?php
        
                  $no       = 1;
                  $products = $data->showStock();
                  foreach ($products as $product) {
                    $img = explode(", ", $product['product_image'])[0];
                    echo '<tr>
																	<td>' . $no . '</td>
																	<td><img src="../assets/img/products/' . $img . '" alt="' . $product['product_name'] . ' Image"></td>
																	<td>' . $product['product_name'] . '</td>
																	<td>' . $product['measurements'] . '</td>
																	<td>' . $product['quantity_in_stock'] . '</td>
																	<td>' . $product['reorder_level'] . '</td>
																	<td>' . ($product['quantity_in_stock'] > $product['reorder_level'] ? '<span class="badge badge-info right">Stocked</span>' : ($product['quantity_in_stock'] == 0 ? '<span class="badge badge-danger right">Out of Stock</span>' : '<span class="badge badge-warning right">Running Out</span>')) . '</td>
																	<td>
																		<button class="addStockBtn btn btn-xs btn-primary" data-id="' . esc($product['product_id']) . '">Add Stock</button>
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
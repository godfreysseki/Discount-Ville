<?php
  
  include_once "includes/header.inc.php";
  
  $data = new Stock();

?>
	
	<main class="main">
		<nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
			<div class="container">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="./">Home</a></li>
					<li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
					<li class="breadcrumb-item active" aria-current="page">Stock</li>
					
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
									<h4>Stock Management</h4>
								</div>
								<div class="col-6 text-right">
								</div>
								<div class="col-12 systemMsg"></div>
								<div class="col-12">
                  <?php
                    
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                      $addStock = new Stock();
                      echo $addStock->addStock($_POST['product_id'], $_POST['quantity']);
                    }
                  
                  ?>
								</div>
								<div class="col-12">
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
																	<td><img src="./assets/img/products/' . $img . '" alt="' . $product['product_name'] . ' Image"></td>
																	<td>' . $product['product_name'] . '</td>
																	<td>' . $product['measurements'] . '</td>
																	<td>' . $product['quantity_in_stock'] . '</td>
																	<td>' . $product['reorder_level'] . '</td>
																	<td>
																		<button class="addStockBtn btn btn-xs btn-rounded btn-secondary" data-id="' . esc($product['product_id']) . '">Add Stock</button>
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
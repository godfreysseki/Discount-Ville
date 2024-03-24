<?php
  
  include_once "../includes/adminHeader.inc.php";
  
  $data = new Products();

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
            $id = $data->addProduct($_POST);
            if ($id > 0) {
              echo alert('success', 'Product Added Successfully. Id: ' . $id);
            } else {
              echo alert('warning', 'Product Failed.');
            }
          }
        
        ?>
				
				<!-- Card with Card Tools -->
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">
							Product List
						</h3>
						<div class="card-tools">
							<ul class="nav nav-pills ml-auto">
								<li class="nav-item">
									<a href="javascript:void(0)" class="addProductBtn nav-link">Add Product</a>
								</li>
								<li class="nav-item">
									<a class="nav-link active" href="#your-store" data-toggle="tab">Your Store</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="#other-vendors" data-toggle="tab">Other Vendors</a>
								</li>
							</ul>
						</div>
					</div><!-- /.card-header -->
					<div class="card-body">
						<div class="tab-content p-0">
							<div class="chart tab-pane active" id="your-store">
								<?php
								
									$products = $data->listMyProducts();
									
								?>
								<div class="table-responsive">
									<table class="table table-bordered table-sm table-striped dataTable">
										<thead>
										<tr>
											<th>#</th>
											<th>Image</th>
											<th>Product Name</th>
											<th>Short Description</th>
											<th>Unit Price</th>
											<th>Selling Price</th>
											<th>Qty in Stock</th>
											<th>Reorder Level</th>
											<th>Category</th>
											<th>Action</th>
										</tr>
										</thead>
										<tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($products as $product) : ?>
											<tr>
												<td><?= $no ?></td>
												<td><?php
                            $images = explode(', ', $product['product_image']);
                            foreach ($images as $image) {
                              echo '<img src="../assets/img/products/' . $image . '" alt="product images">';
                            }
                          ?></td>
												<td><?= esc($product['product_name']); ?></td>
												<td><?= esc($product['short_description']); ?></td>
												<td><?= CURRENCY . ' ' . number_format($product['original_price'], 2); ?></td>
												<td><?= CURRENCY . ' ' . number_format($product['current_price'], 2); ?></td>
												<td><?= $product['quantity_in_stock'] ?></td>
												<td><?= $product['reorder_level'] ?></td>
												<td><?= $product['category_name'] ?></td>
												<td>
													<button class="viewProductBtn btn btn-xs btn-link text-secondary" data-id="<?= esc($product['product_id']); ?>" data-toggle="tooltip" title="View"><span class="fa fa-eye"></span></button>
													<button class="editProductBtn btn btn-xs btn-link text-success" data-id="<?= esc($product['product_id']); ?>" data-toggle="tooltip" title="Edit"><span class="fa fa-pen-fancy"></span></button>
													<button class="btn btn-xs btn-link text-danger" onclick="if (confirm('Are you sure you want to delete this record?')) {$(this).addClass('deleteProductBtn');}" data-id="<?= esc($product['product_id']); ?>"
													        data-toggle="tooltip" title="Delete"><span
																class="fa
											fa-trash-alt"></span></button>
												</td>
											</tr>
                      <?php $no++; ?>
                    <?php endforeach; ?>
										</tbody>
									</table>
								</div>
							</div>
							<div class="chart tab-pane" id="other-vendors">
								<!-- Your Content Here (Product List Table, etc.) -->
                <?php
                  
                  $products = $data->listOtherVendorProducts();
                
                ?>
								<div class="table-responsive">
									<table class="table table-bordered table-sm table-striped dataTable">
										<thead>
										<tr>
											<th>#</th>
											<th>Image</th>
											<th>Product Name</th>
											<th>Short Description</th>
											<th>Unit Price</th>
											<th>Selling Price</th>
											<th>Qty in Stock</th>
											<th>Reorder Level</th>
											<th>Category</th>
											<th>Action</th>
										</tr>
										</thead>
										<tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($products as $product) : ?>
											<tr>
												<td><?= $no ?></td>
												<td><?php
                            $images = explode(', ', $product['product_image']);
                            foreach ($images as $image) {
                              echo '<img src="../assets/img/products/' . $image . '" alt="product images">';
                            }
                          ?></td>
												<td><?= esc($product['product_name']); ?></td>
												<td><?= esc($product['short_description']); ?></td>
												<td><?= CURRENCY . ' ' . number_format($product['original_price'], 2); ?></td>
												<td><?= CURRENCY . ' ' . number_format($product['current_price'], 2); ?></td>
												<td><?= $product['quantity_in_stock'] ?></td>
												<td><?= $product['reorder_level'] ?></td>
												<td><?= $product['category_name'] ?></td>
												<td>
													<button class="viewProductBtn btn btn-xs btn-link text-secondary" data-id="<?= esc($product['product_id']); ?>" data-toggle="tooltip" title="View"><span class="fa fa-eye"></span></button>
													<button class="editProductBtn btn btn-xs btn-link text-success" data-id="<?= esc($product['product_id']); ?>" data-toggle="tooltip" title="Edit"><span class="fa fa-pen-fancy"></span></button>
													<button class="btn btn-xs btn-link text-danger" onclick="if (confirm('Are you sure you want to delete this record?')) {$(this).addClass('deleteProductBtn');}" data-id="<?= esc($product['product_id']); ?>"
													        data-toggle="tooltip" title="Delete"><span
																class="fa
											fa-trash-alt"></span></button>
												</td>
											</tr>
                      <?php $no++; ?>
                    <?php endforeach; ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div><!-- /.card-body -->
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
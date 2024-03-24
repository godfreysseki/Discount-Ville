<?php
  
  include_once "../includes/adminHeader.inc.php";
  
  $data = new Dashboard();

?>
	
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Dashboard</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
						</ol>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->
		
		<!-- Main content -->
		<section class="content">
			<div class="container-fluid">
				<!-- Info boxes -->
				<div class="row">
					<div class="col-sm-9 order-1 order-lg-0">
						<div class="row">
							<div class="col-12 col-sm-6 col-md-4">
								<div class="info-box">
									<span class="info-box-icon bg-info elevation-1"><i class="fas fa-credit-card"></i></span>
									
									<div class="info-box-content">
										<a href="sales_orders.php">
											<span class="info-box-text">Total Sales</span>
										</a>
										<span class="info-box-number">
                  <?= "UGX " . number_format($data->getTotalSales(), 2) ?>
                </span>
									</div>
									<!-- /.info-box-content -->
								</div>
								<!-- /.info-box -->
							</div>
							<!-- /.col -->
							<div class="col-12 col-sm-6 col-md-4">
								<div class="info-box mb-3">
									<span class="info-box-icon bg-primary elevation-1"><i class="fas fa-users"></i></span>
									
									<div class="info-box-content">
										<a href="sales_orders.php">
											<span class="info-box-text">Total Customers</span>
										</a>
										<span class="info-box-number"><?= number_format($data->getTotalCustomers(), 2) ?></span>
									</div>
									<!-- /.info-box-content -->
								</div>
								<!-- /.info-box -->
							</div>
							<!-- /.col -->
							
							<!-- fix for small devices only -->
							<div class="clearfix hidden-md-up"></div>
							
							<div class="col-12 col-sm-6 col-md-4">
								<div class="info-box mb-3">
									<span class="info-box-icon bg-navy elevation-1"><i class="fas fa-box"></i></span>
									
									<div class="info-box-content">
										<a href="products.php">
											<span class="info-box-text">Total Products</span>
										</a>
										<span class="info-box-number"><?= number_format($data->getTotalProducts(), 2) ?></span>
									</div>
									<!-- /.info-box-content -->
								</div>
								<!-- /.info-box -->
							</div>
							<!-- /.col -->
							
							<div class="col-12 col-sm-6 col-md-4">
								<div class="info-box">
									<span class="info-box-icon bg-danger elevation-1"><i class="fas fa-file-invoice-dollar"></i></span>
									
									<div class="info-box-content">
										<a href="sales_orders.php">
											<span class="info-box-text">Completed Orders</span>
										</a>
										<span class="info-box-number">
                  <?= number_format($data->getCompletedOrders(), 2) ?>
                </span>
									</div>
									<!-- /.info-box-content -->
								</div>
								<!-- /.info-box -->
							</div>
							<!-- /.col -->
							
							<!-- fix for small devices only -->
							<div class="clearfix hidden-md-up"></div>
							
							<div class="col-12 col-sm-6 col-md-4">
								<div class="info-box mb-3">
									<span class="info-box-icon bg-orange elevation-1"><i class="fas fa-file-invoice"></i></span>
									
									<div class="info-box-content">
										<a href="sales_orders.php">
											<span class="info-box-text">Pending Orders</span>
										</a>
										<span class="info-box-number"><?= number_format($data->getPendingOrders(), 2) ?></span>
									</div>
									<!-- /.info-box-content -->
								</div>
								<!-- /.info-box -->
							</div>
							<!-- /.col -->
							
							<div class="col-12 col-sm-6 col-md-4">
								<div class="info-box mb-3">
									<span class="info-box-icon bg-purple elevation-1"><i class="fas fa-file-invoice"></i></span>
									
									<div class="info-box-content">
										<a href="sales_orders.php">
											<span class="info-box-text">Total Sales Orders</span>
										</a>
										<span class="info-box-number"><?= number_format($data->getTotalOrders(), 2) ?></span>
									</div>
									<!-- /.info-box-content -->
								</div>
								<!-- /.info-box -->
							</div>
							<!-- /.col -->
						</div>
					</div>
					
					<div class="col-sm-3 order-0 order-lg-1">
						<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-body py-1 profileCompletionChart">
										<?= $data->profileCompletionChart() ?>
									</div>
								</div>
								<!-- /.info-box -->
							</div>
						</div>
					</div>
				</div>
				<!-- /.row -->
				
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header">
								<h5 class="card-title">Realtime Sales</h5>
								
								<div class="card-tools">
									<button type="button" class="btn btn-tool" data-card-widget="collapse">
										<i class="fas fa-minus"></i>
									</button>
									<button type="button" class="btn btn-tool" data-card-widget="remove">
										<i class="fas fa-times"></i>
									</button>
								</div>
							</div>
							<!-- /.card-header -->
							<div class="card-body">
								<div class="row">
									<div class="col-md-12">
										<div class="chart">
											<!-- Sales Chart Canvas -->
											<canvas id="realTimeSalesChart" height="450" style="width:100%; height: 450px;"></canvas>
										</div>
										<!-- /.chart-responsive -->
									</div>
									<!-- /.col -->
								</div>
								<!-- /.row -->
							</div>
							<!-- ./card-body -->
						</div>
						<!-- /.card -->
					</div>
					<!-- /.col -->
				</div>
				<!-- /.row -->
				
				<!-- Main row -->
				<div class="row">
					<!-- Left col -->
					<div class="col-md-6">
						<!-- TABLE: LATEST ORDERS -->
						<div class="card">
							<div class="card-header border-transparent">
								<h3 class="card-title">Latest Sales Orders</h3>
							</div>
							<!-- /.card-header -->
							<div class="card-body p-0">
								<div class="table-responsive">
									<table class="table table-sm table-striped table-hover">
										<thead>
										<tr>
											<th>Order ID</th>
											<th>Customer</th>
											<th>Total Amount</th>
											<th>Status</th>
										</tr>
										</thead>
										<tbody>
                    <?php
                      
                      $orders = new Dashboard();
                      echo $orders->latestSales();
                    
                    ?>
										</tbody>
									</table>
								</div>
								<!-- /.table-responsive -->
							</div>
							<!-- /.card-body -->
							<div class="card-footer clearfix">
								<a href="javascript:void(0)" class="addSalesOrderBtn btn btn-sm btn-info float-left">Place New Order</a>
								<a href="sales_orders.php" class="btn btn-sm btn-secondary float-right">View All Orders</a>
							</div>
							<!-- /.card-footer -->
						</div>
						<!-- /.card -->
					</div>
					<!-- /.col -->
					
					<div class="col-md-6">
						
						<!-- PRODUCT LIST -->
						<div class="card">
							<div class="card-header">
								<h3 class="card-title">Low Stock Products</h3>
							</div>
							<!-- /.card-header -->
							<div class="card-body p-0">
							
							</div>
							<!-- /.card-body -->
							<div class="card-footer text-center">
								<a href="stock.php" class="uppercase">View Stock</a>
							</div>
							<!-- /.card-footer -->
						</div>
						<!-- /.card -->
					</div>
					<!-- /.col -->
				</div>
				<!-- /.row -->
			</div><!--/. container-fluid -->
		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->

<?php
  
  include_once "../includes/adminFooter.inc.php";

?>
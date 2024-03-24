<?php
  
  include_once "includes/header.inc.php";
  
?>
	
	<main class="main">
		<nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
			<div class="container">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="./">Home</a></li>
					<li class="breadcrumb-item active"><a href="dashboard.php">Dashboard</a></li>
					
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
							<div class="row counts">
								<!-- Total Counts Here... -->
							</div>
							<div class="row">
								<div class="col-sm-8">
									<div class="card border-0">
										<div class="card-body">
											<div class="chart">
												<!-- Sales Chart Canvas -->
												<canvas id="realTimeSalesChart" style="width:100%; height: 450px;"></canvas>
											</div>
											<!-- /.chart-responsive -->
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="row">
										<div class="col-12">
											<div class="card border-0">
												<div class="card-body">
													<div class="salesPie">
														<!-- Sales Orders Pie Chart -->
														<canvas id="realtimeSalesOrderStatus" style="width: 100%; height: 300px"></canvas>
													</div>
												</div>
											</div>
										</div>
										<div class="col-12">
											<!-- Realtime Sales Orders Status Table -->
											<div class="realtimeSalesOrderStatusTable"></div>
										</div>
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

<?php
  // Example array of sales order statuses and their counts
  $salesOrderStatuses = [
    'Delivered' => 25,
    'Cancelled' => 5,
  ];
?>

<script>
  // PHP array to JavaScript
  const salesOrderStatuses = <?php echo json_encode($salesOrderStatuses); ?>;
  
  // Get canvas element
  const ctx = document.getElementById('realtimeSalesOrderStatus').getContext('2d');
  
  // Create pie chart
  const salesOrderChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: Object.keys(salesOrderStatuses),
      datasets: [{
        data: Object.values(salesOrderStatuses),
        backgroundColor: [
          'rgba(33,172,0,0.7)',
          'rgba(250,0,52,0.7)',
        ],
        //borderWidth: 0,
      }],
    },
    options: {
      cutoutPercentage: 10,
      plugins: {
        zoom: {
          pan: {
            enabled: true,
            mode: 'xy',
          },
          zoom: {
            enabled: true,
            mode: 'xy',
          }
        }
      },
      responsive: true,
      maintainAspectRatio: false,
      legend: {
        position: 'bottom',
	      display: true,
      },
      title: {
        display: true,
        text: 'Sales Orders Status'
      },
      animation: {
        animateScale: true,
        animateRotate: true
      }
    }
  });
</script>

<?php
  
  include_once "includes/header.inc.php";
  
  $data             = new ServiceProviders();
  $serviceProviders = $data->listProviders();

?>
	
	<main class="main">
		<nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
			<div class="container">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href=./>Home</a></li>
					<li class="breadcrumb-item"><a href="javascript:void(0)">Pages</a></li>
					<li class="breadcrumb-item active">Service Providers</li>
				</ol>
			</div><!-- End .container -->
		</nav><!-- End .breadcrumb-nav -->
		
		<div class="page-content">
			<div class="container">
				<div class="text-center mb-2">
					<h3>Service Providers</h3>
					<p class="lead">If you ever need any service, we bring you the service providers that will suite your budget.</p>
				</div>
				
				<div class="row">
					
					<div class="col-12">
						<div class="search-bar">
							<input type="text" id="serviceSearch" class="form-control mb-2" placeholder="Search service...">
						</div>
					</div>
					
          <?php foreach ($serviceProviders as $provider): ?>
										
					<div class="col-sm-3 service" data-name="<?= strtolower($provider['job_service']) ?>">
						<div class="flip-card text-center">
							<div class="flip-card-front dark" style="height: 120px;">
								<div class="flip-card-inner">
									<div class="card bg-transparent border-0 text-center">
										<div class="card-body">
											<h3 class="card-title"><?= $provider['provider_name'] ?></h3>
											<p class="card-text fw-normal"><?= $provider['job_service'] ?><br><?= CURRENCY . ' ' . number_format($provider['min_price']) . ' - ' . number_format($provider['highest_price']) ?></p>
										</div>
									</div>
								</div>
							</div>
							<div class="flip-card-back" style="height: 120px;">
								<div class="flip-card-inner">
									<p class="mb-1 text-white"><?= reduceWords($provider['description'], 80) ?></p>
									<button type="button" data-id="<?= $provider['provider_id'] ?>" class="serviceDetails btn btn-outline-light">View Details</button>
								</div>
							</div>
						</div>
					</div>
          <?php endforeach; ?>
				</div>
			</div>
	</main>

<?php
  
  include_once "includes/footer.inc.php";

?>
<?php
  
  include_once "includes/header.inc.php";
  
  $data = new Orders();

?>
	<style type="text/css">
		body {
			margin-top: 20px;
		}
		
		.steps .step {
			display: block;
			width: 100%;
			margin-bottom: 35px;
			text-align: center
		}
		
		.steps .step .step-icon-wrap {
			display: block;
			position: relative;
			width: 100%;
			height: 80px;
			text-align: center
		}
		
		.steps .step .step-icon-wrap::before,
		.steps .step .step-icon-wrap::after {
			display: block;
			position: absolute;
			top: 50%;
			width: 50%;
			height: 3px;
			margin-top: -1px;
			background-color: #e1e7ec;
			content: '';
			z-index: 1
		}
		
		.steps .step .step-icon-wrap::before {
			left: 0
		}
		
		.steps .step .step-icon-wrap::after {
			right: 0
		}
		
		.steps .step .step-icon {
			display: inline-block;
			position: relative;
			width: 80px;
			height: 80px;
			border: 1px solid #e1e7ec;
			border-radius: 50%;
			background-color: #f5f5f5;
			color: #374250;
			font-size: 38px;
			line-height: 81px;
			z-index: 5
		}
		
		.steps .step .step-title {
			margin-top: 16px;
			margin-bottom: 0;
			color: #606975;
			font-size: 14px;
			font-weight: 500
		}
		
		.steps .step:first-child .step-icon-wrap::before {
			display: none
		}
		
		.steps .step:last-child .step-icon-wrap::after {
			display: none
		}
		
		.steps .step.completed .step-icon-wrap::before,
		.steps .step.completed .step-icon-wrap::after {
			background-color: #1478FF;
		}
		
		.steps .step.completed .step-icon {
			border-color: #1478FF;
			background-color: #1478FF;
			color: #fff
		}
		
		.steps .step.running .step-icon-wrap::before,
		.steps .step.running .step-icon-wrap::after {
			background-color: #26b000;
		}
		
		.steps .step.running .step-icon {
			border-color: #26b000;
			background-color: #26b000;
			color: #fff
		}
		
		@media (max-width: 576px) {
			.flex-sm-nowrap .step .step-icon-wrap::before,
			.flex-sm-nowrap .step .step-icon-wrap::after {
				display: none
			}
		}
		
		@media (max-width: 768px) {
			.flex-md-nowrap .step .step-icon-wrap::before,
			.flex-md-nowrap .step .step-icon-wrap::after {
				display: none
			}
		}
		
		@media (max-width: 991px) {
			.flex-lg-nowrap .step .step-icon-wrap::before,
			.flex-lg-nowrap .step .step-icon-wrap::after {
				display: none
			}
		}
		
		@media (max-width: 1200px) {
			.flex-xl-nowrap .step .step-icon-wrap::before,
			.flex-xl-nowrap .step .step-icon-wrap::after {
				display: none
			}
		}
		
		.bg-faded, .bg-secondary {
			background-color: #f5f5f5 !important;
		}
	</style>
	<main class="main">
		<nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
			<div class="container d-flex align-items-center">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="./">Home</a></li>
					<li class="breadcrumb-item"><a href="orders.php">Orders</a></li>
					<li class="breadcrumb-item active" aria-current="page">Track My Order</li>
				</ol>
			</div><!-- End .container -->
		</nav><!-- End .breadcrumb-nav -->
		
		<div class="page-content">
			<div class="container">
				<div class="row">
					<div class="col-12">
						
						<div class="card my-3 border-top-0">
							<form method="post">
								<div class="input-group mb-3">
									<input type="text" class="form-control" name="tracking_number" placeholder="Enter Tacking Number or Order Number" aria-label="Enter Tacking Number or Order Number" aria-describedby="button-addon2">
									<div class="input-group-append">
										<button class="btn btn-outline-primary" type="submit" id="button-addon2">Track Now</button>
									</div>
								</div>
							</form>
              <?php
                
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                  echo $data->orderTracking($_POST['tracking_number']);
                }
              
              ?>
						</div>
					
					</div>
				</div>
			</div>
		</div>
	</main>

<?php
  
  include_once "includes/footer.inc.php";

?>
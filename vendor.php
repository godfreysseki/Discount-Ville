<?php
  
  include_once "includes/header.inc.php";
  
  $data = new Vendors();

?>
	
	<main class="main">
		<nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
			<div class="container">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="index.html">Home</a></li>
					<li class="breadcrumb-item"><a href="vendors.php">Vendor List</a></li>
					<li class="breadcrumb-item active" aria-current="page">Vendor</li>
				</ol>
			</div><!-- End .container -->
		</nav><!-- End .breadcrumb-nav -->
		
		<div class="page-content pb-0">
			<div class="container">
				<div class="row">
					<div class="col-sm-3 mb-3 vendor-details">
						<h2 class="title">Vendor Details</h2><!-- End .title -->
              
              <?= $data->vendorDetails($_GET['id']) ?>
						
					</div><!-- End .col-lg-6 -->
					<div class="col-sm-9 mb-3">
						<h2 class="title">Vendor Products</h2><!-- End .title -->
						<div class="row">
              
              <?= $data->showVendorProducts($_GET['id']) ?>
						
						</div>
					</div><!-- End .col-lg-6 -->
				</div>
			</div>
		</div>
	</main>

<?php
  
  include_once "includes/footer.inc.php";

?>
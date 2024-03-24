<?php
  
  include_once "includes/header.inc.php";
  
  $data = new Frontend();

?>

<main class="main">
	<nav aria-label="breadcrumb" class="breadcrumb-nav">
		<div class="container">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="index.html">Home</a></li>
				<li class="breadcrumb-item"><a href="shop.php">Shop</a></li>
				<li class="breadcrumb-item active" aria-current="page">Compare</li>
			</ol>
		</div><!-- End .container -->
	</nav><!-- End .breadcrumb-nav -->
	
	<div class="page-content">
		<div class="cart">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<?php
						
							$products = $data->compareProducts();
						
							echo $data->renderComparisonTable($products);
							
						?>
					</div><!-- End .col-lg-12 -->
				</div><!-- End .row -->
			</div><!-- End .container -->
		</div><!-- End .cart -->
	</div><!-- End .page-content -->
</main><!-- End .main -->

<?php
  
  include_once "includes/footer.inc.php";

?>

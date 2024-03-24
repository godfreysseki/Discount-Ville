<?php
  
  include_once "includes/header.inc.php";
  
  $data = new Frontend();

?>
	
	<main class="main">
		<nav aria-label="breadcrumb" class="breadcrumb-nav">
			<div class="container">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="index.php">Home</a></li>
					<li class="breadcrumb-item"><a href="shop.php">Shop</a></li>
					<li class="breadcrumb-item active" aria-current="page">Wishlist</li>
				</ol>
			</div><!-- End .container -->
		</nav><!-- End .breadcrumb-nav -->
		
		<div class="page-content">
			<div class="container">
				
				<?php
				
					$products = $data->wishlistProducts();
					
					$data->renderWishlist($products);
				
				?>
			</div><!-- End .container -->
		</div><!-- End .page-content -->
	</main><!-- End .main -->

<?php
  
  include_once "includes/footer.inc.php";

?>
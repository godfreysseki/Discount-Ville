<?php
  
  include_once "includes/header.inc.php";
  
  $data = new Frontend();

?>
	
	<main class="main">
		<div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
			<div class="container">
				<h1 class="page-title">Shopping Cart<span>Shop</span></h1>
			</div><!-- End .container -->
		</div><!-- End .page-header -->
		<nav aria-label="breadcrumb" class="breadcrumb-nav">
			<div class="container">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="index.php">Home</a></li>
					<li class="breadcrumb-item"><a href="shop.php">Shop</a></li>
					<li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
				</ol>
			</div><!-- End .container -->
		</nav><!-- End .breadcrumb-nav -->
		
		<div class="page-content">
			<div class="cart">
				<div class="container">
					<div class="row">
						<div class="col-lg-9">
							
							<?php
							
								$products = $data->shoppingCartItems();
								
								$data->renderShoppingCart($products);
							
							?>
							
							<div class="cart-bottom">
								<div class="cart-discount">
									<form action="#">
										<div class="input-group">
											<!--<input type="text" class="form-control" required placeholder="coupon code">
											<div class="input-group-append">
												<button class="btn btn-outline-primary-2" type="submit"><i class="icon-long-arrow-right"></i></button>
											</div>--><!-- .End .input-group-append -->
										</div><!-- End .input-group -->
									</form>
								</div><!-- End .cart-discount -->
								
								<a href="javascript:void(0)" class="btn btn-outline-dark-2 updateCart"><span>UPDATE CART</span><i class="icon-refresh"></i></a>
							</div><!-- End .cart-bottom -->
						</div><!-- End .col-lg-9 -->
						<aside class="col-lg-3">
							
							<?= $data->cartSummary() ?>
							
							<a href="shop.php" class="btn btn-outline-dark-2 btn-block mb-3"><span>CONTINUE SHOPPING</span><i class="icon-refresh"></i></a>
						</aside><!-- End .col-lg-3 -->
					</div><!-- End .row -->
				</div><!-- End .container -->
			</div><!-- End .cart -->
		</div><!-- End .page-content -->
	</main><!-- End .main -->

<?php
  
  include_once "includes/footer.inc.php";

?>
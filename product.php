<?php
  
  include_once "includes/header.inc.php";
  
  $data = new Shopping();

?>
	
	<main class="main">
		<nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
			<div class="container d-flex align-items-center">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="./">Home</a></li>
					<li class="breadcrumb-item"><a href="shop.php">Products</a></li>
					<li class="breadcrumb-item active" aria-current="page">Product Details</li>
				</ol>
				
				<nav class="product-pager ml-auto" aria-label="Product">
					<a class="product-pager-link product-pager-prev" href="#" aria-label="Previous" tabindex="-1">
						<i class="icon-angle-left"></i>
						<span>Prev</span>
					</a>
					
					<a class="product-pager-link product-pager-next" href="#" aria-label="Next" tabindex="-1">
						<span>Next</span>
						<i class="icon-angle-right"></i>
					</a>
				</nav><!-- End .pager-nav -->
			</div><!-- End .container -->
		</nav><!-- End .breadcrumb-nav -->
		
		<div class="page-content">
			<div class="container">
				<div class="product-details-top">
					<div class="row">
						
						<?= $data->showProduct($_GET['id']) ?>
						
					</div><!-- End .row -->
				</div><!-- End .product-details-top -->
				
				<div class="product-details-tab">
					
					<?= $data->showProductDetails($_GET['id']) ?>
					
				</div><!-- End .product-details-tab -->
				
				<h2 class="title text-center mb-4">You May Also Like</h2><!-- End .title text-center -->
				
				<div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl"
				     data-owl-options='{
                            "nav": false, 
                            "dots": true,
                            "margin": 20,
                            "loop": false,
                            "responsive": {
                                "0": {
                                    "items":1
                                },
                                "480": {
                                    "items":2
                                },
                                "768": {
                                    "items":3
                                },
                                "992": {
                                    "items":4
                                },
                                "1200": {
                                    "items":4,
                                    "nav": true,
                                    "dots": false
                                }
                            }
                        }'>
					<div class="product product-7 text-center">
						<figure class="product-media">
							<span class="product-label label-new">New</span>
							<a href="product.html">
								<img src="assets/images/products/product-4.jpg" alt="Product image" class="product-image">
							</a>
							
							<div class="product-action-vertical">
								<a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add to wishlist</span></a>
								<a href="popup/quickView.html" class="btn-product-icon btn-quickview" title="Quick view"><span>Quick view</span></a>
								<a href="#" class="btn-product-icon btn-compare" title="Compare"><span>Compare</span></a>
							</div><!-- End .product-action-vertical -->
							
							<div class="product-action">
								<a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
							</div><!-- End .product-action -->
						</figure><!-- End .product-media -->
						
						<div class="product-body">
							<div class="product-cat">
								<a href="#">Women</a>
							</div><!-- End .product-cat -->
							<h3 class="product-title"><a href="product.html">Brown paperbag waist <br>pencil skirt</a></h3><!-- End .product-title -->
							<div class="product-price">
								$60.00
							</div><!-- End .product-price -->
							<div class="ratings-container">
								<div class="ratings">
									<div class="ratings-val" style="width: 20%;"></div><!-- End .ratings-val -->
								</div><!-- End .ratings -->
								<span class="ratings-text">( 2 Reviews )</span>
							</div><!-- End .rating-container -->
							
							<div class="product-nav product-nav-thumbs">
								<a href="#" class="active">
									<img src="assets/images/products/product-4-thumb.jpg" alt="product desc">
								</a>
								<a href="#">
									<img src="assets/images/products/product-4-2-thumb.jpg" alt="product desc">
								</a>
								
								<a href="#">
									<img src="assets/images/products/product-4-3-thumb.jpg" alt="product desc">
								</a>
							</div><!-- End .product-nav -->
						</div><!-- End .product-body -->
					</div><!-- End .product -->
					
					<div class="product product-7 text-center">
						<figure class="product-media">
							<span class="product-label label-out">Out of Stock</span>
							<a href="product.html">
								<img src="assets/images/products/product-6.jpg" alt="Product image" class="product-image">
							</a>
							
							<div class="product-action-vertical">
								<a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add to wishlist</span></a>
								<a href="popup/quickView.html" class="btn-product-icon btn-quickview" title="Quick view"><span>Quick view</span></a>
								<a href="#" class="btn-product-icon btn-compare" title="Compare"><span>Compare</span></a>
							</div><!-- End .product-action-vertical -->
							
							<div class="product-action">
								<a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
							</div><!-- End .product-action -->
						</figure><!-- End .product-media -->
						
						<div class="product-body">
							<div class="product-cat">
								<a href="#">Jackets</a>
							</div><!-- End .product-cat -->
							<h3 class="product-title"><a href="product.html">Khaki utility boiler jumpsuit</a></h3><!-- End .product-title -->
							<div class="product-price">
								<span class="out-price">$120.00</span>
							</div><!-- End .product-price -->
							<div class="ratings-container">
								<div class="ratings">
									<div class="ratings-val" style="width: 80%;"></div><!-- End .ratings-val -->
								</div><!-- End .ratings -->
								<span class="ratings-text">( 6 Reviews )</span>
							</div><!-- End .rating-container -->
						</div><!-- End .product-body -->
					</div><!-- End .product -->
					
					<div class="product product-7 text-center">
						<figure class="product-media">
							<span class="product-label label-top">Top</span>
							<a href="product.html">
								<img src="assets/images/products/product-11.jpg" alt="Product image" class="product-image">
							</a>
							
							<div class="product-action-vertical">
								<a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add to wishlist</span></a>
								<a href="popup/quickView.html" class="btn-product-icon btn-quickview" title="Quick view"><span>Quick view</span></a>
								<a href="#" class="btn-product-icon btn-compare" title="Compare"><span>Compare</span></a>
							</div><!-- End .product-action-vertical -->
							
							<div class="product-action">
								<a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
							</div><!-- End .product-action -->
						</figure><!-- End .product-media -->
						
						<div class="product-body">
							<div class="product-cat">
								<a href="#">Shoes</a>
							</div><!-- End .product-cat -->
							<h3 class="product-title"><a href="product.html">Light brown studded Wide fit wedges</a></h3><!-- End .product-title -->
							<div class="product-price">
								$110.00
							</div><!-- End .product-price -->
							<div class="ratings-container">
								<div class="ratings">
									<div class="ratings-val" style="width: 80%;"></div><!-- End .ratings-val -->
								</div><!-- End .ratings -->
								<span class="ratings-text">( 1 Reviews )</span>
							</div><!-- End .rating-container -->
							
							<div class="product-nav product-nav-thumbs">
								<a href="#" class="active">
									<img src="assets/images/products/product-11-thumb.jpg" alt="product desc">
								</a>
								<a href="#">
									<img src="assets/images/products/product-11-2-thumb.jpg" alt="product desc">
								</a>
								
								<a href="#">
									<img src="assets/images/products/product-11-3-thumb.jpg" alt="product desc">
								</a>
							</div><!-- End .product-nav -->
						</div><!-- End .product-body -->
					</div><!-- End .product -->
					
					<div class="product product-7 text-center">
						<figure class="product-media">
							<a href="product.html">
								<img src="assets/images/products/product-10.jpg" alt="Product image" class="product-image">
							</a>
							
							<div class="product-action-vertical">
								<a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add to wishlist</span></a>
								<a href="popup/quickView.html" class="btn-product-icon btn-quickview" title="Quick view"><span>Quick view</span></a>
								<a href="#" class="btn-product-icon btn-compare" title="Compare"><span>Compare</span></a>
							</div><!-- End .product-action-vertical -->
							
							<div class="product-action">
								<a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
							</div><!-- End .product-action -->
						</figure><!-- End .product-media -->
						
						<div class="product-body">
							<div class="product-cat">
								<a href="#">Jumpers</a>
							</div><!-- End .product-cat -->
							<h3 class="product-title"><a href="product.html">Yellow button front tea top</a></h3><!-- End .product-title -->
							<div class="product-price">
								$56.00
							</div><!-- End .product-price -->
							<div class="ratings-container">
								<div class="ratings">
									<div class="ratings-val" style="width: 0%;"></div><!-- End .ratings-val -->
								</div><!-- End .ratings -->
								<span class="ratings-text">( 0 Reviews )</span>
							</div><!-- End .rating-container -->
						</div><!-- End .product-body -->
					</div><!-- End .product -->
					
					<div class="product product-7 text-center">
						<figure class="product-media">
							<a href="product.html">
								<img src="assets/images/products/product-7.jpg" alt="Product image" class="product-image">
							</a>
							
							<div class="product-action-vertical">
								<a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add to wishlist</span></a>
								<a href="popup/quickView.html" class="btn-product-icon btn-quickview" title="Quick view"><span>Quick view</span></a>
								<a href="#" class="btn-product-icon btn-compare" title="Compare"><span>Compare</span></a>
							</div><!-- End .product-action-vertical -->
							
							<div class="product-action">
								<a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
							</div><!-- End .product-action -->
						</figure><!-- End .product-media -->
						
						<div class="product-body">
							<div class="product-cat">
								<a href="#">Jeans</a>
							</div><!-- End .product-cat -->
							<h3 class="product-title"><a href="product.html">Blue utility pinafore denim dress</a></h3><!-- End .product-title -->
							<div class="product-price">
								$76.00
							</div><!-- End .product-price -->
							<div class="ratings-container">
								<div class="ratings">
									<div class="ratings-val" style="width: 20%;"></div><!-- End .ratings-val -->
								</div><!-- End .ratings -->
								<span class="ratings-text">( 2 Reviews )</span>
							</div><!-- End .rating-container -->
						</div><!-- End .product-body -->
					</div><!-- End .product -->
				</div><!-- End .owl-carousel -->
			</div><!-- End .container -->
		</div><!-- End .page-content -->
	</main><!-- End .main -->

<?php
  
  include_once "includes/footer.inc.php";

?>

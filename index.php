<?php
  
  include_once "includes/header.inc.php";
  
  $data = new Frontend();

?>

<main class="main">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12 p-0">
        <?= $data->renderSlideshow() ?>
			</div><!-- End .col-lg-8 -->
		</div><!-- End .row -->
	</div><!-- End .container-fluid -->
	<div class="mb-lg-2"></div><!-- End .mb-lg-2 -->
	<div class="container-fluid">
		<div class="row">
			<div class="col-xl-12 col-xxl-12">
				
				<h2 class="title text-center mb-2">Explore Popular Categories</h2><!-- End .title -->
				
				<?= $data->companyLogoSlider() ?>
				
				<div class="mb-2"></div><!-- End .mb-2 -->
        
        <?php //$data->mostViewedProducts() ?>
        
				<?= $data->trendingProducts() ?>
				
				<div class="mb-3"></div><!-- End .mb5 -->
				
				
				<div class="blog-posts pt-2 pb-3">
					<div class="container">
						<div class="row">
						<h2 class="title mb-2">From Our Blog</h2><!-- End .title-lg text-center -->
						
						<div class="owl-carousel owl-simple" data-toggle="owl"
						     data-owl-options='{
                            "nav": true,
                            "dots": true,
                            "items": 3,
                            "margin": 20,
                            "loop": true,
                            "autoplay": true,
                            "responsive": {
                                "0": {
                                    "items":1
                                },
                                "600": {
                                    "items":2
                                },
                                "992": {
                                    "items":3
                                },
                                "1280": {
                                    "items":4
                                }
                            }
                        }'>
							
							<?= $data->showRecentBlogs() ?>
							
						</div><!-- End .owl-carousel -->
						</div>
					</div><!-- End .container -->
				</div><!-- End .blog-posts -->
				
				
				<div class="icon-boxes-container">
					<div class="container-fluid">
						<div class="row">
							<div class="col-sm-6 col-lg-3">
								<div class="icon-box icon-box-side">
                                            <span class="icon-box-icon text-dark">
                                                <i class="icon-rocket"></i>
                                            </span>
									<div class="icon-box-content">
										<h3 class="icon-box-title">Free Shipping</h3><!-- End .icon-box-title -->
										<p>Orders $50 or more</p>
									</div><!-- End .icon-box-content -->
								</div><!-- End .icon-box -->
							</div><!-- End .col-sm-6 col-lg-3 -->
							
							<div class="col-sm-6 col-lg-3">
								<div class="icon-box icon-box-side">
                                            <span class="icon-box-icon text-dark">
                                                <i class="icon-rotate-left"></i>
                                            </span>
									
									<div class="icon-box-content">
										<h3 class="icon-box-title">Free Returns</h3><!-- End .icon-box-title -->
										<p>Within 30 days</p>
									</div><!-- End .icon-box-content -->
								</div><!-- End .icon-box -->
							</div><!-- End .col-sm-6 col-lg-3 -->
							
							<div class="col-sm-6 col-lg-3">
								<div class="icon-box icon-box-side">
                                            <span class="icon-box-icon text-dark">
                                                <i class="icon-info-circle"></i>
                                            </span>
									
									<div class="icon-box-content">
										<h3 class="icon-box-title">Get 20% Off 1 Item</h3><!-- End .icon-box-title -->
										<p>When you sign up</p>
									</div><!-- End .icon-box-content -->
								</div><!-- End .icon-box -->
							</div><!-- End .col-sm-6 col-lg-3 -->
							
							<div class="col-sm-6 col-lg-3">
								<div class="icon-box icon-box-side">
                                            <span class="icon-box-icon text-dark">
                                                <i class="icon-life-ring"></i>
                                            </span>
									
									<div class="icon-box-content">
										<h3 class="icon-box-title">We Support</h3><!-- End .icon-box-title -->
										<p>24/7 amazing services</p>
									</div><!-- End .icon-box-content -->
								</div><!-- End .icon-box -->
							</div><!-- End .col-sm-6 col-lg-3 -->
						</div><!-- End .row -->
					</div><!-- End .container-fluid -->
				</div><!-- End .icon-boxes-container -->
				
				<div class="mb-3"></div><!-- End .mb-5 -->
			</div><!-- End .col-lg-9 col-xxl-10 -->
		</div><!-- End .row -->
	</div><!-- End .container-fluid -->
	
	<div class="cta cta-horizontal cta-horizontal-box bg-dark bg-image" style="background-image: url('assets/images/demos/demo-14/bg-1.jpg');">
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-xl-8 offset-xl-2">
					<div class="row align-items-center">
						<div class="col-lg-5 cta-txt">
							<h3 class="cta-title text-primary">Join Our Newsletter</h3><!-- End .cta-title -->
							<p class="cta-desc text-light">Subscribe to get information about latest products and coupons</p><!-- End .cta-desc -->
						</div><!-- End .col-lg-5 -->
						
						<div class="col-lg-7">
							<form method="post" id="newsletter">
								<div class="input-group">
									<input type="email" id="newsletter-email" name="email" class="form-control" placeholder="Enter your Email Address" aria-label="Email Address" required>
									<div class="input-group-append">
										<button class="btn" type="submit">Subscribe</button>
									</div><!-- .End .input-group-append -->
								</div><!-- .End .input-group -->
							</form>
						</div><!-- End .col-lg-7 -->
					</div><!-- End .row -->
				</div><!-- End .col-xl-8 offset-2 -->
			</div><!-- End .row -->
		</div><!-- End .container-fluid -->
	</div><!-- End .cta -->
</main><!-- End .main -->

<?php
  
  include_once "includes/footer.inc.php";

?>

<script>
  
  /*$('.products-lists').simpleLoadMore({
    item: 'div', count: 5, itemsToLoad: 5, easing: 'fade', counterInBtn: true, btnText: '<button type="button" class="btn btn-primary mt-2">View More Products</button>', onComplete: function() {
      $(this).after('<a href="shop.php" class="btn btn-primary mt-2 btn-rounded">View All Products</a>');
    },
  });*/

/*  $(document).ready(function() {
    const productsContainer = $('.products');
    const loadMoreButton = $('<div class="more-container text-center mt-5"><button type="button" class="btn btn-outline-lightgray btn-more btn-round"><span>View more products</span><i class="icon-long-arrow-right"></i></button></div>');
    const productsPerPage = 12;
    let currentPage = 1;
  
    // Hide all products initially
    $('.product-lists').hide();
    
    // Initial load of products
    showProducts(currentPage);
  
    // Append "View More Products" button
    productsContainer.after(loadMoreButton);
  
    // Handle click on "View More Products" button
    loadMoreButton.on('click', function() {
      currentPage++;
      showProducts(currentPage);
    });
  
    function showProducts(page) {
      const start = (page - 1) * productsPerPage;
      const end = start + productsPerPage;
    
      $('.product-lists').slice(start, end).show();
    
      // If no more products to show, hide the "View More Products" button
      if (end >= $('.product-lists').length) {
        loadMoreButton.hide();
      }
    }
  });*/


</script>

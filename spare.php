<?php
  
  include_once "includes/header.inc.php";
  
  $data = new Shopping();

?>
	
	<main class="main sparePartProducts">
		<nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
			<div class="container">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href=./>Home</a></li>
					<li class="breadcrumb-item"><a href="shop.php">Shop</a></li>
					<li class="breadcrumb-item active">Spare Part Products</li>
				</ol>
			</div><!-- End .container -->
		</nav><!-- End .breadcrumb-nav -->
		
		<div class="page-content">
			<div class="container">
				<div class="row">
					<div class="col-lg-9">
						<div class="toolbox">
							<div class="toolbox-left">
								<div class="toolbox-info">
									<!--Showing <span>9 of 56</span> Products-->
								</div><!-- End .toolbox-info -->
							</div><!-- End .toolbox-left -->
							
							<div class="toolbox-right">
								<div class="toolbox-sort">
									<label for="sortby">Sort by:</label>
									<div class="select-custom">
										<select name="sortby" id="sortby" class="form-control">
											<option value="views" selected="selected">Most Popular</option>
											<option value="rating">Most Rated</option>
											<option value="asc">Sort: A-Z</option>
											<option value="desc">Sort: Z-A</option>
										</select>
									</div>
								</div><!-- End .toolbox-sort -->
								<!--<div class="toolbox-layout">
                  <a href="category-list.html" class="btn-layout">
                    <svg width="16" height="10">
                      <rect x="0" y="0" width="4" height="4"/>
                      <rect x="6" y="0" width="10" height="4"/>
                      <rect x="0" y="6" width="4" height="4"/>
                      <rect x="6" y="6" width="10" height="4"/>
                    </svg>
                  </a>
                  
                  <a href="category-4cols.html" class="btn-layout active">
                    <svg width="22" height="10">
                      <rect x="0" y="0" width="4" height="4"/>
                      <rect x="6" y="0" width="4" height="4"/>
                      <rect x="12" y="0" width="4" height="4"/>
                      <rect x="18" y="0" width="4" height="4"/>
                      <rect x="0" y="6" width="4" height="4"/>
                      <rect x="6" y="6" width="4" height="4"/>
                      <rect x="12" y="6" width="4" height="4"/>
                      <rect x="18" y="6" width="4" height="4"/>
                    </svg>
                  </a>
                </div>--><!-- End .toolbox-layout -->
							</div><!-- End .toolbox-right -->
						</div><!-- End .toolbox -->
						
						<div class="products mb-3">
							<div class="sparePartsListings row justify-content-center">
							
							</div><!-- End .row -->
						</div><!-- End .products -->
						
						
						<nav aria-label="Page navigation">
							<ul class="pagination justify-content-center">
								<li class="page-item disabled">
									<a class="page-link page-link-prev" href="#" aria-label="Previous" tabindex="-1" aria-disabled="true">
										<span aria-hidden="true"><i class="icon-long-arrow-left"></i></span>Prev
									</a>
								</li>
								<li class="page-item active" aria-current="page"><a class="page-link" href="#">1</a></li>
								<li class="page-item"><a class="page-link" href="#">2</a></li>
								<li class="page-item"><a class="page-link" href="#">3</a></li>
								<li class="page-item-total">of 6</li>
								<li class="page-item">
									<a class="page-link page-link-next" href="#" aria-label="Next">
										Next <span aria-hidden="true"><i class="icon-long-arrow-right"></i></span>
									</a>
								</li>
							</ul>
						</nav>
					</div><!-- End .col-lg-9 -->
					<aside class="col-lg-3 order-lg-first">
						<div class="sidebar sidebar-shop">
							<div class="widget widget-clean">
								<label>Filters:</label>
								<a href="javascript:void(0)" class="sidebar-filter-clear">Clean All</a>
							</div><!-- End .widget widget-clean -->
							
							<div class="widget widget-collapsible">
								<h3 class="widget-title">
									<a data-toggle="collapse" href="#widget-1" role="button" aria-expanded="true" aria-controls="widget-1">
										Category
									</a>
								</h3><!-- End .widget-title -->
								
								<div class="collapse show" id="widget-1">
									<div class="widget-body">
										<div class="filter-items filter-items-count">
                      
                      <?= $data->generateAllSparePartsCategoryFilter() ?>
										
										</div><!-- End .filter-items -->
									</div><!-- End .widget-body -->
								</div><!-- End .collapse -->
							</div><!-- End .widget -->
							
							<div class="widget widget-collapsible">
								<h3 class="widget-title">
									<a data-toggle="collapse" href="#widget-5" role="button" aria-expanded="true" aria-controls="widget-5">
										Price
									</a>
								</h3><!-- End .widget-title -->
								
								<div class="collapse show" id="widget-5">
									<div class="widget-body">
                    <?= $data->generatePriceFilter() ?><!-- End .filter-price -->
									</div><!-- End .widget-body -->
								</div><!-- End .collapse -->
							</div><!-- End .widget -->
							
							<div class="widget widget-collapsible">
								<h3 class="widget-title">
									<a data-toggle="collapse" href="#widget-2" role="button" aria-expanded="true" aria-controls="widget-2">
										Size
									</a>
								</h3><!-- End .widget-title -->
								
								<div class="collapse show" id="widget-2">
									<div class="widget-body">
                    
                    <?= $data->generateSizeFilter() ?>
									
									</div><!-- End .widget-body -->
								</div><!-- End .collapse -->
							</div><!-- End .widget -->
							
							<div class="widget widget-collapsible">
								<h3 class="widget-title">
									<a data-toggle="collapse" href="#widget-3" role="button" aria-expanded="true" aria-controls="widget-3">
										Colour
									</a>
								</h3><!-- End .widget-title -->
								
								<div class="collapse show" id="widget-3">
									<div class="widget-body">
                    
                    <?= $data->generateColorFilter() ?>
									
									</div><!-- End .widget-body -->
								</div><!-- End .collapse -->
							</div><!-- End .widget -->
							
							<div class="widget widget-collapsible">
								<h3 class="widget-title">
									<a data-toggle="collapse" href="#widget-4" role="button" aria-expanded="true" aria-controls="widget-4">
										Brand
									</a>
								</h3><!-- End .widget-title -->
								
								<div class="collapse show" id="widget-4">
									<div class="widget-body">
										<div class="filter-items">
                      
                      <?= $data->generateBrandFilter() ?>
										
										</div><!-- End .filter-items -->
									</div><!-- End .widget-body -->
								</div><!-- End .collapse -->
							</div><!-- End .widget -->
						</div><!-- End .sidebar sidebar-shop -->
					</aside><!-- End .col-lg-3 -->
				</div><!-- End .row -->
			</div><!-- End .container -->
		</div><!-- End .page-content -->
	</main><!-- End .main -->

<?php
  
  include_once "includes/footer.inc.php";

?>
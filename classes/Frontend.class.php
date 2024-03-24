<?php
  
  
  class Frontend extends Config
  {
    public function renderSlideshow()
    {
      return '<div class="intro-slider-container slider-container-ratio slider-container-1 mb-2 mb-lg-0">
						<div class="intro-slider intro-slider-1 owl-carousel owl-simple owl-light owl-nav-inside" data-toggle="owl" data-owl-options=\'{
                                        "nav": false,
                                        "arrows": false,
                                        "dots": true,
                                        "autoplay": true,
                                        "animateOut": "fadeOut",
																		    "autoplayTimeout": 2000,
																		    "autoplayHoverPause": false,
                                        "responsive": {
                                            "768": {
                                                "nav": true
                                            }
                                        }
                                    }\'>
							
							<div class="intro-slide">
								<figure class="slide-image">
									<picture>
										<source media="(max-width: 480px)" srcset="assets/img/slides/slide-1-480w.jpg">
										<img src="assets/img/slides/slide-1.jpg" alt="Image Desc">
									</picture>
								</figure><!-- End .slide-image -->
								
								<div class="intro-content">
									<h3 class="intro-subtitle">New Arrivals</h3><!-- End .h3 intro-subtitle -->
									<h1 class="intro-title text-white">
										The New Way <br>To Buy Furniture
									</h1><!-- End .intro-title -->
									
									<div class="intro-text text-white">
										Spring Collections 2024
									</div><!-- End .intro-text -->
									
									<a href="category.html" class="btn btn-primary">
										<span>Discover Now</span>
										<i class="icon-long-arrow-right"></i>
									</a>
								</div><!-- End .intro-content -->
							</div><!-- End .intro-slide -->
							
							<div class="intro-slide">
								<figure class="slide-image">
									<picture>
										<source media="(max-width: 480px)" srcset="assets/img/slides/slide-2-480w.jpg">
										<img src="assets/img/slides/slide-2.jpg" alt="Image Desc">
									</picture>
								</figure><!-- End .slide-image -->
								
								<div class="intro-content">
									<h3 class="intro-subtitle">Hottest Deals</h3><!-- End .h3 intro-subtitle -->
									<h1 class="intro-title">
										<span>Wherever You Go</span> <br>DJI Mavic 2 Pro
									</h1><!-- End .intro-title -->
									
									<div class="intro-price">
										<sup>from</sup>
										<span>
                                                $1,948<sup>.99</sup>
                                            </span>
									</div><!-- End .intro-price -->
									
									<a href="category.html" class="btn btn-primary">
										<span>Discover Here</span>
										<i class="icon-long-arrow-right"></i>
									</a>
								</div><!-- End .intro-content -->
							</div><!-- End .intro-slide -->
							
							<div class="intro-slide">
								<figure class="slide-image">
									<picture>
										<source media="(max-width: 480px)" srcset="assets/img/slides/slide-3-480w.jpg">
										<img src="assets/img/slides/slide-3.jpg" alt="Image Desc">
									</picture>
								</figure><!-- End .slide-image -->
								
								<div class="intro-content">
									<h3 class="intro-subtitle">Limited Quantities</h3><!-- End .h3 intro-subtitle -->
									<h1 class="intro-title">
										Refresh Your <br>Wardrobe
									</h1><!-- End .intro-title -->
									
									<div class="intro-text">
										Summer Collection 2024
									</div><!-- End .intro-text -->
									
									<a href="category.html" class="btn btn-primary">
										<span>Discover Now</span>
										<i class="icon-long-arrow-right"></i>
									</a>
								</div><!-- End .intro-content -->
							</div><!-- End .intro-slide -->
						</div><!-- End .intro-slider owl-carousel owl-simple -->
						
						<span class="slider-loader"></span><!-- End .slider-loader -->
					</div><!-- End .intro-slider-container -->';
    }
    
    public function companyLogoSlider()
    {
      $data   = '';
      $sql    = "SELECT * FROM categories WHERE parent_category_id=0";
      $result = $this->selectQuery($sql);
      if ($result->num_rows > 0) {
        $data = '<div class="owl-carousel owl-simple brands-carousel" data-toggle="owl"
					     data-owl-options=\'{
                                "nav": true,
                                "dots": true,
                                "margin": 20,
                                "loop": true,
                                "autoplay": true,
                                "responsive": {
                                    "0": {
                                        "items":3
                                    },
                                    "576": {
                                        "items":5
                                    },
                                    "768": {
                                        "items":6
                                    },
                                    "992": {
                                        "items":7
                                    },
                                    "1200": {
                                        "items":8
                                    }
                                }
                            }\'>';
        while ($row = $result->fetch_assoc()) {
          $data .= '<div>
                      <a href="category.php?id=' . $row['category_id'] . '" class="cat-block">
                        <figure>
                            <span>
                              <img src="assets/img/categories/' . $row['banner'] . '" alt="Category image">
                            </span>
                        </figure>
                        <p class="m-0 p-0 text-center" class="cat-block-title">' . $row['category_name'] . '</p><!-- End .cat-block-title -->
                      </a>
                    </div>';
        }
        $data .= '</div><!-- End .owl-carousel -->
					       <div class="mb-3"></div><!-- End .mb-5 -->';
      }
      return $data;
    }
    
    public function mostViewedProducts()
    {
      /*$sql    = 'SELECT c.category_id, c.category_name, p.product_id, p.product_name, p.product_image
                FROM categories c
                INNER JOIN products p ON c.category_id = p.category_id
                ORDER BY p.total_views DESC, p.created_at DESC
                LIMIT 10';*/
      $sql    = 'SELECT *, products.product_id AS productId FROM products
              INNER JOIN categories ON products.category_id = categories.category_id
              LEFT JOIN deals ON products.product_id = deals.product_id
              INNER JOIN vendors ON products.vendor_id=vendors.vendor_id
              WHERE (deals.end_date IS NULL OR deals.end_date >= CURRENT_TIMESTAMP)
              GROUP BY products.product_id
              ORDER BY products.total_views DESC';
      $result = $this->selectQuery($sql);
      if ($result->num_rows > 0) {
        $categories         = []; // To store unique categories
        $productsByCategory = []; // To store products grouped by category
        
        // Fetch data and organize it by category
        while ($row = $result->fetch_assoc()) {
          $categoryId = $row['category_id'];
          
          if (!in_array($categoryId, $categories)) {
            $categories[] = $categoryId;
          }
          
          if (!isset($productsByCategory[$categoryId])) {
            $productsByCategory[$categoryId] = [];
          }
          
          $productsByCategory[$categoryId][] = $row;
        }
        
        // Render tabs/pills
        echo PHP_EOL . PHP_EOL . '<div class="bg-lighter trending-products">
                <div class="heading heading-flex mb-3">
                  <div class="heading-left">
                    <h2 class="title">Trending Today</h2><!-- End .title -->
                  </div><!-- End .heading-left -->
                  
                  <div class="heading-right">
                    <ul class="nav nav-pills justify-content-center" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="trending-all-link" data-toggle="tab" href="#trending-all-tab" role="tab" aria-controls="trending-all-tab" aria-selected="true">All</a>
                      </li>';
        // Other tabs/pills
        foreach ($categories as $categoryId) {
          echo '<li class="nav-item">
                  <a class="nav-link" id="trending-' . $categoryId . '-link" data-toggle="tab" href="#trending-' . $categoryId . '-tab" role="tab" aria-controls="trending-' . $categoryId . '-tab" aria-selected="false">' . $this->getCategoryName($categoryId) . '</a>
                </li>';
        }
        echo '</ul>
          </div><!-- End .heading-right -->
        </div><!-- End .heading -->';
        
        // Tabs
        echo '<div class="tab-content tab-content-carousel">';
        // All tab content
        echo '<div class="tab-pane p-0 fade show active" id="trending-all-tab" role="tabpanel" aria-labelledby="trending-all-link">
                <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl"
                     data-owl-options=\'{
                                                      "nav": true,
                                                      "dots": false,
                                                      "margin": 20,
                                                      "loop": true,
                                                      "autoplay": true,
                                                      "autoplayTimeout": 2500,
                                                      "autoplayHoverPause": true,
                                                      "responsive": {
                                                          "0": {
                                                              "items":2
                                                          },
                                                          "480": {
                                                              "items":2
                                                          },
                                                          "768": {
                                                              "items":4
                                                          },
                                                          "992": {
                                                              "items":5
                                                          },
                                                          "1200": {
                                                              "items":6,
                                                              "nav": true
                                                          }
                                                      }
                                                  }\'>
                  ' . $this->renderProductList($productsByCategory) . '
                </div><!-- End .owl-carousel -->
              </div><!-- .End .tab-pane -->';
        
        // Other tabs/pills
        foreach ($categories as $categoryId) {
          echo '<div class="tab-pane p-0 fade" id="trending-' . $categoryId . '-tab" role="tabpanel" aria-labelledby="trending-' . $categoryId . '-link">
                  <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl"
                       data-owl-options=\'{
                                                        "nav": true,
                                                        "dots": false,
                                                        "margin": 20,
                                                        "loop": true,
                                                        "autoplay": true,
                                                        "autoplayTimeout": 2500,
                                                        "autoplayHoverPause": true,
                                                        "responsive": {
                                                            "0": {
                                                                "items":2
                                                            },
                                                            "480": {
                                                                "items":2
                                                            },
                                                            "768": {
                                                                "items":4
                                                            },
                                                            "992": {
                                                                "items":5
                                                            },
                                                            "1200": {
                                                                "items":6,
                                                                "nav": true
                                                            }
                                                        }
                                                    }\'>
                    ' . $this->renderProductList($productsByCategory[$categoryId]) . '
                  </div><!-- End .owl-carousel -->
                </div><!-- .End .tab-pane -->';
        }
        
      }
      
      echo '</div><!-- End .tab-content -->
            </div><!-- End .bg-lighter -->
            
            <div class="mb-3"></div><!-- End .mb-5 -->' . PHP_EOL . PHP_EOL;
      
    }
    
    public function trendingProducts()
    {
      $products = [];
      $data     = '';
      $sql      = 'SELECT *, products.product_id AS productId FROM products
              INNER JOIN categories ON products.category_id = categories.category_id
              LEFT JOIN deals ON products.product_id = deals.product_id
              INNER JOIN vendors ON products.vendor_id=vendors.vendor_id
              WHERE (deals.end_date IS NULL OR deals.end_date >= CURRENT_TIMESTAMP)
              GROUP BY products.product_id
              ORDER BY products.total_views DESC LIMIT 18';
      $result   = $this->selectQuery($sql);
      while ($row = $result->fetch_assoc()) {
        $products[] = $row;
      }
      
      $data .= '<div class="container">
                  <div class="heading heading-center mb-2">
                    <h2 class="title">Top Selling Products</h2><!-- End .title-lg text-center -->
                    <p>Explore our latest trending products! From innovative gadgets to stylish essentials, find what you need to stay ahead of the curve. Shop now!</p>
                  </div><!-- End .heading -->
                  
                  <div class="products just-action-icons-sm">
                    <div class="row">
                      ' . $this->renderProductList($products) . '
                    </div><!-- End .row -->
                  </div><!-- End .products -->
                  
                </div><!-- End .container -->';
      
      return $data;
    }
    
    public function renderProductList($products)
    {
      $data         = '';
      $top          = "";
      $new          = "";
      $discount     = "";
      $productCount = 0;
      foreach ($products as $row) {
        if (isset($row['product_name']) && in_array($row['product_name'], $row)) {
          // Increase product count
          $productCount++;
          $imgs = explode(", ", $row['product_image']);
          // Check if product was added in less that 7 days
          if (daysBack($row['created_at']) <= 7) {
            $new = '<span class="product-label label-new">New Arrival</span>';
          }
          // Check if the product is among the top rated and viewed
          if ($this->top10($row['productId'])) {
            $top = '<span class="product-label label-top">TOP</span>';
          }
          // Check if the product is among the top rated and viewed
          if ($this->discounted($row['productId'])) {
            $top       = '<span class="product-label label-sale">' . $this->productDiscount($row['productId']) . '% OFF</span>';
            $hoursLeft = '<div class="product-countdown" data-until="+' . HoursLeft($this->productDiscountTimeLeft($row['productId'])) . 'h" data-relative="true" data-labels-short="true"></div><!-- End .product-countdown -->';
          } else {
            $top       = "";
            $hoursLeft = "";
          }
          
          if ($this->discounted($row['productId'])) {
            $currentPrice = CURRENCY . " " . number_format(($row['current_price'] - ($row['current_price'] * ($this->productDiscount($row['productId']) / 100))));
          } else {
            $currentPrice = CURRENCY . " " . number_format($row['current_price']);
          }
          
          // Display search results, e.g., product names and links
          $data .= '<div class="col-4 col-md-4 col-lg-3 col-xl-2 product-lists p-0">
                      <div class="product text-center">
                        <figure class="product-media p-0">
                          ' . $top . $new . $discount . '
                          <a href="product.php?id=' . $row['productId'] . '">
                            <img src="assets/img/products/' . $imgs[0] . '" alt="Product image" class="product-image">
                            <img src="assets/img/products/' . (isset($imgs[1]) ? $imgs[1] : $imgs[0]) . '" alt="Product image" class="product-image-hover">
                          </a>
                          ' . $hoursLeft . '
                          <div class="product-action-vertical">
                            <a href="javascript:void(0)" class="btn-product-icon btn-wishlist wishlistBtn" data-id="' . $row['productId'] . '" data-toggle="tooltip" title="Add to wishlist"><span>Add to wishlist</span></a>
                            <a href="javascript:void(0)" class="btn-product-icon btn-quickview quickviewBtn" data-id="' . $row['productId'] . '" data-toggle="tooltip" title="Quick view"><span>Quick view</span></a>
                            <a href="javascript:void(0)" class="btn-product-icon btn-compare compareBtn" data-id="' . $row['productId'] . '" data-toggle="tooltip" title="Compare"><span>Compare</span></a>
                          </div><!-- End .product-action-vertical -->
                          <div class="product-action product-action-dark">
                            <a href="javascript:void(0)" class="btn-product btn-cart cartBtn" data-id="' . $row['productId'] . '"><span>Cart</span></a>
                            <a href="chat.php?vendor=' . $row['vendor_id'] . '&prod=' . $row['productId'] . '" class="btn-product btn-chat" title="Chat with Vendor"><span class="icon-comments">&nbsp;&nbsp;Chat</span></a>
                          </div><!-- End .product-action -->
                        </figure><!-- End .product-media -->
                        <div class="product-body">
                          <h3 class="product-title"><a href="product.php?id=' . $row['productId'] . '">' . $row['product_name'] . '</a></h3><!-- End .product-title -->
                          <div class="product-price">
                            <span class="new-price">' . $currentPrice . '</span>
                          </div><!-- End .product-price -->
                          </div><!-- End .rating-container -->
                          <hr class="my-0 py-0">
                          <span class="product-location">' . $row['address'] . ', ' . $this->countryName($row['country']) . '</span>
                        </div><!-- End .product-body -->
                    </div><!-- End .product -->';
        } else {
          foreach ($row as $item) {
            // Increase product count
            $productCount++;
            $imgs = explode(", ", $item['product_image']);
            // Check if product was added in less that 7 days
            if (daysBack($item['created_at']) <= 7) {
              $new = '<span class="product-label label-new">New Arrival</span>';
            }
            // Check if the product is among the top rated and viewed
            if ($this->top10($item['productId'])) {
              $top = '<span class="product-label label-top">TOP</span>';
            }
            // Check if the product is among the top rated and viewed
            if ($this->discounted($item['productId'])) {
              $top       = '<span class="product-label label-sale">' . $this->productDiscount($item['productId']) . '% OFF</span>';
              $hoursLeft = '<div class="product-countdown" data-until="+' . HoursLeft($this->productDiscountTimeLeft($item['productId'])) . 'h" data-relative="true" data-labels-short="true"></div><!-- End .product-countdown -->';
            } else {
              $top       = "";
              $hoursLeft = "";
            }
            
            if ($this->discounted($item['productId'])) {
              $currentPrice = CURRENCY . " " . number_format(($item['current_price'] - ($item['current_price'] * ($this->productDiscount($item['productId']) / 100))));
            } else {
              $currentPrice = CURRENCY . " " . number_format($item['current_price']);
            }
            
            // Display search results, e.g., product names and links
            $data .= '<div class="col-4 col-md-4 col-lg-3 col-xl-2 product-lists p-0">
                        <div class="product text-center">
                          <figure class="product-media p-0">
                            ' . $top . $new . $discount . '
                            <a href="product.php?id=' . $item['productId'] . '">
                              <img src="assets/img/products/' . $imgs[0] . '" alt="Product image" class="product-image">
                              <img src="assets/img/products/' . (isset($imgs[1]) ? $imgs[1] : $imgs[0]) . '" alt="Product image" class="product-image-hover">
                            </a>
                            ' . $hoursLeft . '
                            <div class="product-action-vertical">
                              <a href="javascript:void(0)" class="btn-product-icon btn-wishlist wishlistBtn" data-id="' . $item['productId'] . '" data-toggle="tooltip" title="Add to wishlist"><span>Add to wishlist</span></a>
                              <a href="javascript:void(0)" class="btn-product-icon btn-quickview quickviewBtn" data-id="' . $item['productId'] . '" data-toggle="tooltip" title="Quick view"><span>Quick view</span></a>
                              <a href="javascript:void(0)" class="btn-product-icon btn-compare compareBtn" data-id="' . $item['productId'] . '" data-toggle="tooltip" title="Compare"><span>Compare</span></a>
                            </div><!-- End .product-action-vertical -->
                            <div class="product-action product-action-dark">
                              <a href="javascript:void(0)" class="btn-product btn-cart cartBtn" data-id="' . $item['productId'] . '"><span>Cart</span></a>
                              <a href="chat.php?vendor=' . $item['vendor_id'] . '&prod=' . $item['productId'] . '" class="btn-product btn-chat" title="Chat with Vendor"><span class="icon-comments">&nbsp;&nbsp;Chat</span></a>
                            </div><!-- End .product-action -->
                          </figure><!-- End .product-media -->
                          <div class="product-body">
                            <h3 class="product-title"><a href="product.php?id=' . $item['productId'] . '">' . $item['product_name'] . '</a></h3><!-- End .product-title -->
                            <div class="product-price">
                              <span class="new-price">' . $currentPrice . '</span>
                            </div><!-- End .product-price -->
                            <hr class="my-0 py-0">
                            <span class="product-location">' . $item['address'] . ', ' . $this->countryName($item['country']) . '</span>
                          </div><!-- End .product-body -->
                        </div><!-- End .product -->
                      </div>';
          }
        }
      }
      
      return $data;
    }
    
    private function getCategoryName($categoryId)
    {
      // Function to get the category name based on category ID
      $sql    = "SELECT category_name FROM categories WHERE category_id = ?";
      $result = $this->selectQuery($sql, [$categoryId]);
      
      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['category_name'];
      }
      
      return '';
    }
    
    public function renderTrendingToday()
    {
      $shows = '';
      $data  = [];
      $sql   = 'SELECT * FROM products
      INNER JOIN categories ON products.category_id = categories.category_id
      LEFT JOIN deals ON products.product_id = deals.product_id
      INNER JOIN vendors ON products.vendor_id=vendors.vendor_id
      WHERE (deals.end_date IS NULL OR deals.end_date >= CURRENT_TIMESTAMP)
      GROUP BY products.product_id
      ORDER BY products.total_views DESC';
      
      $result = $this->selectQuery($sql);
      while ($row = $result->fetch_assoc()) {
        $data[] = $row;
      }
      return $data;
    }
    
    public function renderCategoryProductsHome()
    {
      $no         = 1;
      $ads        = '';
      $cats       = [];
      $prods      = [];
      $categories = '';
      $sql        = "SELECT * FROM categories WHERE parent_category_id=0";
      $result     = $this->selectQuery($sql);
      while ($row = $result->fetch_assoc()) {
        $cats[] = $row;
      }
      
      // Make a stringed categories for listing but at the end of each two categories, the system should add the advert/banner row
      foreach ($cats as $cat) {
        $categories .= '<div class="row cat-banner-row electronics">
                          ' . $this->categoryProductsCarouselHome($cat['category_id']) . '
                        </div><!-- End .row cat-banner-row -->
                        
                        <div class="mb-3"></div><!-- End .mb-3 -->';
        
        // Get advert's banner
        if ($no % 2 === 0) {
          $categories .= '<div class="mb-3"></div><!-- End .mb-3 -->';
        }
        $no++;
      }
      
      return $categories;
    }
    
    private function categoryProductsCarouselHome($categoryId)
    {
      $top      = "";
      $new      = "";
      $discount = "";
      $sql      = "SELECT * FROM products LEFT JOIN categories ON products.category_id=categories.category_id INNER JOIN vendors ON products.vendor_id=vendors.vendor_id WHERE products.category_id=? || parent_category_id=?";
      $params   = [$categoryId, $categoryId];
      $result   = $this->selectQuery($sql, $params);
      $data     = '<div class="col-xl-12 col-xxl-12">
							<div class="owl-carousel owl-full carousel-equal-height carousel-with-shadow" data-toggle="owl"
							     data-owl-options=\'{
                                        "nav": true,
                                        "dots": false,
                                        "margin": 20,
                                        "loop": true,
                                        "autoplay": true,
                                        "autoplayTimeout": 2500,
                                        "autoplayHoverPause": true,
                                        "responsive": {
                                            "0": {
                                                "items":2
                                            },
                                            "480": {
                                                "items":2
                                            },
                                            "768": {
                                                "items":4
                                            },
                                            "992": {
                                                "items":5
                                            },
                                            "1200": {
                                                "items":6
                                            }
                                        }
                                    }\'>';
      while ($row = $result->fetch_assoc()) {
        $imgs = explode(", ", $row['product_image']);
        // Check if product was added in less that 7 days
        if (daysBack($row['created_at']) <= 7) {
          $new = '<span class="product-label label-new">New Arrival</span>';
        }
        // Check if the product is among the top rated and viewed
        if ($this->top10($row['product_id'])) {
          $top = '<span class="product-label label-top">TOP</span>';
        }
        // Check if the product is among the top rated and viewed
        if ($this->discounted($row['product_id'])) {
          $top       = '<span class="product-label label-sale">' . $this->productDiscount($row['product_id']) . '% OFF</span>';
          $hoursLeft = '<div class="product-countdown" data-until="+' . HoursLeft($this->productDiscountTimeLeft($row['product_id'])) . 'h" data-relative="true" data-labels-short="true"></div><!-- End .product-countdown -->';
        } else {
          $top       = "";
          $hoursLeft = "";
        }
        
        if ($this->discounted($row['product_id'])) {
          $currentPrice = CURRENCY . " " . number_format(($row['current_price'] - ($row['current_price'] * ($this->productDiscount($row['product_id']) / 100))));
        } else {
          $currentPrice = CURRENCY . " " . number_format($row['current_price']);
        }
        
        $data .= '<div class="product text-center">
                      <figure class="product-media">
                        ' . $top . $new . $discount . '
                        <a href="product.php?id=' . $row['product_id'] . '">
                          <img src="assets/img/products/' . $imgs[0] . '" alt="Product image" class="product-image">
                          <img src="assets/img/products/' . (isset($imgs[1]) ? $imgs[1] : $imgs[0]) . '" alt="Product image" class="product-image-hover">
                        </a>
                        ' . $hoursLeft . '
                        <div class="product-action-vertical">
                          <a href="javascript:void(0)" class="btn-product-icon btn-wishlist wishlistBtn" data-id="' . $row['product_id'] . '" data-toggle="tooltip" title="Add to wishlist"><span>Add to wishlist</span></a>
                          <a href="javascript:void(0)" class="btn-product-icon btn-quickview quickviewBtn" data-id="' . $row['product_id'] . '" data-toggle="tooltip" title="Quick view"><span>Quick view</span></a>
                          <a href="javascript:void(0)" class="btn-product-icon btn-compare compareBtn" data-id="' . $row['product_id'] . '" data-toggle="tooltip" title="Compare"><span>Compare</span></a>
                        </div><!-- End .product-action-vertical -->
                        <div class="product-action">
                          <a href="#" class="btn-product btn-cart cartBtn" data-id="' . $row['product_id'] . '"><span>Cart</span></a>
                          <a href="chat.php?vendor=' . $row['vendor_id'] . '&prod=' . $row['product_id'] . '" class="btn-product btn-chat" title="Chat with Vendor"><span class="icon-comments">&nbsp;&nbsp;Chat</span></a>
                        </div><!-- End .product-action -->
                      </figure><!-- End .product-media -->
                      <div class="product-body">
                        <div class="product-cat">
                          <a href="category.php?id=' . $row['category_id'] . '">' . $row['category_name'] . '</a>
                        </div><!-- End .product-cat -->
                        <h3 class="product-title"><a href="product.php?id=' . $row['product_id'] . '">' . $row['product_name'] . '</a></h3><!-- End .product-title -->
                        <div class="product-price">
                          <span class="new-price">' . $currentPrice . '</span>
                        </div><!-- End .product-price -->
                        <div class="ratings-container">
                          <div class="ratings" data-toggle="tooltip" title="' . $row['average_stars'] . ' Stars">
                            <div class="ratings-val" style="width: ' . round($row['average_stars'] * 10) . '%;"></div><!-- End .ratings-val -->
                          </div><!-- End .ratings -->
                          <span class="ratings-text">( ' . number_format($row['total_reviews']) . ' Reviews )</span>
                        </div><!-- End .rating-container -->
                        <hr class="my-0 py-0">
                        <span class="product-location">' . $row['address'] . ', ' . $this->cityName($row['city']) . ', ' . $this->countryName($row['country']) . '</span>
                      </div><!-- End .product-body -->
                    </div><!-- End .product -->';
      }
      $data .= '</div><!-- End .owl-carousel -->
              </div><!-- End .col-xl-9 -->';
      
      return $data;
    }
    
    public function renderInProductBanners()
    {
      return '<div class="row">
                <div class="col-md-6">
                  <div class="banner banner-overlay">
                    <a href="#">
                      <img src="assets/images/demos/demo-14/banners/banner-7.jpg" alt="Banner img desc">
                    </a>
                    
                    <div class="banner-content">
                      <h4 class="banner-subtitle text-white d-none d-sm-block"><a href="#">Spring Sale is Coming</a></h4><!-- End .banner-subtitle -->
                      <h3 class="banner-title text-white"><a href="#">Floral T-shirts and Vests <br><span>Spring Sale</span></a></h3><!-- End .banner-title -->
                      <a href="#" class="banner-link">Shop Now <i class="icon-long-arrow-right"></i></a>
                    </div><!-- End .banner-content -->
                  </div><!-- End .banner -->
                </div><!-- End .col-md-6 -->
                
                <div class="col-md-6">
                  <div class="banner banner-overlay">
                    <a href="#">
                      <img src="assets/images/demos/demo-14/banners/banner-8.jpg" alt="Banner img desc">
                    </a>
                    
                    <div class="banner-content">
                      <h4 class="banner-subtitle text-white d-none d-sm-block"><a href="#">Amazing Value</a></h4><!-- End .banner-subtitle -->
                      <h3 class="banner-title text-white"><a href="#">Upgrade and Save <br><span>On The Latest Apple Devices</span></a></h3><!-- End .banner-title -->
                      <a href="#" class="banner-link">Shop Now <i class="icon-long-arrow-right"></i></a>
                    </div><!-- End .banner-content -->
                  </div><!-- End .banner banner-overlay -->
                </div><!-- End .col-md-6 -->
              </div><!-- End .row -->
              
              <div class="mb-3"></div><!-- End .mb-3 -->';
    }
    
    
    public function renderProductListPage($products)
    {
      echo '<div class="row">';
      foreach ($products as $product) {
        $image = explode(", ", $product['product_image'])[0];
        echo '<div class="col-lg-4 col-md-6 mb-4">';
        echo '<div class="product">';
        echo '<div class="product-image">';
        echo '<img src="./assets/img/products/' . $image . '" alt="' . $product['product_name'] . '">';
        echo '</div>';
        echo '<div class="product-info">';
        echo '<h2>' . $product['product_name'] . '</h2>';
        echo '<p>' . $product['short_description'] . '</p>';
        echo '<p>Price: $' . $product['current_price'] . '</p>';
        echo '<button class="btn btn-primary">Add to Cart</button>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
      }
      echo '</div>';
    }
    
    public function renderRegistrationForm()
    {
      echo '<div class="register-form">';
      echo '<form action="register.php" method="post">';
      echo '<div class="form-group">';
      echo '<input type="text" class="form-control" name="username" placeholder="Username">';
      echo '</div>';
      echo '<div class="form-group">';
      echo '<input type="email" class="form-control" name="email" placeholder="Email">';
      echo '</div>';
      echo '<div class="form-group">';
      echo '<input type="password" class="form-control" name="password" placeholder="Password">';
      echo '</div>';
      echo '<button type="submit" class="btn btn-primary">Register</button>';
      echo '</form>';
      echo '</div>';
    }
    
    public function renderProductDetailsPage($product)
    {
      echo '<div class="product-details">';
      echo '<h1>' . $product['product_name'] . '</h1>';
      echo '<div class="product-image">';
      // Add product image here
      echo '<img src="' . $product['image_url'] . '" alt="' . $product['product_name'] . '">';
      echo '</div>';
      echo '<p>' . $product['product_description'] . '</p>';
      echo '<p>Price: $' . $product['price'] . '</p>';
      echo '<button class="btn btn-primary">Add to Cart</button>';
      echo '</div>';
    }
    
    public function renderChatInterface()
    {
      // Implement an interactive chat interface with JavaScript and HTML/CSS.
      echo '<div id="chat-container">';
      // Messages, input box, and send button.
      echo '</div>';
    }
    
    public function renderAdminDashboard($vendors, $subscriptions)
    {
      // Display tables and forms for managing vendors and subscriptions.
    }
    
    public function addToComparison($productId)
    {
      $user  = esc($_SESSION['username']);
      $check = "SELECT * FROM compare WHERE product_id=? && user=?";
      if ($this->selectQuery($check, [$productId, $user])->num_rows > 0) {
        // Return an error message
        return json_encode(['status' => 'warning', 'message' => 'Product already exists in your comparison list.']);
      } else {
        // Insert the product to Wishlist
        $sql    = "INSERT INTO compare (user, product_id) VALUES (?, ?)";
        $params = [$user, $productId];
        if ($this->insertQuery($sql, $params)) {
          return json_encode(['status' => 'success', 'message' => 'Product Added to Comparision List Successfully.']);
        } else {
          return json_encode(['status' => 'warning', 'message' => 'Product Addition to Comparision List Failed.']);
        }
      }
    }
    
    public function removeFromComparison($productId)
    {
      $user   = esc($_SESSION['username']);
      $sql    = "DELETE FROM compare WHERE product_id=? && user=?";
      $params = [$productId, $user];
      if ($this->deleteQuery($sql, $params)) {
        return json_encode(['status' => 'success', 'message' => 'Product Removed from Comparision List Successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Product Removal from Comparision List Failed.']);
      }
    }
    
    public function compareProducts()
    {
      $data = [];
      if (isset($_GET['user'])) {
        $user = esc($_GET['user']);
      } else {
        $user = esc($_SESSION['username']);
      }
      $sql    = "SELECT * FROM compare INNER JOIN products ON compare.product_id=products.product_id WHERE user=?";
      $params = [$user];
      $result = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $data[] = $row;
        }
      }
      return $data;
    }
    
    // Method to render the product comparison table
    public function renderComparisonTable($products)
    {
      echo '<div class="comparison-table table-responsive">';
      echo '<table class="table table-hover table-striped table-cart table-mobile">';
      echo '<thead><tr>';
      echo '<th>FEATURES</th>';
      foreach ($products as $product) {
        echo '<th>' . strtoupper($product['product_name']) . '</th>';
      }
      echo '</tr></thead>';
      
      echo '<tbody><tr>';
      echo '<td></td>';
      foreach ($products as $product) {
        echo '<td><img src="assets/img/products/' . explode(", ", $product['product_image'])[0] . '" alt="product image"></td>';
      }
      echo '</tr>';
      
      echo '<tr>';
      echo '<td>Original Price</td>';
      foreach ($products as $product) {
        echo '<td>' . CURRENCY . ' ' . number_format($product['original_price'], 2) . '</td>';
      }
      echo '</tr>';
      
      echo '<tr>';
      echo '<td>Current Price</td>';
      foreach ($products as $product) {
        echo '<td>' . CURRENCY . ' ' . number_format($product['current_price'], 2) . '</td>';
      }
      echo '</tr>';
      
      echo '<tr>';
      echo '<td>Model</td>';
      foreach ($products as $product) {
        echo '<td>' . $product['model'] . '</td>';
      }
      echo '</tr>';
      
      echo '<tr>';
      echo '<td>Manufacturer</td>';
      foreach ($products as $product) {
        echo '<td>' . $product['manufacturer'] . '</td>';
      }
      echo '</tr>';
      
      echo '<tr>';
      echo '<td>Size</td>';
      foreach ($products as $product) {
        echo '<td>' . $product['size'] . '</td>';
      }
      echo '</tr>';
      
      echo '<tr>';
      echo '<td>Color</td>';
      foreach ($products as $product) {
        $colors = explode(', ', $product['color']);
        echo '<td>';
        foreach ($colors as $color) {
          echo '<a href="javascript:void(0)" style="background: ' . $color . '; display: inline-block" class="color-display">';
        }
        echo '</td>';
      }
      echo '</tr>';
      
      echo '<tr>';
      echo '<td>Weight</td>';
      foreach ($products as $product) {
        echo '<td>' . $product['weight'] . '</td>';
      }
      echo '</tr>';
      
      echo '<tr>';
      echo '<td>Measurements</td>';
      foreach ($products as $product) {
        echo '<td>' . $product['measurements'] . '</td>';
      }
      echo '</tr>';
      
      echo '<tr>';
      echo '<td>Rating</td>';
      foreach ($products as $product) {
        echo '<td>' . $product['average_stars'] . ' Stars</td>';
      }
      echo '</tr>';
      
      echo '<tr>';
      echo '<td>Reviews</td>';
      foreach ($products as $product) {
        echo '<td>' . $product['total_reviews'] . '</td>';
      }
      echo '</tr>';
      
      if (empty($_GET['user'])) {
        echo '<tr>';
        echo '<td></td>';
        foreach ($products as $product) {
          echo '<td><button data-id="' . $product['compare_id'] . '" class="removeCompareBtn btn btn-sm btn-danger">Remove</button></td>';
        }
        echo '</tr>';
      }
      
      echo '</tbody></table>';
      echo '</div>';
    }
    
    public function wishlistProducts()
    {
      $data   = [];
      $user   = esc($_SESSION['username']);
      $sql    = "SELECT * FROM wishlist INNER JOIN products ON wishlist.product_id=products.product_id WHERE wishlist.user=?";
      $params = [$user];
      $result = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $data[] = $row;
        }
      }
      return $data;
    }
    
    // Method to render the user's wishlist
    public function renderWishlist($wishlistItems)
    {
      echo '<table class="table table-wishlist table-mobile">
					<thead>
					<tr>
						<th>Product</th>
						<th>Original Price</th>
						<th>Current Price</th>
						<th>Stock Status</th>
						<th></th>
						<th></th>
					</tr>
					</thead>
					
					<tbody>';
      foreach ($wishlistItems as $item) {
        if ($item['quantity_in_stock'] > $item['reorder_level']) {
          $stock = '<td class="stock-col"><span class="in-stock">In stock</span></td>
                    <td class="action-col pr-2">
                      <button class="btn btn-block btn-outline-primary-2 wishlistCartBtn" data-id="' . $item['product_id'] . '">Add to Cart</button>
                    </td>';
        } elseif ($item['quantity_in_stock'] <= $item['reorder_level'] && $item['quantity_in_stock'] > 0) {
          $stock = '<td class="stock-col"><span class="out-of-stock">' . $item['quantity_in_stock'] . ' Left</span></td>
                    <td class="action-col pr-2">
                      <button class="btn btn-block btn-outline-primary-2 wishlistCartBtn" data-id="' . $item['product_id'] . '">Add to Cart</button>
                    </td>';
        } else {
          $stock = '<td class="stock-col"><span class="out-of-stock">Out of stock</span></td>
                    <td class="action-col pr-2">
                      <button class="btn btn-block btn-outline-primary-2 disabled">Out of Stock</button>
                    </td>';
        }
        echo '
					<tr>
						<td class="product-col">
							<div class="product">
								<figure class="product-media">
									<a href="product.php?id=' . $item['product_id'] . '">
										<img src="assets/img/products/' . explode(", ", $item['product_image'])[0] . '" alt="Product image">
									</a>
								</figure>
								
								<h3 class="product-title">
									<a href="product.php?id=' . $item['product_id'] . '">' . $item['product_name'] . '</a>
								</h3><!-- End .product-title -->
							</div><!-- End .product -->
						</td>
						<td class="price-col">' . CURRENCY . ' ' . number_format($item['original_price'], 2) . '</td>
						<td class="price-col">' . CURRENCY . ' ' . number_format($item['current_price'], 2) . '</td>
						' . $stock . '
						<td class="remove-col pl-2">
							<button class="btn btn-danger removeWishlistBtn" data-id="' . $item['product_id'] . '"> Remove</button>
						</td>
					</tr>';
      }
      echo '</tbody>
				  </table><!-- End .table table-wishlist -->' . PHP_EOL;
    }
    
    // Method to return an array of products in the cart
    public function shoppingCartItems()
    {
      $data   = [];
      $user   = esc($_SESSION['username']);
      $sql    = "SELECT cart.*, products.*, cart.product_id AS productId FROM cart INNER JOIN products ON cart.product_id=products.product_id WHERE user=?";
      $params = [$user];
      $result = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $data[] = $row;
        }
      }
      
      return $data;
    }
    
    // Method to render the shopping cart
    public function renderShoppingCart($cartItems)
    {
      echo '<table class="table table-cart table-mobile">
								<thead>
								<tr>
									<th>Product</th>
									<th>Price (' . CURRENCY . ')</th>
									<th>Quantity</th>
									<th>Total (' . CURRENCY . ')</th>
									<th></th>
								</tr>
								</thead>
								
								<tbody>
								';
      echo '<div class="shopping-cart">';
      echo '<h2>Shopping Cart</h2>';
      echo '<ul>';
      foreach ($cartItems as $item) {
        echo '<tr>
									<td class="product-col">
										<div class="product">
											<figure class="product-media">
												<a href="product.php?id=' . $item['product_id'] . '">
													<img src="assets/img/products/' . explode(", ", $item['product_image'])[0] . '" alt="Product image">
												</a>
											</figure>
											
											<h3 class="product-title">
												<a href="product.php?id=' . $item['product_id'] . '">' . $item['product_name'] . '</a>
											</h3><!-- End .product-title -->
										</div><!-- End .product -->
									</td>
									<td class="price-col">' . number_format($item['current_price'], 2) . '</td>
									<td class="quantity-col">
										<div class="cart-product-quantity">
											<input type="number" data-id="' . $item['product_id'] . '" class="form-control cartQuantity" value="' . $item['quantity'] . '" min="1" max="1000" step="1" data-decimals="0" required>
										</div><!-- End .cart-product-quantity -->
									</td>
									<td class="total-col">' . number_format(($item['quantity'] * $item['current_price']), 2) . '</td>
									<td class="remove-col">
										<button data-id="'.$item['cart_id'].'" class="btn-remove removeCartBtn"><i class="icon-close"></i></button>
									</td>
								</tr>';
      }
      echo '</tbody>
							</table><!-- End .table table-wishlist -->' . PHP_EOL;
    }
    
    // Method to display cart summary of totals and so on
    public function cartSummary()
    {
      $amount = 0;
      $data   = '';
      $user   = esc($_SESSION['username']);
      $sql    = "SELECT * FROM cart INNER JOIN products ON cart.product_id=products.product_id WHERE user=?";
      $params = [$user];
      $result = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $amount += ($row['quantity'] * $row['current_price']);
          $data   = '<div class="summary summary-cart">
								<h3 class="summary-title">Cart Total</h3><!-- End .summary-title -->
								
								<table class="table table-summary">
									<tbody>
									<tr class="summary-subtotal">
										<td>Subtotal:</td>
										<td>' . CURRENCY . ' ' . number_format($amount, 2) . '</td>
									</tr><!-- End .summary-subtotal -->
									<!--<tr class="summary-shipping">
										<td>Transportation:</td>
										<td>&nbsp;</td>
									</tr>
									
									<tr class="summary-shipping-row">
										<td>
											<div class="custom-control custom-radio">
												<input type="radio" id="free-shipping" name="shipping" class="custom-control-input">
												<label class="custom-control-label" for="free-shipping">Free (Next Day)</label>
											</div>
										</td>
										<td>' . CURRENCY . ' 0.00</td>
									</tr>
									
									<tr class="summary-shipping-row">
										<td>
											<div class="custom-control custom-radio">
												<input type="radio" id="standart-shipping" name="shipping" class="custom-control-input">
												<label class="custom-control-label" for="standart-shipping">Standard:</label>
											</div>
										</td>
										<td>' . CURRENCY . ' 10,000.00</td>
									</tr>
									
									<tr class="summary-shipping-row">
										<td>
											<div class="custom-control custom-radio">
												<input type="radio" id="express-shipping" name="shipping" class="custom-control-input">
												<label class="custom-control-label" for="express-shipping">Express:</label>
											</div>
										</td>
										<td>' . CURRENCY . ' 15,000.00</td>
									</tr>-->
									
									<tr class="summary-total">
										<td>Total:</td>
										<td>' . CURRENCY . ' ' . number_format($amount, 2) . '</td>
									</tr><!-- End .summary-total -->
									</tbody>
								</table><!-- End .table table-summary -->
								
								<a href="checkout.php" class="btn btn-outline-primary-2 btn-order btn-block">PROCEED TO CHECKOUT</a>
							</div><!-- End .summary -->';
        }
      }
      
      return $data;
    }
    
    // Method to update shopping cart
    public function updateShoppingCart($cartData)
    {
      $no   = 0;
      $user = esc($_SESSION['username']);
      foreach ($cartData as $item) {
        $sql    = 'UPDATE cart SET quantity=? WHERE product_id=? && user=?';
        $params = [$item['quantity'], $item['productId'], $user];
        if ($this->updateQuery($sql, $params)):
          $no++;
        endif;
      }
      if ($no > 0) {
        return json_encode(['status' => 'success', 'message' => 'Cart updated successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Cart updates failed.']);
      }
    }
    
    // Method to add a product to the user's wishlist
    public function addToWishlist($productId)
    {
      $user  = esc($_SESSION['username']);
      $check = "SELECT * FROM wishlist WHERE product_id=? && user=?";
      if ($this->selectQuery($check, [$productId, $user])->num_rows > 0) {
        // Return an error message
        return json_encode(['status' => 'warning', 'message' => 'Product already exists in your wishlist.']);
      } else {
        // Insert the product to Wishlist
        $sql    = "INSERT INTO wishlist (user, product_id) VALUES (?, ?)";
        $params = [$user, $productId];
        if ($this->insertQuery($sql, $params)) {
          return json_encode(['status' => 'success', 'message' => 'Product Added to Wishlist Successfully.']);
        } else {
          return json_encode(['status' => 'warning', 'message' => 'Product Addition to Wishlist Failed.']);
        }
      }
    }
    
    // Method to add product to shopping cart from th wishlist
    public function addToShoppingCartFromWishlist($productId)
    {
      $user = esc($_SESSION['username']);
      // Check the existence of the product in cart and remove it from the wishlist if it exists in the cart
      $check   = "SELECT * FROM cart WHERE product_id=? && user=?";
      $checker = [$productId, $user];
      if ($this->selectQuery($check, $checker)->num_rows > 0) {
        // Remove the product from wishlist
        $this->deleteQuery("DELETE FROM wishlist WHERE product_id=? && user=?", [$productId, $user]);
        return json_encode(['status' => 'warning', 'message' => 'Product is already added to the shopping cart.']);
      } else {
        // If it does not exist
        $sql    = "INSERT INTO cart (user, product_id, quantity) SELECT user, product_id, 1 FROM wishlist WHERE product_id=? && user=?";
        $params = [$productId, $user];
        if ($this->insertQuery($sql, $params)) {
          // Remove the product from wishlist
          $this->deleteQuery("DELETE FROM wishlist WHERE product_id=? && user=?", [$productId, $user]);
          return json_encode(['status' => 'success', 'message' => 'Product added to shopping cart successfully.']);
        } else {
          return json_encode(['status' => 'warning', 'message' => 'Product addition to shopping cart failed.']);
        }
      }
    }
    
    // Method to update the quantity in the shopping cart
    public function addToShoppingCartSingleProduct($productId, $quantity, $color, $size)
    {
      $user   = esc($_SESSION['username']);
      $sql    = "INSERT INTO cart (user, product_id, quantity, color, size) VALUES (?, ?, ?, ?, ?)";
      $params = [$user, str_replace("?id=", "", $productId), $quantity, implode(", ", str_replace("color-", "", $color)), $size];
      if ($this->insertQuery($sql, $params)) {
        return json_encode(['status' => 'success', 'message' => 'Product Added to Cart Successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Product Addition to Cart Failed.']);
      }
    }
    
    // Method to remove a product from the user's wishlist
    public function removeFromWishlist($productId)
    {
      $user   = esc($_SESSION['username']);
      $sql    = "DELETE FROM wishlist WHERE product_id=? && user=?";
      $params = [$productId, $user];
      if ($this->deleteQuery($sql, $params)) {
        return json_encode(['status' => 'success', 'message' => 'Product Removed from Wishlist Successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Product Removal from Wishlist Failed.']);
      }
    }
    
    // Method to add a product to the shopping cart
    public function addToShoppingCart($productId)
    {
      $user  = esc($_SESSION['username']);
      $check = "SELECT * FROM cart WHERE product_id=? && user=?";
      if ($this->selectQuery($check, [$productId, $user])->num_rows > 0) {
        // Update Cart by increaing quantity
        $sql    = "UPDATE cart SET quantity=quantity+1 WHERE product_id=? && user=?";
        $params = [$productId, $user];
        if ($this->insertQuery($sql, $params)) {
          return json_encode(['status' => 'success', 'message' => 'Product Quantity in Cart Updated Successfully.']);
        } else {
          return json_encode(['status' => 'warning', 'message' => 'Product Quantity Updates Failed.']);
        }
      } else {
        // Insert the product to cart
        $sql    = "INSERT INTO cart (user, product_id, quantity) VALUES (?, ?, ?)";
        $params = [$user, $productId, 1];
        if ($this->insertQuery($sql, $params)) {
          return json_encode(['status' => 'success', 'message' => 'Product Added to Cart Successfully.']);
        } else {
          return json_encode(['status' => 'warning', 'message' => 'Product Addition to Cart Failed.']);
        }
      }
    }
    
    // Method to remove a product from the shopping cart
    public function removeFromShoppingCart($cartId)
    {
      $user   = esc($_SESSION['username']);
      $sql    = "DELETE FROM cart WHERE cart_id=?";
      $params = [$cartId];
      if ($this->deleteQuery($sql, $params)) {
        return json_encode(['status' => 'success', 'message' => 'Product removed from cart successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Product removal from cart failed.']);
      }
    }
    
    
    public function countWishList()
    {
      if (isset($_SESSION['username'])) {
        $user   = esc($_SESSION['username']);
        $sql    = "SELECT count(wishlist_id) AS num FROM wishlist WHERE user=?";
        $params = [$user];
        $result = $this->selectQuery($sql, $params)->fetch_assoc();
        return $result['num'];
      }
      return false;
    }
    
    public function countCart()
    {
      if (isset($_SESSION['username'])) {
        $user   = esc($_SESSION['username']);
        $sql    = "SELECT count(cart_id) AS num FROM cart WHERE user=?";
        $params = [$user];
        $result = $this->selectQuery($sql, $params)->fetch_assoc();
        return $result['num'];
      }
      return false;
    }
    
    // Add more methods for other frontend features here
    public function listMyCompare()
    {
      return '<ul class="compare-products">
												<li class="compare-product">
													<a href="javascript:void(0)" class="btn-remove" title="RemoveCompareProduct Remove Product"><i class="icon-close"></i></a>
													<h4 class="compare-product-title"><a href="product.html">Blue Night Dress</a></h4>
												</li>
												<li class="compare-product">
													<a href="javascript:void(0)" class="btn-remove" title="RemoveCompareProduct Remove Product"><i class="icon-close"></i></a>
													<h4 class="compare-product-title"><a href="product.html">White Long Skirt</a></h4>
												</li>
											</ul>';
    }
    
    public function showDroppingCart()
    {
      $data   = '';
      $total  = 0;
      $user   = esc($_SESSION['username']);
      $sql    = "SELECT cart.*, products.*, cart.product_id AS productId FROM cart INNER JOIN products ON cart.product_id=products.product_id WHERE cart.user=?";
      $params = [$user];
      $result = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $total += $row['current_price'] * $row['quantity'];
          $data  .= '<div class="product">
													<div class="product-cart-details">
														<h4 class="product-title">
															<a href="product.php?id=' . $row['productId'] . '">' . $row['product_name'] . '</a>
														</h4>
														<span class="cart-product-info">
                                <span class="cart-product-qty">' . $row['quantity'] . '</span> x ' . $row['current_price'] . '
                            </span>
													</div><!-- End .product-cart-details -->
													<figure class="product-image-container">
														<a href="product.php?id=' . $row['productId'] . '" class="product-image">
															<img src="assets/img/products/' . explode(", ", $row['product_image'])[0] . '" alt="product">
														</a>
													</figure>
													<a href="javascript:void(0)" class="btn-remove removeCartBtn" title="RemoveFromCart Remove Product"><i class="icon-close"></i></a>
												</div><!-- End .product -->';
          
        }
      }
      $data .= '</div><!-- End .cart-product -->
                <div class="dropdown-cart-total">
                  <span>Total</span>
                  <span class="cart-total-price">' . CURRENCY . " " . number_format($total, 2) . '</span>
                </div><!-- End .dropdown-cart-total -->';
      
      return $data;
    }
    
    public function countCompare()
    {
      if (isset($_SESSION['username'])) {
        $user   = esc($_SESSION['username']);
        $sql    = "SELECT count(compare_id) AS num FROM compare WHERE user=?";
        $params = [$user];
        $result = $this->selectQuery($sql, $params)->fetch_assoc();
        return $result['num'];
      }
      return false;
    }
    
    public function listMyProducts()
    {
      $data = new Products();
      return $data->listMyProducts();
    }
  
    // TODO: Remove method in future
    public function addProductClient($formData)
    {
      $data = new Products();
      return $data->addProductClient($formData);
    }
    
    // TODO: Remove method in future
    public function productForm($productId = null)
    {
      $data = new Products();
      return $data->productFormClient($productId);
    }
    
    public function productViewed($productId)
    {
      // Insert into the product views table
      $sql    = "INSERT INTO product_views (product_id, ip_address) VALUES (?, ?)";
      $params = [$productId, $_SERVER['REMOTE_ADDR']];
      $this->insertQuery($sql, $params);
      // Update the products total views
      $sql    = "UPDATE products SET total_views=total_views+1 WHERE product_id=?";
      $params = [$productId];
      $this->updateQuery($sql, $params);
    }
    
    // Add the menu categories for browsing
    public function showCategories()
    {
      // Connect to your database and fetch categories data
      $categories = $this->getAllCategories(); // Replace with your database query
      
      echo '<ul class="nav megamenu-container">';
      
      foreach ($categories as $category) {
        // Check if it's a top-level category
        if ($category['parent_category_id'] == 0) {
          echo '<li class="megamenu-container">';
          echo '<a class="sf-with-ul" href="#">' . $category['category_name'] . '</a>';
          echo '<div class="megamenu">';
          echo '<div class="row no-gutters">';
          echo '<div class="col-md-8">';
          echo '<div class="menu-col">';
          echo '<div class="row">';
          
          // Fetch subcategories for this category
          $subcategories = $this->getSubcategories($category['category_id']); // Replace with your database query
          
          foreach ($subcategories as $subcategory) {
            echo '<div class="col-md-6">';
            echo '<div class="menu-title">' . $subcategory['category_name'] . '</div>';
            echo '<ul>';
            
            // Fetch sub-subcategories for this subcategory
            $subSubcategories = $this->getSubcategories($subcategory['category_id']); // Replace with your database query
            
            foreach ($subSubcategories as $subSubcategory) {
              echo '<li><a href="#">' . $subSubcategory['category_name'] . '</a></li>';
            }
            
            echo '</ul>';
            echo '</div>';
          }
          
          echo '</div>'; // Close .row
          echo '</div>'; // Close .menu-col
          echo '</div>'; // Close .col-md-8
          echo '</div>'; // Close .row
          echo '</div>'; // Close .megamenu
          echo '</li>';  // Close .megamenu-container
        }
      }
      
      echo '</ul>';
    }
    
    public function getAllCategories()
    {
      // Define the query to fetch all categories
      $query = "SELECT * FROM categories";
      // Execute the query
      $result = $this->selectQuery($query);
      // Initialize an array to store the categories
      $categories = [];
      // Fetch the categories from the result
      while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
      }
      return $categories;
    }
    
    public function getSubSubCategories($parentCategoryID)
    {
      $data   = '<ul>';
      $sql    = "SELECT * FROM categories WHERE parent_category_id=?";
      $params = [$parentCategoryID];
      $result = $this->selectQuery($sql, $params);
      while ($row = $result->fetch_assoc()) {
        $data .= '<li><a href="category.php?id=' . $row['parent_category_id'] . '">' . $row['category_name'] . '</a></li>';
      }
      $data .= '</ul>';
      
      return $data;
    }
    
    // Generate the mobile Menu
    public function mobileMenu()
    {
      $data   = '';
      $sql    = "SELECT * FROM categories WHERE parent_category_id=0";
      $result = $this->selectQuery($sql);
      while ($row = $result->fetch_assoc()) {
        if ($this->hasSubs($row['category_id'])) {
          $data .= '<li>
                      <a href="category.php?id=' . $row['category_id'] . '" class="sf-with-ul">' . $row['category_name'] . '</a>
                      ' . $this->getSubSubCategories($row['category_id']) . '
                    </li>';
        } else {
          $data .= '<li><a href="category.php?id=' . $row['category_id'] . '">' . $row['category_name'] . '</a></li>';
        }
      }
      $data .= '';
      
      return $data;
    }
    
    private function hasSubs($categoryId)
    {
      $sql    = "SELECT * FROM categories WHERE parent_category_id=?";
      $params = [$categoryId];
      $result = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        return true;
      } else {
        return false;
      }
    }
    
    // Generate Search Categories
    function generateCategoryMenu($categories, $parentCategoryId = 0)
    {
      echo '<ul class="menu-vertical sf-arrows">';
      foreach ($categories as $category) {
        // Check if the category has subcategories
        $hasSubcategories = $this->hasSubcategories($categories, $category['category_id']);
        if ($hasSubcategories && $category['parent_category_id'] == 0) {
          
          echo '<li class="megamenu-container">' . PHP_EOL;
          echo '<a class="sf-with-ul px-5" href="javascript:void(0)">' . $category['category_name'] . '</a>' . PHP_EOL;
          
          echo '<div class="megamenu">';
          echo '<div class="row no-gutters">';
          echo '<div class="col-md-8">';
          echo '<div class="menu-col">';
          echo '<div class="row">';
          $this->renderSubcategories($categories, $category['category_id']);
          echo '</div><!-- End .row -->';
          echo '</div><!-- End .menu-col -->';
          echo '</div><!-- End .col-md-8 -->';
          echo '<div class="col-md-4">
                  <div class="banner banner-overlay">
                    <a href="category.php?id=' . $category['category_id'] . '" class="banner banner-menu">
                      <img src="assets/img/categories/' . $category['banner'] . '" alt="' . COMPANY . ' Banner">
                    </a>
                  </div><!-- End .banner banner-overlay -->
                </div><!-- End .col-md-4 -->';
          echo '</div><!-- End .row -->
              </div><!-- End .megamenu -->
            </li>' . PHP_EOL;
        } elseif (!$hasSubcategories && $category['parent_category_id'] == 0) {
          echo '<li><a href="category.php?id=' . $category['category_id'] . '" class="px-5">' . $category['category_name'] . '</a></li>' . PHP_EOL;
        }
      }
      
      echo '<li><a href="categories.php" class="px-5">Browse All Categories</a></li></ul><!-- End .menu-vertical -->' . PHP_EOL;
    }
    
    function hasSubcategories($categories, $categoryId)
    {
      foreach ($categories as $subcategory) {
        if ($subcategory['parent_category_id'] == $categoryId) {
          return true;
        }
      }
      return false;
    }
    
    function renderSubcategories($categories, $categoryId)
    {
      echo '<div class="col-md-4"><ul>' . PHP_EOL;
      $itemCount = 0;
      foreach ($categories as $subcategory) {
        if ($subcategory['parent_category_id'] == $categoryId) {
          if ($itemCount % 2 == 0) {
            // Start a new col-md-6 every 7 items
            if ($itemCount > 0) {
              // Close the previous col-md-6 if it's not the first one
              echo '</ul></div>' . PHP_EOL . '<div class="col-md-4"><ul>';
            }
          }
          echo '<li><a href="category.php?id=' . $subcategory['category_id'] . '">' . $subcategory['category_name'] . '</a></li>';
          $itemCount++;
        }
      }
      // Close the last col-md-6 and ul
      echo '</ul></div>';
    }
    
    public function generateItems()
    {
      $sql    = "SELECT * FROM categories";
      $result = $this->selectQuery($sql);
      
      $data = [];
      while ($row = $result->fetch_assoc()) {
        $data[] = $row;
      }
      
      return $data;
    }
    
    // Configure the search results
    public function searchCategories()
    {
      $data   = '<select name="cat">
                <option value="All">All Categories</option>';
      $sql    = "SELECT * FROM categories WHERE parent_category_id=?";
      $params = [0];
      $result = $this->selectQuery($sql, $params);
      while ($row = $result->fetch_assoc()) {
        if ($this->categoryHasSubcategories($row['category_id'])) {
          $data .= '<optgroup label="' . $row['category_name'] . '">
                      ' . $this->optionsSubcategories($row['category_id']) . '
                    </optgroup>';
        } else {
          $data .= '<option value="' . $row['category_id'] . '">' . $row['category_name'] . '</option>';
        }
      }
      $data .= '</select>';
      
      return $data;
    }
    
    private function categoryHasSubcategories($categoryId)
    {
      $sql    = "SELECT * FROM categories WHERE parent_category_id=?";
      $params = [$categoryId];
      $result = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        return true;
      }
      return false;
    }
    
    private function optionsSubcategories($categoryId)
    {
      $data   = '';
      $sql    = "SELECT * FROM categories WHERE parent_category_id=?";
      $params = [$categoryId];
      $result = $this->selectQuery($sql, $params);
      while ($row = $result->fetch_assoc()) {
        $data .= '<option value="' . $row['category_id'] . '">- ' . $row['category_name'] . '</option>';
      }
      return $data;
    }
  
    public function perfectSearch($searchData)
    {
      $data        = [];
      $searchTerms = explode(" ", $searchData);
      $sql         = "SELECT product_id, product_name FROM products WHERE (product_name LIKE '%$searchData%' OR brand LIKE '%$searchData%' OR model LIKE '%$searchData%' OR manufacturer LIKE '%$searchData%') OR ";
      $conditions  = [];
      foreach ($searchTerms as $term) {
        $term         = esc($term); // Sanitize the input to prevent SQL injection
        $conditions[] = "(product_name LIKE '%$term%' OR brand LIKE '%$term%' OR model LIKE '%$term%' OR manufacturer LIKE '%$term%')";
      }
      $sql    .= implode(" OR ", $conditions);
      $result = $this->selectQuery($sql);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $data[] = ['id' => $row['product_id'], 'name' => $row['product_name']];
        }
      }
      return $data; // Return the flat array of search results directly
    }
  
  
  
  
  
    public function search($searchData)
    {
      $category = $searchData['cat'] ?? null;
      // Step 1: Receive user input
      $searchInput = $searchData['search'] ?? $searchData['searches']; // Assuming you're using the GET method for the search input
      // Step 2: Split input into words
      $searchTerms = explode(" ", $searchInput);
      // Step 3: Construct SQL query
      $sql        = "SELECT * FROM products LEFT JOIN categories ON products.category_id=categories.category_id INNER JOIN vendors ON products.vendor_id=vendors.vendor_id WHERE ";
      $conditions = array();
      foreach ($searchTerms as $term) {
        $term = esc($term); // Sanitize the input to prevent SQL injection
        if ($category === "All" || empty($category)) {
          $conditions[] = "(product_name LIKE '%$term%' OR brand LIKE '%$term%' OR model LIKE '%$term%' OR manufacturer LIKE '%$term%')";
        } else {
          $conditions[] = "(product_name LIKE '%$term%' OR brand LIKE '%$term%' OR model LIKE '%$term%' OR manufacturer LIKE '%$term%' AND products.category_id=$category)";
        }
      }
      
      $sql .= implode(" OR ", $conditions);
      
      // Step 4: Execute the query
      $result   = $this->selectQuery($sql);
      $top      = "";
      $new      = "";
      $discount = "";
      
      // Step 5: Display search results
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $imgs = explode(", ", $row['product_image']);
          // Check if product was added in less that 7 days
          if (daysBack($row['created_at']) <= 7) {
            $new = '<span class="product-label label-new">New Arrival</span>';
          }
          // Check if the product is among the top rated and viewed
          if ($this->top10($row['product_id'])) {
            $top = '<span class="product-label label-top">TOP</span>';
          }
          // Check if the product is among the top rated and viewed
          if ($this->discounted($row['product_id'])) {
            $top       = '<span class="product-label label-sale">' . $this->productDiscount($row['product_id']) . '% OFF</span>';
            $hoursLeft = '<div class="product-countdown" data-until="+' . HoursLeft($this->productDiscountTimeLeft($row['product_id'])) . 'h" data-relative="true" data-labels-short="true"></div><!-- End .product-countdown -->';
          } else {
            $top       = "";
            $hoursLeft = "";
          }
          
          if ($this->discounted($row['product_id'])) {
            $currentPrice = CURRENCY . " " . number_format(($row['current_price'] - ($row['current_price'] * ($this->productDiscount($row['product_id']) / 100))));
          } else {
            $currentPrice = CURRENCY . " " . number_format($row['current_price']);
          }
          
          // Display search results, e.g., product names and links
          echo '<div class="col-6 col-md-3 col-lg-2">
                  <div class="product text-center">
										<figure class="product-media">
											' . $top . $new . $discount . '
											<a href="product.php?id=' . $row['product_id'] . '">
                        <img src="assets/img/products/' . $imgs[0] . '" alt="Product image" class="product-image">
                        <img src="assets/img/products/' . (isset($imgs[1]) ? $imgs[1] : $imgs[0]) . '" alt="Product image" class="product-image-hover">
											</a>
											' . $hoursLeft . '
											<div class="product-action-vertical">
												<a href="javascript:void(0)" class="btn-product-icon btn-wishlist wishlistBtn" data-id="' . $row['product_id'] . '" data-toggle="tooltip" title="Add to wishlist"><span>Add to wishlist</span></a>
												<a href="javascript:void(0)" class="btn-product-icon btn-quickview quickviewBtn" data-id="' . $row['product_id'] . '" data-toggle="tooltip" title="Quick view"><span>Quick view</span></a>
												<a href="javascript:void(0)" class="btn-product-icon btn-compare compareBtn" data-id="' . $row['product_id'] . '" data-toggle="tooltip" title="Compare"><span>Compare</span></a>
											</div><!-- End .product-action-vertical -->
											<div class="product-action">
												<a href="javascript:void(0)" class="btn-product btn-cart cartBtn" data-id="' . $row['product_id'] . '" data-toggle="tooltip" title="Add to Cart"><span>Cart</span></a>
                        <a href="chat.php?vendor=' . $row['vendor_id'] . '&prod=' . $row['product_id'] . '" class="btn-product btn-chat" title="Chat with Vendor"><span class="icon-comments">&nbsp;&nbsp;Chat</span></a>
											</div><!-- End .product-action -->
										</figure><!-- End .product-media -->
										<div class="product-body">
											<div class="product-cat">
												<a href="category.php?id=' . $row['category_id'] . '">' . $row['category_name'] . '</a>
											</div><!-- End .product-cat -->
											<h3 class="product-title"><a href="product.php?id=' . $row['product_id'] . '">' . $row['product_name'] . '</a></h3><!-- End .product-title -->
											<div class="product-price">
												<span class="new-price">' . $currentPrice . '</span>
											</div><!-- End .product-price -->
											<div class="ratings-container">
												<div class="ratings" data-toggle="tooltip" title="' . $row['average_stars'] . ' Stars">
													<div class="ratings-val" style="width: ' . (($row['average_stars'] / 5) * 100) . '%;"></div><!-- End .ratings-val -->
												</div><!-- End .ratings -->
												<span class="ratings-text">( ' . number_format($row['total_reviews']) . ' Reviews )</span>
											</div><!-- End .rating-container -->
                      <hr class="my-0 py-0">
                      <span class="product-location">' . $row['address'] . ', ' . $this->cityName($row['city']) . ', ' . $this->countryName($row['country']) . '</span>
										</div><!-- End .product-body -->
									</div><!-- End .product -->
                </div><!-- End .col-6 -->';
        }
      } else {
        echo "<div class='col-12 w-100 text-center mb-2 bg-primary'><p class='text-center text-white'>No results found for your search: " . $searchInput . ".</p></div>";
        echo $this->relatedProducts($category);
      }
    }
    
    public function top10($productId)
    {
      $data   = [];
      $sql    = "SELECT product_id FROM products ORDER BY total_views DESC, average_stars DESC LIMIT 10";
      $result = $this->selectQuery($sql);
      while ($row = $result->fetch_assoc()) {
        $data[] = $row;
      }
      if (in_array($productId, $data)) {
        return true;
      } else {
        return false;
      }
    }
    
    public function discounted($productId)
    {
      $sql    = 'SELECT * FROM deals WHERE product_id=? && (start_date <= now() && end_date >= now())';
      $params = [$productId];
      $result = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        return true;
      } else {
        return false;
      }
    }
    
    public function productDiscount($productId)
    {
      $sql    = 'SELECT * FROM deals WHERE product_id=?';
      $params = [$productId];
      $result = $this->selectQuery($sql, $params)->fetch_assoc();
      return $result['discount'];
    }
    
    public function productDiscountTimeLeft($productId)
    {
      $sql    = 'SELECT * FROM deals WHERE product_id=?';
      $params = [$productId];
      $result = $this->selectQuery($sql, $params)->fetch_assoc();
      return $result['end_date'];
    }
    
    public function relatedProducts($categoryId)
    {
      $top      = "";
      $new      = "";
      $discount = "";
      $sql      = "SELECT * FROM products INNER JOIN categories ON products.category_id=categories.category_id WHERE products.category_id=?";
      $params   = [$categoryId];
      $result   = $this->selectQuery($sql, $params);
      $data     = '<h2 class="title text-center mb-4">You May Also Like</h2><!-- End .title text-center -->
                   <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl"
                  data-owl-options=\'{
                      "nav": false,
                      "dots": true,
                      "margin": 20,
                      "loop": false,
                      "autoplay": true,
                      "responsive": {
                          "0": {
                              "items":2
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
                  }\'>';
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $imgs = explode(", ", $row['product_image']);
          // Check if product was added in less that 7 days
          if (daysBack($row['created_at']) <= 7) {
            $new = '<span class="product-label label-new">New Arrival</span>';
          }
          // Check if the product is among the top rated and viewed
          if ($this->top10($row['product_id'])) {
            $top = '<span class="product-label label-top">TOP</span>';
          }
          // Check if the product is among the top rated and viewed
          if ($this->discounted($row['product_id'])) {
            $top       = '<span class="product-label label-sale">' . $this->productDiscount($row['product_id']) . '% OFF</span>';
            $hoursLeft = '<div class="product-countdown" data-until="+' . HoursLeft($this->productDiscountTimeLeft($row['product_id'])) . 'h" data-relative="true" data-labels-short="true"></div><!-- End .product-countdown -->';
          } else {
            $top       = "";
            $hoursLeft = "";
          }
          
          if ($this->discounted($row['product_id'])) {
            $currentPrice = CURRENCY . " " . number_format(($row['current_price'] - ($row['current_price'] * ($this->productDiscount($row['product_id']) / 100))));
          } else {
            $currentPrice = CURRENCY . " " . number_format($row['current_price']);
          }
          
          $data .= '<div class="product text-center">
                      <figure class="product-media">
                        ' . $top . $new . $discount . '
                        <a href="product.php?id=' . $row['product_id'] . '">
                          <img src="assets/img/products/' . $imgs[0] . '" alt="Product image" class="product-image">
                          <img src="assets/img/products/' . (isset($imgs[1]) ? $imgs[1] : $imgs[0]) . '" alt="Product image" class="product-image-hover">
                        </a>
                        ' . $hoursLeft . '
                        <div class="product-action-vertical">
                          <a href="javascript:void(0)" class="btn-product-icon btn-wishlist wishlistBtn" data-id="' . $row['product_id'] . '" data-toggle="tooltip" title="Add to wishlist"><span>Add to wishlist</span></a>
                          <a href="javascript:void(0)" class="btn-product-icon btn-quickview quickviewBtn" data-id="' . $row['product_id'] . '" data-toggle="tooltip" title="Quick view"><span>Quick view</span></a>
                          <a href="javascript:void(0)" class="btn-product-icon btn-compare compareBtn" data-id="' . $row['product_id'] . '" data-toggle="tooltip" title="Compare"><span>Compare</span></a>
                        </div><!-- End .product-action-vertical -->
                        <div class="product-action">
                          <a href="javascript:void(0)" class="btn-product btn-cart cartBtn" data-id="' . $row['product_id'] . '" title="Add to cart"><span>Add to cart</span></a>
                        </div><!-- End .product-action -->
                      </figure><!-- End .product-media -->
                      <div class="product-body">
                        <div class="product-cat">
                          <a href="category.php?id=' . $row['category_id'] . '">' . $row['category_name'] . '</a>
                        </div><!-- End .product-cat -->
                        <h3 class="product-title"><a href="product.php?id=' . $row['product_id'] . '">' . $row['product_name'] . '</a></h3><!-- End .product-title -->
                        <div class="product-price">
                          <span class="new-price">' . $currentPrice . '</span>
                        </div><!-- End .product-price -->
                        <div class="ratings-container">
                          <div class="ratings" data-toggle="tooltip" title="' . $row['average_stars'] . ' Stars">
                            <div class="ratings-val" style="width: ' . round($row['average_stars'] * 10) . '%;"></div><!-- End .ratings-val -->
                          </div><!-- End .ratings -->
                          <span class="ratings-text">( ' . number_format($row['total_reviews']) . ' Reviews )</span>
                        </div><!-- End .rating-container -->
                        <hr class="my-0 py-0">
                        <span class="product-location">' . $row['address'] . ', ' . $this->cityName($row['city']) . ', ' . $this->countryName($row['country']) . '</span>
                      </div><!-- End .product-body -->
                    </div><!-- End .product -->';
        }
      } else {
        $this->otherProducts();
      }
      
      $data .= '</div><!-- End .owl-carousel -->';
      return $data;
    }
    
    public function otherProducts()
    {
    }
    
    public function quickProductView($productId)
    {
      $sql    = "SELECT * FROM products INNER JOIN categories ON products.category_id=categories.category_id INNER JOIN vendors ON products.vendor_id=vendors.vendor_id WHERE product_id=?";
      $params = [$productId];
      $row    = $this->selectQuery($sql, $params)->fetch_assoc();
      
      $colored = '';
      $colors  = explode(', ', $row['color']);
      $imgs    = explode(", ", $row['product_image']);
      $images  = '';
      // Loops through the colors from the database
      foreach ($colors as $color) {
        $colored .= '<a href="javascript:void(0)" style="background: ' . $color . ';"></a>';
      }
      // Loop through product images from the database
      $no = 1;
      foreach ($imgs as $img) {
        $images .= '<a class="product-gallery-item ' . (($no === 1) ? "active" : "") . '" href="javascript:void(0)" data-image="assets/img/products/' . $img . '" data-zoom-image="assets/img/products/' . $img . '">
                      <img src="assets/img/products/' . $img . '" alt="product side">
                    </a>';
        $no++;
      }
      // Show discount price
      if ($this->discounted($row['product_id'])) {
        $currentPrice = CURRENCY . " " . number_format(($row['current_price'] - ($row['current_price'] * ($this->productDiscount($row['product_id']) / 100)))) . " (" . $this->productDiscount($row['product_id']) . "% Off)";
      } else {
        $currentPrice = CURRENCY . " " . number_format($row['current_price']);
      }
      
      return '<div class="product-details-top">
                <div class="row">
                  <div class="col-md-7">
                    <div class="product-gallery product-gallery-vertical">
                      <div class="row">
                        <figure class="product-main-image">
                          <img id="product-zoom" src="assets/img/products/' . $imgs[0] . '" data-zoom-image="assets/images/products/' . $imgs[0] . '" alt="product image">
                        </figure><!-- End .product-main-image -->
                        
                        <div id="product-zoom-gallery" class="product-image-gallery">
                          ' . $images . '
                        </div><!-- End .product-image-gallery -->
                      </div><!-- End .row -->
                    </div><!-- End .product-gallery -->
                  </div><!-- End .col-md-6 -->
                  
                  <div class="col-md-5">
                    <div class="product-details">
                      <h1 class="product-title">' . $row['product_name'] . '</h1><!-- End .product-title -->
                      
                      <div class="ratings-container">
                        <div class="ratings" data-toggle="tooltip" title="' . $row['average_stars'] . ' Star Rating">
                          <div class="ratings-val" style="width: ' . round($row['average_stars'] * 10) . '%;"></div><!-- End .ratings-val -->
                        </div><!-- End .ratings -->
                        <a class="ratings-text" href="javascript:void(0)" id="review-link">(' . number_format($row['total_reviews']) . ' Reviews )</a>
                      </div><!-- End .rating-container -->
                      
                      <div class="product-price">
												<span class="new-price">' . $currentPrice . '</span>
                      </div><!-- End .product-price -->
                      
                      <div class="product-content">
                        <p>' . $row['short_description'] . '</p>
                    
                        <p>Vendor: <b><a href="vendor.php?id=' . $row['vendor_id'] . '">' . $row['shop_name'] . '</a></b><br>
                           Address: <b>' . $row['address'] . ', ' . $this->cityName($row['city']) . ', ' . $this->countryName($row['country']) . '</p>
                      </div><!-- End .product-content -->
                      
                      <div class="details-filter-row details-row-size">
                        <label>Color:</label>
                        <div class="product-nav product-nav-thumbs filter-colors">
                          ' . $colored . '
                        </div><!-- End .product-nav -->
                      </div><!-- End .details-filter-row -->
                      
                      <div class="product-details-action product-page">
                        <a href="#" class="btn-product btn-cart"><span>Add to cart</span></a>
                        <a href="chat.php?vendor=' . $row['vendor_id'] . '&prod=' . $row['product_id'] . '" class="btn-product btn-contact"><span>Contact Vendor</span></a>
                        <a href="javascript:void(0)" class="btn-product btn-wishlist wishlistBtn" data-toggle="tooltip" title="Wishlist"><span>Add to Wishlist</span></a>
                        <a href="javascript:void(0)" class="btn-product btn-compare CompareBtn" data-toggle="tooltip" title="Compare"><span>Add to Compare</span></a>
                      </div><!-- End .product-details-action -->
                      
                      <div class="product-details-footer">
                        <div class="product-cat">
                          <span>Category:</span>
                          <a href="category.php?id=' . $row['category_id'] . '">' . $row['category_name'] . '</a>
                        </div><!-- End .product-cat -->
                        
                        <div class="social-icons social-icons-sm mr-auto">
                          <span class="social-label">Share Product:</span>
                          <a href="https://www.facebook.com/sharer/sharer?u=' . URL . "product.php?id=" . $row['product_id'] . '" target="_blank" class="social-icon">
                            <i class="icon-facebook-f"></i>
                          </a>
                          <a href="https://twitter.com/intent/tweet?url=' . URL . "product.php?id=" . $row['product_id'] . '" target="_blank" class="social-icon">
                            <i class="icon-twitter"></i>
                          </a>
                          <a href="http://pinterest.com/pin/create/button/?url=' . URL . "product.php?id=" . $row['product_id'] . '" target="_blank" class="social-icon">
                            <i class="icon-pinterest"></i>
                          </a>
                          <a href="https://www.linkedin.com/shareArticle?mini=true&url=' . URL . "product.php?id=" . $row['product_id'] . '" target="_blank" class="social-icon">
                            <i class="icon-linkedin"></i>
                          </a>
                          <a href="https://api.whatsapp.com/send?text=' . COMPANY . " has got you covered with discounts on " . $row['product_name'] . ". Make your order now at " . URL . "product.php?id=" . $row['product_id'] . '" target="_blank" class="social-icon">
                            <i class="icon-whatsapp"></i>
                          </a>
                        </div>
                      </div><!-- End .product-details-footer -->
                    </div><!-- End .product-details -->
                  </div><!-- End .col-md-6 -->
                </div><!-- End .row -->
              </div><!-- End .product-details-top -->';
    }
    
    // Blogs For Home Page
    public function showRecentBlogs()
    {
      $data = new Blogs();
      return $data->showRecentBlogsHome(6);
    }
    
  }
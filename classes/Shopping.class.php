<?php
  
  class Shopping extends Config
  {
    // Display products on shop by products
    public function displayAllProducts($postData = null, $cat = null)
    {
      if ($cat !== null && !empty($cat)) {
        $sql = "SELECT *, c.category_name
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.category_id
                INNER JOIN vendors v ON p.vendor_id = v.vendor_id WHERE (c.parent_category_id=? || c.category_id=?)";
      } else {
        $sql = "SELECT *, c.category_name
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.category_id
                INNER JOIN vendors v ON p.vendor_id = v.vendor_id";
      }
      
      if ($cat !== null && !empty($cat)) {
        $params = [$cat, $cat];
      } else {
        $params = [];
      }
      
      $conditions = [];
      
      if (!empty($postData['minPrice'])) {
        if ($postData['minPrice'] !== null) {
          $conditions[] = "current_price >= ?";
          $params[]     = $postData['minPrice'];
        }
        if ($postData['maxPrice'] !== null) {
          $conditions[] = "current_price <= ?";
          $params[]     = $postData['maxPrice'];
        }
      }
      
      // Initialize arrays to store filter conditions and parameters
      $filterConditions = [];
      $filterParams     = [];
      
      // Process selected filters
      if (!empty($postData['selectedFilters'])) {
        foreach ($postData['selectedFilters'] as $filter) {
          list($prefix, $value) = explode('-', $filter, 2);
          
          // Determine the column name based on the prefix
          if ($prefix === 'cat') {
            $column = 'p.category_id';
          }
          if ($prefix === 'brand') {
            $column = 'brand';
          }
          if ($prefix === 'color') {
            $column = 'color';
          }
          if ($prefix === 'model') {
            $column = 'model';
          }
          if ($prefix === 'size') {
            $column = 'size';
          }
          
          // Add a condition for the specific column
          if ($column === 'color') {
            $filterConditions[] = $column.' LIKE CONCAT("%", ?, "%")';
            $filterParams[]     = $value;
          } else {
            $filterConditions[] = "$column=?";
            $filterParams[]     = $value;
          }
        }
        
        // Join the filter conditions with OR
        $filterCondition = implode(' OR ', $filterConditions);
        
        // Add the filter condition to the overall conditions
        $conditions[] = "($filterCondition)";
        $params       = array_merge($params, $filterParams);
      }
      
      // Construct the final WHERE clause
      if ($cat !== null && !empty($cat)) {
        if (!empty($conditions)) {
          $sql .= " AND " . implode(" AND ", $conditions);
        }
      } else {
        if (!empty($conditions)) {
          $sql .= " WHERE " . implode(" AND ", $conditions);
        }
      }
      
      // Apply Sorting to the Products
      if (!isset($postData['sortBy'])) {
        $sql .= " ORDER BY total_views DESC";  // You can adjust this based on your actual column name for views/popularity
      } else {
        if ($postData['sortBy'] === 'views') {
          $sql .= " ORDER BY total_views DESC";
        }
        if ($postData['sortBy'] === 'rating') {
          $sql .= " ORDER BY average_stars DESC";
        }
        if ($postData['sortBy'] === 'asc') {
          $sql .= " ORDER BY product_name ASC";
        }
        if ($postData['sortBy'] === 'desc') {
          $sql .= " ORDER BY product_name DESC";
        }
      }
      
      $result       = $this->selectQuery($sql, $params);
      $top          = "";
      $new          = "";
      $discount     = "";
      $productCount = 0;
      
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          // Increase product count
          $productCount++;
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
          echo '<div class="col-6 col-md-4 col-lg-3 col-xl-3">
                  <div class="product text-center">
										<figure class="product-media p-0">
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
											<div class="product-action product-action-dark">
                        <a href="javascript:void(0)" class="btn-product btn-cart cartBtn" data-id="' . $row['product_id'] . '"><span>Cart</span></a>
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
        echo "<div class='col-12 w-100 text-center mb-2 bg-primary'><p class='text-center text-white'>Products will soon be added to the system by vendors. We apologize for the inconveniences caused.</p></div>";
        // You can customize the message or action for no products found
      }
    }
    
    // Filters
    public function generateAllCategoryFilter()
    {
      $categories = [];
      $sql        = "SELECT * FROM categories WHERE (parent_category_id!=? OR category_id NOT IN (SELECT parent_category_id FROM categories)) AND category_id IN (SELECT category_id FROM products)";
      $params     = [0];
      $result     = $this->selectQuery($sql, $params);
      while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
      }
      
      $filterHTML = '<div class="filter-items filter-items-count">';
      foreach ($categories as $category) {
        $filterHTML .= '<div class="filter-item">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input category-filter" id="cat-' . $category['category_id'] . '">
                            <label class="custom-control-label" for="cat-' . $category['category_id'] . '">' . $category['category_name'] . '</label>
                          </div>
                          <span class="item-count">' . $this->countProductsInCategory($category['category_id']) . '</span>
                        </div>';
      }
      
      $filterHTML .= '</div>';
      return $filterHTML;
    }
    
    public function generateCategoryFilter($categoryId)
    {
      $categories = [];
      $id         = esc($categoryId);
      $sql        = "SELECT * FROM categories WHERE parent_category_id=?";
      $params     = [$id];
      $result     = $this->selectQuery($sql, $params);
      while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
      }
      
      $filterHTML = '<div class="filter-items filter-items-count">';
      foreach ($categories as $category) {
        $filterHTML .= '<div class="filter-item">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input category-filter" id="cat-' . $category['category_id'] . '">
                            <label class="custom-control-label" for="cat-' . $category['category_id'] . '">' . $category['category_name'] . '</label>
                          </div>
                          <span class="item-count">' . $this->countProductsInCategory($category['category_id']) . '</span>
                        </div>';
      }
      
      $filterHTML .= '</div>';
      return $filterHTML;
    }
    
    public function countProductsInCategory($categoryId)
    {
      $sql    = "SELECT count(*) AS product_count FROM products WHERE category_id=?";
      $params = [$categoryId];
      $result = $this->selectQuery($sql, $params)->fetch_assoc();
      return $result['product_count'];
    }
    
    public function generateSizeFilter()
    {
      // Fetch sizes from the database
      $sizes      = ['XS', 'S', 'M', 'L', 'XL', 'XXL']; // Replace with actual database query
      $filterHTML = '<div class="filter-items">';
      
      foreach ($sizes as $size) {
        $filterHTML .= '<div class="filter-item">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input size-filter" id="size-' . $size . '">
                <label class="custom-control-label" for="size-' . $size . '">' . $size . '</label>
            </div>
        </div>';
      }
      
      $filterHTML .= '</div>';
      return $filterHTML;
    }
    
    public function generateColorFilter($categoryId = null)
    {
      $colors = [];
      if ($categoryId !== null) {
        $sql    = "SELECT color FROM products LEFT JOIN categories ON products.category_id=categories.category_id WHERE (categories.category_id=? || parent_category_id=?) GROUP BY color";
        $params = [$categoryId, $categoryId];
        $result = $this->selectQuery($sql, $params);
      } else {
        $sql    = "SELECT color FROM products GROUP BY color";
        $result = $this->selectQuery($sql);
      }
      
      while ($row = $result->fetch_assoc()) {
        $colors[] = $row;
      }
      
      $items = '';
      foreach ($colors as $color) {
        $items .= $color['color'] . ", ";
      }
      
      $reals      = explode(", ", rtrim($items, ", "));
      $colorItems = array_count_values($reals);
      
      $filterHTML = '<div class="filter-colors">';
      foreach ($colorItems as $colorItem => $value) {
        $filterHTML .= '<a href="javascript:void(0)" id="color-' . $colorItem . '" style="background: ' . $colorItem . '"><span class="sr-only">' . $colorItem . '</span></a>';
      }
      $filterHTML .= '</div>';
      
      return $filterHTML;
    }
    
    public function generateBrandFilter($categoryId = null)
    {
      $brands = [];
      if ($categoryId !== null) {
        $sql    = "SELECT * FROM products LEFT JOIN categories ON products.category_id=categories.category_id WHERE (categories.category_id=? || parent_category_id=?) && (brand!=NULL OR brand!='') GROUP BY brand";
        $params = [$categoryId, $categoryId];
        $result = $this->selectQuery($sql, $params);
      } else {
        $sql    = "SELECT * FROM products WHERE brand!=NULL OR brand!='' GROUP BY brand";
        $result = $this->selectQuery($sql);
      }
      
      while ($row = $result->fetch_assoc()) {
        $brands[] = $row['brand'];
      }
      $filterHTML = '<div class="filter-items">';
      
      foreach ($brands as $brand) {
        $filterHTML .= '<div class="filter-item">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input brand-filter" id="brand-' . $brand . '">
                <label class="custom-control-label" for="brand-' . $brand . '">' . $brand . '</label>
            </div>
        </div>';
      }
      
      $filterHTML .= '</div>';
      return $filterHTML;
    }
    
    public function generatePriceFilter()
    {
      $range = $this->getPriceRange();
      // Generate the HTML and JavaScript for the price range slider
      $filterHTML = '<input type="text" id="pricing" name="pricing"
                      data-skin="flat"
                      data-min="' . ((($range['min_price'] - ($range['max_price'] / 50)) < 0) ? $range['min_price'] : ($range['min_price'] - ($range['max_price'] / 50))) . '"
                      data-max="' . ($range['max_price'] + $range['min_price']) . '"
                      data-prefix="' . CURRENCY . ' "
                      data-grid="true"
                      data-type="double"
                      data-from="' . $range['min_price'] . '"
                      data-to="' . $range['max_price'] . '"
                      data-prettify-enabled="true"
                      data-prettify-separator=",">';
      
      return $filterHTML;
    }
    
    // Function to apply filters to the products
    private function applyFilters($products, $filters)
    {
      // Implement logic to filter products based on brand, manufacturer, price, and color
      // You can use array_filter or a custom filtering method here
      
      // Example: Filter by brand
      if (!empty($filters['brand'])) {
        $products = array_filter($products, function ($product) use ($filters) {
          return in_array($product['brand'], $filters['brand']);
        });
      }
      
      // Implement similar filtering logic for manufacturer, price, and color
      
      return $products;
    }
    
    public function getPriceRange()
    {
      // Initialize SQL queries to find the minimal and highest product prices
      $minPriceQuery = "SELECT MIN(current_price) AS min_price FROM products";
      $maxPriceQuery = "SELECT MAX(current_price) AS max_price FROM products";
      
      // Execute the queries
      $minPriceResult = $this->selectQuery($minPriceQuery)->fetch_assoc();
      $maxPriceResult = $this->selectQuery($maxPriceQuery)->fetch_assoc();
      
      // Return the price range as an associative array
      return [
        'min_price' => $minPriceResult['min_price'],
        'max_price' => $maxPriceResult['max_price'],
      ];
    }
    
    // Working on single product view
    public function showProduct($productId)
    {
      if (!isset($productId)) {
        header('location:shop.php');
      }
      $sql    = "SELECT *, categories.category_id AS catId FROM products
                INNER JOIN categories ON products.category_id=categories.category_id
                INNER JOIN vendors ON products.vendor_id=vendors.vendor_id
                WHERE product_id=?";
      $params = [esc($productId)];
      $row    = $this->selectQuery($sql, $params)->fetch_assoc();
      $imgs   = explode(", ", $row['product_image']);
      $colors = explode(", ", $row['color']);
      
      $no      = 1;
      $gallery = '';
      foreach ($imgs as $img) {
        $gallery .= '<a class="product-gallery-item ' . (($no === 1) ? "active" : "") . '" href="javascript:void(0)" data-image="assets/img/products/' . $img . '" data-zoom-image="assets/img/products/' . $img . '">
											<img src="assets/img/products/' . $img . '" alt="product side">
										</a>';
        $no++;
      }
      
      // Colors
      $colored = '';
      foreach ($colors as $color) {
        $colored .= '<a href="javascript:void(0)" id="color-' . $color . '" style="background: ' . $color . '"><span class="sr-only">' . $color . '</span></a>';
      }
      
      return '<div class="col-md-6">
                <div class="product-gallery product-gallery-vertical">
                  <div class="row">
                    <figure class="product-main-image">
                      <img id="product-zoom" src="assets/img/products/' . $imgs[0] . '" data-zoom-image="assets/img/products/' . $imgs[0] . '" alt="product image">
                      
                      <a href="javascript:void(0)" id="btn-product-gallery" class="btn-product-gallery">
                        <i class="icon-arrows"></i>
                      </a>
                    </figure><!-- End .product-main-image -->
                    
                    <div id="product-zoom-gallery" class="product-image-gallery">
                      ' . $gallery . '
                    </div><!-- End .product-image-gallery -->
                  </div><!-- End .row -->
                </div><!-- End .product-gallery -->
              </div><!-- End .col-md-6 -->
              
              <div class="col-md-6">
                <div class="product-details">
                  <h1 class="product-title">' . $row['product_name'] . '</h1><!-- End .product-title -->
                  <div class="ratings-container">
                    <div class="ratings">
                      <div class="ratings-val" style="width: ' . (($row['average_stars'] / 5) * 100) . '%;"></div><!-- End .ratings-val -->
                    </div><!-- End .ratings -->
                    <a class="ratings-text" href="#product-review-link" id="review-link">( ' . $row['total_reviews'] . ' Reviews )</a>
                  </div><!-- End .rating-container -->
                  
                  <div class="product-price">
                    <span class="new-price">' . CURRENCY . ' ' . number_format($row['current_price']) . '</span>
                  </div><!-- End .product-price -->
                  
                  <div class="product-content">
                    <p>' . $row['short_description'] . '</p>
                    
                  <p>Vendor: <b><a href="vendor.php?id=' . $row['vendor_id'] . '">' . $row['shop_name'] . '</a></b><br>
                     Address: <b>' . $row['address'] . ', ' . $this->cityName($row['city']) . ', ' . $this->countryName($row['country']) . '</p>
                  </div><!-- End .product-content -->
                  
                  <div class="details-filter-row details-row-size">
                    <label>Color:</label>
                    
                    <div class="product-nav product-colors filter-colors">
                      ' . $colored . '
                    </div><!-- End .product-nav -->
                  </div><!-- End .details-filter-row -->
                  
                  <div class="details-filter-row details-row-size">
                    <label for="size">Size:</label>
                    <div class="select-custom">
                      <select name="size" id="size" class="form-control">
                        <option value="#" selected="selected">Select a size</option>
                        <option value="XS">Extra Small</option>
                        <option value="S">Small</option>
                        <option value="M">Medium</option>
                        <option value="L">Large</option>
                        <option value="XL">Extra Large</option>
                        <option value="XXL">Extreme Extra Large</option>
                      </select>
                    </div><!-- End .select-custom -->
                    
                    <!--<a href="#" class="size-guide"><i class="icon-th-list"></i>size guide</a>-->
                  </div><!-- End .details-filter-row -->
                  
                  <div class="details-filter-row details-row-size">
                    <label for="qty">Qty:</label>
                    <div class="product-details-quantity">
                      <input type="number" id="qty" class="form-control" value="1" min="1" max="10" step="1" data-decimals="0" required>
                    </div><!-- End .product-details-quantity -->
                  </div><!-- End .details-filter-row -->
                  
                  <div class="product-details-action product-page">
                    <a href="javascript:void(0)" class="btn-product btn-cart productToCart"><span>Add to cart</span></a>
                    <a href="chat.php?vendor=' . $row['vendor_id'] . '&prod=' . $row['product_id'] . '" class="btn-product btn-contact"><span>Contact Vendor</span></a>
                    <a href="javascript:void(0)" class="btn-product btn-wishlist wishlistBtn" data-toggle="tooltip" title="Wishlist"><span>Add to Wishlist</span></a>
                    <a href="javascript:void(0)" class="btn-product btn-compare CompareBtn" data-toggle="tooltip" title="Compare"><span>Add to Compare</span></a>
                  </div><!-- End .product-details-action -->
                  
                  <div class="product-details-footer">
                    <div class="product-cat">
                      <span>Category:</span>
                      <a href="category.php?id=' . $row['catId'] . '">' . $row['category_name'] . '</a>
                    </div><!-- End .product-cat -->
                    
                    <div class="social-icons social-icons-sm">
                      <span class="social-label">Share:</span>
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
              </div><!-- End .col-md-6 -->';
    }
    
    // Product Other details
    public function showProductDetails($productId)
    {
      $data   = '';
      $sql    = "SELECT * FROM products WHERE product_id=?";
      $params = [$productId];
      $result = $this->selectQuery($sql, $params);
      while ($row = $result->fetch_assoc()) {
        $review  = new Products();
        $reviews = $review->showProductReviews($productId);
        $data    .= '<ul class="nav nav-pills justify-content-center" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="product-desc-link" data-toggle="tab" href="#product-desc-tab" role="tab" aria-controls="product-desc-tab" aria-selected="true">Description</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="product-info-link" data-toggle="tab" href="#product-info-tab" role="tab" aria-controls="product-info-tab" aria-selected="false">Additional information</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="product-shipping-link" data-toggle="tab" href="#product-shipping-tab" role="tab" aria-controls="product-shipping-tab" aria-selected="false">Shipping & Returns</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="product-review-link" data-toggle="tab" href="#product-review-tab" role="tab" aria-controls="product-review-tab" aria-selected="false">Reviews (' . $row['total_reviews'] . ')</a>
						</li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane fade show active" id="product-desc-tab" role="tabpanel" aria-labelledby="product-desc-link">
							<div class="product-desc-content">
								<h3>Product Information</h3>
								' . $row['product_description'] . '
							</div><!-- End .product-desc-content -->
						</div><!-- .End .tab-pane -->
						<div class="tab-pane fade" id="product-info-tab" role="tabpanel" aria-labelledby="product-info-link">
							<div class="product-desc-content">
								<h3>Additional Product Information</h3>
								
								<b>Fabric & care</b>
								<ul>
									<li>Faux suede fabric</li>
									<li>Gold tone metal hoop handles.</li>
									<li>RI branding</li>
									<li>Snake print trim interior</li>
									<li>Adjustable cross body strap</li>
									<li> Height: 31cm; Width: 32cm; Depth: 12cm; Handle Drop: 61cm</li>
								</ul>
								
								<h3>Size</h3>
								<p>one size</p>
							</div><!-- End .product-desc-content -->
						</div><!-- .End .tab-pane -->
						<div class="tab-pane fade" id="product-shipping-tab" role="tabpanel" aria-labelledby="product-shipping-link">
							<div class="product-desc-content">
								<h3>Delivery & returns</h3>
								<p>We deliver to over 100 countries around the world. For full details of the delivery options we offer, please view our <a href="#">Delivery information</a><br>
									We hope you’ll love every purchase, but if you ever need to return an item you can do so within a month of receipt. For full details of how to make a return, please view our <a href="#">Returns information</a></p>
							</div><!-- End .product-desc-content -->
						</div><!-- .End .tab-pane -->
						<div class="tab-pane fade" id="product-review-tab" role="tabpanel" aria-labelledby="product-review-link">
							<div class="reviews">
								<h3>Reviews (' . $row['total_reviews'] . ')</h3>
								' . $reviews . '
							</div><!-- End .reviews -->
							<div class="reviews review-form mt-5 pt-2 border-top">
							  <h3>Write a Review</h3>
							  <form id="review-form" method="post">
							    <input type="hidden" id="product_id" value="' . esc($_GET['id']) . '" required>
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label for="stars">Give Your Star Rating</label><br>
                        <div id="star-rating-container" data-rateit-backingfld="#stars" data-rateit-step="0.5"></div>
                        <select name="stars" id="stars" class="form-control custom-select select-custom" required>
                          <option value="0">0</option>
                          <option value="0.5">0.5</option>
                          <option value="1">1</option>
                          <option value="1.5">1.5</option>
                          <option value="2">2</option>
                          <option value="2.5">2.5</option>
                          <option value="3">3</option>
                          <option value="3.5">3.5</option>
                          <option value="4">4</option>
                          <option value="4.5">4.5</option>
                          <option value="5">5</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="full_name">Your Full Name</label>
                        <input type="text" name="full_name" id="full_name" class="form-control" required>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="status">Your Feeling</label>
                        <input type="text" name="status" id="status" placeholder="Very Nice" class="form-control" required>
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label for="review">Your Comment/Review</label>
                        <textarea name="review" id="review" class="form-control required"></textarea>
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="form-group">
                        <button type="submit" class="btn btn-outline-primary-2 btn-minwidth-sm">
                          <span>Send Review</span>
                          <i class="icon-long-arrow-right"></i>
                        </button>
                      </div>
                    </div>
                  </div>
							  </form>
							</div><!-- End .review-form -->
						</div><!-- .End .tab-pane -->
					</div><!-- End .tab-content -->';
      }
      return $data;
    }
    
    
    /***************************
     * Brand New Products
     */
    public function displayAllBrandNewProducts($postData = null, $cat = null)
    {
      $sql        = "SELECT *, c.category_name
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.category_id
                INNER JOIN vendors v ON p.vendor_id = v.vendor_id
                WHERE p.product_state='Brand New' ";
      $params     = [];
      $conditions = [];
      
      if (!empty($postData['minPrice'])) {
        if ($postData['minPrice'] !== null) {
          $conditions[] = "current_price >= ?";
          $params[]     = $postData['minPrice'];
        }
        if ($postData['maxPrice'] !== null) {
          $conditions[] = "current_price <= ?";
          $params[]     = $postData['maxPrice'];
        }
      }
      
      // Initialize arrays to store filter conditions and parameters
      $filterConditions = [];
      $filterParams     = [];
      
      // Process selected filters
      if (!empty($postData['selectedFilters'])) {
        foreach ($postData['selectedFilters'] as $filter) {
          list($prefix, $value) = explode('-', $filter, 2);
          
          // Determine the column name based on the prefix
          if ($prefix === 'cat') {
            $column = 'p.category_id';
          }
          if ($prefix === 'brand') {
            $column = 'brand';
          }
          if ($prefix === 'color') {
            $column = 'color';
          }
          if ($prefix === 'model') {
            $column = 'model';
          }
          if ($prefix === 'size') {
            $column = 'size';
          }
          
          // Add a condition for the specific column
          $filterConditions[] = "$column=?";
          $filterParams[]     = $value;
        }
        
        // Join the filter conditions with OR
        $filterCondition = implode(' OR ', $filterConditions);
        
        // Add the filter condition to the overall conditions
        $conditions[] = "($filterCondition)";
        $params       = array_merge($params, $filterParams);
      }
      
      // Construct the final WHERE clause
      if (!empty($conditions)) {
        $sql .= " AND " . implode(" AND ", $conditions);
      }
      
      // Apply Sorting to the Products
      if (!isset($postData['sortBy'])) {
        $sql .= " ORDER BY total_views DESC";  // You can adjust this based on your actual column name for views/popularity
      } else {
        if ($postData['sortBy'] === 'views') {
          $sql .= " ORDER BY total_views DESC";
        }
        if ($postData['sortBy'] === 'rating') {
          $sql .= " ORDER BY average_stars DESC";
        }
        if ($postData['sortBy'] === 'asc') {
          $sql .= " ORDER BY product_name ASC";
        }
        if ($postData['sortBy'] === 'desc') {
          $sql .= " ORDER BY product_name DESC";
        }
      }
      
      $result       = $this->selectQuery($sql, $params);
      $top          = "";
      $new          = "";
      $discount     = "";
      $productCount = 0;
      
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          // Increase product count
          $productCount++;
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
          echo '<div class="col-6 col-md-4 col-lg-3 col-xl-3">
                  <div class="product text-center">
										<figure class="product-media p-0">
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
											<div class="product-action product-action-dark">
                        <a href="javascript:void(0)" class="btn-product btn-cart cartBtn" data-id="' . $row['product_id'] . '"><span>Cart</span></a>
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
        echo "<div class='col-12 w-100 text-center mb-2 bg-primary'><p class='text-center text-white'>Products will soon be added to the system by vendors. We apologize for the inconveniences caused.</p></div>";
        // You can customize the message or action for no products found
      }
    }
    
    public function generateAllBandNewCategoryFilter()
    {
      $categories = [];
      $sql        = "SELECT * FROM categories WHERE (parent_category_id!=? OR category_id NOT IN (SELECT parent_category_id FROM categories)) AND category_id IN (SELECT category_id FROM products WHERE product_state='Brand New')";
      $params     = [0];
      $result     = $this->selectQuery($sql, $params);
      while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
      }
      
      $filterHTML = '<div class="filter-items filter-items-count">';
      foreach ($categories as $category) {
        $filterHTML .= '<div class="filter-item">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input category-filter" id="cat-' . $category['category_id'] . '">
                            <label class="custom-control-label" for="cat-' . $category['category_id'] . '">' . $category['category_name'] . '</label>
                          </div>
                          <span class="item-count">' . $this->countProductsInCategory($category['category_id']) . '</span>
                        </div>';
      }
      
      $filterHTML .= '</div>';
      return $filterHTML;
    }
    
    /***************************
     * Second Hand Products
     */
    public function displayAllSecondHandProducts($postData = null, $cat = null)
    {
      $sql        = "SELECT *, c.category_name
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.category_id
                INNER JOIN vendors v ON p.vendor_id = v.vendor_id
                WHERE p.product_state='Second Hand' ";
      $params     = [];
      $conditions = [];
      
      if (!empty($postData['minPrice'])) {
        if ($postData['minPrice'] !== null) {
          $conditions[] = "current_price >= ?";
          $params[]     = $postData['minPrice'];
        }
        if ($postData['maxPrice'] !== null) {
          $conditions[] = "current_price <= ?";
          $params[]     = $postData['maxPrice'];
        }
      }
      
      // Initialize arrays to store filter conditions and parameters
      $filterConditions = [];
      $filterParams     = [];
      
      // Process selected filters
      if (!empty($postData['selectedFilters'])) {
        foreach ($postData['selectedFilters'] as $filter) {
          list($prefix, $value) = explode('-', $filter, 2);
          
          // Determine the column name based on the prefix
          if ($prefix === 'cat') {
            $column = 'p.category_id';
          }
          if ($prefix === 'brand') {
            $column = 'brand';
          }
          if ($prefix === 'color') {
            $column = 'color';
          }
          if ($prefix === 'model') {
            $column = 'model';
          }
          if ($prefix === 'size') {
            $column = 'size';
          }
          
          // Add a condition for the specific column
          $filterConditions[] = "$column=?";
          $filterParams[]     = $value;
        }
        
        // Join the filter conditions with OR
        $filterCondition = implode(' OR ', $filterConditions);
        
        // Add the filter condition to the overall conditions
        $conditions[] = "($filterCondition)";
        $params       = array_merge($params, $filterParams);
      }
      
      // Construct the final WHERE clause
      if (!empty($conditions)) {
        $sql .= "AND " . implode(" AND ", $conditions);
      }
      
      // Apply Sorting to the Products
      if (!isset($postData['sortBy'])) {
        $sql .= " ORDER BY total_views DESC";  // You can adjust this based on your actual column name for views/popularity
      } else {
        if ($postData['sortBy'] === 'views') {
          $sql .= " ORDER BY total_views DESC";
        }
        if ($postData['sortBy'] === 'rating') {
          $sql .= " ORDER BY average_stars DESC";
        }
        if ($postData['sortBy'] === 'asc') {
          $sql .= " ORDER BY product_name ASC";
        }
        if ($postData['sortBy'] === 'desc') {
          $sql .= " ORDER BY product_name DESC";
        }
      }
      
      $result       = $this->selectQuery($sql, $params);
      $top          = "";
      $new          = "";
      $discount     = "";
      $productCount = 0;
      
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          // Increase product count
          $productCount++;
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
          echo '<div class="col-6 col-md-4 col-lg-3 col-xl-3">
                  <div class="product text-center">
										<figure class="product-media p-0">
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
											<div class="product-action product-action-dark">
                        <a href="javascript:void(0)" class="btn-product btn-cart cartBtn" data-id="' . $row['product_id'] . '"><span>Cart</span></a>
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
        echo "<div class='col-12 w-100 text-center mb-2 bg-primary'><p class='text-center text-white'>Products will soon be added to the system by vendors. We apologize for the inconveniences caused.</p></div>";
        // You can customize the message or action for no products found
      }
    }
    
    public function generateAllSecondHandCategoryFilter()
    {
      $categories = [];
      $sql        = "SELECT * FROM categories WHERE (parent_category_id!=? OR category_id NOT IN (SELECT parent_category_id FROM categories)) AND category_id IN (SELECT category_id FROM products WHERE product_state='Second Hand')";
      $params     = [0];
      $result     = $this->selectQuery($sql, $params);
      while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
      }
      
      $filterHTML = '<div class="filter-items filter-items-count">';
      foreach ($categories as $category) {
        $filterHTML .= '<div class="filter-item">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input category-filter" id="cat-' . $category['category_id'] . '">
                            <label class="custom-control-label" for="cat-' . $category['category_id'] . '">' . $category['category_name'] . '</label>
                          </div>
                          <span class="item-count">' . $this->countProductsInCategory($category['category_id']) . '</span>
                        </div>';
      }
      
      $filterHTML .= '</div>';
      return $filterHTML;
    }
    
    /***************************
     * Spare Parts Products
     */
    public function displayAllSparePartsProducts($postData = null, $cat = null)
    {
      $sql        = "SELECT *, c.category_name
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.category_id
                INNER JOIN vendors v ON p.vendor_id = v.vendor_id
                WHERE p.spare_part='Yes' ";
      $params     = [];
      $conditions = [];
      
      if (!empty($postData['minPrice'])) {
        if ($postData['minPrice'] !== null) {
          $conditions[] = "current_price >= ?";
          $params[]     = $postData['minPrice'];
        }
        if ($postData['maxPrice'] !== null) {
          $conditions[] = "current_price <= ?";
          $params[]     = $postData['maxPrice'];
        }
      }
      
      // Initialize arrays to store filter conditions and parameters
      $filterConditions = [];
      $filterParams     = [];
      
      // Process selected filters
      if (!empty($postData['selectedFilters'])) {
        foreach ($postData['selectedFilters'] as $filter) {
          list($prefix, $value) = explode('-', $filter, 2);
          
          // Determine the column name based on the prefix
          if ($prefix === 'cat') {
            $column = 'p.category_id';
          }
          if ($prefix === 'brand') {
            $column = 'brand';
          }
          if ($prefix === 'color') {
            $column = 'color';
          }
          if ($prefix === 'model') {
            $column = 'model';
          }
          if ($prefix === 'size') {
            $column = 'size';
          }
          
          // Add a condition for the specific column
          $filterConditions[] = "$column=?";
          $filterParams[]     = $value;
        }
        
        // Join the filter conditions with OR
        $filterCondition = implode(' OR ', $filterConditions);
        
        // Add the filter condition to the overall conditions
        $conditions[] = "($filterCondition)";
        $params       = array_merge($params, $filterParams);
      }
      
      // Construct the final WHERE clause
      if (!empty($conditions)) {
        $sql .= "AND " . implode(" AND ", $conditions);
      }
      
      // Apply Sorting to the Products
      if (!isset($postData['sortBy'])) {
        $sql .= " ORDER BY total_views DESC";  // You can adjust this based on your actual column name for views/popularity
      } else {
        if ($postData['sortBy'] === 'views') {
          $sql .= " ORDER BY total_views DESC";
        }
        if ($postData['sortBy'] === 'rating') {
          $sql .= " ORDER BY average_stars DESC";
        }
        if ($postData['sortBy'] === 'asc') {
          $sql .= " ORDER BY product_name ASC";
        }
        if ($postData['sortBy'] === 'desc') {
          $sql .= " ORDER BY product_name DESC";
        }
      }
      
      $result       = $this->selectQuery($sql, $params);
      $top          = "";
      $new          = "";
      $discount     = "";
      $productCount = 0;
      
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          // Increase product count
          $productCount++;
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
          echo '<div class="col-6 col-md-4 col-lg-3 col-xl-3">
                  <div class="product text-center">
										<figure class="product-media p-0">
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
											<div class="product-action product-action-dark">
                        <a href="javascript:void(0)" class="btn-product btn-cart cartBtn" data-id="' . $row['product_id'] . '"><span>Cart</span></a>
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
        echo "<div class='col-12 w-100 text-center mb-2 bg-primary'><p class='text-center text-white'>Products will soon be added to the system by vendors. We apologize for the inconveniences caused.</p></div>";
        // You can customize the message or action for no products found
      }
    }
    
    public function generateAllSparePartsCategoryFilter()
    {
      $categories = [];
      $sql        = "SELECT * FROM categories WHERE (parent_category_id!=? OR category_id NOT IN (SELECT parent_category_id FROM categories)) AND category_id IN (SELECT category_id FROM products WHERE spare_part='Yes')";
      $params     = [0];
      $result     = $this->selectQuery($sql, $params);
      while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
      }
      
      $filterHTML = '<div class="filter-items filter-items-count">';
      foreach ($categories as $category) {
        $filterHTML .= '<div class="filter-item">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input category-filter" id="cat-' . $category['category_id'] . '">
                            <label class="custom-control-label" for="cat-' . $category['category_id'] . '">' . $category['category_name'] . '</label>
                          </div>
                          <span class="item-count">' . $this->countProductsInCategory($category['category_id']) . '</span>
                        </div>';
      }
      
      $filterHTML .= '</div>';
      return $filterHTML;
    }
    
    
  }
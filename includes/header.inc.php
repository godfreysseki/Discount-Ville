<?php
  
  include_once "config.inc.php";
  
  $data = new Frontend();
  $pic  = new Users();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title><?= PAGE . " - " . COMPANY ?></title>
	<!-- SEO META Tags -->
	<meta name="description" content="<?= $pageDescription ?? DESCRIPTION ?>">
	<meta name="keywords" content="<?= $pageKeywords ?? KEYWORDS ?>">
	<meta name="author" content="<?= $pageAuthor ?? 'Gramaxic' ?>">
	<meta name="robots" content="<?= $pageRobots ?? ROBOT ?>">
	<!-- Dynamic Meta Tags -->
	<meta property="og:title" content="<?= $pageTitle ?? COMPANY ?>">
	<meta property="og:description" content="<?= $pageDescription ?? '' ?>">
	<meta property="og:image" content="<?= $pageImage ?? FAVICON ?>">
	<meta property="og:image:alt" content="<?= $pageImageAlt ?? '' ?>">
	<meta property="og:url" content="<?= $pageUrl ?? URL ?>">
	<meta property="og:type" content="<?= $pageType ?? 'website' ?>">
	<meta property="og:site_name" content="<?= COMPANY ?>">
	
	<meta name="twitter:card" content="<?= $summaryImage ?? FAVICON ?>">
	<meta name="twitter:title" content="<?= $pageTitle ?? COMPANY ?>">
	<meta name="twitter:description" content="<?= $pageDescription ?? DESCRIPTION ?>">
	<meta name="twitter:image" content="<?= $pageImage ?? FAVICON ?>">
	
	<link rel="icon" href="<?= FAVICON ?>">
	<!-- Favicon -->
	<!--<link rel="apple-touch-icon" sizes="180x180" href="assets/images/icons/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="assets/images/icons/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="assets/images/icons/favicon-16x16.png">
	<link rel="manifest" href="assets/images/icons/site.html">
	<link rel="mask-icon" href="assets/images/icons/safari-pinned-tab.svg" color="#666666">
	<link rel="shortcut icon" href="assets/images/icons/favicon.ico">
	<meta name="apple-mobile-web-app-title" content="Molla">
	<meta name="application-name" content="Molla">
	<meta name="msapplication-TileColor" content="#cc9966">
	<meta name="msapplication-config" content="assets/images/icons/browserconfig.xml">
	<meta name="theme-color" content="#ffffff">-->
	
	
	<link rel="stylesheet" href="assets/vendor/line-awesome/line-awesome/line-awesome/css/line-awesome.min.css">
	<!-- Plugins CSS File -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/plugins/owl-carousel/owl.carousel.css">
	<link rel="stylesheet" href="assets/css/plugins/magnific-popup/magnific-popup.css">
	<link rel="stylesheet" href="assets/css/plugins/jquery.countdown.css">
	<link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
	<link rel="stylesheet" href="assets/plugins/dropzone/dropzone.css">
	<link rel="stylesheet" href="assets/plugins/datatables/datatables.min.css">
	<link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
	<link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
	<link rel="stylesheet" href="assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
	<link rel="stylesheet" href="assets/plugins/chart.js/Chart.min.css">
	<link rel="stylesheet" href="assets/plugins/summernote/summernote-bs4.min.css">
	<link rel="stylesheet" href="assets/plugins/toastr/toastr.min.css">
	<link rel="stylesheet" href="assets/plugins/animate/animate.min.css">
	<link rel="stylesheet" href="assets/plugins/ion-rangeslider/css/ion.rangeSlider.min.css">
	<link rel="stylesheet" href="assets/plugins/aos/aos.css">
	<link rel="stylesheet" href="assets/plugins/rateit.js/rateit.css">
	<!-- Main CSS File -->
	<link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="assets/css/skins/skin-demo-14.css">
	<link rel="stylesheet" href="assets/css/demos/demo-14.css">
	<link rel="stylesheet" href="assets/css/demos/custom-style.css">
	<script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
	
	<!-- Function to initialize the Google Translate Element -->
	<script>
    function googleTranslateElementInit()
    {
      new google.translate.TranslateElement({
        pageLanguage: 'en', includedLanguages: 'en,fr,es', layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL,
      }, 'google_translate_element');
    }
    
    function changeLanguage(languageCode)
    {
      var selectedLanguage = document.getElementById('selectedLanguage');
      selectedLanguage.innerHTML = languageCode;
      
      // Trigger Google Translate API to change the language
      var el = document.querySelector('.goog-te-combo');
      el.value = languageCode;
      el.dispatchEvent(new Event('change'));
    }
	</script>
</head>

<body>
<div class="page-wrapper">
	<header class="header header-14">
		<div class="header-top">
			<div class="container">
				<div class="header-left">
					<div class="d-none d-md-block">
						<a href="mailto:<?= str_replace(" ", "", COMPANYEMAIL) ?>"><i class="icon-envelope"></i>Mail Us: <?= COMPANYEMAIL ?></a>
						&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="tel:<?= str_replace(" ", "", COMPANYPHONE) ?>"><i class="icon-phone"></i>Call: <?= COMPANYPHONE ?></a>
					</div>
					<div class="d-block d-md-none d-lg-none d-xl-none">
						<a href="contact.php">Contact Us</a>
					</div>
				</div><!-- End .header-left -->
				
				<div class="header-right">
					
					<ul class="top-menu">
						<li>
							<div class="header-dropdown">
								<a href="javascript:void(0)">USD</a>
								<div class="header-menu">
									<ul>
										<li><a href="javascript:void(0)">Eur</a></li>
										<li><a href="javascript:void(0)">Usd</a></li>
									</ul>
								</div><!-- End .header-menu -->
							</div><!-- End .header-dropdown -->
						</li>
						<!-- Language Selection Dropdown -->
						<li>
							<div class="header-dropdown">
								<a href="javascript:void(0)" class="lang" id="selectedLanguage">En</a>
								<div class="header-menu">
									<ul>
										<li class="notranslate"><a href="javascript:void(0)" onclick="changeLanguage('en')">En</a></li>
										<li class="notranslate"><a href="javascript:void(0)" onclick="changeLanguage('fr')">Fr</a></li>
										<li class="notranslate"><a href="javascript:void(0)" onclick="changeLanguage('es')">Es</a></li>
									</ul>
								</div><!-- End .header-menu -->
							</div><!-- End .header-dropdown -->
							<!-- Google Translate Element -->
							<div id="google_translate_element"></div>
						</li>
					</ul><!-- End .top-menu -->
				</div><!-- End .header-right -->
			</div><!-- End .container -->
		</div><!-- End .header-top -->
		
		<div class="header-middle">
			<div class="container-fluid">
				<div class="row">
					<div class="col-auto col-lg-4 col-xl-4 col-xxl-3">
						<button class="mobile-menu-toggler">
							<span class="sr-only">Toggle mobile menu</span>
							<i class="icon-bars"></i>
						</button>
						<a href="index.php" class="logo">
							<img src="<?= FAVICON ?>" class="d-block d-sm-none" alt="<?= COMPANY ?> Logo" style="height:50px">
							<img src="<?= FAVICON_2 ?>" class="d-none d-sm-block" alt="<?= COMPANY ?> Logo" style="height:50px">
						</a>
					</div><!-- End .col-xl-3 col-xxl-2 -->
					
					<div class="col col-lg-8 col-xl-8 col-xxl-9 header-middle-right">
						<div class="row">
							<div class="col-lg-8 col-xxl-4-5col d-none d-lg-block">
								<div class="header-search header-search-extended header-search-visible header-search-no-radius">
									<a href="javascript:void(0)" class="search-toggle" role="button"><i class="icon-search"></i></a>
									<div class="header-search-wrapper search-wrapper-wide">
										
										<label for="search" class="sr-only">Search</label>
										<input type="search" class="form-control" name="search" id="search" placeholder="Search any product ..." required>
										<button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
									</div><!-- End .header-search-wrapper -->
									<div id="searchResult"></div>
								</div><!-- End .header-search -->
							</div><!-- End .col-xxl-4-5col -->
							
							<div class="col-lg-4 col-xxl-5col d-flex justify-content-end align-items-center">
								<div class="header-dropdown-link">
									<a href="javascript:void(0)" class="search-icon wishlist-link d-flex d-block d-xs-block d-lg-none" id="searchIcon" role="button">
										<i class="icon-search"></i>
										<span class="wishlist-txt">Search</span>
									</a>
									<div class="overlay" id="overlay">
										<div class="search-form">
											<input type="text" id="searchInput" placeholder="Search any product ...">
											<div id="searchResults"></div>
										</div>
									</div>
									
									<div class="dropdown cart-dropdown d-flex justify-content-center">
										<a href="javascript:void(0)" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
											<i class="icon-shopping-cart"></i>
                      <?php
                        
                        if ($data->countCart() > 0) {
                          echo '<span class="cart-count">' . $data->countCart() . '</span>';
                        }
                      
                      ?>
											<span class="cart-txt">Cart</span>
										</a>
                    <?php
                      
                      if ($data->countCart() > 0) {
                        echo '<div class="dropdown-menu dropdown-menu-right">
																<div class="dropdown-cart-products">
					                        
					                        ' . $data->showDroppingCart() . '
																	
																	<div class="dropdown-cart-action">
																		<a href="cart.php" class="btn btn-primary">View Cart</a>
																		<a href="checkout.php" class="btn btn-outline-primary-2"><span>Checkout</span><i class="icon-long-arrow-right"></i></a>
																	</div><!-- End .dropdown-cart-total -->
																</div><!-- End .dropdown-menu -->
															</div><!-- End .cart-dropdown -->';
                      }
                    ?>
									
									</div>
                  
                  <?php
                    
                    if (isset($_SESSION['user'])) {
                      echo '<div class="dropdown compare-dropdown d-flex flex-column justify-content-center">
															<a href="javascript:void(0)" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static" title="Compare Products" aria-label="Compare Products">
																'. $pic->profPic() .'
																<a href="javascript:void(0)" style="color: #777; font-size: 1.2rem">' . getFirstWord($_SESSION['user']) . '</a>
															</a>
															
															<div class="dropdown-menu dropdown-menu-right">
																<ul class="compare-products">
																	<li><a href="dashboard.php">Dashboard</a></li>
																	<li><a href="products.php">Products</a></li>
																	<li><a href="orders.php">Orders</a></li>
																	<li><a href="chat.php">Chat</a></li>
																	<li class="menu-divider"></li>
																	<li><a href="cart.php">Shopping Cart</a></li>
																	<li><a href="wishlist.php">My Wishlist</a></li>
																	<li><a href="compare.php">Compare</a></li>
																	<li class="menu-divider"></li>
																	<li><a href="notifications.php">Notifications</a></li>
																	<li><a href="settings.php">Settings</a></li>
																	<li class="menu-divider"></li>
																	<li><a href="logout.php">Logout</a></li>
																</ul>
															</div><!-- End .dropdown-menu -->
														</div>';
                    } else {
                      echo '<a href="#signin-modal" class="search-toggle wishlist-link d-flex justify-content-center" data-toggle="modal">
															<i class="icon-user"></i>
															<span class="wishlist-txt">Account</span>
														</a>';
                    }
                  
                  ?>
								
								</div><!-- End .col-xxl-5col -->
							</div><!-- End .row -->
						</div><!-- End .col-xl-9 col-xxl-10 -->
					</div><!-- End .row -->
				</div><!-- End .container-fluid -->
			</div><!-- End .header-middle -->
			
			<div class="header-bottom sticky-header">
				<div class="container-fluid p-0">
					<div class="row">
						<div class="col-auto col-lg-3 col-xl-3 col-xxl-2 header-left">
							<div class="dropdown category-dropdown" data-visible="false">
								<a href="javascript:void(0)" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static" title="Browse Categories">
									Browse Categories
								</a>
								
								<div class="dropdown-menu">
									<nav class="side-nav">
                    <?php
                      $categories = $data->getAllCategories();
                      $data->generateCategoryMenu($categories);
                    ?>
									</nav><!-- End .side-nav -->
								</div><!-- End .dropdown-menu -->
							</div><!-- End .category-dropdown -->
						</div><!-- End .col-xl-3 col-xxl-2 -->
						
						<div class="col col-lg-7 col-xl-7 col-xxl-8 header-center">
							<nav class="main-nav desktop-menu">
								<ul class="menu sf-arrows">
									<li>
										<a href="index.php">Home</a>
									</li>
									<li>
										<a href="about.php">About Us</a>
									</li>
									<li>
										<a href="categories.php">Shop by Category</a>
									</li>
									<li>
										<a href="shop.php">All Product</a>
									</li>
									<li>
										<a href="vendors.php">Vendors List</a>
									</li>
                  <?= (!isset($_SESSION['user']) ? '<li><a href="#signin-modal" data-toggle="modal">Become a Vendor</a></li>' : '') ?>
									<li>
										<a href="blogs.php">Blogs</a>
									</li>
								</ul><!-- End .menu -->
							</nav><!-- End .main-nav -->
						</div><!-- End .col-xl-9 col-xxl-10 -->
						
						<div class="col col-lg-2 col-xl-2 col-xxl-2 header-right">
							<i class="la la-headphones"></i>
							<a href="contact.php">Customer Service</span></a>
						</div>
					</div><!-- End .row -->
					<div class="row ">
						<div class="col header-center">
							<nav class="navbar navbar-expand-lg navbar-light bg-light child-nav">
								<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
									<span class="navbar-toggler-icon"></span>
								</button>
								<div class="collapse navbar-collapse" id="navbarNavDropdown">
									<ul class="navbar-nav child-navbar">
										<li class="nav-item">
											<a class="nav-link" href="brandnew.php">Brand New Products</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" href="secondhand.php">Second Hand Products</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" href="spare.php">Spare Parts</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" href="service.php">Service Providers</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" href="jobs.php">Job Search</a>
										</li>
                    <?php if (!isset($_SESSION['user_id'])) : ?>
											<li class="nav-item">
												<a class="nav-link" href="pricing.php">Subscription Plans</a>
											</li>
                    <?php endif; ?>
									</ul><!-- End .navbar-nav-->
								</div>
							</nav><!-- End .navbar -->
						</div><!-- End .col-xl-9 col-xxl-10 -->
					</div><!-- End .row -->
				</div><!-- End .container-fluid -->
			</div><!-- End .header-bottom -->
		
	</header><!-- End .header -->
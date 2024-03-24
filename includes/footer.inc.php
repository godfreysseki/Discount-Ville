<footer class="footer border-top">
	<div class="footer-middle border-0 pt-2">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12 col-lg-4">
					<div class="widget widget-about">
						<img src="<?= FAVICON ?>" class="footer-logo float-left" alt="Footer Logo" width="105" height="25">
						<p class="text-justify">At <?= COMPANY ?>, we are committed to delivering a seamless shopping experience that combines the qualities of quality, selection, and savings. Our innovative e-commerce platform offers a diverse range of
							products and vendors, ensuring you
							find everything you need in one place. Your journey with us is more than just a purchase; it's a promise
							of value and a shopping experience you can depend on. We appreciate your trust in our brand and continue to strive for excellence in providing top-notch products and service from the rightful vendors.</p>
						
					</div><!-- End .widget about-widget -->
				</div><!-- End .col-sm-12 col-lg-4 -->
				
				<div class="col-sm-4 col-lg-2">
					<div class="widget">
						<h4 class="widget-title">Useful Links</h4><!-- End .widget-title -->
						
						<ul class="widget-list">
							<li><a href="about.php">About <?= COMPANY ?></a></li>
							<li><a href="how_to.php">How to Use <?= COMPANY ?></a></li>
							<li><a href="faq.php">FAQ</a></li>
							<li><a href="contact.php">Contact us</a></li>
							<li><a href="#signin-modal" data-toggle="modal">Log in</a></li>
						</ul><!-- End .widget-list -->
					</div><!-- End .widget -->
				</div><!-- End .col-sm-4 col-lg-2 -->
				
				<div class="col-sm-4 col-lg-2">
					<div class="widget">
						<h4 class="widget-title">Customer Service</h4><!-- End .widget-title -->
						
						<ul class="widget-list">
							<li><a href="refund_policy.php">Refund Policy</a></li>
							<li><a href="returns.php">Payments, Transportation & Returns</a></li>
							<li><a href="terms.php">Terms and conditions</a></li>
							<li><a href="accessibility.php">Accessibility Statement</a></li>
							<li><a href="privacy_policy.php">Privacy Policy</a></li>
						</ul><!-- End .widget-list -->
					</div><!-- End .widget -->
				</div><!-- End .col-sm-4 col-lg-2 -->
				
				<div class="col-sm-4 col-lg-2">
					<div class="widget">
						<h4 class="widget-title">My Account</h4><!-- End .widget-title -->
						
						<ul class="widget-list">
							<li><?= ((isset($_SESSION['user_id'])) ? '<a href="dashboard.php">Dashboard</a>' : '<a href="#signin-modal" data-toggle="modal">Sign In</a>') ?></li>
							<li><a href="cart.php">View Cart</a></li>
							<li><a href="wishlist.php">My Wishlist</a></li>
							<li><a href="tracking.php">Track My Order</a></li>
							<li><a href="contact.php">Contact Admin</a></li>
						</ul><!-- End .widget-list -->
					</div><!-- End .widget -->
				</div><!-- End .col-sm-4 col-lg-2 -->
				
				<div class="col-sm-4 col-lg-2">
					<div class="widget widget-newsletter">
						<h4 class="widget-title">Sign Up to Newsletter</h4><!-- End .widget-title -->
						
						<p>Subscribe to our weekly newsletter for exclusive deals from <?= COMPANY ?>, exclusive offers and discount coupons from best products and sellers.</p>
						
						<form method="post" id="newsletters">
							<div class="input-group">
								<input type="email" id="newsletters-email" class="form-control" placeholder="Enter your Email Address" aria-label="Email Address" required>
								<div class="input-group-append">
									<button class="btn btn-dark" type="submit"><i class="icon-long-arrow-right"></i></button>
								</div><!-- .End .input-group-append -->
							</div><!-- .End .input-group -->
						</form>
					</div><!-- End .widget -->
				</div><!-- End .col-sm-4 col-lg-2 -->
			</div><!-- End .row -->
		</div><!-- End .container-fluid -->
	</div><!-- End .footer-middle -->
	
	<div class="footer-bottom">
		<div class="container-fluid">
			<p class="footer-copyright">Copyright © 2023 <?= COMPANY ?>. All Rights Reserved.</p><!-- End .footer-copyright -->
			<div class="social-icons social-icons-color">
				<span class="social-label">Social Media</span>
        <?= ((FACEBOOK !== null) ? '<a href="' . FACEBOOK . '" class="social-icon social-facebook" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>' : '') ?>
        <?= ((TWITTER !== null) ? '<a href="' . TWITTER . '" class="social-icon social-twitter" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>' : '') ?>
        <?= ((INSTAGRAM !== null) ? '<a href="' . INSTAGRAM . '" class="social-icon social-instagram" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>' : '') ?>
        <?= ((YOUTUBE !== null) ? '<a href="' . YOUTUBE . '" class="social-icon social-youtube" title="Youtube" target="_blank"><i class="icon-youtube"></i></a>' : '') ?>
			</div><!-- End .soial-icons -->
		</div><!-- End .container-fluid -->
	</div><!-- End .footer-bottom -->
</footer><!-- End .footer -->
</div><!-- End .page-wrapper -->
<button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

<!-- Mobile Menu -->
<div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->

<div class="mobile-menu-container">
	<div class="mobile-menu-wrapper">
		<span class="mobile-menu-close"><i class="icon-close"></i></span>
		
		<ul class="nav nav-pills-mobile" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" id="mobile-menu-link" data-toggle="tab" href="#mobile-menu-tab" role="tab" aria-controls="mobile-menu-tab" aria-selected="true">Menu</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="mobile-cats-link" data-toggle="tab" href="#mobile-cats-tab" role="tab" aria-controls="mobile-cats-tab" aria-selected="false">Categories</a>
			</li>
		</ul>
		
		<div class="tab-content">
			<div class="tab-pane fade show active" id="mobile-menu-tab" role="tabpanel" aria-labelledby="mobile-menu-link">
				<nav class="mobile-nav show">
					<ul class="mobile-menu">
						<li><a href="index.php">Home</a></li>
						<li><a href="about.php">About Us</a></li>
						<li><a href="categories.php">Shop By Category</a></li>
						<li><a href="shop.php">Shop by Product</a></li>
						<li><a href="vendors.php">Vendor List</a></li>
						<?= (!isset($_SESSION['user']) ? '<li><a href="#signin-modal" data-toggle="modal">Become a Vendor</a></li>' : '' ) ?>
						<li><a href="blogs.php">Blogs</a></li>
						<li><a href="contact.php">Customer Service</a></li>
						<hr class="p-0 m-0">
						<li><a href="secondhand.php">Second Hand Products</a></li>
						<li><a href="spare.php">Spare Parts</a></li>
						<li><a href="service.php">Service Providers</a></li>
						<li><a href="jobs.php">Job Search</a></li>
					</ul>
				</nav><!-- End .mobile-nav -->
			</div><!-- .End .tab-pane -->
			<div class="tab-pane fade" id="mobile-cats-tab" role="tabpanel" aria-labelledby="mobile-cats-link">
				<nav class="mobile-cats-nav mobile-nav">
					<ul class="mobile-cats-menu mobile-menu">
            <?php
              
              $data = new Frontend();
              echo $data->mobileMenu();
            
            ?>
					</ul><!-- End .mobile-cats-menu -->
				</nav><!-- End .mobile-cats-nav -->
			</div><!-- .End .tab-pane -->
		</div><!-- End .tab-content -->
		
		<div class="social-icons">
      <?= ((FACEBOOK !== null) ? '<a href="' . FACEBOOK . '" class="social-icon social-facebook" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>' : '') ?>
      <?= ((TWITTER !== null) ? '<a href="' . TWITTER . '" class="social-icon social-twitter" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>' : '') ?>
      <?= ((INSTAGRAM !== null) ? '<a href="' . INSTAGRAM . '" class="social-icon social-instagram" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>' : '') ?>
      <?= ((YOUTUBE !== null) ? '<a href="' . YOUTUBE . '" class="social-icon social-youtube" title="Youtube" target="_blank"><i class="icon-youtube"></i></a>' : '') ?>
		</div><!-- End .social-icons -->
	</div><!-- End .mobile-menu-wrapper -->
</div><!-- End .mobile-menu-container -->

<!-- Sign in / Register Modal -->
<div class="modal fade" id="signin-modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"><i class="icon-close"></i></span>
				</button>
				
				<div class="form-box">
					<div class="form-tab">
						<ul class="nav nav-pills nav-fill" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="signin-tab" data-toggle="tab" href="#signin" role="tab" aria-controls="signin" aria-selected="true">Sign In</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="register-tab" data-toggle="tab" href="#register" role="tab" aria-controls="register" aria-selected="false">Register</a>
							</li>
						</ul>
						<div class="tab-content" id="tab-content-5">
							<div class="accountMsg"></div>
							<div class="tab-pane fade show active" id="signin" role="tabpanel" aria-labelledby="signin-tab">
								<form method="post" class="signIn">
									<div class="form-group">
										<label for="singin-email">Username or email address *</label>
										<input type="text" class="form-control" id="singin-email" name="singin-email" required>
									</div><!-- End .form-group -->
									
									<div class="form-group">
										<label for="singin-password">Password *</label>
										<input type="password" class="form-control" id="singin-password" name="singin-password" required>
									</div><!-- End .form-group -->
									
									<div class="form-group">
										<label for="login-password-visibility">
											<input type="checkbox" id="login-password-visibility"> Show Password?
										</label>
									</div>
									
									<div class="form-footer">
										<button type="submit" class="btn btn-outline-primary-2">
											<span>LOG IN</span>
											<i class="icon-long-arrow-right"></i>
										</button>
										
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" id="signin-remember">
											<label class="custom-control-label" for="signin-remember">Remember Me</label>
										</div><!-- End .custom-checkbox -->
										
										<a href="forgot_password.php" class="forgot-link">Forgot Your Password?</a>
									</div><!-- End .form-footer -->
								</form>
								<div class="form-choice">
									<p class="text-center">or sign in with</p>
									<div class="row">
										<div class="col-sm-6">
                      <?php
                        
                        $login = new Users();
                        echo $login->googleLogin();
                      
                      ?>
										</div><!-- End .col-6 -->
										<div class="col-sm-6">
											<a href="#" class="btn btn-login btn-f">
												<i class="icon-facebook-f"></i>
												Login With Facebook
											</a>
										</div><!-- End .col-6 -->
									</div><!-- End .row -->
								</div><!-- End .form-choice -->
							</div><!-- .End .tab-pane -->
							<div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
								<form method="post" class="registerForm">
									<div class="form-group">
										<label for="register-role">Select Role *</label>
										<select class="form-control custom-select" id="register-role" name="register-role" required>
											<option value="Vendor">I am a Vendor</option>
											<option value="Customer">I am a Customer</option>
										</select>
									</div><!-- End .form-group -->
									
									<div class="form-group">
										<label for="register-full_name">Your Full Name *</label>
										<input type="text" class="form-control" id="register-full_name" name="register-full_name" required>
									</div><!-- End .form-group -->
									
									<div class="form-group">
										<label for="register-email">Your email address *</label>
										<input type="email" class="form-control" id="register-email" name="register-email" required>
									</div><!-- End .form-group -->
									
									<div class="form-group">
										<label for="register-username">Username *</label>
										<input type="text" class="form-control" id="register-username" name="register-username" required>
									</div><!-- End .form-group -->
									
									<div class="form-group">
										<label for="register-password">Password *</label>
										<input type="password" class="form-control" id="register-password" name="register-password" required>
										<span id="passwordStrength"></span>
									</div><!-- End .form-group -->
									
									<div class="form-group">
										<label for="password-visibility">
											<input type="checkbox" id="password-visibility"> Show Password?
										</label>
									</div>
									
									<div class="form-footer">
										<button type="submit" id="signUpBtn" class="btn btn-outline-primary-2 disabled">
											<span>SIGN UP</span>
											<i class="icon-long-arrow-right"></i>
										</button>
										
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" id="register-policy" required>
											<label class="custom-control-label" for="register-policy">I agree to the <a href="privacy_policy.php">privacy policy</a> *</label>
										</div><!-- End .custom-checkbox -->
									</div><!-- End .form-footer -->
								</form>
							</div><!-- .End .tab-pane -->
						</div><!-- End .tab-content -->
					</div><!-- End .form-tab -->
				</div><!-- End .form-box -->
			</div><!-- End .modal-body -->
		</div><!-- End .modal-content -->
	</div><!-- End .modal-dialog -->
</div><!-- End .modal -->



<!-- Overall BS Modal -->
<div class="modal fade" id="modal" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalLabel"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body p-4">
				<div class="modalDetails"></div>
			</div>
		</div>
	</div>
</div>

<!-- Quick View BS Modal -->
<div class="modal fade" id="modal-product" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document" style="max-width: calc(80vw)">
		<div class="modal-content">
			<div class="modal-header border-0">
				<h5 class="modal-title" id="modalLabel"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body p-4">
				<div class="modalDetails"></div>
			</div>
		</div>
	</div>
</div>

<!--<div class="container newsletter-popup-container mfp-hide" id="newsletter-popup-form">
	<div class="row justify-content-center">
		<div class="col-10">
			<div class="row no-gutters bg-white newsletter-popup-content">
				<div class="col-xl-3-5col col-lg-7 banner-content-wrap">
					<div class="banner-content text-center">
						<img src="<?/*= FAVICON */?>" class="logo" alt="logo" width="60" height="15">
						<h2 class="banner-title">get <span>25<light>%</light></span> off</h2>
						<p>Subscribe to the <?/*= COMPANY */?> newsletter to receive timely updates from your favorite products and discount coupons that make you save the day.</p>
						<form action="#">
							<div class="input-group input-group-round">
								<input type="email" class="form-control form-control-white" placeholder="Your Email Address" aria-label="Email Adress" required>
								<div class="input-group-append">
									<button class="btn" type="submit"><span>go</span></button>
								</div>
							</div>
						</form>
						<div class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" id="register-policy-2" required>
							<label class="custom-control-label" for="register-policy-2">Do not show this popup again</label>
						</div>
					</div>
				</div>
				<div class="col-xl-2-5col col-lg-5 ">
					<img src="assets/images/popup/newsletter/img-1.jpg" class="newsletter-img" alt="newsletter">
				</div>
			</div>
		</div>
	</div>
</div>-->
<!-- Plugins JS File -->
<script src="assets/plugins/jquery/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/jquery.hoverIntent.min.js"></script>
<script src="assets/js/jquery.waypoints.min.js"></script>
<script src="assets/js/superfish.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/bootstrap-input-spinner.js"></script>
<script src="assets/js/jquery.magnific-popup.min.js"></script>
<script src="assets/js/jquery.elevateZoom.min.js"></script>
<script src="assets/js/jquery.plugin.min.js"></script>
<script src="assets/js/imagesloaded.pkgd.min.js"></script>
<script src="assets/js/isotope.pkgd.min.js"></script>
<script src="assets/js/jquery.countdown.min.js"></script>
<script src="assets/plugins/dropzone/dropzone-min.js"></script>
<script src="assets/plugins/toastr/toastr.min.js"></script>
<script src="assets/plugins/masonry/masonry.pkgd.min.js"></script>
<script src="assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js"></script>
<script src="assets/plugins/aos/aos.js"></script>
<script src="assets/plugins/rateit.js/jquery.rateit.min.js"></script>
<!-- Main JS File -->
<script src="assets/js/main.js"></script>
<script src="includes/config.js.php"></script>
<script src="assets/js/frontEnd.js"></script>
</body>
</html>
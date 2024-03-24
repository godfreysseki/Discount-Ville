<?php
  
  include_once "includes/header.inc.php";

?>
	
	<main class="main">
		<nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
			<div class="container">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="index.php">Home</a></li>
					<li class="breadcrumb-item"><a href="javascript:void(0)">Pages</a></li>
					<li class="breadcrumb-item active" aria-current="page">Contact Us</li>
				</ol>
			</div><!-- End .container -->
		</nav><!-- End .breadcrumb-nav -->
		
		<div class="page-content">
			<div id="map" class="mb-5">
				<?= ((MAP !== null) ? MAP : "")?>
			</div><!-- End #map -->
			<div class="container">
				<div class="row">
					<div class="col-md-4">
						<div class="contact-box text-center">
							<h3>Office</h3>
							
							<address><?= COMPANY_POST_NO ?><br><?= LOCATION ?></address>
						</div><!-- End .contact-box -->
					</div><!-- End .col-md-4 -->
					
					<div class="col-md-4">
						<div class="contact-box text-center">
							<h3>Start a Conversation</h3>
							
							<div><?= email(COMPANYEMAIL) ?></div>
							<div><?= phone(COMPANYPHONE) ?>, <?= phone(COMPANYPHONE2) ?></div>
						</div><!-- End .contact-box -->
					</div><!-- End .col-md-4 -->
					
					<div class="col-md-4">
						<div class="contact-box text-center">
							<h3>Social</h3>
							
							<div class="social-icons social-icons-color justify-content-center">
                <?= ((FACEBOOK !== null) ? '<a href="' . FACEBOOK . '" class="social-icon social-facebook" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>' : '') ?>
                <?= ((TWITTER !== null) ? '<a href="' . TWITTER . '" class="social-icon social-twitter" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>' : '') ?>
                <?= ((INSTAGRAM !== null) ? '<a href="' . INSTAGRAM . '" class="social-icon social-instagram" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>' : '') ?>
                <?= ((YOUTUBE !== null) ? '<a href="' . YOUTUBE . '" class="social-icon social-youtube" title="Youtube" target="_blank"><i class="icon-youtube"></i></a>' : '') ?>
							</div><!-- End .soial-icons -->
						</div><!-- End .contact-box -->
					</div><!-- End .col-md-4 -->
				</div><!-- End .row -->
				
				<hr class="mt-3 mb-5 mt-md-1">
				<div class="touch-container row justify-content-center">
					<div class="col-md-9 col-lg-8">
						<div class="text-center">
							<h2 class="title mb-1">Get In Touch</h2><!-- End .title mb-2 -->
							<p class="lead text-primary">
								We collaborate with ambitious brands and people; we’d love to build something great together.
							</p><!-- End .lead text-primary -->
							<p class="mb-3">You can contact us directly, if you need any assistance.</p>
						</div><!-- End .text-center -->
						
						<form action="javascript:void(0)" class="contact-form mb-2">
							<div class="row">
								<div class="col-sm-4">
									<label for="cname" class="sr-only">Full Name</label>
									<input type="text" class="form-control" id="cname" placeholder="Name *" required>
								</div><!-- End .col-sm-4 -->
								
								<div class="col-sm-4">
									<label for="cemail" class="sr-only">Email Address</label>
									<input type="email" class="form-control" id="cemail" placeholder="Email *" required>
								</div><!-- End .col-sm-4 -->
								
								<div class="col-sm-4">
									<label for="cphone" class="sr-only">Telephone</label>
									<input type="tel" class="form-control" id="cphone" placeholder="Phone">
								</div><!-- End .col-sm-4 -->
							</div><!-- End .row -->
							
							<label for="csubject" class="sr-only">Subject</label>
							<input type="text" class="form-control" id="csubject" placeholder="Subject *" required>
							
							<label for="cmessage" class="sr-only">Message</label>
							<textarea class="form-control" cols="30" rows="4" id="cmessage" required placeholder="Message *"></textarea>
							
							<div class="text-center">
								<button type="submit" class="btn btn-outline-primary-2 btn-minwidth-sm">
									<span>SUBMIT</span>
									<i class="icon-long-arrow-right"></i>
								</button>
							</div><!-- End .text-center -->
						</form><!-- End .contact-form -->
					</div><!-- End .col-md-9 col-lg-7 -->
				</div><!-- End .row -->
			</div><!-- End .container -->
		</div><!-- End .page-content -->
	</main><!-- End .main -->

<?php
  
  include_once "includes/footer.inc.php";

?>
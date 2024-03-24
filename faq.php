<?php
  
  include_once "includes/header.inc.php";
  
  $data = new FAQs();

?>
	
	<main class="main">
		<nav aria-label="breadcrumb" class="breadcrumb-nav">
			<div class="container">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="index.php">Home</a></li>
					<li class="breadcrumb-item"><a href="javascript:void(0)">Pages</a></li>
					<li class="breadcrumb-item active" aria-current="page">FAQ</li>
				</ol>
			</div><!-- End .container -->
		</nav><!-- End .breadcrumb-nav -->
		
		<div class="page-content">
			<div class="container">
				
				<?= $data->showFAQs() ?>
				
			</div><!-- End .container -->
		</div><!-- End .page-content -->
		
		<div class="cta cta-display bg-image pt-4 pb-4" style="background-image: url(assets/images/backgrounds/cta/bg-7.jpg);">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-md-10 col-lg-9 col-xl-7">
						<div class="row no-gutters flex-column flex-sm-row align-items-sm-center">
							<div class="col">
								<h3 class="cta-title text-white">If You Have More Questions</h3><!-- End .cta-title -->
								<p class="cta-desc text-white">If your question is not answered, please contact customer support services for assistance.</p><!-- End .cta-desc -->
							</div><!-- End .col -->
							
							<div class="col-auto">
								<a href="contact.php" class="btn btn-outline-white"><span>CONTACT US</span><i class="icon-long-arrow-right"></i></a>
							</div><!-- End .col-auto -->
						</div><!-- End .row no-gutters -->
					</div><!-- End .col-md-10 col-lg-9 -->
				</div><!-- End .row -->
			</div><!-- End .container -->
		</div><!-- End .cta -->
	</main><!-- End .main -->

<?php
  
  include_once "includes/footer.inc.php";

?>
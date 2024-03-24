<?php
  
  include_once "includes/header.inc.php";
  
  $data = new Category();

?>

<main class="main">
	<nav aria-label="breadcrumb" class="breadcrumb-nav">
		<div class="container">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="./">Home</a></li>
				<li class="breadcrumb-item">Shop</li>
				<li class="breadcrumb-item active" aria-current="page">Categories</li>
			</ol>
		</div><!-- End .container -->
	</nav><!-- End .breadcrumb-nav -->
	
	<div class="page-content">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
     
					<?= $data->showCategoriesPage() ?>
					
				</div>
			</div>
		</div><!-- End .col-lg-6 -->
	</div><!-- End .row -->


</main><!-- End .main -->

<?php
  
  include_once "includes/footer.inc.php";

?>
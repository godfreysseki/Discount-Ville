<?php
  
  include_once "includes/header.inc.php";

  $data = new Vendors();
?>

<main class="main">
	<nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
		<div class="container">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="index.html">Home</a></li>
				<li class="breadcrumb-item"><a href="#">Pages</a></li>
				<li class="breadcrumb-item active" aria-current="page">About us</li>
			</ol>
		</div><!-- End .container -->
	</nav><!-- End .breadcrumb-nav -->
	
	<div class="page-content pb-0">
		<div class="container">
			<div class="row mb-3">
				
				<?= $data->showVendors() ?>
				
			</div>
		</div>
	</div>
</main>

<?php
  
  include_once "includes/footer.inc.php";

?>

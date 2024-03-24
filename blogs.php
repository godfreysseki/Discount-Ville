<?php
  
  include_once "includes/header.inc.php";
  
  $data = new Blogs();

?>
 
	<main class="main">
		<nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
			<div class="container">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="index.php">Home</a></li>
					<li class="breadcrumb-item active" aria-current="page">Blogs</li>
				</ol>
			</div><!-- End .container -->
		</nav><!-- End .breadcrumb-nav -->
		
		<div class="page-content">
			<div class="container">
				<nav class="blog-nav">
					<?= $data->showBlogsCategories() ?>
					<!-- End .blog-menu -->
				</nav><!-- End .blog-nav -->
				
				<div class="entry-container max-col-4" data-layout="fitRows">
					
					<?= $data->showBlogs() ?>
					
				</div><!-- End .entry-container -->
				
				<!--<nav aria-label="Page navigation">
					<ul class="pagination justify-content-center">
						<li class="page-item disabled">
							<a class="page-link page-link-prev" href="#" aria-label="Previous" tabindex="-1" aria-disabled="true">
								<span aria-hidden="true"><i class="icon-long-arrow-left"></i></span>Prev
							</a>
						</li>
						<li class="page-item active" aria-current="page"><a class="page-link" href="#">1</a></li>
						<li class="page-item"><a class="page-link" href="#">2</a></li>
						<li class="page-item">
							<a class="page-link page-link-next" href="#" aria-label="Next">
								Next <span aria-hidden="true"><i class="icon-long-arrow-right"></i></span>
							</a>
						</li>
					</ul>
				</nav>-->
			</div><!-- End .container -->
		</div><!-- End .page-content -->
	</main><!-- End .main -->

<?php
  
  include_once "includes/footer.inc.php";

?>
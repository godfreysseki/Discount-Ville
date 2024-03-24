<?php
  
  include_once "includes/header.inc.php";

?>
	
	
	<main class="main">
		<nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
			<div class="container d-flex align-items-center">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="./">Home</a></li>
					<li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
					<li class="breadcrumb-item active" aria-current="page">Settings</li>
					
					<button class="ml-auto navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
				</ol>
			</div><!-- End .container -->
		</nav><!-- End .breadcrumb-nav -->
		
		<div class="page-content">
			<div class="container">
				<div class="row">
          <?php
            
            include_once "includes/userMenu.inc.php";
          
          ?>
					
					<div class="col-md-9 settings">
						
						
						<h2>Settings</h2>
						<div class="my-4">
							<ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Notifications</a>
								</li>
							</ul>
							<h5 class="mb-0 mt-5">Notifications Settings</h5>
							<p>Select notification you want to receive to your email</p>
							<hr class="my-4">
							<strong class="mb-0">Security</strong>
							<p>Control security alert you will be notified.</p>
							<div class="list-group mb-5 shadow">
								<div class="list-group-item">
									<div class="row align-items-center">
										<div class="col">
											<strong class="mb-0">Unusual activity notifications</strong>
											<p class="text-muted mb-0">Donec in quam sed urna bibendum tincidunt quis mollis mauris.</p>
										</div>
										<div class="col-auto">
											<div class="form-group form-check">
												<div class="icheck-primary d-inline">
													<input type="checkbox" id="checkboxPrimary1" checked>
													<label for="checkboxPrimary1"></label>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="list-group-item">
									<div class="row align-items-center">
										<div class="col">
											<strong class="mb-0">Unauthorized financial activity</strong>
											<p class="text-muted mb-0">Fusce lacinia elementum eros, sed vulputate urna eleifend nec.</p>
										</div>
										<div class="col-auto">
											<div class="form-group form-check">
												<div class="icheck-primary d-inline">
													<input type="checkbox" id="checkboxPrimary1" checked>
													<label for="checkboxPrimary1"></label>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<hr class="my-4">
							<strong class="mb-0">System</strong>
							<p>Please enable system alert you will get.</p>
							<div class="list-group mb-5 shadow">
								<div class="list-group-item">
									<div class="row align-items-center">
										<div class="col">
											<strong class="mb-0">Notify me about new features and updates</strong>
											<p class="text-muted mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
										</div>
										<div class="col-auto">
											<div class="form-group form-check">
												<div class="icheck-primary d-inline">
													<input type="checkbox" id="checkboxPrimary1" checked>
													<label for="checkboxPrimary1"></label>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="list-group-item">
									<div class="row align-items-center">
										<div class="col">
											<strong class="mb-0">Notify me by email for latest news</strong>
											<p class="text-muted mb-0">Nulla et tincidunt sapien. Sed eleifend volutpat elementum.</p>
										</div>
										<div class="col-auto">
											<div class="form-group form-check">
												<div class="icheck-primary d-inline">
													<input type="checkbox" id="checkboxPrimary1" checked>
													<label for="checkboxPrimary1"></label>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="list-group-item">
									<div class="row align-items-center">
										<div class="col">
											<strong class="mb-0">Notify me about tips on using account</strong>
											<p class="text-muted mb-0">Donec in quam sed urna bibendum tincidunt quis mollis mauris.</p>
										</div>
										<div class="col-auto">
											<div class="form-group form-check">
												<div class="icheck-primary d-inline">
													<input type="checkbox" id="checkboxPrimary1">
													<label for="checkboxPrimary1"></label>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					
					
					</div>
				</div>
			</div>
		</div>
	</main>

<?php
  
  include_once "includes/footer.inc.php";

?>
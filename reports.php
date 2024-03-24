<?php
  
  include_once "includes/header.inc.php";
  
  $data = new Vendors();

?>
	
	<main class="main">
		<nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
			<div class="container">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="./">Home</a></li>
					<li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
					<li class="breadcrumb-item active" aria-current="page">Reports</li>
					
					<button class="ml-auto navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
				</ol>
			</div><!-- End .container -->
		</nav><!-- End .breadcrumb-nav -->
		
		<div class="page-content">
			<div class="dashboard">
				<div class="container">
					<div class="row">
              <?php
                
                include_once "includes/userMenu.inc.php";
              
              ?>
						
						<div class="col-md-9">
							<div class="row">
								<div class="col-6">
									<h4>Reports Management</h4>
								</div>
								<div class="col-6 text-right">
								
								</div>
								<div class="col-12 systemMsg"></div>
								<div class="col-12">
                  <?php
                    
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                      $account = new Reports();
                      $id      = $account->updateAccount($_POST);
                      if ($id > 0) {
                        echo alert('success', 'Account Updated Successfully.');
                      } else {
                        echo alert('warning', 'Account Updates Failed.');
                      }
                    }
                  
                  ?>
								</div>
							</div>
							<form method="post" action="reports_gen.php" target="_blank">
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<label for="reportCategory">Report Type *</label>
											<select id="reportCategory" name="reportCategory" class="form-control custom-select select-custom" required>
												<option value="" disabled selected>-- Select Category --</option>
												<option value="Adverts">Adverts Report</option>
												<option value="Customer">Customer Report</option>
												<option value="Orders">Orders Report</option>
												<option value="Products">Products Report</option>
											</select>
										</div>
									</div><!-- End .col-sm-6 -->
									
									<div class="col-sm-4">
										<div class="form-group">
											<label for="start_date">Start Date *</label>
											<input type="date" id="start_date" name="start_date" class="form-control" required>
										</div>
									</div><!-- End .col-sm-6 -->
									<div class="col-sm-4">
										<div class="form-group">
											<label for="end_date">End Date *</label>
											<input type="date" id="end_date" name="end_date" class="form-control" required>
										</div>
									</div><!-- End .col-sm-6 -->
								</div><!-- End .row -->
								
								<button type="submit" class="btn btn-outline-primary-2">
									<span>Generate Report</span>
									<i class="icon-long-arrow-right"></i>
								</button>
							</form>
						</div><!-- End .col-lg-9 -->
					</div><!-- End .row -->
				</div><!-- End .container -->
			</div><!-- End .dashboard -->
		</div><!-- End .page-content -->
	</main><!-- End .main -->

<?php
  
  include_once "includes/footer.inc.php";

?>
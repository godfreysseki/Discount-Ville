<?php
  
  include_once "includes/header.inc.php";
  
  $data = new Vendors();

?>
	
	<main class="main">
		<nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
			<div class="container">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="./">Home</a></li>
					<li class="breadcrumb-item active"><a href="dashboard.php">Dashboard</a></li>
					<li class="breadcrumb-item active"><a href="account.php">Account Details</a></li>
					
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
									<h4>Account Management</h4>
								</div>
								<div class="col-6 text-right">
								
								</div>
								<div class="col-12 systemMsg"></div>
								<div class="col-12">
                  <?php
                    
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                      $account = new Vendors();
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
							<form method="post">
                <?php
                  
                  $user = $data->vendorData();
                
                ?>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="username">Username / Display Name *</label>
											<input type="text" id="username" name="username" value="<?= $user['username'] ?>" class="form-control" required>
											<small class="form-text">This will be how your name will be displayed in the account section and in reviews</small>
										</div>
									</div><!-- End .col-sm-6 -->
									
									<div class="col-sm-6">
										<div class="form-group">
											<label for="full_name">Full Name *</label>
											<input type="text" id="full_name" name="full_name" value="<?= $user['full_name'] ?>" class="form-control" required>
										</div>
									</div><!-- End .col-sm-6 -->
									<div class="col-sm-6">
										<div class="form-group">
											<label for="phone">Telephone *</label>
											<input type="text" id="phone" name="phone" value="<?= $user['phone'] ?>" class="form-control" required>
										</div>
									</div><!-- End .col-sm-6 -->
									
									<div class="col-sm-6">
										<div class="form-group">
											<label for="email">Email Address</label>
											<input type="email" id="email" name="email" value="<?= $user['email'] ?>" class="form-control">
										</div>
									</div><!-- End .col-sm-6 -->
									
									<div class="col-sm-4">
										<div class="form-group">
											<label for="old_password">Current password</label>
											<input type="password" id="old_password" name="old_password" class="form-control">
											<small class="form-text">Leave blank to leave unchanged</small>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="new_password">New password</label>
											<input type="password" id="new_password" name="new_password" class="form-control">
											<small class="form-text">Leave blank to leave unchanged</small>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="retype_password">Confirm new password</label>
											<input type="password" id="retype_password" name="retype_password" class="form-control">
											<small class="form-text">Leave blank to leave unchanged</small>
										</div>
									</div>
								</div><!-- End .row -->
								
								<button type="submit" class="btn btn-outline-primary-2">
									<span>SAVE CHANGES</span>
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
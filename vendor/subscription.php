<?php
  
  include_once "../includes/adminHeader.inc.php";
  
  $data  = new Subscription();

?>
	
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1><?= PAGE ?> Management</h1>
					</div>
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="index.php">Home</a></li>
							<li class="breadcrumb-item active"><?= PAGE ?></li>
						</ol>
					</div>
				</div>
			</div>
		</section>
		
		<!-- Main content -->
		<section class="content">
			<div class="container-fluid">
				<div class="systemMsg"></div>
				<div class="row">
					<div class="col-sm-3">
						<div class="card">
							<div class="card-header">
								<h5 class="card-title">New Subscription</h5>
							</div>
							<div class="card-body py-2">
								<?php
									
                  if (isset($_POST['subscribeBtn']) && $_SERVER['REQUEST_METHOD'] === "POST") {
	                  echo $data->addSubscription($_POST['plan'], $_POST['months'], $_POST['tnx_id']);
									}
                  
                  echo "<h5 class='card-title'>Current Plan: <b>".$data->vendorCurrentPlan()."</b></h5><br><br>";
								
								?>
								
								<form method="post">
									<div class="form-group">
										<label for="plan">Subscription Plan</label>
										<select name="plan" id="plan" class="custom-select select2">
											<?= $data->getSubscriptionPlansComboOptions() ?>
										</select>
									</div>
									<div class="form-group">
										<label for="months">Time (Months)</label>
										<input type="number" min="1" max="48" value="1" name="months" id="months" class="form-control">
									</div>
									<div class="form-group text-success">
										You will send <b class="to_pay">0</b> to <b><?= COMPANYPHONE ?></b>(Ismail) and record the transaction id below.
									</div>
									<div class="form-group">
										<label for="tnx_id">Transaction ID</label>
										<input type="text" name="tnx_id" id="tnx_id" class="form-control">
									</div>
									<div class="form-group">
										<input type="submit" name="subscribeBtn" value="Subscribe" class="btn btn-sm btn-primary float-right">
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="col-sm-9">
						<!-- Card with Card Tool -->
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><?= PAGE ?> Plans</h3>
							</div>
							<div class="card-body">
                <?php
                  
                  $planManager = new Subscription();
                  $plans       = $planManager->listSubscriptionPlans();
                
                ?>
								<div class="table-responsive">
									<table class="table table-bordered table-sm table-striped dataTable">
										<thead>
										<tr>
											<th>#</th>
											<th>Plan</th>
											<th>Description</th>
											<th>Price</th>
											<th>Duration</th>
											<th>Max Products</th>
											<th>Deals</th>
											<th>Social Media Products</th>
											<th>Support</th>
										</tr>
										</thead>
										<tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($plans as $plan) : ?>
											<tr>
												<td><?= $no ?></td>
												<td><?= esc($plan['name']); ?></td>
												<td><?= esc($plan['description']); ?></td>
												<td><?= CURRENCY . " " . number_format($plan['price']); ?></td>
												<td><?= esc($plan['duration']); ?></td>
												<td><?= esc($plan['max_products']); ?></td>
												<td><?= esc($plan['deal_of_day']); ?></td>
												<td><?= esc($plan['social_media']); ?></td>
												<td><?= esc($plan['customer_support']); ?></td>
											</tr>
                      <?php $no++; ?>
                    <?php endforeach; ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<!-- End Card with Card Tool -->
					</div>
				</div>
			</div>
		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->

<?php
  
  include_once "../includes/adminFooter.inc.php";

?>
<?php
  
  include_once "../includes/adminHeader.inc.php";

?>
	
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1>Notifications Management</h1>
					</div>
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="index.php">Home</a></li>
							<li class="breadcrumb-item active">Notifications</li>
						</ol>
					</div>
				</div>
			</div>
		</section>
		
		<!-- Main content -->
		<section class="content">
			<div class="container-fluid">
				<div class="systemMsg"></div>
				<!-- Card with Card Tool -->
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">All Notifications</h3>
						<div class="card-tools">
							<a href="#" class="alertsSeen btn btn-tool">Mark all as Seen</a>
						</div>
					</div>
					<div class="card-body px-0">
            <?php
              
              $alertManager = new Config();
              $alerts       = $alertManager->showAlerts();
  
              echo '<ul class="nav flex-column">';
              foreach ($alerts as $alert) {
                if ($alert['seen'] === "Yes") {
                  echo '<li class="nav-item">
													<a href="javascript:void(0)" class="nav-link text-muted">
														<b>'.$alert['product_name'].'</b> needs to be restocked, there is <b>'.$alert['quantity_in_stock'].'</b> in stock.
														<span class="float-right badge bg-secondary">'.timeago($alert['alert_date']).'</span>
													</a>
												</li>';
              	} else {
                  echo '<li class="nav-item">
													<a href="javascript:void(0)" class="nav-link alertSeen" data-id="'.$alert['alert_id'].'">
														<b>'.$alert['product_name'].'</b> needs to be restocked, there is <b>'.$alert['quantity_in_stock'].'</b> in stock.
														<span class="float-right badge bg-primary">'.timeago($alert['alert_date']).'</span>
													</a>
												</li>';
              	}
              }
              echo '</ul>';

            ?>
					</div>
				</div>
				<!-- End Card with Card Tool -->
			</div>
		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->


<?php
  
  include_once "../includes/adminFooter.inc.php";

?>
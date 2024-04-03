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
            <h1>Subscribers Management</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item">Subscription Plans</li>
              <li class="breadcrumb-item active">Subscribers</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="systemMsg"></div>
	      <?php
    
          if (isset($_POST['planEditBtn']) && $_SERVER['REQUEST_METHOD'] === "POST") {
            $update = new Subscription();
            echo $update->updateSubscription($_POST['subscriberId'], $_POST['plan'], $_POST['start_date'], $_POST['end_date']);
		      }
	      
	      ?>
        <!-- Card with Card Tool -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">subscribers List</h3>
            <div class="card-tools">
              <!-- Dropdown Menu -->
              <div class="dropdown">
                <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                  <i class="fas fa-wrench"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                  <a href="javascript:void(0)" class="addSubscriberBtn dropdown-item">Add Subscriber</a>
                </div>
              </div>
              <!-- End Dropdown Menu -->
            </div>
          </div>
          <div class="card-body">
            <?php
              
              $planManager = new Subscription();
              $plans      = $planManager->getAllCustomerSubscriptions();
            
            ?>
            <div class="table-responsive">
              <table class="table table-bordered table-sm table-striped dataTable">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Tnx Id</th>
                  <th>Vendor</th>
                  <th>Plan</th>
                  <th>Duration</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 1; ?>
                <?php foreach ($plans as $plan) : ?>
                  <tr>
                    <td><?= $no ?></td>
                    <td><?= esc($plan['transaction_id']); ?></td>
                    <td>Whatsapp: <?= whatsapp($plan['whatsapp']); ?><br><?= email($plan['business_email']); ?><br><?= esc($plan['shop_name']); ?></td>
                    <td><?= esc($plan['name']); ?></td>
	                  <td><?= dateDiff($plan['subscription_start_date'], $plan['subscription_end_date']); ?><br><em class="text-muted"><?= dates($plan['subscription_start_date']) ?> - <?= dates($plan['subscription_end_date']); ?></em></td>
                    <td><?= esc($plan['status']); ?></td>
	                  <td>
		                  <?php if ($plan['status'] === 'Inactive'): ?>
			                  <button class="activateSubscriptionPlanBtn btn btn-xs btn-link text-primary" data-id="<?= esc($plan['subscriber_id']); ?>" data-toggle="tooltip" title="Activate Plan"><span class="fa fa-check"></span></button>
			                  <button class="editSubscriptionPlanBtn btn btn-xs btn-link text-success" data-id="<?= esc($plan['subscriber_id']); ?>" data-toggle="tooltip" title="Edit Subscription"><span class="fa fa-pen-fancy"></span></button>
                      <?php endif; ?>
                    </td>
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
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
  
  include_once "../includes/adminFooter.inc.php";

?>
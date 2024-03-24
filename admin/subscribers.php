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
                  <th>Plan</th>
                  <th>Description</th>
                  <th>Price</th>
                  <th>Duration</th>
                  <th>Max Products</th>
                  <th>Deals</th>
                  <th>Social Media Products</th>
                  <th>Support</th>
                  <th>Created</th>
                  <th>Last Updated</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 1; ?>
                <?php foreach ($plans as $plan) : ?>
                  <tr>
                    <td><?= $no ?></td>
                    <td><?= esc($plan['name']); ?></td>
                    <td><?= esc($plan['description']); ?></td>
                    <td><?= CURRENCY ." ". esc($plan['price']); ?></td>
                    <td><?= esc($plan['duration']); ?></td>
                    <td><?= esc($plan['max_products']); ?></td>
                    <td><?= esc($plan['deal_of_day']); ?></td>
                    <td><?= esc($plan['social_media']); ?></td>
                    <td><?= esc($plan['customer_support']); ?></td>
                    <td><?= esc($plan['created_at']); ?></td>
                    <td><?= esc($plan['updated_at']); ?></td>
                    <td>
                      <button class="viewSubscriptionBtn btn btn-xs btn-link text-secondary" data-id="<?= esc($plan['subscription_id']); ?>" data-toggle="tooltip" title="View"><span class="fa fa-eye"></span></button>
                      <button class="editSubscriptionBtn btn btn-xs btn-link text-success" data-id="<?= esc($plan['subscription_id']); ?>" data-toggle="tooltip" title="Edit"><span class="fa fa-pen-fancy"></span></button>
                      <button class="btn btn-xs btn-link text-danger" onclick="if (confirm('Are you sure you want to delete this record?')) {$(this).addClass('deleteSubscriptionBtn');}" data-id="<?= esc($plan['subscription_id']); ?>"
                              data-toggle="tooltip" title="Delete"><span
                          class="fa
											fa-trash-alt"></span></button>
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
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
            <h1>Audit Trails</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item">System</li>
              <li class="breadcrumb-item active">User Audit Trails</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Card with Card Tool -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Audit Trails</h3>
          </div>
          <div class="card-body">
            <?php
              
              $auditTrails = new AuditTrail();
              $trails      = $auditTrails->getAuditTrails();
            
            ?>
            <div class="table-responsive">
              <table class="table table-bordered table-sm table-striped dataTable">
                <thead>
                <tr>
                  <th>#</th>
                  <th>User Id</th>
                  <th>Time</th>
                  <th>Activity Type</th>
                  <th>Entity Id</th>
                  <th>Activity</th>
                  <th>Details</th>
                  <th>Old Value</th>
                  <th>New Value</th>
                  <th>Module</th>
                  <th>User Agent</th>
                  <th>Status</th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 1; ?>
                <?php foreach ($trails as $trail) : ?>
                  <tr>
                    <td><?= $no ?></td>
                    <td><?= esc($trail['user_id']); ?></td>
                    <td><?= esc($trail['timestamp']); ?></td>
                    <td><?= activityType(esc($trail['activity_type'])); ?></td>
                    <td><?= esc($trail['entity_id']); ?></td>
                    <td><?= esc($trail['activity']); ?></td>
                    <td><?= esc($trail['details']); ?></td>
                    <td><?= nl2br(esc($trail['old_value'])); ?></td>
                    <td><?= nl2br(esc($trail['new_value'])); ?></td>
                    <td><?= esc($trail['module']); ?></td>
                    <td><?= esc($trail['user_agent']); ?></td>
                    <td><?= ((esc($trail['status']) === "success") ? "<span class='badge badge-success'>".esc($trail['status'])."</span>" : "<span class='badge badge-warning'>".esc($trail['status'])."</span>"); ?></td>
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
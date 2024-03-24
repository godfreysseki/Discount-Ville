<?php
  
  include_once "../includes/adminHeader.inc.php";
  
  $data = new Notification();

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
        <!-- Card with Card Tool -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"><?= PAGE ?> List</h3>
            <div class="card-tools">
              <!-- Dropdown Menu -->
              <div class="dropdown">
                <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                  <i class="fas fa-wrench"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                  <a href="javascript:void(0)" class="markAllAlerts dropdown-item">Mark All as Read</a>
                </div>
              </div>
              <!-- End Dropdown Menu -->
            </div>
          </div>
          <div class="card-body">
	          <div class="table-responsive">
		          <table class="table table-sm table-hover table-condensed table-striped dataTable">
			          <thead>
			          <tr>
				          <th>#</th>
				          <th>Message</th>
				          <th>Date</th>
				          <th>Action</th>
			          </tr>
			          </thead>
			          <tbody>
                <?php
        
                  $no       = 1;
                  $alerts = $data->listNotifications();
                  foreach ($alerts as $alert) {
                    if ($alert['is_read'] === 0) {
                      echo '<tr>
																	<td class="font-weight-bold">' . $no . '</td>
																	<td class="font-weight-bold">' . $alert['message'] . '</td>
																	<td class="font-weight-bold">' . datel($alert['created_at']) . '</td>
																	<td>
																		<button class="viewAlertBtn btn btn-xs btn-rounded btn-secondary" data-id="' . esc($alert['notification_id']) . '">Mark as Seen</button>
																		<button class="btn btn-xs btn-rounded btn-danger" onclick="if (confirm(\'Are you sure you want to delete this record?\')) {$(this).addClass(\'deleteAlertBtn\');}" data-id="' . esc($alert['notification_id']) . '">Delete</button>
																	</td>
																</tr>';
                    } else {
                      echo '<tr>
																	<td class="text-muted">' . $no . '</td>
																	<td class="text-muted">' . $alert['message'] . '</td>
																	<td class="text-muted">' . datel($alert['created_at']) . '</td>
																	<td>
																		<button class="btn btn-xs btn-rounded btn-danger" onclick="if (confirm(\'Are you sure you want to delete this record?\')) {$(this).addClass(\'deleteAlertBtn\');}" data-id="' . esc($alert['notification_id']) . '">Delete</button>
																	</td>
																</tr>';
                    }
                    $no++;
                  }
      
                ?>
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
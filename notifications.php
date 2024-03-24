<?php
  
  include_once "includes/header.inc.php";
  
  $data = new Notification();
  
?>
  
  <main class="main">
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
      <div class="container">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="./">Home</a></li>
          <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
          <li class="breadcrumb-item active"><a href="notifications.php">Notifications</a></li>
	
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
			            <h4>System Notifications & Alerts</h4>
		            </div>
		            <div class="col-6 text-right">
			            <button class="btn btn-primary markAllAlerts">Mark all as Read</button>
		            </div>
		            <div class="col-12 systemMsg"></div>
	            </div>
              <div class="row">
	              <div class="col-12">
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
            </div><!-- End .col-lg-9 -->
          </div><!-- End .row -->
        </div><!-- End .container -->
      </div><!-- End .dashboard -->
    </div><!-- End .page-content -->
  </main><!-- End .main -->

<?php
  
  include_once "includes/footer.inc.php";

?>
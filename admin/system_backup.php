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
						<h1>Backup Management</h1>
					</div>
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="index.php">Home</a></li>
							<li class="breadcrumb-item">System</li>
							<li class="breadcrumb-item active">System Backup</li>
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
  
          if (isset($_POST['backup']) && $_POST['backup'] === 'true') {
            // Instantiate the AuditTrail class
            $auditTrail = new AuditTrail();
            // Run the backup
            try {
              $auditTrail->runBackup();
            } catch (\Exception $e) {
              // Handle any errors or exceptions here
              echo 'Backup failed: ' . $e->getMessage();
              exit;
            }
            // Delete the folder after downloading
            $auditTrail->deleteDirectory('../Backup');
          }
          
        ?>
				<!-- Card with Card Tool -->
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Make a Backup</h3>
					</div>
					<div class="card-body">
						<p>
							Ensure the safety of your valuable data by taking a proactive step – create backups today. Backups act as a safety net, guarding against unexpected data loss due to accidents, hardware failures, or other unforeseen circumstances. By
							regularly backing up your information, you ensure that your hard work, important files, and precious memories remain protected and easily recoverable. Don't wait until it's too late – start the habit of backing up your data now to enjoy
							peace of mind and the assurance that your digital assets are safeguarded.
						</p>
						<form method="post">
							<button type="submit" name="backup" value="true" class="btn btn-primary">Backup Now</button>
						</form>
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
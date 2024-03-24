<?php
  
  include "../includes/adminHeader.inc.php";

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0"><?= PAGE ?></h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active"><?= PAGE ?></li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
  
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Main row -->
      <div class="row">
        <section class="col-md-12">
          <div class="systemMsg"></div>
          <?php
            
            if (isset($_POST['saveProviderBtn']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
              $newBlog = new ServiceProviders();
              $newBlog->saveProvider($_POST);
            }
          
          ?>
        </section>
        <section class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><?= PAGE ?></h3>
              <div class="card-tools">
                <div class="btn-group">
                  <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-cog"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right" role="menu" x-placement="bottom-end">
                    <a href="javascript:void(0)" class="newServiceProvider dropdown-item">New Service Provider</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body">
              <?php
                
                $data = new ServiceProviders();
                $serviceProviders = $data->listProviders();
                
              ?>
	            <div class="table-responsive">
		            <table class="table table-striped table-bordered table-sm dataTable">
			            <thead>
			            <tr>
				            <th>Provider ID</th>
				            <th>Provider Name</th>
				            <th>Contacts</th>
				            <th>Service Rendered</th>
				            <th>Action</th>
				            <!-- Add more columns as needed -->
			            </tr>
			            </thead>
			            <tbody>
                  <?php $no = 1; ?>
                  <?php foreach ($serviceProviders as $provider): ?>
				            <tr>
					            <td><?= $no; ?></td>
					            <td><?= $provider['provider_name']; ?></td>
					            <td><?= email($provider['email']); ?><br><?= phone($provider['phone_number']); ?></td>
					            <td><?= $provider['job_service']; ?></td>
					            <td>
						            <button class="viewProviderBtn btn btn-xs btn-link text-secondary" data-id="<?= esc($provider['provider_id']); ?>" data-toggle="tooltip" title="View"><span class="fa fa-eye"></span></button>
						            <button class="editProviderBtn btn btn-xs btn-link text-success" data-id="<?= esc($provider['provider_id']); ?>" data-toggle="tooltip" title="Edit"><span class="fa fa-pen-fancy"></span></button>
						            <button class="btn btn-xs btn-link text-danger" onclick="if (confirm('Are you sure you want to delete this record?')) {$(this).addClass('deleteProviderBtn');}" data-id="<?= esc($provider['provider_id']); ?>"
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
        </section>
      </div>
      <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
  
  include "../includes/adminFooter.inc.php";

?>
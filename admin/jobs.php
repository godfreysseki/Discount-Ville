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
              
              if (isset($_POST['saveJobBtn']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
                $newBlog = new Jobs();
                $newBlog->saveJobAlert($_POST);
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
                      <a href="javascript:void(0)" class="newJobBtn dropdown-item">New Job Search Alert</a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <?php
                  
                  $data = new Jobs();
                  echo $data->listJobs();
                
                ?>
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
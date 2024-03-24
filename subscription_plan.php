<?php
  
  include_once "includes/header.inc.php";

?>
  
  <main class="main">
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
      <div class="container">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="./">Home</a></li>
          <li class="breadcrumb-item active"><a href="dashboard.php">Dashboard</a></li>
	
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
                <?php
                  
                  $data = new Subscription();
                  echo $data->changeSubscription($_GET['id']);
                ?>
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
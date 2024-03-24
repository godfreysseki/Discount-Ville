<?php
  
  include_once "includes/header.inc.php";
  
  $data = new Users();

?>
  
  <main class="main">
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
      <div class="container">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item"><a href="javascript:void(0)">User</a></li>
          <li class="breadcrumb-item active" aria-current="page">Forgot Password</li>
        </ol>
      </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->
    
    <div class="page-content">
      <div class="container mb-5">
        <div class="row justify-content-center">
          <div class="col-md-6">
            <div class="card border-0">
              <div class="card-header">
                <h5 class="card-title text-center">Forgot Password</h5>
              </div>
              <div class="card-body">
                <!-- Forgot Password Form -->
	              <?php
    
                  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	                  echo $data->sendVerificationCodeEmail($_POST['email']);
		              }
	              
	              ?>
                <form method="post">
                  <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                  </div>
                  <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
                </form>
                <!-- End Forgot Password Form -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

<?php
  
  include_once "includes/footer.inc.php";

?>
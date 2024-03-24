<?php
  
  include_once "includes/header.inc.php";
  
  $data = new Vendors();

?>
  
  <main class="main">
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
      <div class="container">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="./">Home</a></li>
          <li class="breadcrumb-item active"><a href="dashboard.php">Dashboard</a></li>
          <li class="breadcrumb-item active"><a href="vendor_shop.php">Shop Management</a></li>
	
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
                  <h4>Shop Management</h4>
                </div>
                <div class="col-6 text-right">
                
                </div>
                <div class="col-12 systemMsg"></div>
                <div class="col-12">
                  <?php
                    
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                      $account = new Vendors();
                      $id      = $account->addVendor($_POST);
                      if ($id > 0) {
                        echo alert('success', 'Shop Details Saved Successfully.');
                      } else {
                        echo alert('warning', 'Shop Details Saving Failed.');
                      }
                    }
                  
                  ?>
                </div>
              </div>
              <form method="post" enctype="multipart/form-data">
                <?php
                  
                  $user = $data->vendorData();
                
                ?>
                <div class="row">
                  <input type="hidden" name="vendor_id" value="<?= $user['vendor_id'] ?>">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="shop_logo">Shop Logo</label>
                      <input type="file" id="shop_logo" name="shop_logo" value="<?= $user['shop_logo'] ?>" class="form-control">
                    </div>
                  </div><!-- End .col-sm-6 -->
  
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="shop_name">Shop Name *</label>
                      <input type="text" id="shop_name" name="shop_name" value="<?= $user['shop_name'] ?>" class="form-control" required>
                    </div>
                  </div><!-- End .col-sm-6 -->
  
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="description">Shop Description *</label>
                      <textarea id="description" name="description" class="form-control" required><?= $user['description'] ?></textarea>
                    </div>
                  </div><!-- End .col-sm-6 -->
                  
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="business_phone">Business Telephone *</label>
                      <input type="text" id="business_phone" name="business_phone" value="<?= $user['business_phone'] ?>" class="form-control" required>
                    </div>
                  </div><!-- End .col-sm-6 -->
                  
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="whatsapp">WhatsApp Number</label>
                      <input type="text" id="whatsapp" name="whatsapp" value="<?= $user['whatsapp'] ?>" class="form-control">
                    </div>
                  </div><!-- End .col-sm-6 -->
  
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="business_email">Business Email Address</label>
                      <input type="email" id="business_email" name="business_email" value="<?= $user['business_email'] ?>" class="form-control">
                    </div>
                  </div><!-- End .col-sm-6 -->
                  
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="country">Country *</label>
                      <select id="country" name="country" class="form-control custom-select select-custom select2" required>
	                      <?php
	                      
		                      $countries = new Country();
		                      echo $countries->countiesCombo();
		                      
	                      ?>
                      </select>
                    </div>
                  </div><!-- End .col-sm-6 -->
                  
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="city">City *</label>
                      <select id="city" name="city" class="form-control custom-select select-custom select2" required>
                        <?php
    
                          $countries = new Country();
                          echo $countries->getCountryCities($user['country']);
  
                        ?>
                      </select>
                    </div>
                  </div><!-- End .col-sm-6 -->
                  
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="address">Location Address *</label>
                      <input type="text" id="address" name="address" value="<?= $user['address'] ?>" class="form-control" required>
                    </div>
                  </div><!-- End .col-sm-6 -->
  
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="iframe_code">Geolocation Iframe Code <small>Width should be changes to 100% and Height to 350px</small></label>
                      <textarea id="iframe_code" name="iframe_code" class="form-control"><?= $user['iframe_code'] ?></textarea>
                    </div>
                  </div><!-- End .col-sm-6 -->
                </div><!-- End .row -->
                
                <button type="submit" class="btn btn-outline-primary-2">
                  <span>SAVE CHANGES</span>
                  <i class="icon-long-arrow-right"></i>
                </button>
              </form>
            </div><!-- End .col-lg-9 -->
          </div><!-- End .row -->
        </div><!-- End .container -->
      </div><!-- End .dashboard -->
    </div><!-- End .page-content -->
  </main><!-- End .main -->

<?php
  
  include_once "includes/footer.inc.php";

?>
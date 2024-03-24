<?php
  
  include_once "../includes/adminHeader.inc.php";
  
  $data = new Vendors();

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
        <!-- Card with Card Tool -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"><?= PAGE ?> Details</h3>
          </div>
          <div class="card-body">
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
		
		          <button type="submit" class="btn btn-primary float-right">
			          <span>SAVE CHANGES</span>
			          <i class="icon-long-arrow-right"></i>
		          </button>
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
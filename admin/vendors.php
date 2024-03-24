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
            <h1>Vendors Management</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Vendors</li>
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
            <h3 class="card-title">Vendors List</h3>
          </div>
          <div class="card-body">
            <?php
              
              $vendorManager = new Vendors();
              $vendors      = $vendorManager->getAllVendors();
            
            ?>
            <div class="table-responsive">
              <table class="table table-bordered table-sm table-striped dataTable">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Logo</th>
                  <th>User</th>
                  <th>Shop</th>
                  <th>Shop Description</th>
                  <th>Shop Contacts</th>
                  <th>Shop Address</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 1; ?>
                <?php foreach ($vendors as $vendor) : ?>
                  <tr>
                    <td><?= $no ?></td>
                    <td><img src="../assets/img/shop_logos/<?= esc($vendor['shop_logo']); ?>" alt="<?= esc($vendor['shop_name']); ?> logo"></td>
	                  <td><b>Username: </b><?= esc($vendor['username']); ?><br><?= esc($vendor['full_name']); ?><br><?= phone($vendor['phone']); ?><br><?= email($vendor['email']); ?></td>
                    <td><?= esc($vendor['shop_name']); ?></td>
                    <td><?= esc($vendor['description']); ?></td>
                    <td>Phone: <?= phone($vendor['business_phone']); ?><br>WhatsApp: <?= whatsapp($vendor['whatsapp']); ?><br><?= email($vendor['business_email']); ?><br></td>
                    <td><?= esc($vendor['address']); ?>, <?= esc($vendor['country']); ?></td>
                    <td>
                      <button class="viewVendorBtn btn btn-xs btn-link text-secondary" data-id="<?= esc($vendor['vendor_id']); ?>" data-toggle="tooltip" title="View"><span class="fa fa-eye"></span></button>
                      <button class="btn btn-xs btn-link text-danger" onclick="if (confirm('Are you sure you want to delete this record?')) {$(this).addClass('deleteVendorBtn');}" data-id="<?= esc($vendor['vendor_id']); ?>"
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
        <!-- End Card with Card Tool -->
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
  
  include_once "../includes/adminFooter.inc.php";

?>
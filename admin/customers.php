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
              
              if (isset($_POST['newBlogBtn']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
                $newBlog = new Blogs();
                $newBlog->newBlog($_FILES['image']['name'], $_FILES["image"]["tmp_name"], $_POST['title'], $_POST['author'], implode(', ', $_POST['tags']), $_POST['category'], $_POST['description']);
              }
            
            ?>
          </section>
          <section class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><?= PAGE ?></h3>
              </div>
              <div class="card-body">
  
                <?php
    
                  $customerManager = new Customers();
                  $customers      = $customerManager->listCustomers();
  
                ?>
	              <div class="table-responsive">
		              <table class="table table-bordered table-sm table-striped dataTable">
			              <thead>
			              <tr>
				              <th>#</th>
				              <th>Image</th>
				              <th>Customer Name</th>
				              <th>Telephone</th>
				              <th>Email Address</th>
				              <th>Reg. Date</th>
				              <th>Action</th>
			              </tr>
			              </thead>
			              <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($customers as $customer) : ?>
				              <tr>
					              <td><?= $no ?></td>
					              <td><?= (!empty($customer['user_image']) ? '<img src="../assets/img/users/'.$customer['user_image'].'" alt="Customer Image">' : "No Image") ?></td>
					              <td><?= esc($customer['full_name']); ?></td>
					              <td><?= phone($customer['phone']); ?></td>
					              <td><?= email($customer['email']); ?></td>
					              <td><?= datel($customer['registration_date']); ?></td>
					              <td>
						              <button class="viewCustomerBtn btn btn-xs btn-link text-secondary" data-id="<?= esc($customer['user_id']); ?>" data-toggle="tooltip" title="View"><span class="fa fa-eye"></span></button>
						              <button class="editCustomerBtn btn btn-xs btn-link text-success" data-id="<?= esc($customer['user_id']); ?>" data-toggle="tooltip" title="Edit"><span class="fa fa-pen-fancy"></span></button>
						              <button class="btn btn-xs btn-link text-danger" onclick="if (confirm('Are you sure you want to delete this record?')) {$(this).addClass('deleteCustomerBtn');}" data-id="<?= esc($customer['user_id']); ?>"
						                      data-toggle="tooltip" title="Delete"><span class="fa fa-trash-alt"></span></button>
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
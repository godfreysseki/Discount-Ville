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
						<h1>Users Management</h1>
					</div>
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="index.php">Home</a></li>
							<li class="breadcrumb-item active">Users</li>
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
            $userManager = new Users();
            $categoryId  = $userManager->addUser($_POST);
            
            echo $categoryId;
          }
        
        ?>
				<!-- Card with Card Tool -->
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Users List</h3>
						<div class="card-tools">
							<!-- Dropdown Menu -->
							<div class="dropdown">
								<button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
									<i class="fas fa-wrench"></i>
								</button>
								<div class="dropdown-menu dropdown-menu-right">
									<a href="javascript:void(0)" class="addUserBtn dropdown-item">Add User</a>
								</div>
							</div>
							<!-- End Dropdown Menu -->
						</div>
					</div>
					<div class="card-body">
            <?php
              
              $userManager = new Users();
              $users       = $userManager->getUsers();
            
            ?>
						<div class="table-responsive">
							<table class="table table-bordered table-sm table-striped dataTable">
								<thead>
								<tr>
									<th>#</th>
									<th>Username</th>
									<th>Full Name</th>
									<th>Email</th>
									<th>Telephone</th>
									<th>Address 1</th>
									<th>Address 2</th>
									<th>City</th>
									<th>Postal Code</th>
									<th>Country</th>
									<th>Role</th>
									<th>Action</th>
								</tr>
								</thead>
								<tbody>
                <?php $no = 1; ?>
                <?php foreach ($users as $user) : ?>
									<tr>
										<td><?= $no ?></td>
										<td><?= esc($user['username']) ?></td>
										<td><?= esc($user['full_name']) ?></td>
										<td><?= email(esc($user['email'])) ?></td>
										<td><?= phone(esc($user['phone'])) ?></td>
										<td><?= esc($user['address_line1']) ?></td>
										<td><?= esc($user['address_line2']) ?></td>
										<td><?= esc($user['city']) ?></td>
										<td><?= esc($user['postal_code']) ?></td>
										<td><?= esc($user['country']) ?></td>
										<td><?= ucwords(strtolower(str_replace("_", " ", esc($user['role'])))) ?></td>
										<td>
											<button class="viewUserBtn btn btn-xs btn-link text-secondary" data-id="<?= esc($user['userid']); ?>" data-toggle="tooltip" title="View Activities"><span class="fa fa-eye"></span></button>
											<button class="editUserBtn btn btn-xs btn-link text-success" data-id="<?= esc($user['userid']); ?>" data-toggle="tooltip" title="Edit"><span class="fa fa-pen-fancy"></span></button>
											<button class="btn btn-xs btn-link text-danger" onclick="if (confirm('Are you sure you want to delete this record?')) {$(this).addClass('deleteUserBtn');}" data-id="<?= esc($user['userid']); ?>"
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
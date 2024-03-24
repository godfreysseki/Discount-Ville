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
						<h1>Categories Management</h1>
					</div>
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="index.php">Home</a></li>
							<li class="breadcrumb-item active">Categories</li>
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
            $categoryManager = new Category();
            $categoryId      = $categoryManager->processCategory($_POST);
            
            if ($categoryId) {
              echo alert("success", "Product category added successfully. Id: ".$categoryId);
            } else {
              echo alert("danger", "Error adding category.");
            }
          }
        
        ?>
				<!-- Card with Card Tool -->
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Categories List</h3>
						<div class="card-tools">
							<!-- Dropdown Menu -->
							<div class="dropdown">
								<button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
									<i class="fas fa-wrench"></i>
								</button>
								<div class="dropdown-menu dropdown-menu-right">
									<a href="javascript:void(0)" class="addCategoryBtn dropdown-item">Add Category</a>
								</div>
							</div>
							<!-- End Dropdown Menu -->
						</div>
					</div>
					<div class="card-body">
            <?php
              
              $categoryManager = new Category();
              $categories      = $categoryManager->getParentCategories();
            
            ?>
						<div class="table-responsive">
							<table class="table table-bordered table-sm table-striped dataTable">
								<thead>
								<tr>
									<th>#</th>
									<th>Image / Banner</th>
									<th>Category</th>
									<th>Sub Cats</th>
									<th>Action</th>
								</tr>
								</thead>
								<tbody>
                <?php $no = 1; ?>
                <?php foreach ($categories as $category) : ?>
									<tr>
										<td><?= $no ?></td>
										<td><img src="../assets/img/categories/<?= esc($category['banner']); ?>" alt="Category Image"></td>
										<td><?= esc($category['category_name']); ?></td>
										<td><?= $categoryManager->countSubCategories($category['category_id']); ?></td>
										<td>
											<button class="viewCategoryBtn btn btn-xs btn-link text-secondary" data-id="<?= esc($category['category_id']); ?>" data-toggle="tooltip" title="View"><span class="fa fa-eye"></span></button>
											<button class="editCategoryBtn btn btn-xs btn-link text-success" data-id="<?= esc($category['category_id']); ?>" data-toggle="tooltip" title="Edit"><span class="fa fa-pen-fancy"></span></button>
											<button class="btn btn-xs btn-link text-danger" onclick="if (confirm('Are you sure you want to delete this record?')) {$(this).addClass('deleteCategoryBtn');}" data-id="<?= esc($category['category_id']); ?>"
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
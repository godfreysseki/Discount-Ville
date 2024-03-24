<?php
  
  include_once "../includes/adminHeader.inc.php";
  
  $data = new Chat();

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
            $addProduct = new Frontend();
            $id         = $addProduct->addProductClient($_POST);
            echo alert($id['status'], $id['message']);
          }
        
        ?>
				<div class="row">
					<div class="col-md-4">
						<div class="card card-primary card-outline">
							<div class="card-header">
								<h3 class="card-title">Contacts</h3>
								
								<div class="card-tools">
									<button type="button" class="btn btn-tool" data-card-widget="collapse">
										<i class="fas fa-minus"></i>
									</button>
								</div>
							</div>
							<div class="card-body p-0">
								<ul id="contacts" class="nav nav-pills flex-column">
								</ul>
							</div>
							<!-- /.card-body -->
						</div>
						<!-- /.card -->
					</div>
					<section class="col-md-8">
						<!-- DIRECT CHAT PRIMARY -->
						<div class="card card-primary card-outline direct-chat direct-chat-primary">
							<div class="card-header">
								<h3 class="card-title">Customers Chat</h3>
								
								<div class="card-tools">
									<button type="button" class="btn btn-tool" data-card-widget="collapse">
										<i class="fas fa-minus"></i>
									</button>
								</div>
							</div>
							<!-- /.card-header -->
							<div class="card-body">
								<!-- Conversations are loaded here -->
								<div class="direct-chat-messages"></div>
								<!--/.direct-chat-messages-->
							
							</div>
							<!-- /.card-body -->
							<div class="card-footer">
								<div class="input-group">
									<div class="input-group-prepend" id="button-addon3">
										<button class="btn text-primary p-0 pr-2" id="dropzoneBtn">
											<span class="fa fa-image fa-2x"></span>
										</button>
										<form action="../forms/chat_upload.php" class="dropzone" id="myDropzone"></form>
									</div>
									<input type="hidden" value="<?= (isset($_GET['vendor']) ? $data->vendorName($_GET['vendor']) : null) ?>" class="chatVendor">
									<input type="text" class="message form-control" id="message" name="message" placeholder="Type Message ..." aria-label="Type Message" aria-describedby="button-addon3">
									<div class="input-group-append" id="button-addon3">
										<button class="sendChatBtn btn btn-primary" type="button">Send</button>
									</div>
								</div>
							</div>
							<!-- /.card-footer-->
						</div>
						<!--/.direct-chat -->
					</section>
				</div>
			</div>
		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->

<?php
  
  include_once "../includes/adminFooter.inc.php";

?>
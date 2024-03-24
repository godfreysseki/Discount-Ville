<?php
  
  include "../includes/adminHeader.inc.php";
  
  
  $data = new Contacts();

?>
	
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Chat & Contacts</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ul class="nav nav-pills justify-content-end" id="custom-tabs-one-tab" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="custom-tabs-one-chat-tab" data-toggle="pill" href="#custom-tabs-one-chat" role="tab" aria-controls="custom-tabs-one-chat" aria-selected="true">Chat</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="custom-tabs-one-contacts-tab" data-toggle="pill" href="#custom-tabs-one-contacts" role="tab" aria-controls="custom-tabs-one-contacts" aria-selected="false">Contacts</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="custom-tabs-one-emails-tab" data-toggle="pill" href="#custom-tabs-one-emails" role="tab" aria-controls="custom-tabs-one-emails" aria-selected="false">Bulk Email</a>
							</li>
						</ul>
					</div><!-- /.col -->
					
					<div class="col-sm-12">
						<div class="systemMsg"></div>
            <?php
              
              if (isset($_POST['bulkEmailBtn']) && $_SERVER['REQUEST_METHOD']==="POST") {
                $form = $data->sendBulkEmailToVendors($_POST);
              }
              
              if (isset($_POST['emailBtn']) && $_SERVER['REQUEST_METHOD']==="POST") {
                $form = $data->sendEmail($_POST);
              }
  
              if (isset($_POST['replyBtn']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
	              echo $data->emailReply($_POST['contactId'], $_POST['reply']);
              }
            
            ?>
					</div>
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->
		
		<!-- Main content -->
		<section class="content">
			<div class="container-fluid">
				<div class="tab-content" id="custom-tabs-one-tabContent">
					<div class="tab-pane fade show active" id="custom-tabs-one-chat" role="tabpanel" aria-labelledby="custom-tabs-one-chat-tab">
						<!-- Chat Tab Content -->
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
					<div class="tab-pane fade" id="custom-tabs-one-contacts" role="tabpanel" aria-labelledby="custom-tabs-one-contacts-tab">
						<!-- Contacts Tab Content -->
						<div class="row">
							<section class="col-md-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Contact Us Page</h3>
									</div>
									<div class="card-body">
                    <?php
                      
                      echo $data->listContact();
                    
                    ?>
									</div>
								</div>
							</section>
						</div>
					</div>
					<div class="tab-pane fade" id="custom-tabs-one-emails" role="tabpanel" aria-labelledby="custom-tabs-one-emails-tab">
						<!-- Bulk Emails Tab Content -->
						<div class="row">
							<section class="col-md-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Bulk Emails</h3>
										<div class="card-tools">
											<div class="btn-group">
												<button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
													<i class="fas fa-cog"></i>
												</button>
												<div class="dropdown-menu dropdown-menu-right" role="menu" x-placement="bottom-end">
													<a href="javascript:void(0)" class="newEmailBtn dropdown-item">New Email</a>
													<a href="javascript:void(0)" class="newBulkEmailBtn dropdown-item">New Bulk Email</a>
												</div>
											</div>
										</div>
									</div>
									<div class="card-body">
                    <?php
                      
                      echo $data->listBulkEmails();
                    
                    ?>
									</div>
								</div>
							</section>
						</div>
					</div>
				</div>
				
			</div><!-- /.container-fluid -->
		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->

<?php
  
  include "../includes/adminFooter.inc.php";

?>
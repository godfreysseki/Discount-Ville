<?php
  
  include_once "includes/header.inc.php";
  
  $data = new Chat();

?>
	
	<main class="main">
		<nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
			<div class="container">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="./">Home</a></li>
					<li class="breadcrumb-item active"><a href="chat.php">Chat & Communication</a></li>
					
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
						<div class="col">
							<div class="container chat-container">
								<div class="contacts">
									<div class="current-user">
                    <?= $data->getUserProfilePic($_SESSION['username']) ?>
										<div class="current-user-info">
											<strong><?= ((isset($_SESSION['user'])) ? $_SESSION['user'] : $_SESSION['username']) ?></strong>
											<span>Status: Available</span>
										</div>
									</div>
									<div class="search-bar">
										<input type="text" placeholder="Search contacts">
									</div>
									<div id="contacts">
										<!-- Contact List here -->
									</div>
								</div>
								<div class="chat">
									<div class="chat-header contact-profile">
										<?= (isset($_GET['vendor']) ? $data->userDetails($data->vendorName($_GET['vendor'])) : "Discount Ville Chat") ?>
										<div class="header-buttons">
											<button class="toggle-contacts-btn"><i class="fas fa-users"></i></button>
											<div class="toggle-settings-btn">
												<div class="dropdown">
													<button class="btn btn-secondary dropdown-toggle toggle-settings-btn" type="button" id="settingsDropdown" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i>
													</button>
													<div class="dropdown-menu dropdown-menu-md-right" aria-labelledby="settingsDropdown">
														<a class="dropdown-item" href="#">Setting 1</a>
														<a class="dropdown-item" href="#">Setting 2</a>
														<a class="dropdown-item" href="#">Setting 3</a>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="chat-body messages">
										
										<!-- Add more messages as needed -->
									</div>
									<div class="message-input">
										<div class="attachments">
											<button id="dropzoneBtn">
												<i class="fas fa-paperclip"></i>
											</button>
											<form action="forms/chat_upload.php" class="dropzone" id="myDropzone"></form>
										</div>
										<input type="hidden" value="<?= (isset($_GET['vendor']) ? $data->vendorName($_GET['vendor']) : null) ?>" class="chatVendor">
										<input type="text" placeholder="Type your message" class="message-input-box">
										<button class="send-btn molla-send-button"><i class="fas fa-paper-plane"></i></button>
									</div>
								</div>
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
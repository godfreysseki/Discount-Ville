<?php
  
  include_once "config.inc.php";
  
  $checkUser = new Users();
  $checkUser->checkRole(ROLE);

?>
	
	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title><?= PAGE ?> | <?= SYSTEM ?></title>
		<!-- Tell the browser to be responsive to screen width -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" href="<?= FAVICON ?>" type="image/x-icon">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
		<!-- Ionicons -->
		<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
		<link rel="stylesheet" href="../assets/plugins/datatables/datatables.min.css">
		<link rel="stylesheet" href="../assets/plugins/select2/css/select2.min.css">
		<link rel="stylesheet" href="../assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
		<link rel="stylesheet" href="../assets/plugins/chart.js/Chart.min.css">
		<link rel="stylesheet" href="../assets/plugins/summernote/summernote-bs4.min.css">
		<link rel="stylesheet" href="../assets/plugins/dropzone/dropzone.css">
		<link rel="stylesheet" href="../assets/plugins/toastr/toastr.min.css">
		<link rel="stylesheet" href="../assets/plugins/flag-icon-css/css/flag-icon.min.css">
		<!-- Theme style -->
		<link rel="stylesheet" href="../assets/css/adminlte.min.css">
		<link rel="stylesheet" href="../assets/css/custom.css">
		<!-- Google Font: Source Sans Pro -->
		<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
		<script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
		
		<!-- Function to initialize the Google Translate Element -->
		<script>
      function googleTranslateElementInit()
      {
        new google.translate.TranslateElement({
          pageLanguage: 'en', includedLanguages: 'en,fr,es', layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL,
        }, 'google_translate_element');
      }
      
      function changeLanguage(languageCode)
      {
        var selectedLanguage = document.getElementById('selectedLanguage');
        var data;
        if (languageCode === 'es') {
          data = '<i class="flag-icon flag-icon-es"></i>';
        } else if (languageCode === 'fr') {
          data = '<i class="flag-icon flag-icon-fr"></i>';
        } else {
          data = '<i class="flag-icon flag-icon-us"></i>';
        }
        
        selectedLanguage.innerHTML = data;
        
        // Trigger Google Translate API to change the language
        var el = document.querySelector('.goog-te-combo');
        el.value = languageCode;
        el.dispatchEvent(new Event('change'));
      }
		</script>
	</head>
<body class="hold-transition <?php
  
  $theme = new Theme();
  echo $theme->loadAccentTheme() . " " . $theme->loadMode() . " " . $theme->loadsidebarMini() . " " . $theme->loadsidebarMiniMD() . " " . $theme->loadFixedFooter() . " " . $theme->loadsidebarCollapsed() . " " . $theme->loadsidebarFixed() . " " . $theme->loadFixedHeader() . " " . $theme->loadsidebarMiniXS() . " " . $theme->loadSmallBodyText();

?>">
<div class="wrapper">
	<!-- Navbar -->
	<nav class="main-header navbar navbar-expand <?php
    
    $theme = new Theme();
    echo $theme->loadTopNavbarTheme() . " " . $theme->loadHeaderLegacy() . " " . $theme->loadHeaderBorder() . " " . $theme->loadSmallNavbarText();
  
  ?>">
		<!-- Left navbar links -->
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link" data-widget="pushmenu" href="javascript:void(0)"><i class="fas fa-bars"></i></a>
			</li>
			<li class="nav-item d-none d-sm-inline-block">
				<a href="../" class="nav-link pt-1 font-weight-bold"><h5><?= strtoupper(COMPANY) ?></h5></a>
			</li>
		</ul>
		
		<!-- Right navbar links -->
		<ul class="navbar-nav ml-auto">
			
			<li class="nav-item">
				<a href="" class="nav-link" data-toggle="tooltip" title="Reload Page"><span class="fa fa-recycle"></span></a>
			</li>
			<!-- Notifications Dropdown Menu -->
			<li class="nav-item dropdown">
        <?php
          
          $alerts = new Config();
        
        ?>
				<a class="nav-link" data-toggle="dropdown" href="javascript:void(0)">
					<i class="far fa-bell"></i>
					<span class="badge badge-info navbar-badge font-weight-bold"><?= $alerts->countNewAlerts(); ?></span>
				</a>
				<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
					<span class="dropdown-item dropdown-header"><?= $alerts->countNewAlerts(); ?> Notification(s)</span>
					<div class="dropdown-divider"></div>
          <?= $alerts->showAlertCategories() ?>
					<a href="notifications.php" class="dropdown-item dropdown-footer">See All Notifications</a>
				</div>
			</li>
			<!-- Language Section -->
			<li class="nav-item dropdown">
				<a class="lang nav-link" id="selectedLanguage" data-toggle="dropdown" href="javascript:void(0)" aria-expanded="false">
					<i class="flag-icon flag-icon-us"></i>
				</a>
				<div class="dropdown-menu dropdown-menu-right p-0" style="left: inherit; right: 0px;">
					<a href="javascript:void(0)" onclick="changeLanguage('en')" class="notranslate dropdown-item active">
						<i class="flag-icon flag-icon-us mr-2"></i> English
					</a>
					<a href="javascript:void(0)" onclick="changeLanguage('fr')" class="notranslate dropdown-item">
						<i class="flag-icon flag-icon-fr mr-2"></i> French
					</a>
					<a href="javascript:void(0)" onclick="changeLanguage('es')" class="notranslate dropdown-item">
						<i class="flag-icon flag-icon-es mr-2"></i> Spanish
					</a>
				</div>
				<div id="google_translate_element"></div>
			</li>
			<!-- User Session -->
			<li class="nav-item dropdown user-menu">
				<a href="javascript:void(0)" class="nav-link dropdown-toggle" data-toggle="dropdown">
					<img src="../assets/img/users/<?= $checkUser->userProfilePic($_SESSION['user_id']) ?>" class="user-image img-circle elevation-2" alt="User Image">
					<span class="d-none d-md-inline"><?= $_SESSION['username'] ?></span>
				</a>
				<ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
					<!-- User image -->
					<li class="user-header">
						<img src="../assets/img/users/<?= $checkUser->userProfilePic($_SESSION['user_id']) ?>" class="img-circle elevation-2" alt="User Image">
						
						<p>
              <?= $_SESSION['username'] ?> - <?= ucwords(str_replace("_", " ", $_SESSION['role'])) ?>
							<small>Member since Nov. 2012</small>
						</p>
					</li>
					<!-- Menu Footer-->
					<li class="user-footer">
						<a href="profile.php" class="btn btn-default btn-flat">Profile</a>
						<a href="../logout.php" class="btn btn-default btn-flat float-right">Sign out</a>
					</li>
				</ul>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-widget="control-sidebar" data-slide="true" href="javascript:void(0)">
					<i class="fas fa-th-large"></i>
				</a>
			</li>
		</ul>
	</nav>
	<!-- /.navbar -->

<?php
  
  include_once strtolower(ROLE) . "Menu.inc.php";

?>
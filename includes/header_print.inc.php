<?php
  
  include_once "config.inc.php";
  
  $data = new Frontend();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?= PAGE . " - " . COMPANY ?></title>
  <!-- SEO META Tags -->
  <meta name="description" content="<?= $pageDescription ?? DESCRIPTION ?>">
  <meta name="keywords" content="<?= $pageKeywords ?? KEYWORDS ?>">
  <meta name="author" content="<?= $pageAuthor ?? 'Gramaxic' ?>">
  <meta name="robots" content="<?= $pageRobots ?? ROBOT ?>">
  <!-- Dynamic Meta Tags -->
  <meta property="og:title" content="<?= $pageTitle ?? COMPANY ?>">
  <meta property="og:description" content="<?= $pageDescription ?? '' ?>">
  <meta property="og:image" content="<?= $pageImage ?? FAVICON ?>">
  <meta property="og:image:alt" content="<?= $pageImageAlt ?? '' ?>">
  <meta property="og:url" content="<?= $pageUrl ?? URL ?>">
  <meta property="og:type" content="<?= $pageType ?? 'website' ?>">
  <meta property="og:site_name" content="<?= COMPANY ?>">
  
  <meta name="twitter:card" content="<?= $summaryImage ?? FAVICON ?>">
  <meta name="twitter:title" content="<?= $pageTitle ?? COMPANY ?>">
  <meta name="twitter:description" content="<?= $pageDescription ?? '' ?>">
  <meta name="twitter:image" content="<?= $pageImage ?? FAVICON ?>">
  
  <link rel="icon" href="<?= FAVICON ?>">
  
  <link rel="stylesheet" href="assets/vendor/line-awesome/line-awesome/line-awesome/css/line-awesome.min.css">
  <!-- Plugins CSS File -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="assets/css/demos/custom-style.css">
	
	<style>
		.buttons .back, .buttons .print{
			padding: 5px 30px !important;
			font-weight: bold;
		}
		
		@media print {
			.buttons, .back, .print {
				display: none;
			}
		}
	</style>
</head>

<body>


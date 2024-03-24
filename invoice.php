<?php
  
  include_once "includes/header_print.inc.php";
  
  $data = new Orders();
  
?>
	<style>
		body {
			font-size: 16px;
		}
		
		.company-logo {
			max-width: 100px;
		}
		
		.invoice-header h1 {
			font-size: 2.5em;
			margin-bottom: 0.2em;
		}
		
		.bill-to-header h2 {
			font-size: 1.8em;
			margin-bottom: 0.5em;
		}
		
		.table th, .table td {
			text-align: center;
		}
		
		.total-section p {
			font-weight: bold;
		}
		
		.note-text {
			color: gray;
			font-size: 0.8rem;
		}
	</style>

<?= $data->invoiceDetails() ?>

<?php
  
  include_once "includes/footer_print.inc.php";

?>
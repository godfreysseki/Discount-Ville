<?php
  
  include_once "includes/header.inc.php";
  
  $data = new Subscription();

?>
  
  <main class="main">
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
      <div class="container">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href=./>Home</a></li>
          <li class="breadcrumb-item"><a href="javascript:void(0)">Pages</a></li>
          <li class="breadcrumb-item active"><a href="pricing.php">Subscription Plans</a></li>
        </ol>
      </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->
    
    <div class="page-content">
      <div class="container">
        <?= $data->renderPlans(); ?>
      </div>
    </div>
  </main>


<?php
  
  include_once "includes/footer.inc.php";

?>
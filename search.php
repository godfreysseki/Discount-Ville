<?php
  
  include_once "includes/header.inc.php";

  $data = new Frontend();
  
?>

<main class="main">
  <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
    <div class="container">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href=./>Home</a></li>
        <li class="breadcrumb-item active">Search</li>
      </ol>
    </div><!-- End .container -->
  </nav><!-- End .breadcrumb-nav -->
  
  <div class="page-content">
    <div class="container">
      <div class="row">
        <div class="col-12">
	        
          <div class="products mb-3">
            <div class="row justify-content-center">
              <?= $data->search($_POST) ?>
            </div><!-- End .row -->
          </div><!-- End .products -->
          
          
          <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
              <li class="page-item disabled">
                <a class="page-link page-link-prev" href="#" aria-label="Previous" tabindex="-1" aria-disabled="true">
                  <span aria-hidden="true"><i class="icon-long-arrow-left"></i></span>Prev
                </a>
              </li>
              <li class="page-item active" aria-current="page"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item-total">of 6</li>
              <li class="page-item">
                <a class="page-link page-link-next" href="#" aria-label="Next">
                  Next <span aria-hidden="true"><i class="icon-long-arrow-right"></i></span>
                </a>
              </li>
            </ul>
          </nav>
        </div><!-- End .col-lg-9 -->
      </div><!-- End .row -->
    </div><!-- End .container -->
  </div><!-- End .page-content -->
</main><!-- End .main -->

<?php
  
  include_once "includes/footer.inc.php";

?>
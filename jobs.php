<?php
  
  include_once "includes/header.inc.php";
  
  $data = new Jobs();

?>
  
  <main class="main">
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
      <div class="container">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href=./>Home</a></li>
          <li class="breadcrumb-item"><a href="javascript:void(0)">Pages</a></li>
          <li class="breadcrumb-item active">Jobs</li>
        </ol>
      </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->
    
    <div class="page-content">
      <div class="container">
        <div class="text-center mb-2">
          <h3>Job Search Alerts</h3>
          <p class="lead">If you ar looking for a job, this is the best place for you to get one.</p>
        </div>
	
	      <div class="row">
		
		      <div class="col-12">
			      <div class="search-bar">
				      <input type="text" id="jobSearch" class="form-control mb-2" placeholder="Search job title...">
			      </div>
		      </div>
	      </div>
	      
        <div class="jobs">
	        
	        <?= $data->showJobs() ?>
	        
        </div>
      </div>
    </div>
  </main>

<?php
  
  include_once "includes/footer.inc.php";

?>
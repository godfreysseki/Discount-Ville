<?php
  
  include_once "includes/header.inc.php";
  
  $data = new Blogs();
  $data->blogViewed(str_replace(' ', '+', $_GET['id']));

?>
  
  <main class="main">
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
      <div class="container">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item"><a href="blogs.php">Blog</a></li>
          <li class="breadcrumb-item active" aria-current="page">Single Blog</li>
        </ol>
      </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->
    
    <div class="page-content">
      <div class="container">
        <div class="row">
          <div class="col-lg-9">
	          
	          <?= $data->showSingleBlog(str_replace(' ', '+', $_GET['id'])) ?>
            <!-- End .entry -->
            
            <div class="related-posts">
              <h3 class="title">Related Posts</h3><!-- End .title -->
              
              <div class="owl-carousel owl-simple" data-toggle="owl"
                   data-owl-options='{
                                        "nav": false,
                                        "dots": true,
                                        "margin": 10,
                                        "loop": true,
                                        "responsive": {
                                            "0": {
                                                "items":1
                                            },
                                            "480": {
                                                "items":2
                                            },
                                            "768": {
                                                "items":3
                                            },
                                            "992": {
                                                "items":4
                                            }
                                        }
                                    }'>
                <?= $data->relatedBlogs(str_replace(' ', '+', $_GET['id'])) ?>
              </div><!-- End .owl-carousel -->
            </div><!-- End .related-posts -->
          </div><!-- End .col-lg-9 -->
          
          <aside class="col-lg-3">
            <div class="sidebar">
              <!--<div class="widget widget-search">
                <h3 class="widget-title">Search</h3>
                
                <form action="#">
                  <label for="ws" class="sr-only">Search in blog</label>
                  <input type="search" class="form-control" name="ws" id="ws" placeholder="Search in blog" required>
                  <button type="submit" class="btn"><i class="icon-search"></i><span class="sr-only">Search</span></button>
                </form>
              </div>-->
              
              <div class="widget widget-cats">
                <h3 class="widget-title">Categories</h3><!-- End .widget-title -->
                
                <ul>
	                <?= $data->showBlogsCategoriesSingleBlog() ?>
                </ul>
              </div><!-- End .widget -->
              
              <div class="widget">
                <h3 class="widget-title">Popular Posts</h3><!-- End .widget-title -->
                
                <ul class="posts-list">
	                
	                <?= $data->showPopularBlogs(8) ?>
	                
                </ul><!-- End .posts-list -->
              </div><!-- End .widget -->
              
              <div class="widget widget-banner-sidebar">
                <div class="banner-sidebar-title">ad box 280 x 280</div><!-- End .ad-title -->
                
                <div class="banner-sidebar">
                  <a href="#">
                    <img src="assets/images/blog/sidebar/banner.jpg" alt="banner">
                  </a>
                </div><!-- End .banner-ad -->
              </div><!-- End .widget -->
              
              <div class="widget">
                <h3 class="widget-title">Browse Tags</h3><!-- End .widget-title -->
                
                <div class="tagcloud">
                  <a href="#">fashion</a>
                  <a href="#">style</a>
                  <a href="#">women</a>
                  <a href="#">photography</a>
                  <a href="#">travel</a>
                  <a href="#">shopping</a>
                  <a href="#">hobbies</a>
                </div><!-- End .tagcloud -->
              </div><!-- End .widget -->
	
	            <div class="widget widget-banner-sidebar">
		            <div class="banner-sidebar-title">ad box 280 x 280</div><!-- End .ad-title -->
		
		            <div class="banner-sidebar">
			            <a href="#">
				            <img src="assets/images/blog/sidebar/banner.jpg" alt="banner">
			            </a>
		            </div><!-- End .banner-ad -->
	            </div><!-- End .widget -->
	
	            <div class="widget widget-banner-sidebar">
		            <div class="banner-sidebar-title">ad box 280 x 280</div><!-- End .ad-title -->
		
		            <div class="banner-sidebar">
			            <a href="#">
				            <img src="assets/images/blog/sidebar/banner.jpg" alt="banner">
			            </a>
		            </div><!-- End .banner-ad -->
	            </div><!-- End .widget -->
	            
            </div><!-- End .sidebar sidebar-shop -->
          </aside><!-- End .col-lg-3 -->
        </div><!-- End .row -->
      </div><!-- End .container -->
    </div><!-- End .page-content -->
  </main><!-- End .main -->

<?php
  
  include_once "includes/footer.inc.php";

?>
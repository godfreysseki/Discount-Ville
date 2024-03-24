<?php
  
  
  class Blogs extends Config
  {
    private $auditTrail;
    
    public function __construct()
    {
      parent::__construct();
      $this->auditTrail = new AuditTrail();
    }
    
    // Blog Ctageories
    public function newBlogCat($category)
    {
      $date   = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
      $cat    = esc($category);
      $sql    = "INSERT INTO blogs_categories (category, regdate) VALUES (?, ?)";
      $params = [$cat, $date];
      if ($this->insertQuery($sql, $params)) {
        echo alert('success', 'Blog category added successfully.');
      } else {
        echo alert('warning', 'Blog category addition failed.');
      }
    }
    
    public function blogCategoryForm($category_id = null)
    {
      $data = '<form method="post">
                <div class="form-group">
                  <label for="category">Category Name</label>
                  <input type="text" name="category" id="category" required class="form-control">
                </div>
                <div class="form-group">
                  <button type="submit" name="newBlogCatBtn" class="btn btn-' . COLOR . ' float-right"><span class="fa fa-fa-check"></span> Save</button>
                </div>
               </form>';
      if ($category_id !== null) {
        $id     = ($category_id);
        $sql    = "SELECT * FROM blogs_categories WHERE bcid=? ";
        $params = [$id];
        $result = $this->selectQuery($sql, $params);
        $row    = $result->fetch_assoc();
        
        $data = '<form method="post">
                    <input type="hidden" name="category_id" value="' . $category_id . '">
                    <div class="form-group">
                      <label for="category">Category Name</label>
                      <input type="text" name="category" id="category" value="' . $row['category'] . '" required class="form-control">
                    </div>
                    <div class="form-group">
                      <button type="submit" name="updateBlogCatBtn" class="btn btn-' . COLOR . ' float-right"><span class="fa fa-fa-check"></span> Update</button>
                    </div>
                  </form>';
      }
      
      return $data;
    }
    
    public function updateBlogCat($category_id, $category)
    {
      $id     = ($category_id);
      $cat    = esc($category);
      $sql    = "UPDATE blogs_categories SET category=? WHERE bcid=?";
      $params = [$cat, $id];
      if ($this->updateQuery($sql, $params)) {
        echo alert('success', 'Blog Category Updated Successfully.');
      } else {
        echo alert('warning', 'Blog Category Updates Failed.');
      }
    }
    
    public function listBlogsCategories()
    {
      $data   = 'No categories Found.';
      $sql    = "SELECT * FROM blogs_categories";
      $result = $this->selectQuery($sql);
      if ($result->num_rows > 0) {
        $no   = 1;
        $data = '<table class="table table-striped table-hover table-sm table-bordered">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Category</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>';
        while ($row = $result->fetch_assoc()) {
          $id     = ($row['bcid']);
          $action = '
                      <button data-id="' . $id . '" class="editBlogCat btn btn-link btn-xs text-success" data-toggle="tooltip" title="Edit"><i class="fa fa-pen-fancy"></i></button>
                      <button data-id="' . $id . '" onclick="if(confirm(\'This will delete this record from the system.\\nIf connected to other records, they will be affected.\\n\\nAre you sure to continue?\')) {$(this).addClass(\'deleteBlogCat\')}" data-toggle="tooltip" title="Delete" class="btn btn-link btn-xs text-danger"><span class="fa fa-trash"></span></button>
                    ';
          $data   .= '<tr>
                     <td>' . $no . '</td>
                     <td>' . $row['category'] . '</td>
                     <td>' . $action . '</td>
                    </tr>';
          $no++;
        }
        $data .= '</tbody></table>';
      }
      return $data;
    }
    
    public function deleteBlogCat($category_id)
    {
    
    }
    
    public function blogCategoriesComboOptions($selectedId = null)
    {
      $sql    = 'SELECT * FROM blogs_categories';
      $result = $this->selectQuery($sql);
      $option = '';
      while ($row = $result->fetch_assoc()) {
        $selected = ($row['bcid'] == $selectedId ? 'selected' : '');
        $option   .= '<option value="' . $row['bcid'] . '" ' . $selected . '>' . $row['category'] . '</option>';
      }
      return $option;
    }
    
    // Blogs
    public function newBlog($image, $tmp, $title, $author, $tags, $category, $description)
    {
      $head   = esc($title);
      $writer = esc($author);
      $tag    = esc($tags);
      $cat    = esc($category);
      $desc   = ($description);
      $dir    = "../assets/img/blogs/";
      $date   = date("Y-m-d H:i:s", $_SERVER['REQUEST_TIME']);
      $sql    = "INSERT INTO blogs (title, author, tags, description, category, regdate) VALUES (?, ?, ?, ?, ?, ?)";
      $params = [$head, $writer, $tag, $desc, $cat, $date];
      if ($this->insertQuery($sql, $params)) {
        echo alert('success', 'Blog published successfully.');
      } else {
        echo alert('warning', 'Blog publication failed.');
      }
      
      // Upload blog image
      if (!empty($_FILES["image"]["name"][0])) {
        // Get old image and delete it from folder
        $gets = "SELECT image FROM blogs WHERE title=? ";
        $para = [$head];
        $get  = $this->selectQuery($gets, $para);
        if ($get->num_rows > 0) {
          $row    = $get->fetch_array();
          $imager = explode(", ", $row['image']) ?? [$row['image']];
          // Remove Image
          foreach ($imager as $item) {
            if (file_exists($item)) {
              unlink($item);
            }
          }
        }
        // Make the files upload now
        $files      = ''; // For the new File names
        $countFiles = count($image);
        for ($i = 0; $i < $countFiles; $i++) {
          $filename  = $image[$i];
          $location  = $dir . $filename;
          $extension = strtolower(pathinfo($location, PATHINFO_EXTENSION));
          // Upload
          if (move_uploaded_file($tmp[$i], $location)) {
            $timer = time() + $i;
            rename($location, $dir . $timer . "." . $extension);
            $newName = $dir . $timer . "." . $extension;
            $files   .= $newName . ", ";
          }
        }
        $images = rtrim($files, ", ");
        // Write to database image and system log
        $datas   = "UPDATE blogs SET image=? WHERE title=? ";
        $paramss = [$images, $head];
        $this->updateQuery($datas, $paramss);
        echo alert('success', 'Blog Image(s) Uploaded Successfully');
        
      }
    }
    
    public function newBlogForm($blogId = null)
    {
      $data = '<form method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="image">Blog Image</label>
                  <input type="file" name="image[]" id="image" accept="image/*" multiple class="form-control">
                </div>
                <div class="form-group">
                  <label for="title">Blog Title</label>
                  <input type="text" name="title" id="title" required class="form-control">
                </div>
                <div class="form-group">
                  <label for="author">Author</label>
                  <input type="text" name="author" id="author" required class="form-control">
                </div>
                <div class="form-group">
                  <label for="tags">Tags</label>
                  <select name="tags[]" id="tags" multiple required class="custom-select select2-tags"></select>
                </div>
                <div class="form-group">
                  <label for="category">Category</label>
                  <select name="category" id="category" required class="custom-select select2">
                    ' . $this->blogCategoriesComboOptions() . '
                  </select>
                </div>
                <div class="form-group">
                  <label for="description">Blog Details</label>
                  <textarea name="description" id="description" required class="editor form-control"></textarea>
                </div>
                <div class="form-group">
                  <button type="submit" name="newBlogBtn" class="btn btn-' . COLOR . ' float-right"><span class="fa fa-fa-check"></span> Save</button>
                </div>
               </form>';
      if ($blogId !== null) {
        $id     = ($blogId);
        $sql    = "SELECT * FROM blogs WHERE bid=? ";
        $params = [$id];
        $result = $this->selectQuery($sql, $params);
        $row    = $result->fetch_assoc();
        $tags   = explode(", ", $row['tags']);
        
        $data = '<form method="post" enctype="multipart/form-data">
                    <input type="hidden" name="blogId" id="blogId" value="' . $blogId . '" class="d-none">
                    <div class="form-group">
                      <label for="image">Blog Image</label>
                      <input type="file" name="image[]" id="image" accept="image/*" multiple class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="title">Blog Title</label>
                      <input type="text" name="title" id="title" value="' . $row['title'] . '" required class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="author">Author</label>
                      <input type="text" name="author" id="author" value="' . $row['author'] . '" required class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="tags">Tags</label>
                      <select name="tags[]" id="tags" multiple required class="custom-select select2-tags">
                        ';
        foreach ($tags as $tag) {
          $data .= '<option value="' . $tag . '" selected>' . $tag . '</option>';
        }
        $data .= '
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="category">Category</label>
                      <select name="category" id="category" required class="custom-select select2">
                        ' . $this->blogCategoriesComboOptions($row['category']) . '
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="description">Blog Details</label>
                      <textarea name="description" id="description" required class="editor form-control">' . $row['description'] . '</textarea>
                    </div>
                    <div class="form-group">
                      <button type="submit" name="updateBlogBtn" class="btn btn-' . COLOR . ' float-right"><span class="fa fa-fa-check"></span> Update</button>
                    </div>
                  </form>';
      }
      
      return $data;
    }
    
    public function updateBlog($blogId, $image, $tmp, $title, $author, $tags, $category, $description)
    {
      $id     = ($blogId);
      $head   = esc($title);
      $writer = esc($author);
      $tag    = esc($tags);
      $cat    = esc($category);
      $desc   = $description;
      $dir    = "../assets/img/blogs/";
      $images = $image;
      $image  = $dir . $image;
      $sql    = "UPDATE blogs SET title=?, author=?, tags=?, description=?, category=? WHERE bid=? ";
      $params = [$head, $writer, $tag, $desc, $cat, $id];
      if ($this->updateQuery($sql, $params)) {
        echo alert('success', 'Blog updated successfully.');
      } else {
        echo alert('warning', 'Blog Post Updated failed.');
      }
      
      // Upload blog image
      if (!empty($_FILES["image"]["name"][0])) {
        // Get old image and delete it from folder
        $gets = "SELECT image FROM blogs WHERE title=? ";
        $para = [$head];
        $get  = $this->selectQuery($gets, $para);
        if ($get->num_rows > 0) {
          $row    = $get->fetch_array();
          $imager = explode(", ", $row['image']) ?? [$row['image']];
          // Remove Image
          foreach ($imager as $item) {
            if (file_exists($item)) {
              unlink($item);
            }
          }
        }
        // Make the files upload now
        $files      = ''; // For the new File names
        $countFiles = count($image);
        for ($i = 0; $i < $countFiles; $i++) {
          $filename  = $image[$i];
          $location  = $dir . $filename;
          $extension = strtolower(pathinfo($location, PATHINFO_EXTENSION));
          // Upload
          if (move_uploaded_file($tmp[$i], $location)) {
            $timer = time() + $i;
            rename($location, $dir . $timer . "." . $extension);
            $newName = $dir . $timer . "." . $extension;
            $files   .= $newName . ", ";
          }
        }
        $images = rtrim($files, ", ");
        // Write to database image and system log
        $datas   = "UPDATE blogs SET image=? WHERE title=? ";
        $paramss = [$images, $head];
        $this->updateQuery($datas, $paramss);
        echo alert('success', 'Blog Image(s) Uploaded Successfully');
        
      }
    }
    
    public function deleteBlog($blogId)
    {
      $id     = ($blogId);
      $sql    = "SELECT * FROM blogs WHERE bid=? ";
      $params = [$id];
      $result = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        $row    = $result->fetch_assoc();
        $images = explode(", ", $row['image']) ?? [$row['image']];
        foreach ($images as $image) {
          unlink($image);
        }
      }
      $del = "DELETE FROM blogs WHERE bid=? ";
      if ($this->deleteQuery($del, $params)) {
        alert('success', 'Blog Post Deleted Successfully.');
      } else {
        alert('warning', 'Blog Post Deletion Failed.');
      }
    }
    
    public function listBlogs()
    {
      $data   = '<p>No blog posts published yet.</p>';
      $sql    = "SELECT * FROM blogs ORDER BY bid DESC";
      $result = $this->selectQuery($sql);
      if ($result->num_rows > 0) {
        $no   = 1;
        $data = '<div class="table-responsive">
                  <table class="table dataTable">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Tags</th>
                        <th>Reg. Date</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>';
        while ($row = $result->fetch_assoc()) {
          $id     = ($row['bid']);
          $action = '
                      <button data-id="' . $id . '" class="viewBlog btn btn-link btn-xs text-primary" data-toggle="tooltip" title="View"><i class="fa fa-eye"></i></button>
                      <button data-id="' . $id . '" class="editBlog btn btn-link btn-xs text-success" data-toggle="tooltip" title="Edit"><i class="fa fa-pen-fancy"></i></button>
                      <button data-id="' . $id . '" onclick="if(confirm(\'This will delete this record from the system.\\nIf connected to other records, they will be affected.\\n\\nAre you sure to continue?\')) {$(this).addClass(\'deleteBlog\')}" data-toggle="tooltip" title="Delete" class="btn btn-link btn-xs text-danger"><span class="fa fa-trash"></span></button>
                    ';
          $tags   = explode(", ", $row['tags']);
          $data   .= '<tr>
                        <td>' . $no . '</td>
                        <td>' . $row['title'] . '</td>
                        <td>' . $row['author'] . '</td>
                        <td>';
          foreach ($tags as $tag) {
            $data .= '<span class="badge badge-' . COLOR . ' font-weight-normal">' . $tag . '</span>&nbsp;';
          }
          $data .= '</td>
                        <td>' . dates($row['regdate']) . '</td>
                        <td>' . $action . '</td>
                      </tr>';
          $no++;
        }
        $data .= '</tbody></table></div>';
      }
      
      return $data;
    }
    
    public function listSingleBlog($blogId)
    {
      $id     = ($blogId);
      $sql    = "SELECT * FROM blogs WHERE bid=? ";
      $params = [$id];
      $result = $this->selectQuery($sql, $params);
      $row    = $result->fetch_assoc();
      
      return '<h5 class="mb-3 text-center text-' . COLOR . '">' . $row['title'] . '</h5><img src="' . explode(', ', $row['image'])[0] . '" class="img-fluid" alt="Blog Img">' . $row['description'];
    }
    
    // Client Side
    public function showBlogs()
    {
      $data   = '<p>No blogs published yet. We apologize for the inconveniences caused.</p>';
      $sql    = "SELECT * FROM blogs ORDER BY bid DESC";
      $result = $this->selectQuery($sql);
      if ($result->num_rows > 0) {
        $data = '';
        while ($row = $result->fetch_assoc()) {
          $id   = $row['bid'];
          $data .= '<div class="entry-item ' . $this->blogCategory($row['category']) . ' col-sm-6 col-md-4 col-lg-3">
                      <article class="entry entry-grid text-center">
                        <figure class="entry-media">
                          <div class="owl-carousel owl-simple owl-light owl-nav-inside" data-toggle="owl">
                            ' . $this->blogImages($row['bid']) . '
                          </div><!-- End .owl-carousel -->
                        </figure><!-- End .entry-media -->
                        
                        <div class="entry-body">
                          <div class="entry-meta">
                            <a href="javascript:void(0)">' . date('M d, Y', strtotime($row['regdate'])) . '</a>
                            <span class="meta-separator">|</span>
                            <a href="blog.php?id=' . $id . '#comments">' . $this->blogCommentsCount($row['bid']) . ' Comments</a>
                          </div><!-- End .entry-meta -->
                          
                          <h2 class="entry-title">
                            <a href="blog.php?id=' . $id . '">' . $row['title'] . '</a>
                          </h2><!-- End .entry-title -->
                          
                          <div class="entry-cats">
                            in <a href="javascript:void(0)">' . $this->blogCategory($row['category']) . '</a>
                          </div><!-- End .entry-cats -->
                          
                          <div class="entry-content">
                            <p>' . reduceWords(strip_tags($row['description']), 110) . '</p>
                            <a href="blog.php?id=' . $id . '" class="read-more">Continue Reading</a>
                          </div><!-- End .entry-content -->
                        </div><!-- End .entry-body -->
                      </article><!-- End .entry -->
                    </div><!-- End .entry-item -->';
        }
      }
      
      return $data;
    }
    
    public function showSingleBlog($blogId)
    {
      $data   = '<p>Please re-select the blog to view content</p>';
      $id     = ($blogId);
      $sql    = "SELECT * FROM blogs WHERE bid='" . $id . "' ";
      $result = $this->selectQuery($sql);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $data = '<article class="entry single-entry">
                    <figure class="entry-media">
                      <div class="owl-carousel owl-simple owl-light owl-nav-inside" data-toggle="owl">
                        ' . $this->blogImages($row['bid']) . '
                      </div>
                    </figure><!-- End .entry-media -->
                    
                    <div class="entry-body">
                      <div class="entry-meta">
                        <span class="entry-author">
                            by <a href="#">' . $row['author'] . '</a>
                        </span>
                        <span class="meta-separator">|</span>
                        <a href="javascript:void(0)">' . date('M d, Y', strtotime($row['regdate'])) . '</a>
                        <span class="meta-separator">|</span>
                        <a href="#comments">' . $this->blogCommentsCount($row['bid']) . ' Comments</a>
                        <span class="meta-separator">|</span>
                        <a href="javascript:void(0)">' . $row['views'] . ' views</a>
                      </div><!-- End .entry-meta -->
                
                      <h2 class="entry-title">
                        ' . $row['title'] . '
                      </h2><!-- End .entry-title -->
                      
                      <div class="entry-cats">
                        in <a href="javascript:void(0)">' . $this->blogCategory($row['category']) . '</a>
                      </div><!-- End .entry-cats -->
                      
                      <div class="entry-content editor-content">
                        ' . $row['description'] . '
                      </div><!-- End .entry-content -->
                      
                      <div class="entry-footer row no-gutters flex-column flex-md-row">
                        <div class="col-md">
                          <div class="entry-tags">
                            <span>Tags:</span> ' . $this->showTags($blogId) . '
                          </div><!-- End .entry-tags -->
                        </div><!-- End .col -->
                        
                        <div class="col-md-auto mt-2 mt-md-0">
                          <div class="social-icons social-icons-color">
                            <span class="social-label">Share this post:</span>
                            <a href="https://www.facebook.com/sharer/sharer?u=' . base_url($_SERVER['REQUEST_URI']) . '" target="_blank" class="social-icon social-facebook">
                              <i class="icon-facebook-f"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url=' . base_url($_SERVER['REQUEST_URI']) . '" target="_blank" class="social-icon social-twitter">
                              <i class="icon-twitter"></i>
                            </a>
                            <a href="http://pinterest.com/pin/create/button/?url=' . base_url($_SERVER['REQUEST_URI']) . '" target="_blank" class="social-icon social-pinterest">
                              <i class="icon-pinterest"></i>
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url=' . base_url($_SERVER['REQUEST_URI']) . '" target="_blank" class="social-icon social-linkedin">
                              <i class="icon-linkedin"></i>
                            </a>
                            <a href="https://api.whatsapp.com/send?text=' . $row['title'] . ' ' . base_url($_SERVER['REQUEST_URI']) . '" target="_blank" class="social-icon social-whatsapp">
                              <i class="icon-whatsapp"></i>
                            </a>
                          </div><!-- End .soial-icons -->
                        </div><!-- End .col-auto -->
                      </div><!-- End .entry-footer row no-gutters -->
                    </div><!-- End .entry-body -->
                    
                  </article>
                  
                  <!-- Comments
                  ============================================= -->
                  <div id="comments" class="comments">
                    <h3 id="comments-title" class="title"><span>' . $this->blogCommentsCount($row['bid']) . '</span> Comments</h3>
                    <div class="clear"></div>
                    
                    ' . $this->showBlogComments($blogId) . '
                    
                    </div>
                    
                    <!-- Comment Form
                            ============================================= -->
                            <div id="respond" class="reply">
                              <h3>Leave a <span>Comment</span></h3>
                              <p><small><i>Your email address will not be published.<br>Required fields are marked * </i></small></p>
                              <form method="POST" action="forms/blog_comment.php" role="form" class="php-email-form" id="commentform">
                                <div class="row">
                                  <input name="commentId" id="commentId" type="hidden" class="form-control" value="0" required>
                                  <div class="col-md-6 form-group">
                                    <input name="name" type="text" class="form-control" placeholder="Your Name*">
                                  </div>
                                  <div class="col-md-6 form-group">
                                    <input name="email" type="text" class="form-control" placeholder="Your Email*">
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col form-group">
                                    <textarea name="comment" class="form-control" placeholder="Your Comment*"></textarea>
                                  </div>
                                </div>
                                <button name="commentBtn" type="submit" id="submit-button" tabindex="5" value="Submit" class="btn btn-outline-primary-2 button-rounded m-0">
                                  <span>Post Comment</span>
                                  <i class="icon-long-arrow-right"></i>
                                </button>
              
                                <div class="my-3 d-none">
                                  <div class="loading">Loading</div>
                                  <div class="sent-message">Your message has been sent. Thank you!</div>
                                </div>
                              </form>
        
                            </div><!-- #respond end -->';
        }
      }
      
      return $data;
    }
    
    public function blogCommentsCount($bid)
    {
      $data   = 0;
      $sql    = "SELECT COUNT(bcid) AS lops FROM blog_comments WHERE post='" . $bid . "' ";
      $result = $this->selectQuery($sql);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $data = $row['lops'];
        }
      }
      
      return $data;
    }
    
    public function showBlogSearch($search)
    {
      $term   = esc($search);
      $data   = "<p>No search result found.</p>";
      $sql    = "SELECT * FROM blogs WHERE title LIKE '%" . $term . "%' || description LIKE '%" . $term . "%' || author LIKE '%" . $term . "%' || tags LIKE '%" . $term . "%' ";
      $result = $this->runSQL($sql);
      if ($result->num_rows > 0) {
        $data = '';
        while ($row = $result->fetch_assoc()) {
          $data .= '<article class="entry" data-aos="fade-up">

                    <div class="entry-img">
                      <img src="' . str_replace("../", "", $row['image']) . '" alt="Blog Image" class="img-fluid">
                    </div>
      
                    <h2 class="entry-title">
                      <a href="article?id=' . ($row['bid']) . '">' . $row['title'] . '</a>
                    </h2>
      
                    <div class="entry-meta">
                      <ul>
                        <li class="d-flex align-items-center"><i class="icofont-user"></i> <a href="javascript:void(0)">' . $row['author'] . '</a></li>
                        <li class="d-flex align-items-center"><i class="icofont-wall-clock"></i> <a href="javascript:void(0)"><time datetime="' . $row['regdate'] . '">' . dates($row['regdate']) . '</time></a></li>
                        <li class="d-flex align-items-center"><i class="icofont-comment"></i> <a href="javascript:void(0)">' . $this->blogCommentsCount($row['bid']) . '</a></li>
                      </ul>
                    </div>
      
                    <div class="entry-content">
                      <p>' . reduceWords(strip_tags($row['description']), 340) . '</p>
                      <div class="read-more">
                        <a href="article?id=' . ($row['bid']) . '">Read More</a>
                      </div>
                    </div>
      
                  </article>';
        }
      }
      
      return $data;
    }
    
    public function showBlogsCategories()
    {
      $data   = '';
      $sql    = "SELECT * FROM blogs_categories ORDER BY category";
      $result = $this->selectQuery($sql);
      if ($result->num_rows > 0) {
        $data = '<ul class="menu-cat entry-filter justify-content-center">
                  <li class="active"><a href="javascript:void(0)" data-filter="*">All Blog<span>' . $this->allBlogsCount() . '</span></a></li>' . PHP_EOL;
        while ($row = $result->fetch_assoc()) {
          $data .= '<li><a href="javascript:void(0)" data-filter=".' . $row['category'] . '">' . $row['category'] . '<span>' . $this->categoryBlogsCount($row['bcid']) . '</span></a></li>' . PHP_EOL;
        }
        $data .= '</ul>';
      }
      
      return $data;
    }
    
    private function allBlogsCount()
    {
      $sql    = "SELECT COUNT(bid) AS lops FROM blogs";
      $result = $this->selectQuery($sql)->fetch_assoc();
      return $result['lops'];
    }
    
    private function categoryBlogsCount($bcid)
    {
      $data   = 0;
      $id     = esc($bcid);
      $sql    = "SELECT COUNT(bid) AS lops FROM blogs WHERE category=? ";
      $params = [$id];
      $result = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $data = $row['lops'];
        }
      }
      
      return $data;
    }
    
    public function showPopularBlogs($numberOfPosts)
    {
      $data   = '<p>No recent blogs found.</p>';
      $sql    = "SELECT * FROM blogs ORDER BY views DESC LIMIT " . $numberOfPosts;
      $result = $this->selectQuery($sql);
      if ($result->num_rows > 0) {
        $data = '';
        while ($row = $result->fetch_assoc()) {
          $data .= '<li>
                    <figure>
                      <a href="blog.php?id=' . ($row['bid']) . '">
                        <img src="'.str_replace("../", "", explode(', ', $row['image']))[0].'" alt="post">
                      </a>
                    </figure>
                    
                    <div>
                      <span>'.date('M d, Y', strtotime($row['regdate'])).'</span>
                      <h4><a href="blog.php?id=' . ($row['bid']) . '">' . $row['title'] . '</a></h4>
                    </div>
                  </li>';
        }
      }
      
      return $data;
    }
    
    public function showRecentBlogs($numberOfPosts)
    {
      $data   = '<p>No recent blogs found.</p>';
      $sql    = "SELECT * FROM blogs ORDER BY bid DESC LIMIT " . $numberOfPosts;
      $result = $this->runSQL($sql);
      if ($result->num_rows > 0) {
        $data = '';
        while ($row = $result->fetch_assoc()) {
          $data .= '<div class="entry col-12">
                      <div class="grid-inner row g-0">
                        <div class="col-auto">
                          <div class="entry-image">
                            <a href="blog.php?id=' . ($row['bid']) . '"><img class="rounded-circle" src="' . str_replace("../", "", $row['image']) . '" alt="Image"></a>
                          </div>
                        </div>
                        <div class="col ps-3">
                          <div class="entry-title">
                            <h4><a href="blog.php?id=' . ($row['bid']) . '">' . $row['title'] . '</a></h4>
                          </div>
                          <div class="entry-meta">
                            <ul>
                              <li><i class="icon-comments-alt"></i> ' . $this->blogCommentsCount($row['bid']) . ' Comments</li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>';
        }
      }
      
      return $data;
    }
    
    public function showRecentBlogsHome($numberOfPosts)
    {
      $data   = '<p>No recent blogs found.</p>';
      $sql    = "SELECT * FROM blogs ORDER BY bid DESC LIMIT " . $numberOfPosts;
      $result = $this->selectQuery($sql);
      if ($result->num_rows > 0) {
        $data = '';
        while ($row = $result->fetch_assoc()) {
          $data .= '<article class="entry">
                      <figure class="entry-media">
                        <a href="blog.php?id='.($row['bid']).'">
                          <img src="' . explode(", ", str_replace("../", "", $row['image']))[0] . '" alt="Image" style="height: 200px; object-fit: fill; margin: auto">
                        </a>
                      </figure><!-- End .entry-media -->
                      
                      <div class="entry-body">
                        <div class="entry-meta">
                          <a href="#">'.dates($row['regdate']).'</a>, ' . $this->blogCommentsCount($row['bid']) . ' Comments
                        </div><!-- End .entry-meta -->
                        
                        <h3 class="entry-title">
                          <a href="blog.php?id='.($row['bid']).'">' . $row['title'] . '</a>
                        </h3><!-- End .entry-title -->
                        
                        <div class="entry-content">
                          <p>'.reduceWords(nl2br(strip_tags($row['description'])), 90).'</p>
                          <a href="blog.php?id='.($row['bid']).'" class="read-more">Read More</a>
                        </div><!-- End .entry-content -->
                      </div><!-- End .entry-body -->
                    </article><!-- End .entry -->';
        }
      }
      
      return $data;
    }
    
    public function showTags($blogId)
    {
      $id     = ($blogId);
      $data   = '';
      $sql    = "SELECT * FROM blogs WHERE bid='" . $id . "' ";
      $result = $this->selectQuery($sql);
      if ($result->num_rows > 0) {
        $row  = $result->fetch_assoc();
        $data = '';
        $tags = explode(", ", $row['tags']);
        foreach ($tags as $tag) {
          $data .= '<a href="javascript:void(0)">' . $tag . '</a>';
        }
        
      }
      
      return $data;
    }
    
    public function showBlogsInCategory($categoryId)
    {
      $data   = "<p>No articles found for the selected category.</p>";
      $cat    = ($categoryId);
      $sql    = "SELECT * FROM blogs WHERE category='" . $cat . "' ";
      $result = $this->runSQL($sql);
      if ($result->num_rows > 0) {
        $data = '';
        while ($row = $result->fetch_assoc()) {
          $data .= '<article class="entry" data-aos="fade-up">

                    <div class="entry-img">
                      <img src="' . str_replace("../", "", $row['image']) . '" alt="Blog Image" class="img-fluid">
                    </div>
      
                    <h2 class="entry-title">
                      <a href="article?id=' . ($row['bid']) . '">' . $row['title'] . '</a>
                    </h2>
      
                    <div class="entry-meta">
                      <ul>
                        <li class="d-flex align-items-center"><i class="icofont-user"></i> <a href="javascript:void(0)">' . $row['author'] . '</a></li>
                        <li class="d-flex align-items-center"><i class="icofont-wall-clock"></i> <a href="javascript:void(0)"><time datetime="' . $row['regdate'] . '">' . dates($row['regdate']) . '</time></a></li>
                        <li class="d-flex align-items-center"><i class="icofont-comment"></i> <a href="javascript:void(0)">' . $this->blogCommentsCount($row['bid']) . '</a></li>
                      </ul>
                    </div>
      
                    <div class="entry-content">
                      <p>' . reduceWords(strip_tags($row['description']), 340) . '</p>
                      <div class="read-more">
                        <a href="article?id=' . ($row['bid']) . '">Read More</a>
                      </div>
                    </div>
      
                  </article>';
        }
      }
      
      return $data;
    }
  
    public function showBlogsCategoriesSingleBlog()
    {
      $data = '';
      $sql = "SELECT * FROM blogs_categories ORDER BY category ASC";
      $result = $this->selectQuery($sql);
      while ($row = $result->fetch_assoc()) {
        $data .= '<li><a href="blogs.php">'.$row['category'].'<span>'.$this->categoryBlogsCount($row['bcid']).'</span></a></li>';
      }
      return $data;
    }
    
    public function writeComment($post, $commentId, $full_name, $email, $comment)
    {
      $art   = ($post);
      $reply = (is_int($commentId) ? 0 : ($commentId));
      $name  = esc($full_name);
      $mail  = esc($email);
      $com   = esc($comment);
      $date  = date("Y-m-d H:i:s", $_SERVER['REQUEST_TIME']);
      $sql   = "INSERT INTO blog_comments (post, commentId, full_name, email, comment, regdate) VALUES (?, ?, ?, ?, ?, ?)";
      $params = [$art, $reply, $name, $mail, $com, $date];
      if ($this->insertQuery($sql, $params)) {
        echo "Comment added successfully";
        echo "<script>
                $('form').reset();
              </script>";
      } else {
        echo "Our comment system has some error, we apologise for the inconveniences caused.";
      }
    }
    
    public function showBlogComments($postId)
    {
      $data   = '<p>Be the first person to add a comment.</p>';
      $post   = ($postId);
      $sql    = "SELECT * FROM blog_comments WHERE post='" . $post . "' && commentId=0 ";
      $result = $this->selectQuery($sql);
      if ($result->num_rows > 0) {
        $no   = 1;
        $data = '<ul>';
        while ($row = $result->fetch_assoc()) {
          $id   = ($row['bcid']);
          $data .= '<li>
                      <div class="comment">
                        <figure class="comment-media">
                          <a href="javascript:void(0)">
                            <img alt="Image" src="https://1.gravatar.com/avatar/' . md5($row['email']) . '?s=40&amp;d=http%3A%2F%2F1.gravatar.com%2Favatar%2Fad516503a11cd5ca435acc9bb6523536%3Fs%3D40&amp;r=G" class="avatar avatar-40 photo"
                                         height="40" width="40"/>
                          </a>
                        </figure>
                        
                        <div class="comment-body">
                          <a href="javascript:void(0)" data-id="' . $id . '" class="comment-reply commentReply">Reply</a>
                          <div class="comment-user">
                            <h4><a href="javascript:void(0)">' . $row['full_name'] . '</a></h4>
                            <span class="comment-date">' . datel($row['regdate']) . '</span>
                          </div><!-- End .comment-user -->
                          
                          <div class="comment-content">
                            <p>' . nl2br($row['comment']) . '</p>
                          </div><!-- End .comment-content -->
                        </div><!-- End .comment-body -->
                      </div><!-- End .comment -->
                      ' . $this->listReplies($post, $row['bcid']) . '
                    </li>';
          $no++;
        }
        $data .= '</ul>';
      }
      
      return $data;
    }
    
    public function listReplies($postId, $commentId)
    {
      $data   = '';
      $sql    = "SELECT * FROM blog_comments WHERE post=0 && commentId='" . $commentId . "' ";
      $result = $this->selectQuery($sql);
      if ($result->num_rows > 0) {
        $data .= '<ul>';
        while ($row = $result->fetch_assoc()) {
          $data .= '<li>
                      <div class="comment">
                        <figure class="comment-media">
                          <a href="javascript:void(0)">
                            <img alt="Image" src="https://1.gravatar.com/avatar/' . md5($row['email']) . '?s=40&amp;d=http%3A%2F%2F1.gravatar.com%2Favatar%2Fad516503a11cd5ca435acc9bb6523536%3Fs%3D40&amp;r=G" class="avatar avatar-40 photo"
                                     height="40" width="40"/>
                          </a>
                        </figure>
                        
                        <div class="comment-body">
                          <div class="comment-user">
                            <h4><a href="javascript:void(0)">' . $row['full_name'] . '</a></h4>
                            <span class="comment-date">' . datel($row['regdate']) . '</span>
                          </div><!-- End .comment-user -->
                          
                          <div class="comment-content">
                            <p>' . nl2br($row['comment']) . '</p>
                          </div><!-- End .comment-content -->
                        </div><!-- End .comment-body -->
                      </div><!-- End .comment -->
                    </li>';
        }
        $data .= '</ul>';
      }
      
      return $data;
    }
    
    public function postAuthor($postId)
    {
      $data   = "";
      $post   = ($postId);
      $sql    = "SELECT * FROM blogs WHERE bid='" . $post . "' ";
      $result = $this->runSQL($sql);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $data = '<img src="' . str_replace("../", "", $this->userProfileImage($row['author'])) . '" class="rounded-circle float-left" alt="">
                    <h4>' . $row['author'] . '</h4>
                    <div class="social-links">
                      <a href="https://twitters.com/#"><i class="icofont-twitter"></i></a>
                      <a href="https://facebook.com/#"><i class="icofont-facebook"></i></a>
                      <a href="https://instagram.com/#"><i class="icofont-instagram"></i></a>
                    </div>
                    <p>
                      ' . $this->aboutUser($row['author']) . '
                    </p>';
        }
      }
      return $data;
    }
    
    public function blogViewed($blogId)
    {
      $id     = ($blogId);
      $sql    = "UPDATE blogs SET views=(views+1) WHERE bid=? ";
      $params = [$id];
      $this->updateQuery($sql, $params);
    }
    
    private function blogImages($bid)
    {
      $data   = '';
      $sql    = "SELECT * FROM blogs WHERE bid=? ";
      $params = [$bid];
      $result = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        $row  = $result->fetch_assoc();
        $imgs = (str_contains($row['image'], ", ")) ? explode(", ", $row['image']) : [$row['image']];
        foreach ($imgs as $img) {
          $data .= '<a href="blog.php?id=' . ($bid) . '">
                      <img src="' . URL . '' . str_replace("../", "", $img) . '" alt="blog image">
                    </a>';
        }
      }
      
      return $data;
    }
    
    private function singleBlogImages($bid)
    {
      $data   = '';
      $sql    = "SELECT * FROM blogs WHERE bid='" . $bid . "' ";
      $result = $this->selectQuery($sql);
      if ($result->num_rows > 0) {
        $row  = $result->fetch_assoc();
        $imgs = (str_contains($row['image'], ", ")) ? explode(", ", $row['image']) : [$row['image']];
        foreach ($imgs as $img) {
          $data .= '<div class="slide"><a href="' . URL . '' . str_replace("../", "", $img) . '" data-lightbox="gallery-item" style="background: url(\'' . URL . '' . str_replace("../", "",
              $img) . '\') no-repeat center bottom; background-size: cover; height: 400px;"></a></div>';
        }
      }
      
      return $data;
    }
    
    private function blogCategory($category)
    {
      $data   = "";
      $sql    = "SELECT * FROM blogs_categories WHERE bcid='" . $category . "' ";
      $result = $this->selectQuery($sql);
      if ($result->num_rows > 0) {
        $row  = $result->fetch_assoc();
        $data = $row['category'];
      }
      
      return $data;
    }
    
    public function pageDetails($pageId)
    {
      $row    = [];
      $id     = ($pageId);
      $sql    = "SELECT * FROM blogs WHERE bid='" . $id . "' ";
      $result = $this->runSQL($sql);
      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
      }
      return $row;
    }
    
    public function relatedBlogs($blogId)
    {
      $blogs  = '';
      $id     = ($blogId);
      $sql    = "SELECT * FROM blogs WHERE bid!=? ORDER BY RAND() LIMIT 8";
      $params = [$id];
      $result = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $blogs .= '<article class="entry entry-grid">
                      <figure class="entry-media">
                        <a href="blog.php?id=' . ($row['bid']) . '">
                          <img src="' . str_replace("../", "", explode(", ", $row['image'])[0]) . '" alt="image desc">
                        </a>
                      </figure><!-- End .entry-media -->
                      
                      <div class="entry-body">
                        <div class="entry-meta">
                          <a href="javascript:void(0)">' . date('M d, Y', strtotime($row['regdate'])) . '</a>
                          <span class="meta-separator">|</span>
                          <a href="blog.php?id=' . ($row['bid']) . '#comments">' . $this->blogCommentsCount($row['bid']) . ' Comments</a>
                        </div><!-- End .entry-meta -->
                        
                        <h2 class="entry-title">
                          <a href="blog.php?id=' . ($row['bid']) . '">' . $row['title'] . '</a>
                        </h2><!-- End .entry-title -->
                        
                        <div class="entry-cats">
                          in <a href="javascript:void(0)">' . $this->blogCategory($row['bid']) . '</a>
                        </div><!-- End .entry-cats -->
                      </div><!-- End .entry-body -->
                    </article><!-- End .entry -->';
        }
      }
      
      return $blogs;
    }
    
  }
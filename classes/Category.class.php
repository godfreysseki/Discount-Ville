<?php
  
  
  class Category extends Config
  {
    private AuditTrail $auditTrail;
    
    public function __construct()
    {
      parent::__construct();
      $this->auditTrail = new AuditTrail();
    }
    
    public function getCategories()
    {
      $sql    = "SELECT * FROM categories";
      $result = $this->selectQuery($sql);
      
      $categories = [];
      while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
      }
      
      return $categories;
    } // TODO - Remove it is unused method
    
    public function getSubcategories()
    {
      $sql    = "SELECT * FROM categories WHERE parent_category_id != ?";
      $result = $this->selectQuery($sql, [0]);
      
      $subcategories = [];
      while ($row = $result->fetch_assoc()) {
        $subcategories[] = $row;
      }
      
      return $subcategories;
    }
    
    public function addCategory($categoryName)
    {
      $sql        = "INSERT INTO categories (category_name) VALUES (?)";
      $categoryId = $this->insertQuery($sql, [$categoryName]);
      return $categoryId;
    } // TODO - Remove it is unused method
    
    public function addSubcategory($categoryId, $subcategoryName)
    {
      $sql           = "INSERT INTO subcategories (category_id, subcategory_name) VALUES (?, ?)";
      $subcategoryId = $this->insertQuery($sql, [$categoryId, $subcategoryName]);
      return $subcategoryId;
    } // TODO - Remove it is unused method
    
    
    public function renderCategoryForm($categoryId = null)
    {
      if ($categoryId) {
        // Load existing category data if editing an existing category.
        $category = $this->getCategoryById($categoryId);
        $action   = 'edit';
      } else {
        $category = ['category_id' => '', 'banner' => '', 'category_name' => '', 'parent_category_id' => ''];
        $action   = 'add';
      }
      
      $form = '<form method="post" enctype="multipart/form-data">
                <input type="hidden" name="action" value="' . $action . '">
                <input type="hidden" name="category_id" value="' . $category['category_id'] . '">
                <div class="form-group">
                  <label for="banner">Category Image: ' . (isset($category['banner']) ? "(" . $category['banner'] . ")" : "") . '</label>
                  <input type="file" name="banner" id="banner" accept="image/*" class="form-control">
                </div>
                <div class="form-group">
                  <label for="category_name">Category Name:</label>
                  <input type="text" name="category_name" id="category_name" value="' . $category['category_name'] . '" class="form-control" required>
                </div>
                <div class="form-group">
                  <label for="parent_category">Parent Category:</label>
                  <select name="parent_category" id="parent_category" class="custom-select select2">
                    <option value="">Select a parent category</option>';
      
      // Fetch all existing categories to populate the dropdown.
      $categories = $this->getParentCategories();
      foreach ($categories as $cat) {
        $selected = ($cat['category_id'] == $category['parent_category_id']) ? 'selected' : '';
        $form     .= '<option value="' . $cat['category_id'] . '" ' . $selected . '>' . $cat['category_name'] . '</option>';
      }
      
      $form .= '</select>
                </div>
                <div class="form-group">
                  <input type="submit" value="Save Category" class="btn btn-primary">
                </div>
              </form>';
      
      return $form;
    }
    
    public function processCategory($postData)
    {
      $id             = "";
      $action         = $postData['action'];
      $categoryName   = $postData['category_name'];
      $parentCategory = $postData['parent_category'];
      
      $categoryBanner  = $this->getCategoryBanner($postData['category_id']);
      
      // Handle image uploads
      if (!empty($_FILES['banner']['name'])) {
        $uploadDir = '../assets/img/categories/';
        if (is_uploaded_file($_FILES['banner']['tmp_name'])) {
          $uniqueFilename = 'category_' . uniqid() . '.' . pathinfo($_FILES['banner']['name'], PATHINFO_EXTENSION);
          $uploadFile     = $uploadDir . $uniqueFilename;
          
          if (move_uploaded_file($_FILES['banner']['tmp_name'], $uploadFile)) {
            // Image uploaded successfully
            if (isset($categoryBanner) && !empty($categoryBanner)) {
              if (file_exists($uploadDir.$categoryBanner)) {
                unlink($uploadDir.$categoryBanner);
              }
            }
            // Remove old image from the folder if it exists
            $categoryBanner = $uniqueFilename;
          }
        }
      }
      
      if ($action == 'add') {
        // Insert new category into the database.
        $sql    = 'INSERT INTO categories (banner, category_name, parent_category_id) VALUES (?, ?, ?)';
        $params = [$categoryBanner, $categoryName, $parentCategory];
        $id     = $this->insertQuery($sql, $params);
      } elseif ($action == 'edit') {
        // Update an existing category in the database.
        $categoryId = $postData['category_id'];
        $sql        = 'UPDATE categories SET banner=?, category_name = ?, parent_category_id = ? WHERE category_id = ?';
        $params     = [$categoryBanner, $categoryName, $parentCategory, $categoryId];
        $id         = $this->updateQuery($sql, $params);
      }
      return $id;
    }
  
    private function getCategoryBanner($category_id)
    {
      $sql = "SELECT * FROM categories WHERE category_id=?";
      $params = [$category_id];
      $result = $this->selectQuery($sql, $params)->fetch_assoc();
      return $result['banner'];
    }
    
    public function getCategoryById($categoryId)
    {
      $sql    = 'SELECT * FROM categories WHERE category_id = ?';
      $params = [$categoryId];
      $result = $this->selectQuery($sql, $params);
      
      if ($result->num_rows == 1) {
        return $result->fetch_assoc();
      }
      
      return null; // Return null if the category is not found.
    }
    
    public function getAllCategories()
    {
      $sql    = 'SELECT * FROM categories';
      $result = $this->selectQuery($sql);
      
      $categories = [];
      while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
      }
      
      return $categories;
    }
    
    public function getParentCategories()
    {
      $sql    = 'SELECT * FROM categories WHERE parent_category_id=?';
      $params = [0];
      $result = $this->selectQuery($sql, $params);
  
      $categories = [];
      while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
      }
  
      return $categories;
    }
  
    public function getChildCategories($parent_category_id)
    {
      $sql = "SELECT * FROM categories WHERE parent_category_id=?";
      $params = [$parent_category_id];
      $result = $this->selectQuery($sql, $params);
  
      $categories = [];
      while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
      }
  
      return $categories;
    }
    
    public function countSubCategories($category_id)
    {
      $data   = 0;
      $sql    = "SELECT count(category_id) AS num FROM categories WHERE parent_category_id=?";
      $params = [$category_id];
      $result = $this->selectQuery($sql, $params)->fetch_assoc();
      $data   = $result['num'];
      return $data;
    }
    
    // Method to count products for a given category_id (including subcategories)
    public function countProductsForCategory($categoryId)
    {
      $sql    = "SELECT COUNT(*) AS product_count FROM products WHERE category_id = $categoryId
            OR category_id IN (SELECT category_id FROM categories WHERE parent_category_id = $categoryId || category_id = $categoryId)";
      $result = $this->selectQuery($sql);
      $row    = $result->fetch_assoc();
      return $row['product_count'];
    }
    
    // Modified showCategoriesPage method
    public function showCategoriesPage()
    {
      $sql    = "SELECT * FROM categories WHERE parent_category_id = 0";
      $result = $this->selectQuery($sql);
      
      // Initialize an empty string to store the HTML for categories
      $categoryHTML = '';
      
      while ($row = $result->fetch_assoc()) {
        $categoryId   = $row['category_id'];
        $categoryName = $row['category_name'];
        $banner       = $row['banner'];
        
        // Count products for the current category and subcategories
        $productCount = $this->countProductsForCategory($categoryId);
        
        // Create HTML for each category item
        $categoryHTML .= '
            <div class="category-item">
                <div class="banner banner-cat mb-0 banner-badge">
                    <img src="assets/img/categories/' . $banner . '" alt="' . $categoryName . '">
                    
                    <a class="banner-link" href="category.php?id=' . $categoryId . '">
                        <h3 class="banner-title">' . $categoryName . '</h3>
                        <h4 class="banner-subtitle">' . $productCount . ' Product' . ($productCount != 1 ? 's' : '') . '</h4>
                        <span class="banner-link-text">Shop Now</span>
                    </a>
                </div>
            </div>';
      }
      
      // Wrap the generated category items in the container div
      $categoryHTML = '<div class="category-grid" data-masonry=\'{
        "columnWidth": ".category-item",
        "transitionDuration":"0.8s",
        "horizontalOrder":true,
        "originLeft": true,
        "originTop": true,
        "itemSelector": ".category-item"
    }\'>' . $categoryHTML . '</div>';
      
      return $categoryHTML;
    }
    
  }

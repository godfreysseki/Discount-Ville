<?php
  
  // Your other classes that extend Config class
  require_once 'Config.class.php';
  
  class products extends Config
  {
    private $auditTrail;
    
    public function __construct()
    {
      parent::__construct();
      $this->auditTrail = new AuditTrail();
    }
    
    // Add a new product to the database
    public function addProduct($productData)
    {
      if (isset($productData['product_id']) && !empty($productData['product_id'])) {
        $productImages  = $this->getProductImages($productData['product_id']);
        $uploadedImages = array();
        
        // Handle image uploads
        if (!empty($_FILES['images']['name'][0])) {
          $uploadDir = '../assets/img/products/';
          
          foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            if (is_uploaded_file($tmp_name)) {
              $uniqueFilename = 'product_' . uniqid() . '.' . pathinfo($_FILES['images']['name'][$key], PATHINFO_EXTENSION);
              $uploadFile     = $uploadDir . $uniqueFilename;
              
              if (move_uploaded_file($tmp_name, $uploadFile)) {
                // Image uploaded successfully, add it to the list of uploaded images
                $uploadedImages[] = $uniqueFilename;
              }
            }
          }
          
          // Remove old images
          foreach ($productImages as $oldImage) {
            if (!in_array($oldImage, $uploadedImages)) {
              unlink($uploadDir . $oldImage);
            }
          }
          
          // Update product data & images in the database
          $sql    = "UPDATE products SET vendor_id=?, category_id=?, product_name=?, short_description=?, product_description=?, additional_information=?, quantity_in_stock=?, reorder_level=?, original_price=?, current_price=?, color=?, weight=?, measurements=?, product_image=? WHERE product_id=?";
          $params = [
            $productData['vendor_id'],
            $productData['category_id'],
            $productData['product_name'],
            $productData['short_description'],
            $productData['product_description'],
            null,
            $productData['quantity_in_stock'],
            $productData['reorder_level'],
            $productData['original_price'],
            $productData['current_price'],
            $productData['color'],
            $productData['weight'],
            $productData['measurements'],
            implode(", ", $uploadedImages),
            $productData['product_id']
          ];
          return $this->insertQuery($sql, $params);
        }
      } else {
        // Handle image uploads for a new product
        $uploadedImages = array();
        
        if (!empty($_FILES['images']['name'][0])) {
          $uploadDir = '../assets/img/products/';
          
          foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            if (is_uploaded_file($tmp_name)) {
              $uniqueFilename = 'product_' . uniqid() . '.' . pathinfo($_FILES['images']['name'][$key], PATHINFO_EXTENSION);
              $uploadFile     = $uploadDir . $uniqueFilename;
              
              if (move_uploaded_file($tmp_name, $uploadFile)) {
                // Image uploaded successfully, add it to the list of uploaded images
                $uploadedImages[] = $uniqueFilename;
              }
            }
          }
          // Insert product data to the database
          $sql    = "INSERT INTO products (vendor_id, category_id, product_name, short_description, product_description, additional_information, quantity_in_stock, reorder_level, original_price, current_price, color, weight, measurements, product_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
          $params = [
            $productData['vendor_id'],
            $productData['category_id'],
            $productData['product_name'],
            $productData['short_description'],
            $productData['product_description'],
            null,
            $productData['quantity_in_stock'],
            $productData['reorder_level'],
            $productData['original_price'],
            $productData['current_price'],
            $productData['color'],
            $productData['weight'],
            $productData['measurements'],
            implode(", ", $uploadedImages)
          ];
          return $this->insertQuery($sql, $params);
        }
      }
    }
    
    // Add a new product to the database
    public function addProductClient($productData)
    {
      if ($productData['product_id']) {
        $productImages  = $this->getProductImages($productData['product_id']);
        $uploadedImages = [];
        
        //dnd($_FILES['images']['name'][0]);
        
        // Handle image uploads
        if (isset($_FILES['images']['name'][0]) && !empty($_FILES['images']['name'][0])) {
          $uploadDir = '../assets/img/products/';
  
          foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            if (is_uploaded_file($tmp_name)) {
              $uniqueFilename = 'product_' . uniqid() . '.' . pathinfo($_FILES['images']['name'][$key], PATHINFO_EXTENSION);
              $uploadFile     = $uploadDir . $uniqueFilename;
      
              if (move_uploaded_file($tmp_name, $uploadFile)) {
                // Image uploaded successfully, add it to the list of uploaded images
                $uploadedImages[] = $uniqueFilename;
              }
            }
          }
        }
  
        // Remove old images only if there are new uploaded images
        if (!empty($uploadedImages)) {
          $uploadDir = '../assets/img/products/';
  
          foreach ($productImages as $oldImage) {
            if (!in_array($oldImage, $uploadedImages)) {
              if (file_exists($uploadDir . $oldImage)) {
                unlink($uploadDir . $oldImage); // Delete old images
              }
            }
          }
        }
        
        // Update product data & images in the database
        $sql    = "UPDATE products SET vendor_id=?, category_id=?, product_name=?, short_description=?, product_description=?, additional_information=?, quantity_in_stock=?, reorder_level=?, original_price=?, current_price=?, color=?, weight=?, measurements=?, product_image=?, product_state=?, spare_part=? WHERE product_id=?";
        $params = [
          $this->getVendorId(),
          $productData['category_id'],
          $productData['product_name'],
          $productData['short_description'],
          $productData['product_description'],
          null,
          $productData['quantity_in_stock'],
          $productData['reorder_level'],
          $productData['original_price'],
          $productData['current_price'],
          implode(", ", $productData['color']),
          $productData['weight'],
          $productData['measurements'],
          (!empty($uploadedImages[0]) ? implode(", ", $uploadedImages) : implode(", ", $productImages)),
          $productData['product_state'],
          $productData['spare_part'] ?? "No",
          $productData['product_id']
        ];
        if ($this->updateQuery($sql, $params)) {
          return ['status' => 'success', 'message'=>'Product Updated Successfully.'];
        } else {
          return ['status' => 'warning', 'message'=>'Product Updates Failed.'];
        }
        
      } else {
        // Handle image uploads for a new product
        $uploadedImages = array();
        
        if (!empty($_FILES['images']['name'][0])) {
          $uploadDir = '../assets/img/products/';
          
          foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            if (is_uploaded_file($tmp_name)) {
              $uniqueFilename = 'product_' . uniqid() . '.' . pathinfo($_FILES['images']['name'][$key], PATHINFO_EXTENSION);
              $uploadFile     = $uploadDir . $uniqueFilename;
              
              if (move_uploaded_file($tmp_name, $uploadFile)) {
                // Image uploaded successfully, add it to the list of uploaded images
                $uploadedImages[] = $uniqueFilename;
              }
            }
          }
          // Insert product data to the database
          $sql    = "INSERT INTO products (vendor_id, category_id, product_name, short_description, product_description, additional_information, quantity_in_stock, reorder_level, original_price, current_price, color, weight, measurements, product_image, product_state, spare_part) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
          $params = [
            $this->getVendorId(),
            $productData['category_id'],
            $productData['product_name'],
            $productData['short_description'],
            $productData['product_description'],
            null,
            $productData['quantity_in_stock'],
            $productData['reorder_level'],
            $productData['original_price'],
            $productData['current_price'],
            implode(", ", $productData['color']),
            $productData['weight'],
            $productData['measurements'],
            implode(", ", $uploadedImages),
            $productData['product_state'],
            $productData['spare_part'] ?? "No"
          ];
          if ($this->insertQuery($sql, $params)) {
            return ['status' => 'success', 'message'=>'Product Added Successfully.'];
          } else {
            return ['status' => 'warning', 'message'=>'Product Addition Failed.'];
          }
        }
      }
    }
    
    public function getProductImages($productId)
    {
      $sql    = "SELECT * FROM products WHERE product_id=?";
      $params = [$productId];
      $result = $this->selectQuery($sql, $params)->fetch_assoc();
      return explode(", ", $result['product_image']);
    }
    
    // Get the product form for adding a new product or updating an existing one
    public function productForm($productId = null)
    {
      // Define the product data array with empty values for the form
      $productData = [
        'product_id' => '',
        'vendor_id' => '',
        'category_id' => '',
        'product_name' => '',
        'short_description' => '',
        'product_description' => '',
        'additional_information' => '',
        'quantity_in_stock' => '',
        'reorder_level' => '',
        'original_price' => '',
        'current_price' => '',
        'color' => '',
        'weight' => '',
        'measurements' => '',
        'product_image' => ''
      ];
      
      // If $productId is provided, fetch the product data from the database
      if ($productId !== null) {
        $productData = $this->getProductById($productId);
      }
      
      // Add Vendors to a combo
      $vens    = new Vendors();
      $vendors = $vens->getAllVendors();
      $vendos  = "";
      foreach ($vendors as $vendor) {
        $vendos .= '<option value="' . $vendor['vendor_id'] . '" ' . ($productData['vendor_id'] === $vendor['vendor_id'] ? " selected" : "") . '>' . $vendor['full_name'] . ' of ' . $vendor['shop_name'] . '</option>';
      }
      
      // Add Categories to a combo
      $cat        = new Category();
      $cats       = $cat->getSubCategories();
      $categories = '';
      foreach ($cats as $cat) {
        $categories .= '<option value="' . $cat['category_id'] . '" ' . ($productData['category_id'] === $cat['category_id'] ? " selected" : "") . '>' . $cat['category_name'] . '</option>';
      }
      
      // Get the colors from the database and convert them into an array
      $productColors = explode(', ', $productData['color']);
      // List of available colors in the dropdown
      $availableColors = [
        '#000000' => 'Black',
        '#FFFFFF' => 'White',
        '#C0C0C0' => 'Silver',
        '#FFD700' => 'Gold',
        '#FF0000' => 'Red',
        '#0000FF' => 'Blue',
        '#008000' => 'Green',
        '#FFFF00' => 'Yellow',
        '#FFA500' => 'Orange',
        '#800080' => 'Purple',
        '#808080' => 'Gray',
        '#A52A2A' => 'Brown',
        '#FFC0CB' => 'Pink',
        '#40E0D0' => 'Turquoise',
        '#008080' => 'Teal',
        '#FF00FF' => 'Magenta',
        '#E6E6FA' => 'Lavender',
        '#808000' => 'Olive',
        '#00FFFF' => 'Cyan',
        '#F5F5DC' => 'Beige',
      ];
      
      $colorsCombo = '';
      foreach ($availableColors as $colorCode => $colorName) {
        $selected    = in_array($colorCode, $productColors) ? 'selected' : '';
        $colorsCombo .= '<option value="' . $colorCode . '" ' . $selected . '>' . $colorName . ' - ' . $colorCode . '</option>';
      }
      
      // Start building the HTML form
      $form = '<form method="post" enctype="multipart/form-data">
                  <input type="hidden" name="product_id" value="' . $productId . '">
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="image">Product Images <small>(Maximum 4 Images will be taken.)</small></label>
                        <input type="file" class="form-control-file" id="image" name="images[]" accept="image/*" multiple>
                      </div>
                      <div class="form-group">
                        <label for="product_name">Product Name</label>
                        <input type="text" class="form-control" id="product_name" name="product_name" value="' . esc($productData['product_name']) . '" required>
                      </div>
                      <div class="form-group">
                        <label for="short_description">Short Description</label>
                        <textarea class="form-control" id="short_description" name="short_description" rows="4">' . esc($productData['short_description']) . '</textarea>
                      </div>
                      <div class="form-group">
                        <label for="product_description">Full Description</label>
                        <textarea class="form-control editor" id="product_description" name="product_description" rows="4">' . esc($productData['product_description']) . '</textarea>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="original_price">Original Price</label>
                        <input type="number" step="0.01" class="form-control" id="original_price" name="original_price" value="' . esc($productData['original_price']) . '" required>
                      </div>
                      <div class="form-group">
                        <label for="current_price">Current Price</label>
                        <input type="number" step="0.01" class="form-control" id="current_price" name="current_price" value="' . esc($productData['current_price']) . '" required>
                      </div>
                      <!--<div class="form-group">
                        <label for="color">Color</label>
                        <input type="color" class="form-control" id="color" value="' . esc($productData['color']) . '" name="color" required>
                      </div>-->
                      <div class="form-group">
                        <label for="color">Color(s)</label>
                        <select class="custom-select select-custom select2 form-control" multiple id="color" name="color[]" required>
                          ' . $colorsCombo . '
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="weight">Weight (Kg)</label>
                        <input type="number" class="form-control" id="weight" step="0.01" value="' . esc($productData['weight']) . '" name="weight" required>
                      </div>
                      <div class="form-group">
                        <label for="measurements">Measurement</label>
                        <input type="text" class="form-control" id="measurements" value="' . esc($productData['measurements']) . '" name="measurements" required>
                      </div>
                      <div class="form-group">
                        <label for="quantity_in_stock">Quantity in Stock</label>
                        <input type="number" class="form-control" value="' . esc($productData['quantity_in_stock']) . '" id="quantity_in_stock" name="quantity_in_stock">
                      </div>
                      <div class="form-group">
                        <label for="reorder_level">Reorder Level</label>
                        <input type="number" class="form-control" value="' . esc($productData['reorder_level']) . '" id="reorder_level" name="reorder_level">
                      </div>
                      <div class="form-group">
                        <label for="category_id">Category</label>
                        <select class="select2 form-control" id="category_id" name="category_id">
                          <option value="">-- Select Category --</option>
                          ' . $categories . '
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="vendor_id">Vendor</label>
                        <select class="select2 form-control" id="vendor_id" name="vendor_id">
                          <option value="">-- Select Vendor --</option>
                          ' . $vendos . '
                        </select>
                      </div>
                      <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary float-right">' . ($productId !== null ? 'Update' : 'Add') . ' Product</button>
                      </div>
                    </div>
                  </div>
                </form>';
      
      return $form;
    }
    
    // This if for client side
    public function productFormClient($productId = null)
    {
      
      // Define the product data array with empty values for the form
      $productData = [
        'product_id' => '',
        'vendor_id' => '',
        'category_id' => '',
        'product_name' => '',
        'short_description' => '',
        'product_description' => '',
        'additional_information' => '',
        'quantity_in_stock' => '',
        'reorder_level' => '',
        'original_price' => '',
        'current_price' => '',
        'color' => '',
        'weight' => '',
        'measurements' => '',
        'product_state' => '',
        'spare_part' => '',
        'product_image' => ''
      ];
      
      // If $productId is provided, fetch the product data from the database
      if ($productId !== null) {
        $productData = $this->getProductById($productId);
      }
      
      // Add Categories to a combo
      $cat        = new Category();
      $cats       = $cat->getSubCategories();
      $categories = '';
      foreach ($cats as $cat) {
        $categories .= '<option value="' . $cat['category_id'] . '" ' . ($productData['category_id'] === $cat['category_id'] ? " selected" : "") . '>' . $cat['category_name'] . '</option>';
      }
      
      // Get the colors from the database and convert them into an array
      $productColors = explode(', ', $productData['color']);
      // List of available colors in the dropdown
      $availableColors = [
        '#000000' => 'Black',
        '#FFFFFF' => 'White',
        '#C0C0C0' => 'Silver',
        '#FFD700' => 'Gold',
        '#FF0000' => 'Red',
        '#0000FF' => 'Blue',
        '#008000' => 'Green',
        '#FFFF00' => 'Yellow',
        '#FFA500' => 'Orange',
        '#800080' => 'Purple',
        '#808080' => 'Gray',
        '#A52A2A' => 'Brown',
        '#FFC0CB' => 'Pink',
        '#40E0D0' => 'Turquoise',
        '#008080' => 'Teal',
        '#FF00FF' => 'Magenta',
        '#E6E6FA' => 'Lavender',
        '#808000' => 'Olive',
        '#00FFFF' => 'Cyan',
        '#F5F5DC' => 'Beige',
      ];
      
      $colorsCombo = '';
      foreach ($availableColors as $colorCode => $colorName) {
        $selected    = in_array($colorCode, $productColors) ? 'selected' : '';
        $colorsCombo .= '<option value="' . $colorCode . '" ' . $selected . '>' . $colorName . '</option>';
      }
      
      // Start building the HTML form
      $form = '<form method="post" enctype="multipart/form-data">
                  <input type="hidden" name="product_id" value="' . $productId . '">
                  <div class="form-group">
                    <label for="image">Product Images <small>(Maximum 4 Images will be taken.)</small></label>
                    <input type="file" class="form-control-file" id="image" name="images[]" accept="image/*" multiple>
                  </div>
                  <div class="form-group">
                    <label for="product_name">Product Name</label>
                    <input type="text" class="form-control" id="product_name" name="product_name" value="' . esc($productData['product_name']) . '" required>
                  </div>
                  <div class="form-group">
                    <label for="short_description">Short Description</label>
                    <textarea class="form-control" id="short_description" name="short_description" rows="4">' . esc($productData['short_description']) . '</textarea>
                  </div>
                  <div class="form-group">
                    <label for="product_description">Full Description</label>
                    <textarea class="form-control editor" id="product_description" name="product_description" rows="4">' . esc($productData['product_description']) . '</textarea>
                  </div>
                  <div class="form-group">
                    <label for="original_price">Original Price</label>
                    <input type="number" step="0.01" class="form-control" id="original_price" name="original_price" value="' . esc($productData['original_price']) . '" required>
                  </div>
                  <div class="form-group">
                    <label for="current_price">Current Price</label>
                    <input type="number" step="0.01" class="form-control" id="current_price" name="current_price" value="' . esc($productData['current_price']) . '" required>
                  </div>
                  <div class="form-group">
                    <label for="color">Color(s)</label>
                    <select class="custom-select select-custom select2 form-control" multiple id="color" name="color[]" required>
                      ' . $colorsCombo . '
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="weight">Weight (Kg)</label>
                    <input type="number" class="form-control" id="weight" step="0.01" value="' . esc($productData['weight']) . '" name="weight" required>
                  </div>
                  <div class="form-group">
                    <label for="measurements">Measurement</label>
                    <input type="text" class="form-control" id="measurements" value="' . esc($productData['measurements']) . '" name="measurements" required>
                  </div>
                  <div class="form-group">
                    <label for="quantity_in_stock">Quantity in Stock</label>
                    <input type="number" class="form-control" value="' . esc($productData['quantity_in_stock']) . '" id="quantity_in_stock" name="quantity_in_stock">
                  </div>
                  <div class="form-group">
                    <label for="reorder_level">Reorder Level</label>
                    <input type="number" class="form-control" value="' . esc($productData['reorder_level']) . '" id="reorder_level" name="reorder_level">
                  </div>
                  <div class="form-group row">
                    <div class="col-6">
                      <label for="brand_new">
                        <input type="radio" name="product_state" id="brand_new" value="Brand New" ' . (($productData['product_state'] === "Brand New") ? "checked" : "") . ' required class="from-group"> Brand New Product
                      </label>
                    </div>
                    <div class="col-6">
                      <label for="second_hand">
                        <input type="radio" name="product_state" id="second_hand" value="Second Hand" ' . (($productData['product_state'] === "Second Hand") ? "checked" : "") . ' required class="from-group"> Second Hand Product
                      </label>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="spare_part">
                      <input type="checkbox" name="spare_part" id="spare_part" value="Yes" ' . (($productData['spare_part'] === "Yes") ? "checked" : "") . ' class="from-group"> Spare Part Product
                    </label>
                  </div>
                  <div class="form-group">
                    <label for="category_id">Category</label>
                    <select class="select2 form-control" id="category_id" name="category_id">
                      <option value="">-- Select Category --</option>
                      ' . $categories . '
                    </select>
                  </div>
                  <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary float-right">' . ($productId !== null ? 'Update' : 'Add') . ' Product</button>
                  </div>
                </form>';
      
      return $form;
    }
    
    // Update an existing product in the database
    public function updateProduct($productId, $productData)
    {
      $sql    = 'UPDATE products SET product_name = ?, description = ?, unit_price = ?, quantity_in_stock = ?,
                reorder_level = ?, category_id = ?, supplier_id = ?, product_image = ? WHERE product_id = ?';
      $params = [
        $productData['product_name'],
        $productData['description'],
        $productData['unit_price'],
        $productData['quantity_in_stock'],
        $productData['reorder_level'],
        $productData['category_id'],
        $productData['supplier_id'],
        $productData['product_image'],
        $productId
      ];
      
      $this->updateQuery($sql, $params);
      
      // Log the activity in the AuditTrail
      $this->auditTrail->logActivity($_SESSION['user_id'], 2, $productId, 'Product updated', 'Product ID: ' . $productId);
      
      return true;
    }
    
    // Delete a product from the database
    public function deleteProductAdmin($productId)
    {
      
      $images = $this->getProductImages($productId);
      foreach ($images as $image) {
        if (file_exists("../assets/img/products/" . $image)) {
          unlink("../assets/img/products/" . $image);
        }
      }
      
      $sql    = 'DELETE FROM products WHERE product_id = ?';
      $params = [$productId];
      $id     = $this->deleteQuery($sql, $params);
      
      // Log the activity in the AuditTrail
      $this->auditTrail->logActivity($_SESSION['user_id'], 3, $productId, 'Product deleted', 'Product ID: ' . $productId);
      
      return $id;
    }
    
    // Delete a product from the database
    public function deleteProduct($productId)
    {
      $images = $this->getProductImages($productId);
      foreach ($images as $image) {
        if (file_exists("../assets/img/products/" . $image)) {
          unlink("../assets/img/products/" . $image);
        }
      }
      
      $sql    = 'DELETE FROM products WHERE product_id = ?';
      $params = [$productId];
      $id     = $this->deleteQuery($sql, $params);
      // Log the activity in the AuditTrail
      $this->auditTrail->logActivity($_SESSION['user_id'], 3, $productId, 'Product deleted', 'Product ID: ' . $productId);
      
      return $id;
    }
    
    // Example method using the SELECT query template
    public function getProductById($productId)
    {
      $sql    = 'SELECT * FROM products WHERE product_id = ?';
      $params = [$productId];
      $result = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        // Fetch and return the product data
        return $result->fetch_assoc();
      }
      return null;
    }
    
    // Get all products from the database
    public function getProducts()
    {
      $sql    = 'SELECT * FROM products INNER JOIN categories ON products.category_id = categories.category_id';
      $result = $this->selectQuery($sql);
      
      $products = [];
      while ($row = $result->fetch_assoc()) {
        $products[] = $row;
      }
      
      return $products;
    }
    
    public function productDetails($productId)
    {
      // Get product Details
      $sql     = "SELECT * FROM products WHERE product_id=?";
      $params  = [$productId];
      $result1 = $this->selectQuery($sql, $params)->fetch_assoc();
      // Get product Sales
      $sqls    = "SELECT * FROM salesorderitems WHERE product_id=?";
      $paramss = [$productId];
      $result2 = $this->selectQuery($sqls, $paramss);
      $data[0] = $result1;
      
      while ($row = $result2->fetch_assoc()) {
        $data[1][] = $row;
      }
      return $data;
    }
  
    public function productDetailsVendor($productId)
    {
      $rows = $this->productDetails($productId);
      $row = $rows[0];
      $salers = $rows[1] ?? null;
      $salesData = '';
      $no = 1;
      if (is_array($salers)) {
        foreach ($salers as $saler) {
          $salesData .= '<tr><td>' . $no . '</td><td>' . $saler['quantity'] . '</td><td>' . $saler['unit_price'] . '</td><td>' . $saler['total_amount'] . '</td></tr>';
          $no++;
        }
      }
      $colored = "";
      $colors = explode(", ", $row['color']);
      foreach ($colors as $color) {
        $colored .= '<a href="javascript:void(0)" style="background: ' . $color . '; display: inline-block" class="color-display"></a>';
      }
      return '<div class="row">
                <div class="col-sm-6">
                  <h5>Sales Details</h5>
                  <div class="table-responsive">
                    <table class="table table-sm table-bordered table-striped table-hover">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Qty</th>
                          <th>Unit Price</th>
                          <th>Total</th>
                        </tr>
                      </thead>
                      <tbody>'.$salesData.'</tbody>
                    </table>
                  </div>
                </div>
                <div class="col-sm-6">
                  <h5>Product Details</h5>
                  <p>
                    <img src="../assets/img/products/'.(isset(explode(", ", $row['product_image'])[0]) ? explode(", ", $row['product_image'])[0] : 'default.png').'" alt="Product Image" class="rounded" style="width: 24%">
                    <img src="../assets/img/products/'.(isset(explode(", ", $row['product_image'])[1]) ? explode(", ", $row['product_image'])[1] : 'default.png').'" alt="Product Image" class="rounded" style="width: 24%">
                    <img src="../assets/img/products/'.(isset(explode(", ", $row['product_image'])[2]) ? explode(", ", $row['product_image'])[2] : 'default.png').'" alt="Product Image" class="rounded" style="width: 24%">
                    <img src="../assets/img/products/'.(isset(explode(", ", $row['product_image'])[3]) ? explode(", ", $row['product_image'])[3] : 'default.png').'" alt="Product Image" class="rounded" style="width: 24%">
                  </p>
                  <p>
                    <b>Brand:</b> '.$row['brand'].'<br>
                    <b>Model:</b> '.$row['model'].'<br>
                    <b>Manufacturer:</b> '.$row['manufacturer'].'<br>
                    <b>Colors:</b> '.$colored.'<br>
                    <b>Size:</b> '.$row['size'].'<br>
                    <b>Weight:</b> '.$row['weight'].' Kg<br>
                    <b>State:</b> '.$row['product_state'].'<br>
                    <b>Spare Part:</b> '.$row['spare_part'].'<br>
                  </p>
                  <p><b>Short Description:</b><br>'.$row['short_description'].'</p>
                  <p><b>Full Description:</b><br>'.$row['product_description'].'</p>
                </div>
              </div>
              ';
    }
    
    public function updateStockQuantities($productId, $movementType, $quantity)
    {
      $sql = "UPDATE products SET quantity_in_stock = quantity_in_stock ";
      
      if ($movementType === 'in') {
        $sql .= "+ ?";
      } elseif ($movementType === 'out') {
        $sql .= "- ?";
      }
      
      $sql .= " WHERE product_id = ?";
      
      $this->updateQuery($sql, [$quantity, $productId]);
    }
    
    private function getProductImage($product_id)
    {
      $sql  = "SELECT product_image FROM products WHERE product_id=?";
      $data = $this->selectQuery($sql, [$product_id])->fetch_assoc();
      return $data['product_image'];
    } // TODO - Remove it is unused method
    
    public function getProductDetails($productId)
    {
      // Logic to retrieve details of a specific product.
      // Query the database to get product information.
    }
    
    public function listProductsByCategory($categoryId)
    {
      // Logic to list products in a specific category.
      // Query the database for products in the category.
    } // TODO - Remove it is unused method
    
    public function searchProducts($keywords)
    {
      // Logic to search for products by keywords.
      // Query the database for matching products.
    }
    
    public function addProductReview($full_name, $status, $stars, $review, $productId)
    {
      // Write to review and increase the total product reviews too
      $sql    = "INSERT INTO reviews (product_id, title, stars, review, helpful, unhelpful, user) VALUES (?, ?, ?, ?, ?, ?, ?)";
      $params = [$productId, $status, $stars, $review, 0, 0, $full_name];
      if ($this->insertQuery($sql, $params)) {
        // Update total stars and reviews of the product
        $avgStars = $this->getAverageStars($productId);
        $this->updateQuery("UPDATE products SET average_stars=?, total_reviews=total_reviews+1 WHERE product_id=?", [$avgStars, $productId]);
        // Report review taken
        return json_encode(['status' => 'success', 'message' => 'Review Added Successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Review Failed.']);
      }
    }
    
    private function getAverageStars($productId)
    {
      $sql    = "SELECT avg(stars) AS average FROM reviews WHERE product_id=?";
      $params = [$productId];
      $result = $this->selectQuery($sql, $params)->fetch_assoc();
      return $result['average'];
    }
    
    public function listProductReviews($productId)
    {
      // Logic to list reviews for a product.
      // Query the database to get product reviews.
    }
    
    public function showProductReviews($productId)
    {
      $data   = '';
      $sql    = "SELECT * FROM reviews WHERE product_id=?";
      $params = [$productId];
      $result = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $data .= '<div class="review">
                      <div class="row no-gutters">
                        <div class="col-auto">
                          <h4><a href="javascript:void(0)">' . $row['user'] . '</a></h4>
                          <div class="ratings-container">
                            <div class="ratings">
                              <div class="ratings-val" style="width: ' . (($row['stars'] / 5) * 100) . '%;"></div><!-- End .ratings-val -->
                            </div><!-- End .ratings -->
                          </div><!-- End .rating-container -->
                          <span class="review-date">' . timeago($row['created_at']) . '</span>
                        </div><!-- End .col -->
                        <div class="col">
                          <h4>' . $row['title'] . '</h4>
                          
                          <div class="review-content">
                            <p>' . $row['review'] . '</p>
                          </div><!-- End .review-content -->
                          
                          <div class="review-action">
                            <a href="javascript:void(0)" data-id="' . $row['review_id'] . '" class="helpful"><i class="icon-thumbs-up"></i>Helpful (' . ($row['helpful'] ?? 0) . ')</a>
                            <a href="javascript:void(0)" data-id="' . $row['review_id'] . '" class="unhelpful"><i class="icon-thumbs-down"></i>Unhelpful (' . ($row['unhelpful'] ?? 0) . ')</a>
                          </div><!-- End .review-action -->
                        </div><!-- End .col-auto -->
                      </div><!-- End .row -->
                    </div><!-- End .review -->' . PHP_EOL;
        }
      } else {
        $data = '<p>No Reviews Found.</p>';
      }
      return $data;
    }
    
    public function addHelpfulReview($reviewId)
    {
      $sql    = "UPDATE reviews SET helpful=helpful+1 WHERE review_id=?";
      $params = [$reviewId];
      if ($this->updateQuery($sql, $params)) {
        return json_encode(['status' => 'success', 'message' => 'Review Marked as Helpful Successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Review Marking Failed.']);
      }
    }
    
    public function addUnHelpfulReview($reviewId)
    {
      $sql    = "UPDATE reviews SET unhelpful=unhelpful+1 WHERE review_id=?";
      $params = [$reviewId];
      if ($this->updateQuery($sql, $params)) {
        return json_encode(['status' => 'success', 'message' => 'Review Marked as Unhelpful Successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Review Marking Failed.']);
      }
    }
    
    public function addToWishlist($customerId, $productId)
    {
      // Logic to add a product to a customer's wishlist.
      // Insert wishlist entry into the database.
    }
    
    public function removeFromWishlist($customerId, $productId)
    {
      // Logic to remove a product from a customer's wishlist.
      // Delete the corresponding wishlist entry.
    }
    
    public function listWishlist($customerId)
    {
      // Logic to list products in a customer's wishlist.
      // Query the database for wishlist entries.
    }
    
    public function addToCart($customerId, $productId, $quantity)
    {
      // Logic to add a product to a customer's shopping cart.
      // Insert cart entry with quantity into the database.
    }
    
    public function updateCartItemQuantity($customerId, $productId, $quantity)
    {
      // Logic to update the quantity of a product in a customer's cart.
      // Update the cart entry in the database.
    } // TODO - Remove it is unused method
    
    public function removeFromCart($customerId, $productId)
    {
      // Logic to remove a product from a customer's shopping cart.
      // Delete the corresponding cart entry.
    }
    
    public function listCartItems($customerId)
    {
      // Logic to list products in a customer's shopping cart.
      // Query the database for cart entries.
    }
    
    public function placeOrder($customerId, $cartItems)
    {
      // Logic to place an order with the items in the shopping cart.
      // Create order, update inventory, and handle payment.
    }
    
    // Add more methods as needed for your specific product-related features.
    // Get Products by Vendor
    public function listMyProducts()
    {
      $vendorId = $this->getVendorId();
      $sql      = "SELECT * FROM products INNER JOIN categories ON products.category_id = categories.category_id WHERE vendor_id=?";
      $params   = [$vendorId];
      return $this->selectQuery($sql, $params);
    }
    
    public function listOtherVendorProducts()
    {
      $vendorId = $this->getVendorId();
      $sql      = "SELECT * FROM products INNER JOIN categories ON products.category_id = categories.category_id WHERE vendor_id!=?";
      $params   = [$vendorId];
      return $this->selectQuery($sql, $params);
    }
    
    
    
  }
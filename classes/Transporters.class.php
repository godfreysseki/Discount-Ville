<?php
  
  class Transporters extends Config
  {
    private $auditTrail;
    
    public function __construct()
    {
      parent::__construct();
      $this->auditTrail = new AuditTrail();
    }
    
    // Add a new transporter to the database
    public function addTransporter($transporterData)
    {
      // Check if transporter_id is set
      if (isset($transporterData['transporter_id']) && !empty($transporterData['transporter_id'])) {
        $transporterImages = $this->getTransporterImage($transporterData['transporter_id']);
        
        // Handle image upload if provided
        if (!empty($_FILES['image']['name'])) {
          $uploadDir = '../assets/img/transporters/';
          $uniqueFilename = 'transporter_' . uniqid() . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
          $uploadFile = $uploadDir . $uniqueFilename;
          
          // Remove Old Image
          if (file_exists($uploadDir . $transporterImages)) {
            unlink($uploadDir . $transporterImages);
          }
          
          // Upload new image
          if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            // Image uploaded successfully, save the unique filename to the database
            $transporterImage = $uniqueFilename;
          } else {
            // Image upload failed
            $transporterImage = $transporterImages; // or set to a default image
          }
        } else {
          $transporterImage = $transporterImages; // No image provided
        }
      } else {
        // Handle image upload if provided
        if (!empty($_FILES['image']['name'])) {
          $uploadDir = '../assets/img/transporters/';
          $uniqueFilename = 'transporter_' . uniqid() . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
          $uploadFile = $uploadDir . $uniqueFilename;
          
          // Upload new image
          if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            // Image uploaded successfully, save the unique filename to the database
            $transporterImage = $uniqueFilename;
          } else {
            // Image upload failed
            $transporterImage = ''; // or set to a default image
          }
        } else {
          $transporterImage = ''; // No image provided
        }
      }
      
      // Check if transporter_id is set and not empty for updating existing transporter
      if (isset($transporterData['transporter_id']) && !empty($transporterData['transporter_id'])) {
        // Update Transporter
        $sql = 'UPDATE transporters SET transporter_name=?, kilo_price=?, image=? WHERE transporter_id=?';
        $params = [
          $transporterData['transporter_name'],
          $transporterData['kilo_price'],
          $transporterImage,
          $transporterData['transporter_id']
        ];
        
        return $this->updateQuery($sql, $params);
      } else {
        // Insert new Transporter
        $sql = 'INSERT INTO transporters (transporter_name, kilo_price, image) VALUES (?, ?, ?)';
        $params = [
          $transporterData['transporter_name'],
          $transporterData['kilo_price'],
          $transporterImage
        ];
        
        $transporterId = $this->insertQuery($sql, $params);
        
        // Log the activity in the AuditTrail
        $this->auditTrail->logActivity($_SESSION['user_id'], 1, $transporterId, 'Transporter added', 'Transporter ID: ' . $transporterId);
        
        return $transporterId;
      }
    }
    
    // Get the transporter form for adding a new transporter or updating an existing one
    public function transporterForm($transporterId = null)
    {
      // Define the transporter data array with empty values for the form
      $transporterData = [
        'transporter_id' => '',
        'transporter_name' => '',
        'kilo_price' => '',
        'image' => '' // Assuming the image filename/path is provided in the transporter data
      ];
      
      // If $transporterId is provided, fetch the transporter data from the database
      if ($transporterId !== null) {
        $sql = "SELECT * FROM transporters WHERE transporter_id = ?";
        $params = [$transporterId];
        $transporterData = $this->selectQuery($sql, $params)->fetch_assoc();
      }
      
      // Start building the HTML form
      $form = '<form method="post" enctype="multipart/form-data">
                  <input type="hidden" name="transporter_id" value="' . $transporterId . '">
                  <div class="form-group">
                    <label for="image">Company Image <small>(' . htmlspecialchars($transporterData['image']) . ')</small></label>
                    <input type="file" class="form-control-file" id="image" name="image">
                  </div>
                  <div class="form-group">
                    <label for="transporter_name">Company Name</label>
                    <input type="text" class="form-control" id="transporter_name" name="transporter_name" value="' . htmlspecialchars($transporterData['transporter_name']) . '" required>
                  </div>
                  <div class="form-group">
                    <label for="kilo_price">Kilogram Price</label>
                    <input type="number" step="0.01" class="form-control" id="kilo_price" name="kilo_price" value="' . htmlspecialchars($transporterData['kilo_price']) . '" required>
                  </div>
                  <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary float-right">' . ($transporterId !== null ? 'Update' : 'Add') . ' Transporter</button>
                  </div>
                </form>';

        return $form;
    }

    // Update an existing transporter in the database
    public function updateTransporter($transporterId, $transporterData)
    {
        $sql = 'UPDATE transporters SET transporter_name=?, kilo_price=?, image=? WHERE transporter_id=?';
        $params = [
            $transporterData['transporter_name'],
            $transporterData['kilo_price'],
            $transporterData['image'],
            $transporterId
        ];

        $this->updateQuery($sql, $params);

        // Log the activity in the AuditTrail
        $this->auditTrail->logActivity($_SESSION['user_id'], 2, $transporterId, 'Transporter updated', 'Transporter ID: ' . $transporterId, 'Transporters', 'Success');

        return true;
    }

    // Delete a transporter from the database
    public function deleteTransporter($transporterId)
    {
        $sql = 'DELETE FROM transporters WHERE transporter_id = ?';
        $params = [$transporterId];
        if ($this->deleteQuery($sql, $params)) {
            // Log the activity in the AuditTrail
            $this->auditTrail->logActivity($_SESSION['user_id'], 3, $transporterId, 'Transporter deleted', 'Transporter ID: ' . $transporterId, 'Transporters', 'Success');

            return json_encode(['status' => 'success', 'message' => 'Transporter/Item deleted Successfully.']);
        } else {
            return json_encode(['status' => 'warning', 'message' => 'Transporter/Item already deleted. Reload to see effect.']);
        }
    }

    // Example method using the SELECT query template
    public function getTransporterById($transporterId)
    {
        $sql = 'SELECT * FROM transporters WHERE transporter_id = ?';
        $params = [$transporterId];

        $result = $this->selectQuery($sql, $params);

        if ($result->num_rows > 0) {
            // Fetch and return the transporter data
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    // Get all transporters from the database
    public function getTransporters()
    {
        $sql = 'SELECT * FROM transporters ORDER BY transporter_id DESC';
        $result = $this->selectQuery($sql);

        $transporters = [];
        while ($row = $result->fetch_assoc()) {
            $transporters[] = $row;
        }

        return $transporters;
    }

    public function transporterDetails($transporterId)
    {
        // Get transporter Details
        $sql = "SELECT * FROM transporters WHERE transporter_id=?";
        $params = [$transporterId];
        $result1 = $this->selectQuery($sql, $params)->fetch_assoc();
        // Get transporter Sales
        $sqls = "SELECT * FROM salesorderitems WHERE transporter_id=?";
        $paramss = [$transporterId];
        $result2 = $this->selectQuery($sqls, $paramss);
        $data[0] = $result1;

        while ($row = $result2->fetch_assoc()) {
            $data[1][] = $row;
        }
        return $data;
    }

    private function getTransporterImage($transporter_id)
    {
        $sql = "SELECT image FROM transporters WHERE transporter_id=?";
        $params = [$transporter_id];
        return $this->selectQuery($sql, $params)->fetch_assoc()['image'];
    }

    public function getTransportersTable()
    {
      $no = 1;
      $items = $this->getTransporters();
  
      $table = '<div class="table-responsive">
                    <table class="table dataTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Transporter Name</th>
                                <th>Kilo Price</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>';
  
      foreach ($items as $item) {
        $table .= '<tr>
                        <td>' . $no++ . '</td>
                        <td>' . htmlspecialchars($item['transporter_name']) . '</td>
                        <td>' . htmlspecialchars($item['kilo_price']) . '</td>
                        <td><img src="../assets/img/transporters/' . htmlspecialchars($item['image']) . '" alt="Transporter Image" class="img-fluid"></td>
                        <td>
                            <a href="edit_transporter.php?id=' . $item['transporter_id'] . '" class="btn btn-sm btn-primary">Edit</a>
                            <button onclick="deleteTransporter(' . $item['transporter_id'] . ')" class="btn btn-sm btn-danger">Delete</button>
                        </td>
                    </tr>';
      }
  
      $table .= '</tbody>
                </table>
            </div>';
  
      return $table;
    }
}

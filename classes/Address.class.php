<?php
  
  
  class Address extends Config
  {
    private $auditTrail;
    
    public function __construct()
    {
      parent::__construct();
      $this->auditTrail = new AuditTrail();
    }
    
    public function addAddress($data)
    {
      $user = esc($_SESSION['user_id']);
      if ($data['address_id'] !== "") {
        // Update Address
        $sql    = "update useraddresses set address_line1=?, city=?, postal_code=?, country=? where user_id=? && address_id=?";
        $params = [$data["address_line1"], $data["city"], $data["postal_code"], $data["country"], $user, $data["address_id"]];
        if ($this->updateQuery($sql, $params)) {
          return alert('success', 'Address Updated Successfully.');
        } else {
          return alert('warning', 'Address Updates Failed.');
        }
      } else {
        // Insert data to the database
        $sql    = "insert into useraddresses (user_id, address_line1, city, postal_code, country) values (?, ?, ?, ?, ?)";
        $params = [$user, $data["address_line1"], $data["city"], $data["postal_code"], $data["country"]];
        if ($this->insertQuery($sql, $params)) {
          return alert('success', 'Address Added Successfully.');
        } else {
          return alert('warning', 'Address Addition Failed.');
        }
      }
    }
    
    public function addAddressForm($addressId = null)
    {
      $data = [
        "user_id" => "",
        "address_line1" => "",
        "address_line2" => "",
        "city" => "",
        "postal_code" => "",
        "country" => "",
        "address_id" => null
      ];
      
      if ($addressId !== null) {
        $data = $this->getAddressDetails($addressId);
      }
      
      $countries = new Country();
      
      return '<form method="post">
                    <input type="hidden" name="address_id" value="' . $data['address_id'] . '" class="form-control" required>
                  <div class="form-group">
                    <label for="postal_code">Postal Code *</label>
                    <input type="text" id="postal_code" name="postal_code" value="' . $data['postal_code'] . '" class="form-control" required>
                  </div>
                  <div class="form-group">
                    <label for="address_line1">Address Line *</label>
                    <input type="text" id="address_line1" name="address_line1" value="' . $data['address_line1'] . '" class="form-control" required>
                  </div>
                  <div class="form-group">
                    <label for="country">Country *</label>
                    <select id="country" name="country" class="form-control custom-select select-custom select2" required>
                      ' . $countries->countiesCombo() . '
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="city">City *</label>
                    <select id="city" name="city" class="form-control custom-select select-custom select2" required>
                      ' . $countries->getCountryCities() . '
                    </select>
                  </div>
                  <div class="form-group">
                    <button type="submit" name="addAddress" class="btn btn-primary">Save Address</button>
                  </div>
                </form>';
    }
    
    public function showMyAddresses()
    {
      $data   = '';
      $user   = esc($_SESSION['user_id']);
      $sql    = "select * from useraddresses where user_id=?";
      $params = [$user];
      $result = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        $no = 1;
        while ($row = $result->fetch_assoc()) {
          $data .= '<div class="card">
                      <div class="card-header" id="heading-' . $no . '">
                        <h2 class="card-title">
                          <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-' . $no . '" aria-expanded="false" aria-controls="collapse-' . $no . '">
                            ' . $row['address_line1'] . '
                          </a>
                        </h2>
                      </div><!-- End .card-header -->
                      <div id="collapse-' . $no . '" class="collapse" aria-labelledby="heading-' . $no . '" data-parent="#accordion-1">
                        <div class="card-body">
                          <table class="table table-hover">
                            <tr>
                              <th>Postal Code</th><td class="border-right">' . $row['postal_code'] . '</td>
                              <th>Address Line</th><td>' . $row['address_line1'] . '</td>
                            </tr>
                            <tr>
                              <th>City</th><td class="border-right">' . $row['city'] . '</td>
                              <th>Country</th><td>' . $row['country'] . '</td>
                            </tr>
                          </table>
                            <button class="editAddressBtn btn btn-primary btn-sm" data-id="' . $row['address_id'] . '">Edit</button>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <button class="deleteAddressBtn btn btn-danger btn-sm" data-id="' . $row['address_id'] . '">Delete</button>
                        </div><!-- End .card-body -->
                      </div><!-- End .collapse -->
                    </div>';
          $no++;
        }
      }
      return $data;
    }
    
    public function getAddressDetails($addressId)
    {
      $sql    = "select * from useraddresses where address_id=?";
      $params = [$addressId];
      return $this->selectQuery($sql, $params)->fetch_assoc();
    }
    
    public function deleteAddress($addressId)
    {
      $sql    = "delete from useraddresses where address_id=?";
      $params = [$addressId];
      if ($this->deleteQuery($sql, $params)) {
        return alert('success', 'Address Deleted Successfully.');
      } else {
        return alert('warning', 'Address Deletion Failed.');
      }
    }
    
  }
<?php
  
  class ServiceProviders extends Config
  {
    private AuditTrail $auditTrail;
    
    public function __construct()
    {
      parent::__construct();
      $this->auditTrail = new AuditTrail();
    }
    
    public function saveProvider($data)
    {
      $provider_id = $data['provider_id'] ?? null;
      $action      = $data['action'] ?? '';
      
      // Sanitize input data to prevent SQL injection
      $provider_name = esc($data['provider_name'] ?? '');
      $email         = esc($data['email'] ?? '');
      $phone_number  = esc($data['phone_number'] ?? '');
      $address       = esc($data['address'] ?? '');
      $city          = esc($data['city'] ?? '');
      $state         = esc($data['state'] ?? '');
      $country       = esc($data['country'] ?? '');
      $postal_code   = esc($data['postal_code'] ?? '');
      $logo_url      = esc($data['logo_url'] ?? '');
      $job_service   = esc($data['job_service'] ?? '');
      $description   = esc($data['description'] ?? '');
      
      if ($action == 'edit' && $provider_id) {
        // Update existing provider
        $sql    = "UPDATE service_providers SET provider_name=?, email=?, phone_number=?, address=?, city=?, state=?, country=?, postal_code=?, logo_url=?, job_service=?, description=? WHERE provider_id=?";
        $params = [$provider_name, $email, $phone_number, $address, $city, $state, $country, $postal_code, $logo_url, $job_service, $description, $provider_id];
        $this->updateQuery($sql, $params);
      } else {
        // Insert new provider
        $sql    = "INSERT INTO service_providers (provider_name, email, phone_number, address, city, state, country, postal_code, logo_url, job_service, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $params = [$provider_name, $email, $phone_number, $address, $city, $state, $country, $postal_code, $logo_url, $job_service, $description];
        $this->insertQuery($sql, $params);
      }
    }
    
    public function providerForm($provider_id = null)
    {
      if ($provider_id) {
        // Load existing provider data if editing an existing provider
        $provider = $this->getServiceProviderById($provider_id);
        $action   = 'edit';
      } else {
        $provider = [
          'provider_id' => '',
          'provider_name' => '',
          'email' => '',
          'phone_number' => '',
          'address' => '',
          'city' => '',
          'state' => '',
          'country' => '',
          'postal_code' => '',
          'logo_url' => '',
          'job_service' => '',
          'description' => ''
        ];
        $action   = 'add';
      }
      
      // Generate HTML form for adding/editing providers
      $form = '<form method="post" enctype="multipart/form-data" class="row">
                    <input type="hidden" name="action" value="' . $action . '">
                    <input type="hidden" name="provider_id" value="' . $provider['provider_id'] . '">
                    <div class="form-group col-sm-6">
                        <label for="provider_name">Provider/Company Name:</label>
                        <input type="text" name="provider_name" id="provider_name" value="' . $provider['provider_name'] . '" class="form-control" required>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email" value="' . $provider['email'] . '" class="form-control" required>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="phone_number">Phone Number:</label>
                        <input type="text" name="phone_number" id="phone_number" value="' . $provider['phone_number'] . '" class="form-control" required>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="address">Address:</label>
                        <input type="text" name="address" id="address" value="' . $provider['address'] . '" class="form-control">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="city">City:</label>
                        <input type="text" name="city" id="city" value="' . $provider['city'] . '" class="form-control">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="state">State:</label>
                        <input type="text" name="state" id="state" value="' . $provider['state'] . '" class="form-control">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="country">Country:</label>
                        <input type="text" name="country" id="country" value="' . $provider['country'] . '" class="form-control">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="postal_code">Postal Code:</label>
                        <input type="text" name="postal_code" id="postal_code" value="' . $provider['postal_code'] . '" class="form-control">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="logo_url">Logo URL:</label>
                        <input type="text" name="logo_url" id="logo_url" value="' . $provider['logo_url'] . '" class="form-control">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="job_service">Job/Service:</label>
                        <input type="text" name="job_service" id="job_service" value="' . $provider['job_service'] . '" class="form-control">
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="description">Description:</label>
                        <textarea name="description" id="description" class="form-control">' . $provider['description'] . '</textarea>
                    </div>
                    <div class="form-group col-sm-12">
                        <input type="submit" name="saveProviderBtn" value="Save Data" class="btn btn-primary float-right">
                    </div>
                </form>';
      
      return $form;
    }
    
    public function getServiceProviderById($provider_id)
    {
      $sql    = "SELECT * FROM service_providers WHERE provider_id=?";
      $params = array($provider_id);
      $result = $this->selectQuery($sql, $params);
      
      if ($result->num_rows > 0) {
        return $result->fetch_assoc();
      }
      
      return null;
    }
  
    public function getServiceProviderDetails($provider_id)
    {
      $data = '';
      $row = $this->getServiceProviderById($provider_id);
      $data .= '<p><b>Company: </b>'.$row['provider_name'].'</p>';
      $data .= '<p><b>Contacts: </b>'.phone($row['phone_number']).', '.email($row['email']).'</p>';
      $data .= '<p><b>Address: </b>'.$row['postal_code'].', '.$row['address'].', '.$row['city'].', '.$row['state'].', '.$row['country'].'</p>';
      $data .= '<p><b>Service Rendered: </b>'.$row['job_service'].'</p>';
      $data .= '<p><b>Price Range: </b>'.CURRENCY .' '. number_format($row['min_price']).' - '.number_format($row['highest_price']).'</p>';
      $data .= '<p><b>Service Full Description: </b><br>'.$row['description'].'</p>';
  
      return $data;
    }
    
    public function deleteProvider($provider_id)
    {
      $sql    = "DELETE FROM service_providers WHERE provider_id=?";
      $params = array($provider_id);
      $this->deleteQuery($sql, $params);
      return alert('success', 'Service Provider Deleted Successfully.');
    }
    
    public function listProviders()
    {
      $sql    = 'SELECT * FROM service_providers ORDER BY provider_id DESC';
      $result = $this->selectQuery($sql);
      
      $providers = [];
      while ($row = $result->fetch_assoc()) {
        $providers[] = $row;
      }
      
      return $providers;
    }
  }

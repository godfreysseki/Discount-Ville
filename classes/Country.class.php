<?php
  
  
  class Country extends Config
  {
    private $auditTrail;
    
    public function __construct()
    {
      parent::__construct();
      $this->auditTrail = new AuditTrail();
    }
    
    public function countiesCombo()
    {
      $data   = '<option value="" disabled selected>-- Select Country --</option>';
      $sql    = "select * from countries order by name";
      $result = $this->selectQuery($sql);
      while ($row = $result->fetch_assoc()) {
        $data .= '<option value="' . $row['alpha_2'] . '">' . $row['name'] . '</option>';
      }
      return $data;
    }
    
    public function getCountryCities($countryCode = null)
    {
      $data   = '<option value="" disabled selected>-- Select City Now --</option>';
      $sql    = "select * from cities where country=? order by name";
      $params = [$countryCode];
      $result = $this->selectQuery($sql, $params);
      while ($row = $result->fetch_assoc()) {
        $data .= '<option value="' . $row['code'] . '">' . $row['name'] . '</option>';
      }
      return $data;
    }
    
  }
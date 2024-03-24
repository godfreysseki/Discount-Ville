<?php
  
  
  class Reports extends Config
  {
    private $auditTrail;
    
    public function __construct()
    {
      parent::__construct();
      $this->auditTrail = new AuditTrail();
    }
    
    public function generateReport($reportCategory, $startDate, $endDate)
    {
      if ($reportCategory === "Adverts") {
        return "Adverts Report";
      }
      
      if ($reportCategory === "Customer") {
        return "Customer Report";
      }
      
      if ($reportCategory === "Orders") {
        return "Orders Report";
      }
      
      if ($reportCategory === "Products") {
        return "Products Report";
      }
      
    }
  }

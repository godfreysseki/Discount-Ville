<?php
  
  
  class Newsletters extends Config
  {
    
    public function addNewsletter()
    {
      // Add to database
      // Send Email to all users who are active
    }
    
    public function subscribe($email)
    {
      $sql    = "INSERT INTO newsletter_subscribers (email, status) VALUES (?, ?)";
      $params = [esc($email), "Active"];
      if ($this->insertQuery($sql, $params)) {
        return json_encode(['status' => 'success', 'message' => 'You have been subscribed to ' . COMPANY . ' newsletter successfully.<br><b>Email</b>: ' . $email]);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Your newsletter subscription has failed.']);
      }
    }
    
    public function listSubscribers()
    {
      $data   = [];
      $sql    = "SELECT * FROM newsletter_subscribers";
      $result = $this->selectQuery($sql);
      while ($row = $result->fetch_assoc()) {
        $data[] = $row;
      }
      return $data;
    }
    
  }
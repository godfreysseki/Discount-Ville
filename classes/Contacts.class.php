<?php
  
  
  class Contacts extends Config
  {
    
    public function sendContact($contactData)
    {
      $cname    = esc($contactData['cname']);
      $cemail   = esc($contactData['cemail']);
      $cphone   = esc($contactData['cphone']);
      $csubject = esc($contactData['csubject']);
      $cmessage = esc($contactData['cmessage']);
      $sql      = "INSERT INTO contacts (full_name, phone, email, subject, message) VALUES (?, ?, ?, ?, ?)";
      $params   = [$cname, $cphone, $cemail, $csubject, $cmessage];
      if ($this->insertQuery($sql, $params)) {
        return json_encode(['status' => 'success', 'message' => 'Your contact message has been sent. You will get a reply by email or phone call. Thank you.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Sorry, Your message was not sent. We apologize for the inconveniences caused.']);
      }
    }
    
    public function listContact()
    {
      $data   = '<p>No guest has contacted you yet.</p>';
      $sql    = "SELECT * FROM contacts ORDER BY replied";
      $result = $this->selectQuery($sql);
      if ($result->num_rows > 0) {
        $no   = 1;
        $data = '<div class="table-responsive">
                  <table class="table dataTable">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Full Name</th>
                        <th>Telephone</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Contacted</th>
                        <th>Seen</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>';
        while ($row = $result->fetch_assoc()) {
          $id     = $row['contid'];
          $action = '
                      <button data-id="' . $id . '" class="viewContact btn btn-link btn-xs text-success" data-toggle="tooltip" title="View"><i class="fa fa-eye"></i></button>
                      <button data-id="' . $id . '" class="replyContact btn btn-link btn-xs text-primary" data-toggle="tooltip" title="Reply"><i class="fa fa-reply"></i></button>
                      <button data-id="' . $id . '" onclick="if(confirm(\'This will delete this record from the system.\\nIf connected to other records, they will be affected.\\n\\nAre you sure to continue?\')) {$(this).addClass(\'deleteContact\')}" data-toggle="tooltip" title="Delete" class="btn btn-link btn-xs text-danger"><span class="fa fa-trash"></span></button>
                    ';
          $data   .= '<tr>
                      <td>' . $no . '</td>
                      <td>' . dates($row['created_at']) . '</td>
                      <td>' . $row['full_name'] . '</td>
                      <td>' . phone($row['phone']) . '</td>
                      <td>' . email($row['email']) . '</td>
                      <td>' . $row['subject'] . '</td>
                      <td>' . $row['replied'] . '</td>
                      <td>' . $row['seen'] . '</td>
                      <td>' . $action . '</td>
                    </tr>';
          $no++;
        }
        $data .= '</tbody></table></div>';
      }
      
      return $data;
    }
    
    public function viewSingleContact($contactId)
    {
      $data   = '';
      $sql    = "SELECT * FROM contacts WHERE contid=? ";
      $params = [$contactId];
      $result = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $data = '
                    Sender : <b>' . $row['full_name'] . '</b><br>
                    Telephone : <b>' . phone($row['phone']) . '</b><br>
                    Email : <b>' . email($row['email']) . '</b><br><br>
                    Subject : <b>' . $row['subject'] . '</b><br><br>
                    <b>Message :</b><br>' . $row['message'] . '
                  ';
        }
      }
      
      return $data;
    }
    
    public function emailReply($contactId, $message)
    {
      $sql    = "SELECT * FROM contacts WHERE contid=? ";
      $params = [$contactId];
      $result = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          // Show Contact information then send reply
          $to      = esc($row['email']);
          $subject = "Reply - " . $row['subject'];
          $body    = esc($message);
          $headers = "From: " . esc(COMPANYEMAIL);
          
          if (mail($to, $subject, $body, $headers)) {
            // Update contact as Replied
            $this->updateQuery("UPDATE contacts SET replied='Yes' WHERE contid=? ", [$contactId]);
            return alert('success', 'Email Reply sent successfully.');
          } else {
            return alert('warning', 'Email Replied Failed. Check your mail server.');
          }
        }
      }
    }
    
    public function contactReplyForm($contactId)
    {
      $data   = '';
      $sql    = "SELECT * FROM contacts WHERE contid=? ";
      $params = [$contactId];
      $result = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $data = '
                    <p>Sender : <b>' . $row['full_name'] . '</b></p>
                    <p>Telephone : <b>' . phone($row['phone']) . '</b></p>
                    <p>Email : <b>' . email($row['email']) . '</b></p>
                    <p>Subject : <b>' . $row['subject'] . '</b></p>
                    <p><b>Message :</b><br>' . $row['message'] . '</p>
                    <form method="post">
                      <input type="hidden" name="contactId" id="contactId" value="' . $contactId . '" class="d-none">
                      <div class="form-group">
                        <label for="reply">Reply Message</label>
                        <textarea name="reply" id="reply" class="form-control"></textarea>
                      </div>
                      <div class="form-group">
                        <button type="submit" name="replyBtn" class="btn btn-' . COLOR . ' float-right">Send Reply</button>
                      </div>
                    </form>
                  ';
        }
      }
      
      return $data;
    }
    
    public function deleteContact($contactId)
    {
      $sql    = "DELETE FROM contacts WHERE contid=? ";
      $params = [$contactId];
      if ($this->deleteQuery($sql, $params)) {
        return alert('success', 'You have successfully deleted the contact.');
      } else {
        return alert('success', 'Contact failed to be deleted.');
      }
    }
    
    public function markAsRead($contactId)
    {
      $sql    = "UPDATE contacts SET seen='Yes' WHERE contid=? ";
      $params = [$contactId];
      $this->updateQuery($sql, $params);
    }
    
    public function countNewContacts() // TODO: Remove method if not used
    {
      $data   = 0;
      $sql    = "SELECT COUNT(contid) AS lops FROM contacts WHERE seen='No' ";
      $result = $this->selectQuery($sql);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $data = $row['lops'];
        }
      }
      
      return $data;
    }
    
    /*******
     * Send Vendors Bulk Email
     */
    public function selectVendorEmails()
    {
      $sql    = "SELECT email FROM users WHERE role='Vendor'";
      $result = $this->selectQuery($sql);
      
      $emails = [];
      while ($row = $result->fetch_assoc()) {
        $emails[] = $row['email'];
      }
      
      return $emails;
    }
    
    public function selectCustomerEmails()
    {
      $sql    = "SELECT email FROM users WHERE role='Customer'";
      $result = $this->selectQuery($sql);
      
      $emails = [];
      while ($row = $result->fetch_assoc()) {
        $emails[] = $row['email'];
      }
      
      return $emails;
    }
    
    public function selectAdminEmails()
    {
      $sql    = "SELECT email FROM users WHERE role='Admin'";
      $result = $this->selectQuery($sql);
      
      $emails = [];
      while ($row = $result->fetch_assoc()) {
        $emails[] = $row['email'];
      }
      
      return $emails;
    }
    
    private function fullName($email)
    {
      $sql    = "SELECT full_name FROM users WHERE email=?";
      $params = [$email];
      $result = $this->selectQuery($sql, $params)->fetch_assoc();
      return $result['full_name'];
    }
    
    public function emailForm()
    {
      return '<form method="post">
                <div class="form-group">
                  <label for="recipient">Recipient Email</label>
                  <input type="email" name="recipient" id="recipient" class="form-control">
                </div>
                <div class="form-group">
                  <label for="subject">Subject</label>
                  <input type="text" name="subject" id="subject" class="form-control">
                </div>
                <div class="form-group">
                  <label for="message">Subject</label>
                  <textarea name="message" id="message" class="form-control editor"></textarea>
                </div>
                <div class="form-group">
                  <input type="submit" value="Send" name="emailBtn" class="btn btn-primary float-right">
                </div>
              </form>';
    }
    
    public function bulkEmailForm()
    {
      return '<form method="post">
                <div class="form-group">
                  <label for="recipients">Recipients</label>
                  <select name="recipients" id="recipients" class="custom-select select2">
                    <option value="Admins">All Administrators</option>
                    <option value="Customers">All Customers</option>
                    <option value="Vendors">All Vendors</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="subject">Subject</label>
                  <input type="text" name="subject" id="subject" class="form-control">
                </div>
                <div class="form-group">
                  <label for="message">Subject</label>
                  <textarea name="message" id="message" class="form-control editor"></textarea>
                </div>
                <div class="form-group">
                  <input type="submit" value="Send" name="bulkEmailBtn" class="btn btn-primary float-right">
                </div>
              </form>';
    }
    
    public function formatEmailTemplate($fullName, $title, $content)
    {
      // Read the content of the template file
      $templateFilePath = "../mail-messenger.php"; // Update with the actual file path
      $templateContent  = file_get_contents($templateFilePath);
      
      if ($templateContent === false) {
        // Handle the error, e.g., by logging or returning an error message
        return false;
      }
      
      // Replace placeholders with actual data
      $templateContent = str_replace("[User]", $fullName, $templateContent);
      $templateContent = str_replace("[Title]", $title, $templateContent);
      $templateContent = str_replace("[Content]", $content, $templateContent);
      
      return $templateContent;
    }
    
    public function sendBulkEmailToVendors($formData)
    {
      $recipients   = $formData['recipients'];
      $subject      = $formData['subject'];
      $emailContent = $formData['message'];
      // Select emails according to recipients
      if ($recipients === 'Vendors') {
        $vendorEmails = $this->selectVendorEmails();
      } elseif ($recipients === 'Customers') {
        $vendorEmails = $this->selectCustomerEmails();
      } elseif ($recipients === 'Admins') {
        $vendorEmails = $this->selectAdminEmails();
      }
      
      // Send email to each vendor individually
      if (isset($vendorEmails) && count($vendorEmails) > 0) {
        foreach ($vendorEmails as $email) {
          $headers = "MIME-Version: 1.0" . "\r\n";
          $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
          $headers .= "From: Discount-Ville Team <" . COMPANYEMAIL . ">\r\n"; // Specify the sender name here
          $headers .= "Reply-To: " . COMPANYEMAIL . "\r\n";
          
          // Format email template
          $emailTemplate = $this->formatEmailTemplate($this->fullName($email), $subject, $emailContent);
          // Send email
          mail($email, $subject, $emailTemplate, $headers);
        }
        // Insert the sent email to the database
        $this->insertQuery("INSERT INTO bulk_emails (emails, subject, message, recipients, send_date, sender) VALUES (?, ?, ?, ?, ?, ?)", [
          implode(", ", $vendorEmails),
          $subject,
          $emailContent,
          $recipients,
          date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']),
          $_SESSION['username']
        ]);
        // echo Success Message
        echo alert('success', 'Bulk emails sent successfully to all ' . $recipients);
      } else {
        echo alert('warning', 'Emails failed');
      }
    }
    
    public function sendEmail($formData)
    {
      $to           = $formData['recipient'];
      $subject      = $formData['subject'];
      $emailContent = $formData['message'];
      
      // Send email to each vendor individually
      $headers = "MIME-Version: 1.0" . "\r\n";
      $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
      $headers .= "From: Discount-Ville Team <" . COMPANYEMAIL . ">\r\n"; // Specify the sender name here
      $headers .= "Reply-To: " . COMPANYEMAIL . "\r\n";
      
      // Format email template
      $emailTemplate = $this->formatEmailTemplate($this->fullName($to), $subject, $emailContent);
      // Send email
      mail($to, $subject, $emailTemplate, $headers);
      // Insert the sent email to the database
      $this->insertQuery("INSERT INTO bulk_emails (emails, subject, message, recipients, send_date, sender) VALUES (?, ?, ?, ?, ?, ?)", [
        $to,
        $subject,
        $emailContent,
        'Single Email',
        date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']),
        $_SESSION['username']
      ]);
      // echo Success Message
      echo alert('success', 'Email has been sent successfully to ' . $to);
      
    }
    
    public function listBulkEmails()
    {
      
      $data   = '<p>No Emails Have been sent yet.</p>';
      $sql    = "SELECT * FROM bulk_emails ORDER BY beid DESC";
      $result = $this->selectQuery($sql);
      if ($result->num_rows > 0) {
        $no   = 1;
        $data = '<div class="table-responsive">
                  <table class="table dataTable">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Subject</th>
                        <th>Recipients</th>
                        <th>Sender</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>';
        while ($row = $result->fetch_assoc()) {
          $id     = $row['beid'];
          $action = '
                      <button data-id="' . $id . '" class="viewEmailBtn btn btn-link btn-xs text-success" data-toggle="tooltip" title="View"><i class="fa fa-eye"></i></button>
                      <button data-id="' . $id . '" onclick="if(confirm(\'This will delete this record from the system.\\nIf connected to other records, they will be affected.\\n\\nAre you sure to continue?\')) {$(this).addClass(\'deleteEmailBtn\')}" data-toggle="tooltip" title="Delete" class="btn btn-link btn-xs text-danger"><span class="fa fa-trash"></span></button>
                    ';
          $data   .= '<tr>
                      <td>' . $no . '</td>
                      <td>' . dates($row['send_date']) . '</td>
                      <td>' . $row['subject'] . '</td>
                      <td>' . $row['recipients'] . '</td>
                      <td>' . $row['sender'] . '</td>
                      <td>' . $action . '</td>
                    </tr>';
          $no++;
        }
        $data .= '</tbody></table></div>';
      }
      
      return $data;
    }
    
    public function bulkEmailView($email_id)
    {
      $data   = '';
      $sql    = "SELECT * FROM bulk_emails WHERE beid=?";
      $params = [$email_id];
      $result = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $data .= '<p><b>Subject: </b>' . $row['subject'] . '</p>';
        }
      } else {
        $data = 'An error occurred. Re-select the email using buttons provided.';
      }
      return $data;
    }
    
    public function bulkEmailDelete($email_id)
    {
      return 'Deleted';
    }
    
  }
<?php
  
  
  class Chat extends Config
  {
    private $auditTrail;
    
    public function __construct()
    {
      parent::__construct();
      $this->auditTrail = new AuditTrail();
    }
    public function sendMessage($senderId, $recipientId, $message)
    {
      if(!empty($message)) {
        $sql    = "INSERT INTO chat_messages (sender_id, receiver_id, message_content, seen) VALUES (?, ?, ?, ?)";
        $params = [$senderId, $recipientId, $message, 'No'];
        if ($this->insertQuery($sql, $params)) {
          return json_encode(['status' => 'success', 'message' => 'Message Sent Successfully.']);
        } else {
          return json_encode(['status' => 'warning', 'message' => 'Message Failed.']);
        }
      }
    }
  
    public function uploadChatFile($senderId, $recipientId, $files)
    {
      $sql    = "INSERT INTO chat_messages (sender_id, receiver_id, uploads, seen) VALUES (?, ?, ?, ?)";
      $params = [$senderId, $recipientId, $files, 'No'];
      if ($this->insertQuery($sql, $params)) {
        return json_encode(['status' => 'success', 'message' => 'File Uploaded Successfully.']);
      } else {
        return json_encode(['status' => 'warning', 'message' => 'File Upload Failed.']);
      }
    }
  
    private function lastTextMessage($user)
    {
      $sql    = "SELECT * FROM chat_messages WHERE (receiver_id=? || sender_id=?) && (message_content!='' || message_content IS NOT NULL) ORDER BY message_id DESC LIMIT 1";
      $params = [$user, $user];
      $result = $this->selectQuery($sql, $params)->fetch_assoc();
      return $result['message_content'];
    }
    
    // Admin and Vendors
    public function getAdminMessages($user, $otherUser)
    {
      $data   = '<h3 style="color: #a7a7a7;text-align:center; margin-top:100px;">Please select user to view content.</h3>';
      $sql    = "SELECT * FROM chat_messages WHERE (receiver_id=? AND sender_id=?) OR (receiver_id=? AND sender_id=?)";
      $params = [$user, $otherUser, $otherUser, $user];
      $result = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        $data = '';
        while ($row = $result->fetch_assoc()) {
          // Update messages as seen
          $this->updateQuery("UPDATE chat_messages SET seen='Yes' WHERE receiver_id=? && sender_id=?", [$user, $row['sender_id']]);
      
          if ($row['sender_id'] == esc($_SESSION['username'])) {
            $data .= '<!-- Message to the right -->
									<div class="direct-chat-msg right">
										<div class="direct-chat-infos clearfix">
											<span class="direct-chat-name float-right">You</span>
											<span class="direct-chat-timestamp float-left">' . chatTimeago($row['timestamp']) . '</span>
										</div>
										<!-- /.direct-chat-infos -->
										' . $this->getUserProfilePic($_SESSION['username']) . '
										<!-- /.direct-chat-img -->
										<div class="direct-chat-text">
											' . (($row['message_content'] === "" && !empty($row['uploads'])) ? '<img src="../assets/img/chat/' . $row['uploads'] . '" class="chatImage thumbnail" alt="image uploaded" style="max-width: 240px">' : $row['message_content']) . '
										</div>
										<!-- /.direct-chat-text -->
									</div>
									<!-- /.direct-chat-msg -->';
          } else {
            $data .= '<!-- Message. Default to the left -->
									<div class="direct-chat-msg">
										<div class="direct-chat-infos clearfix">
											<span class="direct-chat-name float-left">'.$otherUser .'</span>
											<span class="direct-chat-timestamp float-right">' . chatTimeago($row['timestamp']) . '</span>
										</div>
										<!-- /.direct-chat-infos -->
										' . $this->getUserProfilePic($row['sender_id']) . '
										<!-- /.direct-chat-img -->
										<div class="direct-chat-text">
											' . (($row['message_content'] === "" && !empty($row['uploads'])) ? '<img src="../assets/img/chat/' . $row['uploads'] . '" class="chatImage" alt="image uploaded" style="max-width: 240px">' : $row['message_content'] ) . '
										</div>
										<!-- /.direct-chat-text -->
									</div>
									<!-- /.direct-chat-msg -->';
          }
        }
      }
      return $data;
    }
  
    public function loadChatContacts()
    {
      $user   = esc($_SESSION['username']);
      $data   = '';
      $sql    = "SELECT * FROM chat_messages
            WHERE receiver_id=? OR sender_id=?
            ORDER BY timestamp DESC";
      $params = [$user, $user];
      $result = $this->selectQuery($sql, $params);
      // Use an associative array to store the latest message for each contact
      $latestMessages = [];
      while ($row = $result->fetch_assoc()) {
        $contactId = ($row['receiver_id'] === $user) ? $row['sender_id'] : $row['receiver_id'];
        // Check if there are new messages (you need to implement this logic)
        $hasNewMessages = $this->checkForNewMessages($user, $row['sender_id']);
        // Check if we already have a latest message for this contact
        if (!isset($latestMessages[$contactId])) {
          $latestMessages[$contactId] = $row;
          $data                       .= '<li class="nav-item contact" data-id="' . $contactId . '" ' . ($hasNewMessages ? 'data-new-message="true"' : '') . '>
                                            <a href="javascript:void(0)" class="nav-link">
                                              ' . $this->getUserProfilePic($contactId) . '
                                              <div class="contact-info">
                                                <strong>' . $contactId . '</strong>
                                                <span>' . $this->lastTextMessage($row['receiver_id']) . '</span>
                                              </div>
                                              <!--<span class="badge bg-primary float-right">6</span>-->
                                            </a>
                                          </li>';
        }
      }
      return $data;
    }
    
    // Customers and Guests
    public function getMessages($user, $otherUser)
    {
      $data   = '<h3 style="color: #a7a7a7;text-align:center; margin-top:100px;">Please select user to view content.</h3>';
      $sql    = "SELECT * FROM chat_messages WHERE (receiver_id=? AND sender_id=?) OR (receiver_id=? AND sender_id=?)";
      $params = [$user, $otherUser, $otherUser, $user];
      $result = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        $data = '';
        while ($row = $result->fetch_assoc()) {
          // Update messages as seen
          $this->updateQuery("UPDATE chat_messages SET seen='Yes' WHERE receiver_id=? && sender_id=?", [$user, $row['sender_id']]);
          
          if ($row['sender_id'] == esc($_SESSION['username'])) {
            $data .= '<div class="message sender">
                        <div>
                          ' . (($row['message_content'] === "" && !empty($row['uploads'])) ? '<img src="assets/img/chat/' . $row['uploads'] . '" class="chatImage" alt="image uploaded" style="max-width: 240px">' : '<p class="text">' . $row['message_content'] . '</p>') . '
                          <span class="message-time">' . chatTimeago($row['timestamp']) . '</span>
                        </div>
                        ' . $this->getUserProfilePic($_SESSION['username']) . '
                      </div>';
          } else {
            $data .= '<div class="message receiver">
                        ' . $this->getUserProfilePic($row['sender_id']) . '
                        <div>
                          ' . (($row['message_content'] === "" && !empty($row['uploads'])) ? '<img src="assets/img/chat/' . $row['uploads'] . '" class="chatImage" alt="image uploaded" style="max-width: 240px">' : '<p class="text">' . $row['message_content'] . '</p>') . '
                          <span class="message-time">' . chatTimeago($row['timestamp']) . '</span>
                        </div>
                      </div>';
          }
        }
      }
      return $data;
    }
    
    public function loadChatHistory()
    {
      $user   = esc($_SESSION['username']);
      $data   = '';
      $sql    = "SELECT * FROM chat_messages
            WHERE receiver_id=? OR sender_id=?
            ORDER BY timestamp DESC";
      $params = [$user, $user];
      $result = $this->selectQuery($sql, $params);
      // Use an associative array to store the latest message for each contact
      $latestMessages = [];
      while ($row = $result->fetch_assoc()) {
        $contactId = ($row['receiver_id'] === $user) ? $row['sender_id'] : $row['receiver_id'];
        // Check if there are new messages (you need to implement this logic)
        $hasNewMessages = $this->checkForNewMessages($user, $row['sender_id']);
        // Check if we already have a latest message for this contact
        if (!isset($latestMessages[$contactId])) {
          $latestMessages[$contactId] = $row;
          $data                       .= '<div data-id="' . $contactId . '" class="contact" ' . ($hasNewMessages ? 'data-new-message="true"' : '') . '>
                                            ' . $this->getUserProfilePic($contactId) . '
                                            <div class="contact-info">
                                              <strong>' . $contactId . '</strong>
                                              <span>' . $this->lastTextMessage($row['receiver_id']) . '</span>
                                            </div>
                                          </div>';
        }
      }
      return $data;
    }
    
    // Function to check for new messages based on the 'seen' column
    function checkForNewMessages($receiverId, $senderId)
    {
      // Implement your logic to check for new messages
      // For example, query your database to check if there are unseen messages
      $sql    = "SELECT COUNT(*) AS newMessagesCount FROM chat_messages WHERE receiver_id=? AND sender_id=? AND seen='No'";
      $params = [$receiverId, $senderId];
      $result = $this->selectQuery($sql, $params);
      
      if ($result && $row = $result->fetch_assoc()) {
        // If there are unseen messages, return true
        return ($row['newMessagesCount'] > 0);
        //return true;
      }
      
      // Default to false if there's an error or no unseen messages
      return false;
    }
    
    
    public function getUnreadMessages($participantId)
    {
      // Logic to retrieve unread messages for a participant.
      // Query the database for unread messages.
    }
    
    public function markMessageAsRead($messageId)
    {
      // Logic to mark a message as read.
      // Update the message status in the database.
    }
    
    public function userDetails($username)
    {
      return $this->getUserProfilePic($username) . '<p class="receiverName text-uppercase">' . $username . '</p>';
    }
    
    public function vendorName($vendorId)
    {
      $data   = '';
      $sql    = "SELECT * FROM vendors INNER JOIN users ON vendors.user_id=users.user_id WHERE vendor_id=?";
      $params = [$vendorId];
      $result = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $data = $row['username'];
        }
      }
      return $data;
    }
    
  }
<?php
  
  
  class Notification extends Config
  {
    public function sendNotification($recipientId, $message, $type)
    {
      // Logic to send a notification to a recipient.
      // Store the notification message and type in the database.
    }
    
    public function markNotificationAsRead($notificationId)
    {
      $user   = esc($_SESSION['user_id']);
      $sql    = "update notifications set is_read=? where notification_id=? && user_id=?";
      $params = [1, $notificationId, $user];
      if ($this->updateQuery($sql, $params)) {
        return alert('success', 'Notification marked as seen successfully.');
      } else {
        return alert('warning', 'Marking Notification as Read Failed.');
      }
    }
    
    public function markAllNotificationAsRead()
    {
      $user   = esc($_SESSION['user_id']);
      $sql    = "update notifications set is_read=? where user_id=?";
      $params = [1, $user];
      if ($this->updateQuery($sql, $params)) {
        return alert('success', 'All Notifications marked as seen successfully.');
      } else {
        return alert('warning', 'Marking Notifications as Read Failed.');
      }
    }
    
    public function listNotifications()
    {
      $user   = esc($_SESSION['user_id']);
      $sql    = "select * from notifications where user_id=? order by notification_id desc";
      $params = [$user];
      return $this->selectQuery($sql, $params);
    }
    
    public function deleteNotification($notificationId)
    {
      $user   = esc($_SESSION['user_id']);
      $sql    = "delete from notifications where notification_id=? && user_id=?";
      $params = [$notificationId, $user];
      if ($this->deleteQuery($sql, $params)) {
        return alert('success', 'Notification deleted successfully.');
      } else {
        return alert('warning', 'Notification Deletion Failed.');
      }
    }
  }

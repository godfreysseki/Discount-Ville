<?php
  
  class users extends Config
  {
    private $auditTrail;
    
    public function __construct()
    {
      parent::__construct();
      $this->auditTrail = new AuditTrail();
    }
    
    public function addUser($data)
    {
      if ($data['user_id'] !== null && $data['user_id'] !== "") {
        // Update user data
        $sql    = "UPDATE users SET username=?, full_name=?, email=?, phone=?, password=?, role=? WHERE user_id=? ";
        $params = [$data['username'], $data['full_name'], $data['email'], $data['phone'], password_hash($data['password'], PASSWORD_DEFAULT), $data['role'], $data['user_id']];
        $id     = $this->updateQuery($sql, $params);
        // Update Addresses
        $sql    = "UPDATE useraddresses SET address_line1=?, address_line2=?, city=?, postal_code=?, country=? WHERE user_id=? ";
        $params = [$data['address_line1'], $data['address_line2'], $data['city'], $data['postal_code'], $data['country'], $data['user_id']];
        $this->updateQuery($sql, $params);
        return alert('success', 'User Updated Successfully. User Id: ' . $id);
      } else {
        // Insert user data
        $sql    = "INSERT INTO users (username, full_name, email, phone, password, role) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $params = [$data['username'], $data['full_name'], $data['email'], $data['phone'], password_hash($data['password'], PASSWORD_DEFAULT), $data['role']];
        $id     = $this->insertQuery($sql, $params);
        // Insert Addresses
        $sql    = "INSERT INTO useraddresses (user_id, address_line1, address_line2, city, postal_code, country) VALUES (?, ?, ?, ?, ?, ?) ";
        $params = [$id, $data['address_line1'], $data['address_line2'], $data['city'], $data['postal_code'], $data['country']];
        $this->insertQuery($sql, $params);
        return alert('success', 'User Added Successfully. User Id: ' . $id);
      }
    }
    
    public function addUserForm($user_id = null)
    {
      $userData = [
        'username' => '',
        'full_name' => '',
        'email' => '',
        'phone' => '',
        'password' => '',
        'role' => '',
        'address_line1' => '',
        'address_line2' => '',
        'city' => '',
        'postal_code' => '',
        'country' => '',
        'user_id' => null,
      ];
      // Get user details for editing
      if ($user_id !== null) {
        $userData = $this->getUserById($user_id);
      }
      
      $form = '<form method="post">
                <input type="hidden" name="user_id" value="' . ($userData['userid'] ?? "") . '">
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="username">Username</label>
                      <input type="text" name="username" id="username" value="' . esc($userData['username']) . '" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="full_name">Full Name</label>
                      <input type="text" name="full_name" id="full_name" value="' . esc($userData['full_name']) . '" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="email">Email</label>
                      <input type="email" name="email" id="email" value="' . esc($userData['email']) . '" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="phone">Telephone</label>
                      <input type="text" name="phone" id="phone" value="' . esc($userData['phone']) . '" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="password">Password</label>
                      <input type="text" name="password" id="password" placeholder="Type Current/New Password" required class="form-control">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="role">User Role</label>
                      <select name="role" id="role" class="select2 form-control">
                        <option value="">-- Select User\'s Role --</option>
                        <option value="admin" ' . (($userData['role'] === "admin") ? "selected" : "") . '>Administrator</option>
                        <option value="manager" ' . (($userData['role'] === "manager") ? "selected" : "") . '>Manager</option>
                        <option value="inventory_staff" ' . (($userData['role'] === "inventory_staff") ? "selected" : "") . '>Inventory / Purchasing Staff</option>
                        <option value="sales_staff" ' . (($userData['role'] === "sales_staff") ? "selected" : "") . '>Sales Staff</option>
                        <option value="warehouse_staff" ' . (($userData['role'] === "warehouse_staff") ? "selected" : "") . '>Warehouse Staff</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="address_line1">Address Line 1</label>
                      <input type="text" name="address_line1" id="address_line1" value="' . esc($userData['address_line1']) . '" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="address_line2">Address Line 2</label>
                      <input type="text" name="address_line2" id="address_line2" value="' . esc($userData['address_line2']) . '" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="city">City</label>
                      <input type="text" name="city" id="city" value="' . esc($userData['city']) . '" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="postal_code">Postal Code</label>
                      <input type="text" name="postal_code" id="postal_code" value="' . esc($userData['postal_code']) . '" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="country">Country</label>
                      <input type="text" name="country" id="country" value="' . esc($userData['country']) . '" class="form-control">
                    </div>
                    <div class="form-group">
                      <button class="btn btn-primary float-right">' . ($user_id !== null ? 'Update' : 'Add') . ' User</button>
                    </div>
                  </div>
                </div>
               </form>';
      return $form;
    }
    
    public function addUserFormSelf($user_id = null)
    {
      $userData = [
        'username' => '',
        'full_name' => '',
        'email' => '',
        'phone' => '',
        'address_line1' => '',
        'address_line2' => '',
        'city' => '',
        'postal_code' => '',
        'country' => '',
        'user_id' => null,
      ];
      // Get user details for editing
      if ($user_id !== null) {
        $userData = $this->getUserById($user_id);
      }
      
      $form = '<form method="post">
                <input type="hidden" name="user_id" value="' . ($userData['userid'] ?? "") . '">
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="username">Username</label>
                      <input type="text" name="username" id="username" value="' . esc($userData['username']) . '" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="full_name">Full Name</label>
                      <input type="text" name="full_name" id="full_name" value="' . esc($userData['full_name']) . '" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="email">Email</label>
                      <input type="email" name="email" id="email" value="' . esc($userData['email']) . '" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="phone">Telephone</label>
                      <input type="text" name="phone" id="phone" value="' . esc($userData['phone']) . '" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="address_line1">Address Line 1</label>
                      <input type="text" name="address_line1" id="address_line1" value="' . esc($userData['address_line1']) . '" class="form-control">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="address_line2">Address Line 2</label>
                      <input type="text" name="address_line2" id="address_line2" value="' . esc($userData['address_line2']) . '" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="city">City</label>
                      <input type="text" name="city" id="city" value="' . esc($userData['city']) . '" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="postal_code">Postal Code</label>
                      <input type="text" name="postal_code" id="postal_code" value="' . esc($userData['postal_code']) . '" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="country">Country</label>
                      <input type="text" name="country" id="country" value="' . esc($userData['country']) . '" class="form-control">
                    </div>
                    <div class="form-group">
                      <button name="btn" class="btn btn-primary float-right">' . ($user_id !== null ? 'Update' : 'Add') . ' Profile</button>
                    </div>
                  </div>
                </div>
               </form>';
      return $form;
    }
    
    public function getUsers()
    {
      $sql = "SELECT users.*, users.user_id AS userid, useraddresses.* FROM users LEFT JOIN useraddresses ON users.user_id=useraddresses.user_id";
      return $this->selectQuery($sql);
    }
    
    public function getUserById($user_id)
    {
      $sql    = "SELECT users.*, users.user_id AS userid, useraddresses.* FROM users LEFT JOIN useraddresses ON users.user_id=useraddresses.user_id WHERE users.user_id=?";
      $params = [$user_id];
      return $this->selectQuery($sql, $params)->fetch_assoc();
    }
    
    public function registerUser($full_name, $email, $username, $password, $role)
    {
      if ($this->selectQuery("SELECT * FROM users WHERE username=? || email=?", [$username, $email])->num_rows > 0) {
        echo alert('warning', 'Username or Email already in use by another person.');
      } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $date   = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
        $sql    = "INSERT INTO users (username, full_name, email, password, role, registration_date) VALUES (?, ?, ?, ?, ?, ?)";
        $params = [$username, $full_name, $email, $hashed, $role, $date];
        if ($this->insertQuery($sql, $params)) {
          echo alert('success', 'Registration Completed Successfully.');
          $this->loginUser($username, $password);
        }
      }
    }
    
    public function loginUser($username, $password)
    {
      $sql    = "SELECT user_id, username, full_name, password, role FROM users WHERE username = ? || email = ?";
      $params = [$username, $username];
      $result = $this->selectQuery($sql, $params);
      if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
          // Password is correct, set up the session
          // First change the guest session details in the tables and then assign the new login credentials
          if (isset($_SESSION['username'])) {
            $this->updateCartSession($user['username']);
            $this->updateWishlistSession($user['username']);
            $this->updateChatSession($user['username']);
            $this->updateCompareSession($user['username']);
            $this->updateSalesOrdersSession($user['username']);
          }
          $_SESSION['user_id']  = $user['user_id'];
          $_SESSION['user']     = $user['full_name'];
          $_SESSION['username'] = $user['username'];
          $_SESSION['role']     = $user['role'];
          switch ($_SESSION['role']) {
            case 'Admin':
              echo "<script>window.location.href=('admin/')</script>";
              break;
            case 'Vendor':
              echo "<script>window.location.href=('vendor/')</script>";
              break;
            default:
              echo "<script>window.location.href=('./dashboard.php')</script>";
          }
        } else {
          echo alert('warning', 'You have a wrong password.');
        }
      } else {
        echo alert('warning', 'Check your Username/Email and Password.');
      }
    }
    
    public function googleLogin()
    {
      require_once "assets/plugins/google-api/vendor/autoload.php";
      
      // Creating new google client instance
      $client = new Google_Client();
      // Enter your Client ID
      $client->setClientId('191190076808-6nijhbpsscb1rfa6ngh9pucddghktnlg.apps.googleusercontent.com');
      // Enter your Client Secret
      $client->setClientSecret('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');
      // Enter the Redirect URL
      $client->setRedirectUri('https://discount-ville.com/dashboard.php');
      // Adding those scopes which we want to get (email & profile Information)
      $client->addScope("email");
      $client->addScope("profile");
      
      if (isset($_GET['code'])) {
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        
        if (!isset($token["error"])) {
          $client->setAccessToken($token['access_token']);
          // getting profile information
          $google_oauth        = new Google_Service_Oauth2($client);
          $google_account_info = $google_oauth->userinfo->get();
          // Prepare to use or store data into database
          $id          = esc($google_account_info->id);
          $email       = esc($google_account_info->email);
          $profile_pic = esc($google_account_info->picture);
          
          // checking user already exists or not
          $sql      = "SELECT * FROM users WHERE google_id='" . $id . "' || email='" . $email . "' ";
          $get_user = $this->selectQuery($sql);
          if ($get_user->num_rows > 0) {
            while ($rows = $get_user->fetch_assoc()) {
              if ($rows['active'] == 0) {
                alert('warning', 'Your account is not yet activated.');
              } else {
                // Update the user google id and profile picture
                if ($rows['google_id'] == "" || $rows['google_id'] == null) {
                  $sqls = "UPDATE users SET google_id='" . $id . "' WHERE email='" . $email . "' ";
                  $this->updateQuery($sqls);
                }
                if ($rows['image'] == "" || $rows['image'] == null) {
                  $sqls = "UPDATE users SET user_image='" . $profile_pic . "' WHERE email='" . $email . "' ";
                  $this->updateQuery($sqls);
                }
                
                // Create the sessions and redirect user
                $_SESSION['user_id']  = $rows['user_id'];
                $_SESSION['username'] = $rows['username'];
                $_SESSION['user']     = $rows['fullname'];
                $_SESSION['role']     = $rows['role'];
                
                switch ($rows['role']) {
                  case "Admin":
                    header('location:admin/');
                    break;
                  case "Teacher":
                    header('location:dashboard.php');
                    break;
                  default:
                    alert("warning", "You don't have any role assigned to your username.<br>Please Contact System Administrator for help.<br><br>Thank you.");
                }
              }
            }
          } else {
            alert("warning", "It seems your email or Google Id is not registered in the system");
          }
        }
      } else {
        echo '<a href="' . $client->createAuthUrl() . '" class="btn btn-login btn-g">
                <i class="icon-google"></i> Login With Google
              </a>';
      }
    }
    
    public function logoutUser()
    {
      session_unset();
      session_destroy();
      header('location: ./');
    }
    
    public function checkRole($requiredRole)
    {
      if (isset($_SESSION['role'])) {
        $sessionRole = strtolower(str_replace("_", "", $_SESSION['role']));
        $dir         = strtolower($requiredRole);
        if ($sessionRole !== $dir) {
          header('location: ../logout.php');
        }
      } else {
        header('location: ../logout.php');
      }
    }
    
    public function deleteUser($userId)
    {
      $sql    = "DELETE FROM users WHERE user_id=?";
      $params = [$userId];
      $this->deleteQuery($sql, $params);
      
      $sql    = "DELETE FROM useraddresses WHERE user_id=?";
      $params = [$userId];
      $this->deleteQuery($sql, $params);
      return alert('success', 'User Deleted Successfully. User Id: ' . $userId);
    }
    
    // Change password from the email after forgetting your login credentials.
    public function updatepassword($old, $new)
    {
      $oldpassword = esc($old);
      $newpassword = password_hash($new, PASSWORD_DEFAULT);
      
      // Check if the old password matches with the one in database
      $sql    = "SELECT * FROM users WHERE username='" . $_SESSION['username'] . "' ";
      $result = $this->selectQuery($sql);
      
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          if (password_verify($oldpassword, $row['password'])) {
            // Change the user's Password
            $sqls = "UPDATE users SET password='" . $newpassword . "' WHERE username='" . $_SESSION['username'] . "' ";
            if ($this->updateQuery($sqls)) {
              return alert('success', 'Password Changed Successfully.');
            } else {
              return alert('warning', 'Password Update Failed.');
            }
          } else {
            return alert('warning', 'Your Passwords don\'t match the one in the database.');
          }
        }
      } else {
        return alert('warning', 'Your Username does not exist.');
      }
    }
    
    public function updatepicture($pic, $tmp)
    {
      if (!empty($_FILES["profimg"]["name"])) {
        $imagedir = "../assets/img/users/";
        $images   = $pic;
        $image    = $imagedir . $pic;
        
        // Update Profile image
        if (!empty($_FILES["profimg"]["name"])) {
          // Get old image and delete it from folder
          $gets = "SELECT user_image FROM users WHERE username=? ";
          $params = [$_SESSION['username']];
          $get  = $this->selectQuery($gets, $params);
          if ($get->num_rows > 0) {
            while ($row = $get->fetch_array()) {
              $imager = '../assets/img/users/'.$row['user_image'];
              // Remove Image
              if (file_exists($imager)) {
                unlink($imager);
              }
            }
          }
          
          if (move_uploaded_file($tmp, $image)) {
            // Rename File
            $extension = strtolower(pathinfo($image, PATHINFO_EXTENSION));
            $timer     = time();
            rename($image, $imagedir . $timer . "." . $extension);
            $newName = $timer . "." . $extension;
            
            // Write to database image and system log
            $datas = "UPDATE users SET user_image=? WHERE username=? ";
            $params = [$newName, $_SESSION['username']];
            $this->updateQuery($datas, $params);
            return alert('success', 'Image Updated Successfully');
          }
        }
      }
    }
    
    public function updateProfile($data)
    {
      // Update user data
      $sql    = "UPDATE users SET username=?, full_name=?, email=?, phone=? WHERE user_id=? ";
      $params = [$data['username'], $data['full_name'], $data['email'], $data['phone'], $_SESSION['user_id']];
      $id     = $this->updateQuery($sql, $params);
      // Update Addresses
      $sql    = "UPDATE useraddresses SET address_line1=?, address_line2=?, city=?, postal_code=?, country=? WHERE user_id=? ";
      $params = [$data['address_line1'], $data['address_line2'], $data['city'], $data['postal_code'], $data['country'], $_SESSION['user_id']];
      $this->updateQuery($sql, $params);
      return alert('success', 'Profile Updated Successfully.');
    }
    
    public function updateCartSession($newUsername)
    {
      $sql    = "UPDATE cart SET user=? WHERE user=?";
      $params = [esc($newUsername), esc($_SESSION['username'])];
      $this->updateQuery($sql, $params);
    }
    
    public function updateWishlistSession($newUsername)
    {
      $sql    = "UPDATE wishlist SET user=? WHERE user=?";
      $params = [esc($newUsername), esc($_SESSION['username'])];
      $this->updateQuery($sql, $params);
    }
    
    public function updateChatSession($newUsername)
    {
      $sql    = "UPDATE chat_messages SET receiver_id=?, sender_id=? WHERE receiver_id=? || sender_id=?";
      $params = [esc($newUsername), esc($newUsername), esc($_SESSION['username']), esc($_SESSION['username'])];
      $this->updateQuery($sql, $params);
    }
    
    public function updateCompareSession($newUsername)
    {
      $sql    = "UPDATE compare SET user=? WHERE user=?";
      $params = [esc($newUsername), esc($_SESSION['username'])];
      $this->updateQuery($sql, $params);
    }
    
    public function updateSalesOrdersSession($newUsername)
    {
      $sql    = "UPDATE salesorders SET user=? WHERE user=?";
      $params = [esc($newUsername), esc($_SESSION['username'])];
      $this->updateQuery($sql, $params);
    }
    
    // Function to get and display user's profile picture
    public function getUserProfilePic($username)
    {
      // Implement your logic to retrieve the profile picture filename or URL
      // Assuming there's a 'profile_pic' column in your user table
      $sql    = "SELECT user_image, online_status FROM users WHERE username=?";
      $params = [$username];
      $result = $this->selectQuery($sql, $params);
      
      if ($result && $row = $result->fetch_assoc()) {
        $profilePic = $row['user_image'];
        // Assuming profile pictures are stored in an 'uploads' directory
        $profilePicPath        = URL . 'assets/img/users/' . $profilePic;
        $profilePicPathToCheck = 'assets/img/users/' . $profilePic;
        // Check if the file exists before displaying
        if ((file_exists($profilePicPathToCheck) || file_exists('../' . $profilePicPathToCheck)) && $profilePic !== '') {
          // Display the profile picture
          return '<img src="' . $profilePicPath . '" alt="Profile Picture" class="' . $row['online_status'] . ' direct-chat-img">';
        } else {
          // Display a default profile picture or an alternative image
          // Display shop logo in case the image is not there otherwise company logo
          $logoPath        = URL . 'assets/img/shop_logos/';
          $logoPathToCheck = URL . 'assets/img/shop_logos/';
          $logo            = $this->shopLogo($username);
          if ((file_exists($logoPathToCheck . $logo) || file_exists('../' . $logoPathToCheck . $logo)) && ($logo !== "" || $logo !== null)) {
            return '<img src="' . $logoPath . $logo . '" alt="Vendor Shop Image" class="online direct-chat-img" style="max-width: 40px">';
          } else {
            return '<img src="' . FAVICON . '" alt="Vendor Shop Image" class="online direct-chat-img" style="max-width: 40px">';
          }
        }
      }
      // Default to a placeholder or default profile picture if there's an error
      return '<img src="' . FAVICON . '" alt="Placeholder Image" class="online direct-chat-img" style="max-width: 40px">';
    }
    
    // Get profile pic only
    public function userProfilePic($user_id)
    {
      $sql    = "SELECT user_image FROM users WHERE user_id=?";
      $params = [$user_id];
      $row    = $this->selectQuery($sql, $params)->fetch_assoc();
      return (!empty($row['user_image']) ? $row['user_image'] : 'default.png');
    }
    
    public function profPic()
    {
      $data = $this->getUserProfilePic($_SESSION['username']);
      $pic  = str_replace('alt', ' style="width: 32px; border-radius: 50%" alt', $data);
      return $pic;
    }
    
    public function shopLogo($username)
    {
      $sql    = "SELECT * FROM vendors INNER JOIN users ON vendors.user_id=users.user_id WHERE users.username=?";
      $result = $this->selectQuery($sql, [$username]);
      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['shop_logo'];
      }
      
      return null;
    }
    
    // Password Recovery
    function sendVerificationCodeEmail($userEmail)
    {
      $to               = $userEmail;
      $verificationCode = generateVerificationCode();
      // Check the existence of the user to the system, then send an email and redirect to reset_password.php
      $check = $this->selectQuery("SELECT * FROM users WHERE email=?", [$to]);
      if ($check->num_rows > 0) {
        $row       = $check->fetch_assoc();
        $userNames = $row['full_name'];
        // add the reset code to the user account
        $this->updateQuery("UPDATE users SET reset_code=?, time_sent=? WHERE email=?", [$verificationCode, date('Y-m-d H:i:s'), $to]);
        // Work on the email
        $subject = 'Discount Ville Password Reset Code';
        
        // To send HTML mail, the Content-type header must be set
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        
        // Additional headers
        $headers .= 'From: Discount Ville <info@discount-ville.com>' . "\r\n";
        
        // Body of the email (replace with your actual path to the HTML template)
        $message = file_get_contents('mail.php');
        
        // Replace placeholders in the email template with actual values
        $message = str_replace('[User]', $userNames, $message); // Replace with the actual user's name
        $message = str_replace('[Generated Code]', $verificationCode, $message);
        
        // Send email
        if (mail($to, $subject, $message, $headers)) {
          return alert('success', 'A verification Code has been sent to ' . $to . ' successfully. Go to your email to complete the process.');
        } else {
          return alert('warning', 'Email Failed, we apologize for the inconveniences caused.');
        }
      } else {
        return alert('warning', 'The Email provided does not exist in our system.');
      }
    }
    
    public function resetPassword($email, $newPassword, $verificationCode)
    {
      // Check if the email provided contains the code provided
      $check = $this->selectQuery("SELECT * FROM users WHERE email=? && reset_code=?", [$email, $verificationCode]);
      if ($check->num_rows > 0) {
        // Update password for the user
        $sql    = "UPDATE users SET password=?, reset_code=NULL, time_sent=NULL WHERE email=?";
        $params = [password_hash($newPassword, PASSWORD_DEFAULT), $email];
        if ($this->updateQuery($sql, $params)) {
          return json_encode(['status' => 'success', 'message' => 'Password Updated Successfully. You can login now with your username and new password']);
        } else {
          return json_encode(['status' => 'warning', 'message' => 'Password updates failed, we apologize for the inconveniences caused.']);
        }
      } else {
        return json_encode(['status' => 'warning', 'message' => 'Password reset failed ue to code expiration or change. Retry the process and complete it before 48 Hours.']);
      }
    }
    
    
  }
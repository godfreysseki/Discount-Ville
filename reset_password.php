<?php
  
  include_once "includes/header.inc.php";
  
  $data = new Users();

?>
  
  <main class="main">
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
      <div class="container">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item"><a href="javascript:void(0)">User</a></li>
          <li class="breadcrumb-item active" aria-current="page">Reset Password</li>
        </ol>
      </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->
    
    <div class="page-content">
      <div class="container mb-5">
        <div class="row justify-content-center">
          <div class="col-md-6">
            <div class="card border-0">
              <div class="card-header">
                <h5 class="card-title text-center">Reset Password</h5>
              </div>
              <div class="card-body">
                <!-- Reset Password Form -->
	              <?php
    
                  if ($_SERVER['REQUEST_METHOD'] === "POST") {
	                  echo $data->resetPassword($_POST['email'], $_POST['password'], $_POST['verificationCode']);
	                  
	                }
	              
	              ?>
                <form id="resetPasswordForm" method="post">
                  <div class="form-group">
                    <label for="email">Your Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your Email Address" required>
                  </div>
                  <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your new password" required>
	                  <div class="invalid-feedback" id="passwordError"></div>
                  </div>
                  <div class="form-group">
                    <label for="confirmPassword">Confirm New Password</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm your new password" required>
	                  <div class="invalid-feedback" id="confirmPasswordError"></div>
                  </div>
	                <div class="form-group form-check">
		                <div class="icheck-primary d-inline">
			                <input type="checkbox" id="showResetPassword">
			                <label for="showResetPassword">Show Passwords</label>
		                </div>
	                </div>
                  <div class="form-group">
                    <label for="verificationCode">Verification Code</label>
                    <input type="text" class="form-control" id="verificationCode" name="verificationCode" placeholder="Enter verification code" maxlength="6" required>
                  </div>
                  <button type="submit" class="btn btn-primary btn-block">Set New Password</button>
                </form>
                <!-- End Reset Password Form -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

<?php
  
  include_once "includes/footer.inc.php";

?>
<script>
  $(document).ready(function() {
    // Function to validate password strength
    function isStrongPassword(password) {
      // Implement your password strength rules here
      // Example: At least 8 characters, with a mix of letters, numbers, and special characters
      var passwordRegex = /^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
      return passwordRegex.test(password);
    }
    
    // Function to validate and show password error
    function validatePassword() {
      var password = $("#password").val();
      var passwordError = $("#passwordError");
      
      if (!isStrongPassword(password)) {
        passwordError.text("Password must be at least 8 characters and include letters, numbers, and special characters.");
        $("#password").addClass("is-invalid");
        return false;
      } else {
        passwordError.text("");
        $("#password").removeClass("is-invalid");
        return true;
      }
    }
    
    // Function to validate and show confirm password error
    function validateConfirmPassword() {
      var confirmPassword = $("#confirmPassword").val();
      var password = $("#password").val();
      var confirmPasswordError = $("#confirmPasswordError");
      
      if (confirmPassword !== password) {
        confirmPasswordError.text("Passwords do not match.");
        $("#confirmPassword").addClass("is-invalid");
        return false;
      } else {
        confirmPasswordError.text("");
        $("#confirmPassword").removeClass("is-invalid");
        return true;
      }
    }
  
    // Function to toggle password visibility
    function togglePasswordVisibility() {
      var passwordField = $("#password");
      var confirmPasswordField = $("#confirmPassword");
      var showPasswordCheckbox = $("#showResetPassword");
    
      var passwordType = showPasswordCheckbox.prop("checked") ? "text" : "password";
    
      passwordField.attr("type", passwordType);
      confirmPasswordField.attr("type", passwordType);
    }
    
    // Validate on password input change
    $("#password").on("input", function() {
      validatePassword();
    });
    
    // Validate on confirmPassword input change
    $("#confirmPassword").on("input", function() {
      validateConfirmPassword();
    });
  
    // Toggle password visibility when the checkbox changes
    $("#showResetPassword").on("change", function() {
      togglePasswordVisibility();
    });
    
    // Validate on form submission
    $("#resetPasswordForm").on("submit", function(event) {
      var isPasswordValid = validatePassword();
      var isConfirmPasswordValid = validateConfirmPassword();
      
      // If any validation fails, prevent form submission
      if (!isPasswordValid || !isConfirmPasswordValid) {
        event.preventDefault();
        toastr.warning("Complete the form correctly to reset your password.");
      }
    });
  });
</script>
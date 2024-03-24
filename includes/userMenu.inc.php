<?php if (isset($_SESSION['user_id'])): ?>
  <div class="col col-md-3 p-0">
    <nav class="navbar navbar-expand-lg navbar-light p-0">
      <div class="vendor-menu collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto flex-column">
          <li class="nav-item">
            <a href="dashboard.php" class="nav-link">Dashboard</a>
          </li>
          <?php if ($_SESSION['role'] === 'Vendor'): ?>
            <li class="nav-item">
              <a href="products.php" class="nav-link">Products</a>
            </li>
          <?php endif; ?>
          <li class="nav-item">
            <a href="orders.php" class="nav-link">Orders</a>
          </li>
          <?php if ($_SESSION['role'] === 'Vendor'): ?>
            <li class="nav-item">
              <a href="customers.php" class="nav-link">Customers</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="adverts.php">Adverts & Banners</a>
            </li>
          <?php endif; ?>
          <li class="nav-item">
            <a class="nav-link" href="chat.php">Chat & Communication</a>
          </li>
          <?php if ($_SESSION['role'] === 'Vendor'): ?>
            <li class="nav-item">
              <a class="nav-link" href="subscription.php">Subscription</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="stock.php">Stock Management</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="vendor_shop.php">Shop Management</a>
            </li>
          <?php endif; ?>
          <li class="nav-item">
            <a class="nav-link" href="address.php">Addresses</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="account.php">Account Details</a>
          </li>
          <?php if ($_SESSION['role'] === 'Vendor'): ?>
            <li class="nav-item">
              <a class="nav-link" href="reports.php">Reports</a>
            </li>
          <?php endif; ?>
          <li class="nav-item">
            <a class="nav-link" href="notifications.php">Notifications</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="settings.php">Settings</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
          </li>
        </ul>
      </div>
    </nav>
  </div><!-- End .col-lg-3 -->

<?php endif; ?>
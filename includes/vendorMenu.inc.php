<!-- Admin Menu -->
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary <?php
  
  $theme = new Theme();
  echo $theme->loadSidebarTheme() . " " . $theme->loadsidebarDisableHover();

?>  elevation-4">
	<!-- Brand Logo -->
	<a href="../" class="brand-link <?php
    
    $theme = new Theme();
    echo $theme->loadLogoTheme() . " " . $theme->loadSmallBrand();
  
  ?>">
		<img src="../assets/img/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
		<span class="brand-text font-weight-light"><?= COMPANYSHORT ?></span>
	</a>
	
	<!-- Sidebar -->
	<div class="sidebar">
		
		<ul class="nav nav-pills nav-sidebar flex-column mt-3 <?php
      
      echo $theme->loadsidebarFlat() . " " . $theme->loadsidebarLegacy() . " " . $theme->loadsidebarCompact() . " " . $theme->loadsidebarIndentChild() . " " . $theme->loadsidebarHideChildOnCollapse() . " " . $theme->loadSmallSidebarText();
    
    ?>" data-widget="treeview" role="menu" data-accordion="true">
			<!-- Dashboard -->
			<li class="nav-item">
				<a href="./" class="nav-link">
					<i class="nav-icon fas fa-tachometer-alt"></i>
					<p>Dashboard</p>
				</a>
			</li>
			
			<!-- Products -->
			<li class="nav-item">
				<a href="products.php" class="nav-link">
					<i class="nav-icon fas fa-cube"></i>
					<p>Products</p>
				</a>
			</li>
			
			<!-- Orders -->
			<li class="nav-item">
				<a href="orders.php" class="nav-link">
					<i class="nav-icon fas fa-shopping-cart"></i>
					<p>Orders</p>
				</a>
			</li>
			
			<!-- Customers -->
			<li class="nav-item">
				<a href="customers.php" class="nav-link">
					<i class="nav-icon fas fa-user"></i>
					<p>Customers</p>
				</a>
			</li>
			
			<!-- Adverts & Banners -->
			<!--<li class="nav-item">
				<a href="adverts.php" class="nav-link">
					<i class="nav-icon fas fa-bullhorn"></i>
					<p>Advertising & Banners</p>
				</a>
			</li>-->
			
			<!-- Communication -->
			<li class="nav-item">
				<a href="chat.php" class="nav-link">
					<i class="nav-icon fas fa-comments"></i>
					<p>Chat & Communication</p>
				</a>
			</li>
			
			<!-- Your Shop Management -->
			<li class="nav-item">
				<a href="shop.php" class="nav-link">
					<i class="nav-icon fas fa-store"></i>
					<p>Shop Management</p>
				</a>
			</li>
			
			<!-- Subscription Management -->
			<!--<li class="nav-item">
				<a href="subscription.php" class="nav-link">
					<i class="nav-icon fas fa-money-bill"></i>
					<p>Subscription Management</p>
				</a>
			</li>-->
			
			<!-- Stock Management -->
			<li class="nav-item">
				<a href="stock.php" class="nav-link">
					<i class="nav-icon fas fa-tree"></i>
					<p>Stock Management</p>
				</a>
			</li>
			
			<!-- Reports Management -->
			<!--<li class="nav-item">
				<a href="reports.php" class="nav-link">
					<i class="nav-icon fas fa-print"></i>
					<p>Reports Management</p>
				</a>
			</li>-->
			
			<!-- Settings -->
			<li class="nav-item">
				<a href="notifications.php" class="nav-link">
					<i class="nav-icon fas fa-bell"></i>
					<p>Notifications</p>
				</a>
			</li>
			
			<!-- Settings -->
			<!--<li class="nav-item">
				<a href="settings.php" class="nav-link">
					<i class="nav-icon fas fa-cog"></i>
					<p>Settings</p>
				</a>
			</li>-->
		</ul>
	
	</div>
</aside>
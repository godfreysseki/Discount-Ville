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
			
			<!-- Vendors -->
			<li class="nav-item">
				<a href="vendors.php" class="nav-link">
					<i class="nav-icon fas fa-users"></i>
					<p>Vendors</p>
				</a>
			</li>
			
			<!-- Blogs -->
			<li class="nav-item">
				<a href="blogs.php" class="nav-link">
					<i class="nav-icon fas fa-clipboard"></i>
					<p>Blogs</p>
				</a>
			</li>
			
			<!-- Products -->
			<li class="nav-item">
				<a href="products.php" class="nav-link">
					<i class="nav-icon fas fa-cube"></i>
					<p>Products</p>
				</a>
			</li>
			
			<!-- Categories -->
			<li class="nav-item">
				<a href="categories.php" class="nav-link">
					<i class="nav-icon fas fa-folder"></i>
					<p>Categories</p>
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
			<li class="nav-item">
				<a href="adverts.php" class="nav-link">
					<i class="nav-icon fas fa-bullhorn"></i>
					<p>Advertising & Banners</p>
				</a>
			</li>
			
			<!-- Blogs -->
			<li class="nav-item">
				<a href="jobs.php" class="nav-link">
					<i class="nav-icon fas fa-user-graduate"></i>
					<p>Job Search Alerts</p>
				</a>
			</li>
			
			<!-- Communication -->
			<li class="nav-item">
				<a href="chat.php" class="nav-link">
					<i class="nav-icon fas fa-comments"></i>
					<p>Chat & Contacts</p>
				</a>
			</li>
			
			<!-- Service Providers -->
			<li class="nav-item">
				<a href="service_providers.php" class="nav-link">
					<i class="nav-icon fas fa-hand-lizard"></i>
					<p>Service Providers</p>
				</a>
			</li>
			
			<!-- Your Shop Management -->
			<li class="nav-item">
				<a href="shop.php" class="nav-link">
					<i class="nav-icon fas fa-store"></i>
					<p>Shop Management</p>
				</a>
			</li>
			
			<!-- Subscription Plans -->
			<li class="nav-item has-treeview">
				<a href="javascript:void(0)" class="nav-link">
					<i class="nav-icon fas fa-money-bill"></i>
					<p>
						Subscription Plans
						<i class="fas fa-angle-left right"></i>
					</p>
				</a>
				<ul class="nav nav-treeview">
					<li class="nav-item">
						<a href="subscriptions.php" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Plans</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="subscribers.php" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Subscribers</p>
						</a>
					</li>
				</ul>
			</li>
			
			<!-- Stock Management -->
			<li class="nav-item">
				<a href="stock.php" class="nav-link">
					<i class="nav-icon fas fa-tree"></i>
					<p>Stock Management</p>
				</a>
			</li>
			
			<!-- Stock Management -->
			<li class="nav-item">
				<a href="transporters.php" class="nav-link">
					<i class="nav-icon fas fa-car"></i>
					<p>Transportation & Deliveries</p>
				</a>
			</li>
			
			<!-- Reports -->
			<li class="nav-item has-treeview">
				<a href="javascript:void(0)" class="nav-link">
					<i class="nav-icon fas fa-chart-bar"></i>
					<p>
						Reports
						<i class="fas fa-angle-left right"></i>
					</p>
				</a>
				<ul class="nav nav-treeview">
					<li class="nav-item">
						<a href="reports_sales.php" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Sales</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="reports_stock_movement.php" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Stock Movement</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="reports_purchase.php" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Purchase</p>
						</a>
					</li>
				</ul>
			</li>
			
			<!-- Users -->
			<li class="nav-item">
				<a href="users.php" class="nav-link">
					<i class="nav-icon fas fa-user-shield"></i>
					<p>User Management</p>
				</a>
			</li>
			
			<!-- Settings -->
			<li class="nav-item">
				<a href="settings_general.php" class="nav-link">
					<i class="nav-icon fas fa-cogs"></i>
					<p>System Settings</p>
				</a>
			</li>
			
			<!-- Settings -->
			<li class="nav-item">
				<a href="notifications.php" class="nav-link">
					<i class="nav-icon fas fa-bell"></i>
					<p>Notifications</p>
				</a>
			</li>
			
			<!-- System -->
			<li class="nav-item has-treeview">
				<a href="javascript:void(0)" class="nav-link">
					<i class="nav-icon fas fa-database"></i>
					<p>
						Security & Compliance
						<i class="fas fa-angle-left right"></i>
					</p>
				</a>
				<ul class="nav nav-treeview">
					<li class="nav-item">
						<a href="system_backup.php" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>System Backup</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="system_user_audits.php" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>User Audit Trails</p>
						</a>
					</li>
				</ul>
			</li>
		</ul>
	
	</div>
</aside>
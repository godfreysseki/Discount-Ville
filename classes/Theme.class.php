<?php
  
  
  class Theme extends Config
  {
    private $auditTrail;
    
    public function __construct()
    {
      parent::__construct();
      $this->auditTrail = new AuditTrail();
    }
    
    /**
     * Working on the light or dark mode
     *
     * @param $mode
     */
    public function addMode($mode)
    {
      $modes    = esc($mode);
      $username = esc($_SESSION['username']);
      
      $sql    = "select * from usertheme where username = ?";
      $params = [$username];
      $check  = $this->selectQuery($sql, $params);
      
      if ($check->num_rows > 0) {
        $sql    = "update usertheme set colorMode = ? where username = ? ";
        $params = [$modes, $username];
        return $this->updateQuery($sql, $params);
      } else {
        $sql    = "insert into usertheme (username, colorMode) values (?, ?)";
        $params = [$username, $modes];
        return $this->insertQuery($sql, $params);
      }
    }
    
    public function loadMode()
    {
      $username = esc($_SESSION['username']);
      $color    = "";
      $sql      = "select * from usertheme where username = ? ";
      $params   = [$username];
      $result   = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $color = $row['colorMode'];
        }
      }
      
      return $color;
    }
    
    /**
     * Working on the Checkboxes options
     *
     */
    
    // Header Options
    public function addFixedHeader($headerData)
    {
      $data     = esc($headerData);
      $username = esc($_SESSION['username']);
      
      $sql    = "select * from usertheme where username = ? ";
      $params = [$username];
      $check  = $this->selectQuery($sql, $params);
      
      if ($check->num_rows > 0) {
        $sql    = "update usertheme set headerFixed = ? where username = ? ";
        $params = [$data, $username];
        return $this->updateQuery($sql, $params);
      } else {
        $sql    = "insert into usertheme (username, headerFixed) values (?, ?) ";
        $params = [$username, $data];
        return $this->insertQuery($sql, $params);
      }
    }
    
    public function loadFixedHeader()
    {
      $username = esc($_SESSION['username']);
      $data     = "layout-navbar-fixed";
      $sql      = "select * from usertheme where username = ? ";
      $params   = [$username];
      $result   = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $data = $row['headerFixed'];
        }
      }
      
      return $data;
    }
    
    public function addHeaderLegacy($headerData)
    {
      $data     = esc($headerData);
      $username = esc($_SESSION['username']);
      
      $sql    = "select * from usertheme where username = ? ";
      $params = [$username];
      $check  = $this->selectQuery($sql, $params);
      
      if ($check->num_rows > 0) {
        $sql    = "update usertheme set headerLegacy = ? where username = ? ";
        $params = [$data, $username];
        return $this->updateQuery($sql, $params);
      } else {
        $sql    = "insert into usertheme (username, headerLegacy) values (?, ?) ";
        $params = [$username, $data];
        return $this->insertQuery($sql, $params);
      }
    }
    
    public function loadHeaderLegacy()
    {
      $username = esc($_SESSION['username']);
      $data     = "";
      $sql      = "select * from usertheme where username = ? ";
      $params   = [$username];
      $result   = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $data = $row['headerLegacy'];
        }
      }
      
      return $data;
    }
    
    public function addHeaderBorder($headerData)
    {
      $data     = esc($headerData);
      $username = esc($_SESSION['username']);
      
      $sql    = "select * from usertheme where username = ? ";
      $params = [$username];
      $check  = $this->selectQuery($sql, $params);
      
      if ($check->num_rows > 0) {
        $sql    = "update usertheme set headerBorder = ? where username = ? ";
        $params = [$data, $username];
        return $this->updateQuery($sql, $params);
      } else {
        $sql    = "insert into usertheme (username, headerBorder) values (?, ?) ";
        $params = [$username, $data];
        return $this->insertQuery($sql, $params);
      }
    }
    
    public function loadHeaderBorder()
    {
      $username = esc($_SESSION['username']);
      $data     = "";
      $sql      = "select * from usertheme where username = ? ";
      $params   = [$username];
      $result   = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $data = $row['headerBorder'];
        }
      }
      
      return $data;
    }
    
    // Sidebar Options
    public function addSidebarCollapsed($sidebarData)
    {
      $data     = esc($sidebarData);
      $username = esc($_SESSION['username']);
      
      $sql    = "select * from usertheme where username = ? ";
      $params = [$username];
      $check  = $this->selectQuery($sql, $params);
      
      if ($check->num_rows > 0) {
        $sql    = "update usertheme set sidebarCollapsed=? where username=? ";
        $params = [$data, $username];
        return $this->updateQuery($sql, $params);
      } else {
        $sql    = "insert into usertheme (username, sidebarCollapsed) values (?, ?) ";
        $params = [$username, $data];
        return $this->insertQuery($sql, $params);
      }
    }
    
    public function loadsidebarCollapsed()
    {
      $username = esc($_SESSION['username']);
      $data     = "";
      $sql      = "select * from usertheme where username = ? ";
      $params   = [$username];
      $result   = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $data = $row['sidebarCollapsed'];
        }
      }
      
      return $data;
    }
    
    public function addSidebarFixed($sidebarData)
    {
      $data     = esc($sidebarData);
      $username = esc($_SESSION['username']);
      
      $sql    = "select * from usertheme where username = ? ";
      $params = [$username];
      $check  = $this->selectQuery($sql, $params);
      
      if ($check->num_rows > 0) {
        $sql    = "update usertheme set sidebarFixed = ? where username = ? ";
        $params = [$data, $username];
        return $this->updateQuery($sql, $params);
      } else {
        $sql    = "insert into usertheme (username, sidebarFixed) values (?, ?) ";
        $params = [$username, $data];
        return $this->insertQuery($sql, $params);
      }
    }
    
    public function loadsidebarFixed()
    {
      $username = esc($_SESSION['username']);
      $data     = "layout-fixed";
      $sql      = "select * from usertheme where username = ? ";
      $params   = [$username];
      $result   = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $data = $row['sidebarFixed'];
        }
      }
      
      return $data;
    }
    
    public function addSidebarMini($sidebarData)
    {
      $data     = esc($sidebarData);
      $username = esc($_SESSION['username']);
      
      $sql    = "select * from usertheme where username = ? ";
      $params = [$username];
      $check  = $this->selectQuery($sql, $params);
      
      if ($check->num_rows > 0) {
        $sql    = "update usertheme set sidebarMini=? where username=? ";
        $params = [$data, $username];
        return $this->updateQuery($sql, $params);
      } else {
        $sql    = "insert into usertheme (username, sidebarMini) values (?, ?) ";
        $params = [$username, $data];
        return $this->insertQuery($sql, $params);
      }
    }
    
    public function loadsidebarMini()
    {
      $username = esc($_SESSION['username']);
      $data     = "";
      $sql      = "select * from usertheme where username = ? ";
      $params   = [$username];
      $result   = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $data = $row['sidebarMini'];
        }
      }
      
      return $data;
    }
    
    public function addSidebarMiniMD($sidebarData)
    {
      $data     = esc($sidebarData);
      $username = esc($_SESSION['username']);
      
      $sql    = "select * from usertheme where username = ? ";
      $params = [$username];
      $check  = $this->selectQuery($sql, $params);
      
      if ($check->num_rows > 0) {
        $sql    = "update usertheme set sidebarMiniMD=? where username=? ";
        $params = [$data, $username];
        return $this->updateQuery($sql, $params);
      } else {
        $sql    = "insert into usertheme (username, sidebarMiniMD) values (?, ?) ";
        $params = [$username, $data];
        return $this->insertQuery($sql, $params);
      }
    }
    
    public function loadsidebarMiniMD()
    {
      $username = esc($_SESSION['username']);
      $data     = "";
      $sql      = "select * from usertheme where username = ? ";
      $params   = [$username];
      $result   = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $data = $row['sidebarMiniMD'];
        }
      }
      
      return $data;
    }
    
    public function addSidebarMiniXS($sidebarData)
    {
      $data     = esc($sidebarData);
      $username = esc($_SESSION['username']);
      
      $sql    = "select * from usertheme where username = ? ";
      $params = [$username];
      $check  = $this->selectQuery($sql, $params);
      
      if ($check->num_rows > 0) {
        $sql    = "update usertheme set sidebarMiniXS=? where username=? ";
        $params = [$data, $username];
        return $this->updateQuery($sql, $params);
      } else {
        $sql    = "insert into usertheme (username, sidebarMiniXS) values (?, ?) ";
        $params = [$username, $data];
        return $this->insertQuery($sql, $params);
      }
    }
    
    public function loadsidebarMiniXS()
    {
      $username = esc($_SESSION['username']);
      $data     = "";
      $sql      = "select * from usertheme where username = ? ";
      $params   = [$username];
      $result   = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $data = $row['sidebarMiniXS'];
        }
      }
      
      return $data;
    }
    
    public function addSidebarFlat($sidebarData)
    {
      $data     = esc($sidebarData);
      $username = esc($_SESSION['username']);
      
      $sql    = "select * from usertheme where username = ? ";
      $params = [$username];
      $check  = $this->selectQuery($sql, $params);
      
      if ($check->num_rows > 0) {
        $sql    = "update usertheme set sidebarFlat=? where username=? ";
        $params = [$data, $username];
        return $this->updateQuery($sql, $params);
      } else {
        $sql    = "insert into usertheme (username, sidebarFlat) values (?, ?) ";
        $params = [$username, $data];
        return $this->insertQuery($sql, $params);
      }
    }
    
    public function loadsidebarFlat()
    {
      $username = esc($_SESSION['username']);
      $data     = "nav-flat";
      $sql      = "select * from usertheme where username = ? ";
      $params   = [$username];
      $result   = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $data = $row['sidebarFlat'];
        }
      }
      
      return $data;
    }
    
    public function addSidebarLegacy($sidebarData)
    {
      $data     = esc($sidebarData);
      $username = esc($_SESSION['username']);
      
      $sql    = "select * from usertheme where username = ? ";
      $params = [$username];
      $check  = $this->selectQuery($sql, $params);
      
      if ($check->num_rows > 0) {
        $sql    = "update usertheme set sidebarLegacy=? where username=? ";
        $params = [$data, $username];
        return $this->updateQuery($sql, $params);
      } else {
        $sql    = "insert into usertheme (username, sidebarLegacy) values (?, ?) ";
        $params = [$username, $data];
        return $this->insertQuery($sql, $params);
      }
    }
    
    public function loadsidebarLegacy()
    {
      $username = esc($_SESSION['username']);
      $data     = "";
      $sql      = "select * from usertheme where username = ? ";
      $params   = [$username];
      $result   = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $data = $row['sidebarLegacy'];
        }
      }
      
      return $data;
    }
    
    public function addSidebarCompact($sidebarData)
    {
      $data     = esc($sidebarData);
      $username = esc($_SESSION['username']);
      
      $sql    = "select * from usertheme where username = ? ";
      $params = [$username];
      $check  = $this->selectQuery($sql, $params);
      
      if ($check->num_rows > 0) {
        $sql    = "update usertheme set sidebarCompact=? where username=? ";
        $params = [$data, $username];
        return $this->updateQuery($sql, $params);
      } else {
        $sql    = "insert into usertheme (username, sidebarCompact) values (?, ?) ";
        $params = [$username, $data];
        return $this->insertQuery($sql, $params);
      }
    }
    
    public function loadsidebarCompact()
    {
      $username = esc($_SESSION['username']);
      $data     = "nav-compact";
      $sql      = "select * from usertheme where username = ? ";
      $params   = [$username];
      $result   = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $data = $row['sidebarCompact'];
        }
      }
      
      return $data;
    }
    
    public function addSidebarIndentChild($sidebarData)
    {
      $data     = esc($sidebarData);
      $username = esc($_SESSION['username']);
      
      $sql    = "select * from usertheme where username = ? ";
      $params = [$username];
      $check  = $this->selectQuery($sql, $params);
      
      if ($check->num_rows > 0) {
        $sql    = "update usertheme set sidebarIndentChild=? where username=? ";
        $params = [$data, $username];
        return $this->updateQuery($sql, $params);
      } else {
        $sql    = "insert into usertheme (username, sidebarIndentChild) values (?, ?) ";
        $params = [$username, $data];
        return $this->insertQuery($sql, $params);
      }
    }
    
    public function loadsidebarIndentChild()
    {
      $username = esc($_SESSION['username']);
      $data     = "nav-child-indent";
      $sql      = "select * from usertheme where username = ? ";
      $params   = [$username];
      $result   = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $data = $row['sidebarIndentChild'];
        }
      }
      
      return $data;
    }
    
    public function addSidebarHideChildOnCollapse($sidebarData)
    {
      $data     = esc($sidebarData);
      $username = esc($_SESSION['username']);
      
      $sql    = "select * from usertheme where username = ? ";
      $params = [$username];
      $check  = $this->selectQuery($sql, $params);
      
      if ($check->num_rows > 0) {
        $sql    = "update usertheme set sidebarHideChildOnCollapse=? where username=? ";
        $params = [$data, $username];
        return $this->updateQuery($sql, $params);
      } else {
        $sql    = "insert into usertheme (username, sidebarHideChildOnCollapse) values (?, ?) ";
        $params = [$username, $data];
        return $this->insertQuery($sql, $params);
      }
    }
    
    public function loadsidebarHideChildOnCollapse()
    {
      $username = esc($_SESSION['username']);
      $data     = "";
      $sql      = "select * from usertheme where username = ? ";
      $params   = [$username];
      $result   = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $data = $row['sidebarHideChildOnCollapse'];
        }
      }
      
      return $data;
    }
    
    public function addSidebarDisableHover($sidebarData)
    {
      $data     = esc($sidebarData);
      $username = esc($_SESSION['username']);
      
      $sql    = "select * from usertheme where username = ? ";
      $params = [$username];
      $check  = $this->selectQuery($sql, $params);
      
      if ($check->num_rows > 0) {
        $sql    = "update usertheme set sidebarDisableHover=? where username=? ";
        $params = [$data, $username];
        return $this->updateQuery($sql, $params);
      } else {
        $sql    = "insert into usertheme (username, sidebarDisableHover) values (?, ?) ";
        $params = [$username, $data];
        return $this->insertQuery($sql, $params);
      }
    }
    
    public function loadsidebarDisableHover()
    {
      $username = esc($_SESSION['username']);
      $data     = "";
      $sql      = "select * from usertheme where username = ? ";
      $params   = [$username];
      $result   = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $data = $row['sidebarDisableHover'];
        }
      }
      
      return $data;
    }
    
    // Fixed Footer
    public function addFixedFooter($footerData)
    {
      $data     = esc($footerData);
      $username = esc($_SESSION['username']);
      
      $sql    = "select * from usertheme where username = ? ";
      $params = [$username];
      $check  = $this->selectQuery($sql, $params);
      
      if ($check->num_rows > 0) {
        $sql    = "update usertheme set footerFixed=? where username=? ";
        $params = [$data, $username];
        return $this->updateQuery($sql, $params);
      } else {
        $sql    = "insert into usertheme (username, footerFixed) values (?, ?) ";
        $params = [$username, $data];
        return $this->insertQuery($sql, $params);
      }
    }
    
    public function loadFixedFooter()
    {
      $username = esc($_SESSION['username']);
      $data     = "layout-footer-fixed";
      $sql      = "select * from usertheme where username = ? ";
      $params   = [$username];
      $result   = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $data = $row['footerFixed'];
        }
      }
      
      return $data;
    }
    
    // Small Text in the design
    public function addSmallBodyText($smallTextData)
    {
      $data     = esc($smallTextData);
      $username = esc($_SESSION['username']);
      
      $sql    = "select * from usertheme where username = ? ";
      $params = [$username];
      $check  = $this->selectQuery($sql, $params);
      
      if ($check->num_rows > 0) {
        $sql    = "update usertheme set smallBodyText=? where username=? ";
        $params = [$data, $username];
        return $this->updateQuery($sql, $params);
      } else {
        $sql    = "insert into usertheme (username, smallBodyText) values (?, ?) ";
        $params = [$username, $data];
        return $this->insertQuery($sql, $params);
      }
    }
    
    public function loadSmallBodyText()
    {
      $username = esc($_SESSION['username']);
      $data     = "text-sm";
      $sql      = "select * from usertheme where username = ? ";
      $params   = [$username];
      $result   = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $data = $row['smallBodyText'];
        }
      }
      
      return $data;
    }
    
    public function addSmallNavbarText($smallTextData)
    {
      $data     = esc($smallTextData);
      $username = esc($_SESSION['username']);
      
      $sql    = "select * from usertheme where username = ? ";
      $params = [$username];
      $check  = $this->selectQuery($sql, $params);
      
      if ($check->num_rows > 0) {
        $sql    = "update usertheme set smallNavbarText=? where username=? ";
        $params = [$data, $username];
        return $this->updateQuery($sql, $params);
      } else {
        $sql    = "insert into usertheme (username, smallNavbarText) values (?, ?) ";
        $params = [$username, $data];
        return $this->insertQuery($sql, $params);
      }
    }
    
    public function loadSmallNavbarText()
    {
      $username = esc($_SESSION['username']);
      $data     = "";
      $sql      = "select * from usertheme where username = ? ";
      $params   = [$username];
      $result   = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $data = $row['smallNavbarText'];
        }
      }
      
      return $data;
    }
    
    public function addSmallBrand($smallTextData)
    {
      $data     = esc($smallTextData);
      $username = esc($_SESSION['username']);
      
      $sql    = "select * from usertheme where username = ? ";
      $params = [$username];
      $check  = $this->selectQuery($sql, $params);
      
      if ($check->num_rows > 0) {
        $sql    = "update usertheme set smallBrand=? where username=? ";
        $params = [$data, $username];
        return $this->updateQuery($sql, $params);
      } else {
        $sql    = "insert into usertheme (username, smallBrand) values (?, ?) ";
        $params = [$username, $data];
        return $this->insertQuery($sql, $params);
      }
    }
    
    public function loadSmallBrand()
    {
      $username = esc($_SESSION['username']);
      $data     = "";
      $sql      = "select * from usertheme where username = ? ";
      $params   = [$username];
      $result   = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $data = $row['smallBrand'];
        }
      }
      
      return $data;
    }
    
    public function addSmallSidebarText($smallTextData)
    {
      $data     = esc($smallTextData);
      $username = esc($_SESSION['username']);
      
      $sql    = "select * from usertheme where username = ? ";
      $params = [$username];
      $check  = $this->selectQuery($sql, $params);
      
      if ($check->num_rows > 0) {
        $sql    = "update usertheme set smallSidebarText=? where username=? ";
        $params = [$data, $username];
        return $this->updateQuery($sql, $params);
      } else {
        $sql    = "insert into usertheme (username, smallSidebarText) values (?, ?) ";
        $params = [$username, $data];
        return $this->insertQuery($sql, $params);
      }
    }
    
    public function loadSmallSidebarText()
    {
      $username = esc($_SESSION['username']);
      $data     = "";
      $sql      = "select * from usertheme where username = ? ";
      $params   = [$username];
      $result   = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $data = $row['smallSidebarText'];
        }
      }
      
      return $data;
    }
    
    public function addSmallFooterText($smallTextData)
    {
      $data     = esc($smallTextData);
      $username = esc($_SESSION['username']);
      
      $sql    = "select * from usertheme where username = ? ";
      $params = [$username];
      $check  = $this->selectQuery($sql, $params);
      
      if ($check->num_rows > 0) {
        $sql    = "update usertheme set smallFooterText=? where username=? ";
        $params = [$data, $username];
        return $this->updateQuery($sql, $params);
      } else {
        $sql    = "insert into usertheme (username, smallFooterText) values (?, ?) ";
        $params = [$username, $data];
        return $this->insertQuery($sql, $params);
      }
    }
    
    public function loadSmallFooterText()
    {
      $username = esc($_SESSION['username']);
      $data     = "";
      $sql      = "select * from usertheme where username = ? ";
      $params   = [$username];
      $result   = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $data = $row['smallFooterText'];
        }
      }
      
      return $data;
    }
    
    /**
     * Start on the color themes
     *
     * @param $themeData
     */
    public function addTheme($themeData)
    {
      $username = esc($_SESSION['username']);
      $color    = esc($themeData);
      
      $sql    = "select * from usertheme where username = ? ";
      $params = [$username];
      $check  = $this->selectQuery($sql, $params);
      
      if ($check->num_rows > 0) {
        // User exists, just update the themes
        if (str_starts_with($color, "logo ")) {
          $sql = "UPDATE userTheme SET logoTheme=? WHERE username=? ";
          $params = [str_replace("logo ", "", $color), $username];
          return $this->updateQuery($sql, $params);
        }
        if (str_starts_with($color, "navbar")) {
          $sql = "UPDATE userTheme SET navbarTheme=? WHERE username=? ";
          $params = [$color, $username];
          return $this->updateQuery($sql, $params);
        }
        if (str_starts_with($color, "sidebar")) {
          $sql = "UPDATE userTheme SET sidebarSkin=? WHERE username=? ";
          $params = [$color, $username];
          return $this->updateQuery($sql, $params);
        }
        if (str_starts_with($color, "accent")) {
          $sql    = "UPDATE userTheme SET accentTheme=? WHERE username=? ";
          $params = [$color, $username];
          return $this->updateQuery($sql, $params);
        }
      } else {
        // Create User in the themes table and add the theme
        if (str_starts_with($color, "logo ")) {
          $sql    = "insert into userTheme (username, logoTheme) values (?, ?)";
          $params = [$username, str_replace("logo ", "", $color)];
          return $this->insertQuery($sql, $params);
        }
        if (str_starts_with($color, "navbar")) {
          $sql    = "insert into userTheme (username, navbarTheme) values (?, ?)";
          $params = [$username, $color];
          return $this->insertQuery($sql, $params);
        }
        if (str_starts_with($color, "sidebar")) {
          $sql    = "insert into userTheme (username, sidebarSkin) values (?, ?)";
          $params = [$username, $color];
          return $this->insertQuery($sql, $params);
        }
        if (str_starts_with($color, "accent")) {
          $sql    = "insert into userTheme (username, accentTheme) values (?, ?)";
          $params = [$username, $color];
          return $this->insertQuery($sql, $params);
        }
      }
    }
    
    public function loadLogoTheme()
    {
      $username = esc($_SESSION['username']);
      $color    = "navbar-primary";
      $sql      = "select * from usertheme where username = ? ";
      $params   = [$username];
      $result   = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $color = $row['logoTheme'];
        }
      }
      
      return $color;
    }
    
    public function loadTopNavbarTheme()
    {
      $username = esc($_SESSION['username']);
      $color    = "navbar-white navbar-light";
      $sql      = "select * from usertheme where username = ? ";
      $params   = [$username];
      $result   = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $color = $row['navbarTheme'];
        }
      }
      
      return $color;
    }
    
    public function loadSidebarTheme()
    {
      $username = esc($_SESSION['username']);
      $color    = "sidebar-dark-primary";
      $sql      = "select * from usertheme where username = ? ";
      $params   = [$username];
      $result   = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $color = $row['sidebarSkin'];
        }
      }
      
      return $color;
    }
    
    public function loadAccentTheme()
    {
      $username = esc($_SESSION['username']);
      $color    = "";
      $sql      = "select * from usertheme where username = ? ";
      $params   = [$username];
      $result   = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $color = $row['accentTheme'];
        }
      }
      
      return $color;
    }
    
  }
<?php
  
  include_once "../includes/config.inc.php";
  
  $check = new Users();
  $check->checkRole(ROLE);
  
  $theme = new Theme();
  
  if (isset($_POST['modeData'])) {
    $theme->addMode($_POST['modeData']);
  }
  
  
  if (isset($_POST['headerFixedData'])) {
    $theme->addFixedHeader($_POST['headerFixedData']);
  }
  if (isset($_POST['headerLegacyData'])) {
    $theme->addHeaderLegacy($_POST['headerLegacyData']);
  }
  if (isset($_POST['headerBorderData'])) {
    $theme->addHeaderBorder($_POST['headerBorderData']);
  }
  
  
  if (isset($_POST['sidebarCollapseData'])) {
    $theme->addSidebarCollapsed($_POST['sidebarCollapseData']);
  }
  if (isset($_POST['sidebarFixedData'])) {
    $theme->addSidebarFixed($_POST['sidebarFixedData']);
  }
  if (isset($_POST['sidebarMiniData'])) {
    $theme->addSidebarMini($_POST['sidebarMiniData']);
  }
  if (isset($_POST['sidebarMiniMDData'])) {
    $theme->addSidebarMiniMD($_POST['sidebarMiniMDData']);
  }
  if (isset($_POST['sidebarMiniXSData'])) {
    $theme->addSidebarMiniXS($_POST['sidebarMiniXSData']);
  }
  if (isset($_POST['sidebarFlatData'])) {
    $theme->addSidebarFlat($_POST['sidebarFlatData']);
  }
  if (isset($_POST['sidebarLegacyData'])) {
    $theme->addSidebarLegacy($_POST['sidebarLegacyData']);
  }
  if (isset($_POST['sidebarCompactData'])) {
    $theme->addSidebarCompact($_POST['sidebarCompactData']);
  }
  if (isset($_POST['sidebarIndentChildData'])) {
    $theme->addSidebarIndentChild($_POST['sidebarIndentChildData']);
  }
  if (isset($_POST['sidebarHideOnCollapseChildData'])) {
    $theme->addSidebarHideChildOnCollapse($_POST['sidebarHideOnCollapseChildData']);
  }
  if (isset($_POST['sidebarDisableHoverData'])) {
    $theme->addSidebarDisableHover($_POST['sidebarDisableHoverData']);
  }
  
  
  if (isset($_POST['fixedFooterData'])) {
    $theme->addFixedFooter($_POST['fixedFooterData']);
  }
  
  
  if (isset($_POST['smallBodyTextData'])) {
    $theme->addSmallBodyText($_POST['smallBodyTextData']);
  }
  if (isset($_POST['smallNavbarTextData'])) {
    $theme->addSmallNavbarText($_POST['smallNavbarTextData']);
  }
  if (isset($_POST['smallBrandData'])) {
    $theme->addSmallBrand($_POST['smallBrandData']);
  }
  if (isset($_POST['smallSidebarTextData'])) {
    $theme->addSmallSidebarText($_POST['smallSidebarTextData']);
  }
  if (isset($_POST['smallFooterTextData'])) {
    $theme->addSmallFooterText($_POST['smallFooterTextData']);
  }
  
  
  if (isset($_POST['themeData'])) {
    $theme->addTheme($_POST['themeData']);
  }
  
  
  if (isset($_POST['minimizeNoticeBoard'])) {
    $theme->minimizeNoticeBoard($_POST['minimizeNoticeBoard']);
  }
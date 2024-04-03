(function($) {
  'use strict';
  
  function capitalizeFirstLetter(string)
  {
    return string.charAt(0).toUpperCase() + string.slice(1);
  }
  
  var $sidebar = $('.control-sidebar');
  var $container = $('<div />', {
    class: 'p-3 control-sidebar-content',
  });
  
  $sidebar.append($container);
  
  // Checkboxes
  
  $container.append('<h5>Panel Outlook</h5><hr class="mb-2"/>');
  
  var $dark_mode_checkbox = $('<input />', {
    type: 'checkbox', value: 1, checked: $('body').hasClass('dark-mode'), class: 'mr-1',
  }).on('click', function() {
    if ($(this).is(':checked')) {
      $('body').addClass('dark-mode');
      $.ajax({
        url: 'theme.php', type: 'post', data: {modeData: 'dark-mode'},
      });
    }
    else {
      $('body').removeClass('dark-mode');
      $.ajax({
        url: 'theme.php', type: 'post', data: {modeData: ''},
      });
    }
  });
  var $dark_mode_container = $('<div />', {class: 'mb-4'}).append($dark_mode_checkbox).append('<span>Dark Mode</span>');
  $container.append($dark_mode_container);
  
  $container.append('<h6>Header Options</h6>');
  
  var $header_fixed_checkbox = $('<input />', {
    type: 'checkbox', value: 1, checked: $('body').hasClass('layout-navbar-fixed'), class: 'mr-1',
  }).on('click', function() {
    if ($(this).is(':checked')) {
      $('body').addClass('layout-navbar-fixed');
      $.ajax({
        url: 'theme.php', type: 'post', data: {headerFixedData: 'layout-navbar-fixed'},
      });
    }
    else {
      $('body').removeClass('layout-navbar-fixed');
      $.ajax({
        url: 'theme.php', type: 'post', data: {headerFixedData: ''},
      });
    }
  });
  var $header_fixed_container = $('<div />', {class: 'mb-1'}).append($header_fixed_checkbox).append('<span>Fixed</span>');
  $container.append($header_fixed_container);
  
  var $dropdown_legacy_offset_checkbox = $('<input />', {
    type: 'checkbox', value: 1, checked: $('.main-header').hasClass('dropdown-legacy'), class: 'mr-1',
  }).on('click', function() {
    if ($(this).is(':checked')) {
      $('.main-header').addClass('dropdown-legacy');
      $.ajax({
        url: 'theme.php', type: 'post', data: {headerLegacyData: 'dropdown-legacy'},
      });
    }
    else {
      $('.main-header').removeClass('dropdown-legacy');
      $.ajax({
        url: 'theme.php', type: 'post', data: {headerLegacyData: ''},
      });
    }
  });
  var $dropdown_legacy_offset_container = $('<div />', {class: 'mb-1'}).append($dropdown_legacy_offset_checkbox).append('<span>Dropdown Legacy Offset</span>');
  $container.append($dropdown_legacy_offset_container);
  
  var $no_border_checkbox = $('<input />', {
    type: 'checkbox', value: 1, checked: $('.main-header').hasClass('border-bottom-0'), class: 'mr-1',
  }).on('click', function() {
    if ($(this).is(':checked')) {
      $('.main-header').addClass('border-bottom-0');
      $.ajax({
        url: 'theme.php', type: 'post', data: {headerBorderData: 'border-bottom-0'},
      });
    }
    else {
      $('.main-header').removeClass('border-bottom-0');
      $.ajax({
        url: 'theme.php', type: 'post', data: {headerBorderData: ''},
      });
    }
  });
  var $no_border_container = $('<div />', {class: 'mb-4'}).append($no_border_checkbox).append('<span>No border</span>');
  $container.append($no_border_container);
  
  $container.append('<h6>Sidebar Options</h6>');
  
  var $sidebar_collapsed_checkbox = $('<input />', {
    type: 'checkbox', value: 1, checked: $('body').hasClass('sidebar-collapse'), class: 'mr-1',
  }).on('click', function() {
    if ($(this).is(':checked')) {
      $('body').addClass('sidebar-collapse');
      $(window).trigger('resize');
      $.ajax({
        url: 'theme.php', type: 'post', data: {sidebarCollapseData: 'sidebar-collapse'},
      });
    }
    else {
      $('body').removeClass('sidebar-collapse');
      $(window).trigger('resize');
      $.ajax({
        url: 'theme.php', type: 'post', data: {sidebarCollapseData: ''},
      });
    }
  });
  var $sidebar_collapsed_container = $('<div />', {class: 'mb-1'}).append($sidebar_collapsed_checkbox).append('<span>Collapsed</span>');
  $container.append($sidebar_collapsed_container);
  
  $(document).on('collapsed.lte.pushmenu', '[data-widget="pushmenu"]', function() {
    $sidebar_collapsed_checkbox.prop('checked', true);
  });
  $(document).on('shown.lte.pushmenu', '[data-widget="pushmenu"]', function() {
    $sidebar_collapsed_checkbox.prop('checked', false);
  });
  
  var $sidebar_fixed_checkbox = $('<input />', {
    type: 'checkbox', value: 1, checked: $('body').hasClass('layout-fixed'), class: 'mr-1',
  }).on('click', function() {
    if ($(this).is(':checked')) {
      $('body').addClass('layout-fixed');
      $(window).trigger('resize');
      $.ajax({
        url: 'theme.php', type: 'post', data: {sidebarFixedData: 'layout-fixed'},
      });
    }
    else {
      $('body').removeClass('layout-fixed');
      $(window).trigger('resize');
      $.ajax({
        url: 'theme.php', type: 'post', data: {sidebarFixedData: ''},
      });
    }
  });
  var $sidebar_fixed_container = $('<div />', {class: 'mb-1'}).append($sidebar_fixed_checkbox).append('<span>Fixed</span>');
  $container.append($sidebar_fixed_container);
  
  var $sidebar_mini_checkbox = $('<input />', {
    type: 'checkbox', value: 1, checked: $('body').hasClass('sidebar-mini'), class: 'mr-1',
  }).on('click', function() {
    if ($(this).is(':checked')) {
      $('body').addClass('sidebar-mini');
      $.ajax({
        url: 'theme.php', type: 'post', data: {sidebarMiniData: 'sidebar-mini'},
      });
    }
    else {
      $('body').removeClass('sidebar-mini');
      $.ajax({
        url: 'theme.php', type: 'post', data: {sidebarMiniData: ''},
      });
    }
  });
  var $sidebar_mini_container = $('<div />', {class: 'mb-1'}).append($sidebar_mini_checkbox).append('<span>Sidebar Mini</span>');
  $container.append($sidebar_mini_container);
  
  var $sidebar_mini_md_checkbox = $('<input />', {
    type: 'checkbox', value: 1, checked: $('body').hasClass('sidebar-mini-md'), class: 'mr-1',
  }).on('click', function() {
    if ($(this).is(':checked')) {
      $('body').addClass('sidebar-mini-md');
      $.ajax({
        url: 'theme.php', type: 'post', data: {sidebarMiniMDData: 'sidebar-mini-md'},
      });
    }
    else {
      $('body').removeClass('sidebar-mini-md');
      $.ajax({
        url: 'theme.php', type: 'post', data: {sidebarMiniMDData: ''},
      });
    }
  });
  var $sidebar_mini_md_container = $('<div />', {class: 'mb-1'}).append($sidebar_mini_md_checkbox).append('<span>Sidebar Mini MD</span>');
  $container.append($sidebar_mini_md_container);
  
  var $sidebar_mini_xs_checkbox = $('<input />', {
    type: 'checkbox', value: 1, checked: $('body').hasClass('sidebar-mini-xs'), class: 'mr-1',
  }).on('click', function() {
    if ($(this).is(':checked')) {
      $('body').addClass('sidebar-mini-xs');
      $.ajax({
        url: 'theme.php', type: 'post', data: {sidebarMiniXSData: 'sidebar-mini-xs'},
      });
    }
    else {
      $('body').removeClass('sidebar-mini-xs');
      $.ajax({
        url: 'theme.php', type: 'post', data: {sidebarMiniXSData: ''},
      });
    }
  });
  var $sidebar_mini_xs_container = $('<div />', {class: 'mb-1'}).append($sidebar_mini_xs_checkbox).append('<span>Sidebar Mini XS</span>');
  $container.append($sidebar_mini_xs_container);
  
  var $flat_sidebar_checkbox = $('<input />', {
    type: 'checkbox', value: 1, checked: $('.nav-sidebar').hasClass('nav-flat'), class: 'mr-1',
  }).on('click', function() {
    if ($(this).is(':checked')) {
      $('.nav-sidebar').addClass('nav-flat');
      $.ajax({
        url: 'theme.php', type: 'post', data: {sidebarFlatData: 'nav-flat'},
      });
    }
    else {
      $('.nav-sidebar').removeClass('nav-flat');
      $.ajax({
        url: 'theme.php', type: 'post', data: {sidebarFlatData: ''},
      });
    }
  });
  var $flat_sidebar_container = $('<div />', {class: 'mb-1'}).append($flat_sidebar_checkbox).append('<span>Nav Flat Style</span>');
  $container.append($flat_sidebar_container);
  
  var $legacy_sidebar_checkbox = $('<input />', {
    type: 'checkbox', value: 1, checked: $('.nav-sidebar').hasClass('nav-legacy'), class: 'mr-1',
  }).on('click', function() {
    if ($(this).is(':checked')) {
      $('.nav-sidebar').addClass('nav-legacy');
      $.ajax({
        url: 'theme.php', type: 'post', data: {sidebarLegacyData: 'nav-legacy'},
      });
    }
    else {
      $('.nav-sidebar').removeClass('nav-legacy');
      $.ajax({
        url: 'theme.php', type: 'post', data: {sidebarLegacyData: ''},
      });
    }
  });
  var $legacy_sidebar_container = $('<div />', {class: 'mb-1'}).append($legacy_sidebar_checkbox).append('<span>Nav Legacy Style</span>');
  $container.append($legacy_sidebar_container);
  
  var $compact_sidebar_checkbox = $('<input />', {
    type: 'checkbox', value: 1, checked: $('.nav-sidebar').hasClass('nav-compact'), class: 'mr-1',
  }).on('click', function() {
    if ($(this).is(':checked')) {
      $('.nav-sidebar').addClass('nav-compact');
      $.ajax({
        url: 'theme.php', type: 'post', data: {sidebarCompactData: 'nav-compact'},
      });
    }
    else {
      $('.nav-sidebar').removeClass('nav-compact');
      $.ajax({
        url: 'theme.php', type: 'post', data: {sidebarCompactData: ''},
      });
    }
  });
  var $compact_sidebar_container = $('<div />', {class: 'mb-1'}).append($compact_sidebar_checkbox).append('<span>Nav Compact</span>');
  $container.append($compact_sidebar_container);
  
  var $child_indent_sidebar_checkbox = $('<input />', {
    type: 'checkbox', value: 1, checked: $('.nav-sidebar').hasClass('nav-child-indent'), class: 'mr-1',
  }).on('click', function() {
    if ($(this).is(':checked')) {
      $('.nav-sidebar').addClass('nav-child-indent');
      $.ajax({
        url: 'theme.php', type: 'post', data: {sidebarIndentChildData: 'nav-child-indent'},
      });
    }
    else {
      $('.nav-sidebar').removeClass('nav-child-indent');
      $.ajax({
        url: 'theme.php', type: 'post', data: {sidebarIndentChildData: ''},
      });
    }
  });
  var $child_indent_sidebar_container = $('<div />', {class: 'mb-1'}).append($child_indent_sidebar_checkbox).append('<span>Nav Child Indent</span>');
  $container.append($child_indent_sidebar_container);
  
  var $child_hide_sidebar_checkbox = $('<input />', {
    type: 'checkbox', value: 1, checked: $('.nav-sidebar').hasClass('nav-collapse-hide-child'), class: 'mr-1',
  }).on('click', function() {
    if ($(this).is(':checked')) {
      $('.nav-sidebar').addClass('nav-collapse-hide-child');
      $.ajax({
        url: 'theme.php', type: 'post', data: {sidebarHideOnCollapseChildData: 'nav-collapse-hide-child'},
      });
    }
    else {
      $('.nav-sidebar').removeClass('nav-collapse-hide-child');
      $.ajax({
        url: 'theme.php', type: 'post', data: {sidebarHideOnCollapseChildData: ''},
      });
    }
  });
  var $child_hide_sidebar_container = $('<div />', {class: 'mb-1'}).append($child_hide_sidebar_checkbox).append('<span>Nav Child Hide on Collapse</span>');
  $container.append($child_hide_sidebar_container);
  
  var $no_expand_sidebar_checkbox = $('<input />', {
    type: 'checkbox', value: 1, checked: $('.main-sidebar').hasClass('sidebar-no-expand'), class: 'mr-1',
  }).on('click', function() {
    if ($(this).is(':checked')) {
      $('.main-sidebar').addClass('sidebar-no-expand');
      $.ajax({
        url: 'theme.php', type: 'post', data: {sidebarDisableHoverData: 'sidebar-no-expand'},
      });
    }
    else {
      $('.main-sidebar').removeClass('sidebar-no-expand');
      $.ajax({
        url: 'theme.php', type: 'post', data: {sidebarDisableHoverData: ''},
      });
    }
  });
  var $no_expand_sidebar_container = $('<div />', {class: 'mb-4'}).append($no_expand_sidebar_checkbox).append('<span>Disable Hover/Focus Auto-Expand</span>');
  $container.append($no_expand_sidebar_container);
  
  $container.append('<h6>Footer Options</h6>');
  
  var $footer_fixed_checkbox = $('<input />', {
    type: 'checkbox', value: 1, checked: $('body').hasClass('layout-footer-fixed'), class: 'mr-1',
  }).on('click', function() {
    if ($(this).is(':checked')) {
      $('body').addClass('layout-footer-fixed');
      $.ajax({
        url: 'theme.php', type: 'post', data: {fixedFooterData: 'layout-footer-fixed'},
      });
    }
    else {
      $('body').removeClass('layout-footer-fixed');
      $.ajax({
        url: 'theme.php', type: 'post', data: {fixedFooterData: ''},
      });
    }
  });
  var $footer_fixed_container = $('<div />', {class: 'mb-4'}).append($footer_fixed_checkbox).append('<span>Fixed</span>');
  $container.append($footer_fixed_container);
  
  $container.append('<h6>Small Text Options</h6>');
  
  var $text_sm_body_checkbox = $('<input />', {
    type: 'checkbox', value: 1, checked: $('body').hasClass('text-sm'), class: 'mr-1',
  }).on('click', function() {
    if ($(this).is(':checked')) {
      $('body').addClass('text-sm');
      $.ajax({
        url: 'theme.php', type: 'post', data: {smallBodyTextData: 'text-sm'},
      });
    }
    else {
      $('body').removeClass('text-sm');
      $.ajax({
        url: 'theme.php', type: 'post', data: {smallBodyTextData: ''},
      });
    }
  });
  var $text_sm_body_container = $('<div />', {class: 'mb-1'}).append($text_sm_body_checkbox).append('<span>Body</span>');
  $container.append($text_sm_body_container);
  
  var $text_sm_header_checkbox = $('<input />', {
    type: 'checkbox', value: 1, checked: $('.main-header').hasClass('text-sm'), class: 'mr-1',
  }).on('click', function() {
    if ($(this).is(':checked')) {
      $('.main-header').addClass('text-sm');
      $.ajax({
        url: 'theme.php', type: 'post', data: {smallNavbarTextData: 'text-sm'},
      });
    }
    else {
      $('.main-header').removeClass('text-sm');
      $.ajax({
        url: 'theme.php', type: 'post', data: {smallNavbarTextData: ''},
      });
    }
  });
  var $text_sm_header_container = $('<div />', {class: 'mb-1'}).append($text_sm_header_checkbox).append('<span>Navbar</span>');
  $container.append($text_sm_header_container);
  
  var $text_sm_brand_checkbox = $('<input />', {
    type: 'checkbox', value: 1, checked: $('.brand-link').hasClass('text-sm'), class: 'mr-1',
  }).on('click', function() {
    if ($(this).is(':checked')) {
      $('.brand-link').addClass('text-sm');
      $.ajax({
        url: 'theme.php', type: 'post', data: {smallBrandData: 'text-sm'},
      });
    }
    else {
      $('.brand-link').removeClass('text-sm');
      $.ajax({
        url: 'theme.php', type: 'post', data: {smallBrandData: ''},
      });
    }
  });
  var $text_sm_brand_container = $('<div />', {class: 'mb-1'}).append($text_sm_brand_checkbox).append('<span>Brand</span>');
  $container.append($text_sm_brand_container);
  
  var $text_sm_sidebar_checkbox = $('<input />', {
    type: 'checkbox', value: 1, checked: $('.nav-sidebar').hasClass('text-sm'), class: 'mr-1',
  }).on('click', function() {
    if ($(this).is(':checked')) {
      $('.nav-sidebar').addClass('text-sm');
      $.ajax({
        url: 'theme.php', type: 'post', data: {smallSidebarTextData: 'text-sm'},
      });
    }
    else {
      $('.nav-sidebar').removeClass('text-sm');
      $.ajax({
        url: 'theme.php', type: 'post', data: {smallSidebarTextData: ''},
      });
    }
  });
  var $text_sm_sidebar_container = $('<div />', {class: 'mb-1'}).append($text_sm_sidebar_checkbox).append('<span>Sidebar Nav</span>');
  $container.append($text_sm_sidebar_container);
  
  var $text_sm_footer_checkbox = $('<input />', {
    type: 'checkbox', value: 1, checked: $('.main-footer').hasClass('text-sm'), class: 'mr-1',
  }).on('click', function() {
    if ($(this).is(':checked')) {
      $('.main-footer').addClass('text-sm');
      $.ajax({
        url: 'theme.php', type: 'post', data: {smallFooterTextData: 'text-sm'},
      });
    }
    else {
      $('.main-footer').removeClass('text-sm');
      $.ajax({
        url: 'theme.php', type: 'post', data: {smallFooterTextData: ''},
      });
    }
  });
  var $text_sm_footer_container = $('<div />', {class: 'mb-4'}).append($text_sm_footer_checkbox).append('<span>Footer</span>');
  $container.append($text_sm_footer_container);
  
  // Color Arrays
  
  var navbar_dark_skins = [
    'navbar-primary',
    'navbar-secondary',
    'navbar-info',
    'navbar-success',
    'navbar-danger',
    'navbar-indigo',
    'navbar-purple',
    'navbar-pink',
    'navbar-navy',
    'navbar-lightblue',
    'navbar-teal',
    'navbar-cyan',
    'navbar-dark',
    'navbar-gray-dark',
    'navbar-gray',
  ];
  
  var navbar_light_skins = [
    'navbar-light', 'navbar-warning', 'navbar-white', 'navbar-orange',
  ];
  
  var sidebar_colors = [
    'bg-primary',
    'bg-warning',
    'bg-info',
    'bg-danger',
    'bg-success',
    'bg-indigo',
    'bg-lightblue',
    'bg-navy',
    'bg-purple',
    'bg-fuchsia',
    'bg-pink',
    'bg-maroon',
    'bg-orange',
    'bg-lime',
    'bg-teal',
    'bg-olive',
  ];
  
  var accent_colors = [
    'accent-primary',
    'accent-warning',
    'accent-info',
    'accent-danger',
    'accent-success',
    'accent-indigo',
    'accent-lightblue',
    'accent-navy',
    'accent-purple',
    'accent-fuchsia',
    'accent-pink',
    'accent-maroon',
    'accent-orange',
    'accent-lime',
    'accent-teal',
    'accent-olive',
  ];
  
  var sidebar_skins = [
    'sidebar-dark-primary',
    'sidebar-dark-warning',
    'sidebar-dark-info',
    'sidebar-dark-danger',
    'sidebar-dark-success',
    'sidebar-dark-indigo',
    'sidebar-dark-lightblue',
    'sidebar-dark-navy',
    'sidebar-dark-purple',
    'sidebar-dark-fuchsia',
    'sidebar-dark-pink',
    'sidebar-dark-maroon',
    'sidebar-dark-orange',
    'sidebar-dark-lime',
    'sidebar-dark-teal',
    'sidebar-dark-olive',
    'sidebar-light-primary',
    'sidebar-light-warning',
    'sidebar-light-info',
    'sidebar-light-danger',
    'sidebar-light-success',
    'sidebar-light-indigo',
    'sidebar-light-lightblue',
    'sidebar-light-navy',
    'sidebar-light-purple',
    'sidebar-light-fuchsia',
    'sidebar-light-pink',
    'sidebar-light-maroon',
    'sidebar-light-orange',
    'sidebar-light-lime',
    'sidebar-light-teal',
    'sidebar-light-olive',
  ];
  
  // Navbar Variants
  
  $container.append('<h6>Navbar Variants</h6>');
  
  var $navbar_variants = $('<div />', {
    'class': 'd-flex',
  });
  var navbar_all_colors = navbar_dark_skins.concat(navbar_light_skins);
  var $navbar_variants_colors = createSkinBlock(navbar_all_colors, function(e) {
    var color = $(this).data('color');
    var $main_header = $('.main-header');
    $main_header.removeClass('navbar-dark').removeClass('navbar-light');
    navbar_all_colors.map(function(color) {
      $main_header.removeClass(color);
    });
    
    if (navbar_dark_skins.indexOf(color) > -1) {
      $main_header.addClass('navbar-dark');
      $.ajax({
        url: 'theme.php', type: 'post', data: {themeData: 'navbar-dark ' + color},
      });
    }
    else {
      $main_header.addClass('navbar-light');
      $.ajax({
        url: 'theme.php', type: 'post', data: {themeData: 'navbar-light ' + color},
      });
    }
    
    $main_header.addClass(color);
  });
  
  $navbar_variants.append($navbar_variants_colors);
  
  $container.append($navbar_variants);
  
  // Sidebar Colors
  
  $container.append('<h6>Accent Color Variants</h6>');
  var $accent_variants = $('<div />', {
    'class': 'd-flex',
  });
  $container.append($accent_variants);
  $container.append(createSkinBlock(accent_colors, function() {
    var color = $(this).data('color');
    var accent_class = color;
    var $body = $('body');
    accent_colors.map(function(skin) {
      $body.removeClass(skin);
    });
    
    $body.addClass(accent_class);
    $.ajax({
      url: 'theme.php', type: 'post', data: {themeData: color},
    });
  }));
  
  $container.append('<h6>Dark Sidebar Variants</h6>');
  var $sidebar_variants_dark = $('<div />', {
    'class': 'd-flex',
  });
  $container.append($sidebar_variants_dark);
  $container.append(createSkinBlock(sidebar_colors, function() {
    var color = $(this).data('color');
    var sidebar_class = 'sidebar-dark-' + color.replace('bg-', '');
    var $sidebar = $('.main-sidebar');
    sidebar_skins.map(function(skin) {
      $sidebar.removeClass(skin);
    });
    
    $sidebar.addClass(sidebar_class);
    $.ajax({
      url: 'theme.php', type: 'post', data: {themeData: sidebar_class},
    });
  }));
  
  $container.append('<h6>Light Sidebar Variants</h6>');
  var $sidebar_variants_light = $('<div />', {
    'class': 'd-flex',
  });
  $container.append($sidebar_variants_light);
  $container.append(createSkinBlock(sidebar_colors, function() {
    var color = $(this).data('color');
    var sidebar_class = 'sidebar-light-' + color.replace('bg-', '');
    var $sidebar = $('.main-sidebar');
    sidebar_skins.map(function(skin) {
      $sidebar.removeClass(skin);
    });
    
    $sidebar.addClass(sidebar_class);
    $.ajax({
      url: 'theme.php', type: 'post', data: {themeData: sidebar_class},
    });
  }));
  
  var logo_skins = navbar_all_colors;
  $container.append('<h6>Brand Logo Variants</h6>');
  var $logo_variants = $('<div />', {
    'class': 'd-flex',
  });
  $container.append($logo_variants);
  var $clear_btn = $('<a />', {
    href: 'javascript:void(0)',
  }).text('clear').on('click', function() {
    var $logo = $('.brand-link');
    logo_skins.map(function(skin) {
      $logo.removeClass(skin);
    });
  });
  $container.append(createSkinBlock(logo_skins, function() {
    var color = $(this).data('color');
    var $logo = $('.brand-link');
    logo_skins.map(function(skin) {
      $logo.removeClass(skin);
    });
    $logo.addClass(color);
    $.ajax({
      url: 'theme.php', type: 'post', data: {themeData: 'logo ' + color},
    });
  }).append($clear_btn));
  
  function createSkinBlock(colors, callback)
  {
    var $block = $('<div />', {
      'class': 'd-flex flex-wrap mb-3',
    });
    
    colors.map(function(color) {
      var $color = $('<div />', {
        'class': (typeof color === 'object' ? color.join(' ') : color).replace('navbar-', 'bg-').replace('accent-', 'bg-') + ' elevation-2',
      });
      
      $block.append($color);
      
      $color.data('color', color);
      
      $color.css({
        width: '40px', height: '20px', borderRadius: '25px', marginRight: 10, marginBottom: 10, opacity: 0.8, cursor: 'pointer',
      });
      
      $color.hover(function() {
        $(this).css({opacity: 1}).removeClass('elevation-2').addClass('elevation-4');
      }, function() {
        $(this).css({opacity: 0.8}).removeClass('elevation-4').addClass('elevation-2');
      });
      
      if (callback) {
        $color.on('click', callback);
      }
    });
    
    return $block;
  }
  
  $('.product-image-thumb').on('click', function() {
    const image_element = $(this).find('img');
    $('.product-image').prop('src', $(image_element).attr('src'));
    $('.product-image-thumb.active').removeClass('active');
    $(this).addClass('active');
  });
  
  $container.append('<br><br>');
  
  /*************************
   ******    Mine    *******
   *************************/
  
  /*************************
   *   Activate Active menu Item
   */
  var url = window.location;
  // for sidebar menu entirely but not cover treeview
  $('ul.nav-sidebar a').filter(function() {
    return this.href == url;
  }).addClass('active');
  // for treeview
  $('ul.nav-treeview a').filter(function() {
    return this.href == url;
  }).parentsUntil('.nav-sidebar > .nav-treeview').addClass('menu-is-opening menu-open').prev('a').addClass('active');
  
  // Initialize the datatables
  function activateDataTable()
  {
    if ($('.dataTable').length) {
      $('.dataTable').dataTable({
        /*dom: 'Bfrtip',
        buttons: [
          'excel'
        ],*/
        dom: 'Bfrtip', // Start for other button options
        buttons: [
          {
            extend: 'excelHtml5', text: 'Excel Current', exportOptions: {
              columns: ':visible', modifier: {
                page: 'current',
              },
            },
          }, {
            extend: 'excelHtml5', text: 'Excel ', exportOptions: {
              columns: ':visible',
            },
          }, {
            extend: 'csv', text: 'CSV', exportOptions: {
              columns: ':visible',
            },
          }, {
            extend: 'pdf', exportOptions: {
              columns: ':visible',
            },
          }, {
            extend: 'print', exportOptions: {
              columns: ':visible',
            },
          }, {
            extend: 'copyHtml5', text: 'Copy Current', exportOptions: {
              columns: ':visible', modifier: {
                page: 'current',
              },
            },
          }, {
            extend: 'copyHtml5', text: 'Copy', exportOptions: {
              columns: ':visible',
            },
          }, 'colvis',
        ], // End of other buttons options*/
        'bDestroy': true, initComplete: function() {
          this.api().columns().every(function() {
            var column = this;
            var select = $('<select  class="browser-default select2 w-100 custom-select form-control-sm"><option value="" selected>Search</option></select>').
                appendTo($(column.footer()).empty()).
                appendTo($(column.footer()).empty()).
                on('change', function() {
                  var val = $.fn.dataTable.util.escapeRegex($(this).val());
                  
                  column.search(val ? '^' + val + '$' : '', true, false).draw();
                });
            
            column.data().unique().sort().each(function(d, j) {
              select.append('<option value="' + d + '">' + d + '</option>');
            });
          });
        },
      });
    }
  }
  
  // Initialize the combobox
  function activateSelect()
  {
    if ($('.select2').length) {
      $('.select2').select2({
        width: '100%',
      });
    }
  }
  
  function activateSelect2Tags()
  {
    if ($('.select2-tags').length) {
      $(function() {
        $('.select2-tags').addClass('w-100');
        $('.select2-tags').select2({
          tags: true, tokenSeparators: [','], // [',', ' ']
        });
      });
    }
  }
  
  // Add forn-control-sm to all form-controls
  function addSMControls()
  {
    $('.form-control').addClass('form-control-sm');
  }
  
  function activateEditor()
  {
    if ($('.editor').length) {
      $('.editor').summernote();
    }
  }
  
  // Initialize tooltips
  $('[data-toggle="tooltip"]').tooltip();
  
  function activateToolTips()
  {
    $('[data-toggle="tooltip"]').tooltip();
  }
  
  // Confirm before deleting
  function confirmDelete($class)
  {
    if (confirm('Are you sure you want to delete this record?')) {
      $(this).addClass($class);
    }
  }
  
  /**************************
   * Dashboard
   */
  // Function to create and initialize the real-time sales chart
  function createRealTimeChart()
  {
    const ctx = document.getElementById('realTimeSalesChart').getContext('2d');
    
    // Check if the dark mode class is applied to the body
    const isDarkMode = $('body').hasClass('dark-mode');
    
    // Define label color based on mode
    const labelColor = isDarkMode ? 'white' : 'black'; // Adjust the color as needed
    
    const salesChart = new Chart(ctx, {
      type: 'line', data: {
        labels: [], // X-axis labels (timestamps)
        datasets: [
          {
            label: 'Sales', data: [], // Sales data points
            fill: true, borderColor: 'rgb(20, 120, 255)', backgroundColor: 'rgba(20, 120, 255)', tension: 0.3, color: labelColor,
          },
        ],
      }, options: {
        maintainAspectRatio: false, responsive: true, legends: {
          display: false,
        }, scales: {
          x: {
            type: 'time', // X-axis is a time scale
            time: {
              unit: 'minute', // Display timestamps by minute
              displayFormats: {
                minute: 'HH:mm', // Format for minute labels (adjust as needed)
              },
            }, title: {
              display: true, text: 'Time', color: labelColor,
            },
          }, y: {
            beginAtZero: true, title: {
              display: true, text: 'Sales', color: labelColor,
            },
          }, xAxes: [
            {
              gridLines: {
                display: false,
              },
            },
          ], yAxes: [
            {
              gridLines: {
                display: false,
              },
            },
          ],
        },
      },
    });
    
    // Function to update chart data
    function updateData()
    {
      // Fetch new sales data from your server using AJAX
      $.ajax({
        url: 'index_charts_sales.php', // Replace with the actual endpoint
        method: 'GET', dataType: 'json', success: function(data) {
          // Process the data and add it to the chart
          const salesData = data; // Assuming the data format is as provided by your PHP endpoint
          
          // Extract timestamps and sales values from the data
          const timestamps = salesData.map(item => item.timestamp);
          const salesValues = salesData.map(item => item.sales);
          
          // Update chart labels and data
          salesChart.data.labels = timestamps;
          salesChart.data.datasets[0].data = salesValues;
          
          // Update the chart
          salesChart.update();
        }, error: function(xhr, status, error) {
          console.error('Error fetching real-time sales data:', error);
        },
      });
    }
    
    // Set up a timer to update the chart data periodically (e.g., every 5 seconds)
    setInterval(updateData, 5000); // Adjust the interval as needed
  }
  
  // Call the function to create and initialize the real-time sales chart
  if ($('#realTimeSalesChart').length) {
    createRealTimeChart();
  }
  
  $(document).ready(function() {
    contactSearch();
    loadChat();
    loadChatHistory();
  });
  
  /**************************
   * Password
   */
  if ($('#retype').length) {
    // Workout the matching passwords and character counting
    // Check if passwords are matching
    $('#passSubmit').addClass('disabled');
    
    function checkPasswordMatch()
    {
      var password = $('#new').val();
      var confirmPassword = $('#retype').val();
      
      if (password != confirmPassword) {
        $('#divCheckPasswordMatch').html('Passwords do not match<br>');
        $('#passSubmit').prop('disabled', true);
      }
      else {
        if ((password == confirmPassword) && (password.length < 8)) {
          $('#divCheckPasswordMatch').html('Password must be 8 characters or more<br>');
          $('#passSubmit').prop('disabled', true);
        }
        else {
          $('#divCheckPasswordMatch').html('');
          $('#passSubmit').prop('disabled', false);
          $('#passSubmit').removeClass('disabled');
        }
      }
    }
    
    $(document).ready(function() {
      $('#retype').keyup(checkPasswordMatch);
    });
  }
  
  /**************************
   * Notifications & Alerts
   */
  $(document).on('click', '.alertsSeen', function() {
    $.ajax({
      url: 'notifications_seen.php', type: 'post', success: function(response) {
        $('.systemMsg').html(response);
      },
    });
  });
  
  $(document).on('click', '.alertSeen', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'notifications_seen.php', type: 'post', data: {dataId: dataId}, success: function(response) {
        $('.systemMsg').html(response);
      },
    });
  });
  
  /**************************
   * Vendors
   */
  // View Vendor
  $(document).on('click', '.viewVendorBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'vendors_view.php', type: 'post', data: {dataId: dataId}, success: function(response) {
        $('#modal .modal-dialog').removeClass('modal-lg').addClass('modal-xl modal-dialog-scrollable');
        $('#modal .modal-title').html('Vendor Data');
        $('#modal .modalDetails').html(response);
        activateSelect();
        addSMControls();
        activateDataTable();
        $('#modal').modal('show');
      },
    });
  });
  // Delete Vendor
  $(document).on('click', '.deleteVendorBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'vendors_delete.php', type: 'post', data: {dataId: dataId}, success: function(response) {
        $('.systemMsg').html(response);
      },
    });
  });
  
  /**************************
   * Blogs
   */
  $(document).on('click', '.newBlog', function() {
    $.ajax({
      url: 'blogs_form.php', type: 'post', success: function(response) {
        $('#modal .modal-dialog').removeClass('modal-lg').removeClass('modal-xl');
        $('#modal .modal-title').html('New Blog Post');
        $('#modal .modalDetails').html(response);
        addSMControls();
        activateSelect2Tags();
        activateEditor();
        $('#modal').modal('show');
      },
    });
  });
  
  $(document).on('click', '.newBlogCat', function() {
    $.ajax({
      url: 'blogs_cat_form.php', type: 'post', success: function(response) {
        $('#modal .modal-dialog').removeClass('modal-lg').removeClass('modal-xl');
        $('#modal .modal-title').html('New Blog Category');
        $('#modal .modalDetails').html(response);
        addSMControls();
        $('#modal').modal('show');
      },
    });
  });
  
  $(document).on('click', '.viewBlog', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'blogs_view.php', type: 'POST', data: {dataId: dataId}, success: function(response) {
        $('#modal .modal-dialog').addClass('modal-lg').removeClass('modal-xl').addClass('modal-dialog-scrollable');
        $('#modal .modal-title').html('Blog Details');
        $('#modal .modalDetails').html(response);
        $('#modal').modal('show');
      },
    });
  });
  
  $(document).on('click', '.blogCategories', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'blogs_cat_view.php', type: 'POST', data: {dataId: dataId}, success: function(response) {
        $('#modal .modal-dialog').addClass('modal-lg').removeClass('modal-xl');
        $('#modal .modal-title').html('Blog Categories');
        $('#modal .modalDetails').html(response);
        addSMControls();
        $('#modal').modal('show');
      },
    });
  });
  
  $(document).on('click', '.editBlog', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'blogs_form.php', type: 'POST', data: {dataId: dataId}, success: function(response) {
        $('#modal .modal-dialog').addClass('modal-lg').removeClass('modal-xl');
        $('#modal .modal-title').html('New Blog Category');
        $('#modal .modalDetails').html(response);
        addSMControls();
        activateSelect2Tags();
        activateSelect();
        activateEditor();
        $('#modal').modal('show');
      },
    });
  });
  
  $(document).on('click', '.editBlogCat', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'blogs_cat_form.php', type: 'POST', data: {dataId: dataId}, success: function(response) {
        $('#modal .modal-dialog').removeClass('modal-lg').removeClass('modal-xl');
        $('#modal .modal-title').html('Edit Blog Category');
        $('#modal .modalDetails').html(response);
        addSMControls();
        $('#modal').modal('show');
      },
    });
  });
  
  $(document).on('click', '.deleteBlog', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'blogs_delete.php', type: 'POST', data: {dataId: dataId}, success: function(response) {
        $('.systemMsg').html(response);
      },
    });
  });
  
  $(document).on('click', '.deleteBlogCat', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'blogs_cat_delete.php', type: 'POST', data: {dataId: dataId}, success: function(response) {
        $('.systemMsg').html(response);
      },
    });
  });
  
  /**************************
   * Products
   */
  // Add Product
  $(document).on('click', '.addProductBtn', function() {
    $.ajax({
      url: 'products_form.php', type: 'post', success: function(response) {
        $('#modal .modal-dialog').addClass('modal-lg').removeClass('modal-xl modal-dialog-scrollable');
        $('#modal .modal-title').html('New Product');
        $('#modal .modalDetails').html(response);
        activateSelect();
        addSMControls();
        activateEditor();
        $('#modal').modal('show');
      },
    });
  });
  // Edit Product
  $(document).on('click', '.editProductBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'products_form.php', type: 'post', data: {dataId: dataId}, success: function(response) {
        $('#modal .modal-dialog').addClass('modal-lg').removeClass('modal-xl modal-dialog-scrollable');
        $('#modal .modal-title').html('Edit Product');
        $('#modal .modalDetails').html(response);
        activateSelect();
        addSMControls();
        activateEditor();
        $('#modal').modal('show');
      },
    });
  });
  // View Product Details and sales
  $(document).on('click', '.viewProductBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'products_view.php', type: 'post', data: {dataId: dataId}, success: function(response) {
        $('#modal .modal-dialog').removeClass('modal-lg').addClass('modal-xl modal-dialog-scrollable');
        $('#modal .modal-title').html('Product Details');
        $('#modal .modalDetails').html(response);
        activateSelect();
        addSMControls();
        activateDataTable();
        $('#modal').modal('show');
      },
    });
  });
  // Delete Product
  $(document).on('click', '.deleteProductBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'products_delete.php', type: 'post', data: {dataId: dataId}, success: function(response) {
        $('.systemMsg').html(response);
      },
    });
  });
  
  /**************************
   * Categories
   */
  // Add Category
  $(document).on('click', '.addCategoryBtn', function() {
    $.ajax({
      url: 'category_form.php', type: 'post', success: function(response) {
        $('#modal .modal-dialog').addClass('modal-lg');
        $('#modal .modal-title').html('New Category');
        $('#modal .modalDetails').html(response);
        activateSelect();
        addSMControls();
        $('#modal').modal('show');
      },
    });
  });
  // View Category
  $(document).on('click', '.viewCategoryBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'category_view.php', type: 'post', data: {dataId: dataId}, success: function(response) {
        $('#modal .modal-dialog').addClass('modal-lg');
        $('#modal .modal-title').html('Category Details');
        $('#modal .modalDetails').html(response);
        activateToolTips();
        activateDataTable();
        $('#modal').modal('show');
      },
    });
  });
  // Edit Category
  $(document).on('click', '.editCategoryBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'category_form.php', type: 'post', data: {dataId: dataId}, success: function(response) {
        $('#modal .modal-dialog').addClass('modal-lg');
        $('#modal .modal-title').html('Edit Category');
        $('#modal .modalDetails').html(response);
        activateSelect();
        addSMControls();
        $('#modal').modal('show');
      },
    });
  });
  // Delete Category
  $(document).on('click', '.deleteCategoryBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'category_delete.php', type: 'post', data: {dataId: dataId}, success: function(response) {
        $('.systemMsg').html(response);
      },
    });
  });
  
  /**************************
   * Stock Management
   */
  $(document).on('click', '.addStockBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: '../forms/stock_add.php', type: 'post', data: {dataId: dataId}, success: function(response) {
        $('#modal .modal-dialog').removeClass('modal-lg').removeClass('modal-xl modal-dialog-scrollable');
        $('#modal .modal-title').html('Add Product Stock');
        $('#modal .modalDetails').html(response);
        activateSelect();
        addSMControls();
        activateDataTable();
        $('#modal').modal('show');
      },
    });
  });
  
  /***********************
   * CHAT & COMMUNICATION
   *****/
  // Send chat
  $(document).on('click', '.sendChatBtn', function() {
    var receiver = $('.chatVendor').val();
    var message = $('.message').val();
    if (message !== '') {
      $.ajax({
        url: '../forms/sendChat.php', type: 'post', data: {receiver: receiver, message: message}, success: function(response) {
          if (response.status === 'success') {
            $('.message').val('');
            toastr.success(response.message);
            scTop();
            loadChat();
            loadChatHistory();
          }
          else {
            toastr.warning(response.message);
          }
        },
      });
    }
    else {
      toastr.warning('You need to select a contact from the list or type something in the message box.');
    }
  });
  // Send Chat by pressing the enter key
  $(document).on('keyup', function(event) {
    if (event.keyCode === 13 || event.charCode === 13) {
      var receiver = $('.chatVendor').val();
      var message = $('.message').val();
      if (message !== '') {
        $.ajax({
          url: '../forms/sendChat.php', type: 'post', data: {receiver: receiver, message: message}, success: function(response) {
            if (response.status === 'success') {
              $('.message').val('');
              toastr.success(response.message);
              scTop();
              loadChat();
              loadChatHistory();
            }
            else {
              toastr.warning(response.message);
            }
          },
        });
      }
      else {
        toastr.warning('You need to select a contact from the list or type something in the message box.');
      }
    }
  });
  // Show user messages
  $(document).on('click', '.contact', function() {
    var user = $(this).data('id');
    $('.chatVendor').val(user);
    $('.contact').removeClass('active');
    $(this).addClass('active');
    // Update profile pic
    $.ajax({
      url: '../forms/getChatUserPic.php', type: 'POST', data: {user: user}, success: function(response) {
        // Destroy existing Dropzone instance if it exists
        if (Dropzone.instances.length > 0) {
          Dropzone.instances.forEach(function(instance) {
            instance.destroy();
          });
        }
        
        $('.contact-profile').
            html(response + '<div class="header-buttons">' +
                '<button class="toggle-contacts-btn" onclick="toggleContacts()"><i class="fas fa-users"></i></button>' +
                '<div class="toggle-settings-btn"><div class="dropdown">' +
                '<button class="btn btn-secondary dropdown-toggle toggle-settings-btn" type="button" id="settingsDropdown" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i>' +
                '</button>' + '<div class="dropdown-menu dropdown-menu-md-right" aria-labelledby="settingsDropdown">' +
                '<a class="dropdown-item" href="#">Setting 1</a>' + '<a class="dropdown-item" href="#">Setting 2</a>' +
                '<a class="dropdown-item" href="#">Setting 3</a>' + '</div></div></div></div>');
        
        // Initialize Dropzone after updating the content
        var receiver = $('.chatVendor').val();
        initializeDropzone(receiver);
      },
    });
    scTop();
    loadChat();
  });
  
  // Chat image upload
  // Function to initialize Dropzone
  function initializeDropzone(user)
  {
    // Disable autoDiscover for Dropzone to prevent the file chooser dialog
    Dropzone.autoDiscover = false;
    
    // Initialize Dropzone on the form element
    var myDropzone = new Dropzone('#myDropzone', {
      url: '../forms/chat_upload.php?user=' + user, paramName: 'file', // The
      // name that will be used to transfer the file
      maxFilesize: 5, // MB
      acceptedFiles: 'image/*', clickable: '#dropzoneBtn', // Define a custom clickable area
      init: function() {
        this.on('success', function(file, response) {
          scTop();
          loadChat();
          if (response.status === 'success') {
            toastr.success(response.message);
          }
          else {
            toastr.warning(response.message);
          }
        });
      },
    });
  }
  
  // Get Chat
  function loadChat()
  {
    setInterval(function() {
      var username = $('.chatVendor').val();
      $.ajax({
        url: 'chat_messages.php', type: 'post', data: {username: username}, success: function(response) {
          $('.direct-chat-messages').html(response);
        },
      });
    }, 2000);
  }
  
  // Function to load and update chat history
  function loadChatHistory()
  {
    if ($('#contacts').length) {
      $.ajax({
        url: 'chat_contacts.php', method: 'GET', // or 'POST'
        // depending on your setup
        success: function(response) {
          var receiver = $('.chatVendor').val();
          if (receiver === $('.contact').data('id')) {
            $(this).addClass('active');
          }
          $('#contacts').html(response);
          // Check if there are new messages and play notification sound
          if (response.includes('data-new-message="true"')) {
            playNotificationSound();
          }
        },
      });
    }
  }
  
  // Search Contacts
  function contactSearch()
  {
    // Cache the contact items for better performance
    var $contactItems = $('.contact');
    $('#contactSearchInput').on('keyup', function() {
      var searchTerm = $(this).val().toLowerCase();
      // Filter contacts based on the search term
      $contactItems.each(function() {
        var contactName = $(this).find('.name').text().toLowerCase();
        var contactPreview = $(this).find('.preview').text().toLowerCase();
        // Show or hide the contact based on the search term
        if (contactName.includes(searchTerm) || contactPreview.includes(searchTerm)) {
          $(this).show();
        }
        else {
          $(this).hide();
        }
      });
    });
  }
  
  // Function to play the notification sound
  function playNotificationSound()
  {
    var notificationSound = document.getElementById('notificationSound');
    if (notificationSound) {
      //notificationSound.play();
    }
  }
  
  // Scroll to the bottom of the chatbox
  function scTop()
  {
    $('.direct-chat-messages').animate({scrollTop: $('.direct-chat-messages')[0].scrollHeight});
  }
  
  /**************************
   * Orders
   */
  // View Orders
  $(document).on('click', '.viewOrderBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: '../forms/order_view.php', type: 'post', data: {dataId: dataId}, success: function(response) {
        $('#modal .modal-dialog').addClass('modal-lg');
        $('#modal .modal-title').html('View & Process Order');
        $('#modal .modalDetails').html(response);
        $('#modal').modal('show');
      },
    });
  });
  // Reject Order
  $(document).on('click', '.rejectOrderBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: '../forms/order_reject.php', type: 'post', data: {dataId: dataId}, success: function(response) {
        if (response.status === 'success') {
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  });
  
  // Change Order Item Status
  $(document).on('change', '#orderProductStatusChanger', function() {
    var itemId = $(this).data('item');
    var status = $(this).val();
    var state = $('.orderProductStatus[data-item="' + itemId + '"]');
    $.ajax({
      url: '../forms/order_change_item_status.php', type: 'post', data: {itemId: itemId, status: status}, success: function(response) {
        if (response.status === 'success') {
          // Change the item's status in the table too
          state.text(status);
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  });
  
  /**************************
   * Job Alerts
   */
  // Add Job
  $(document).on('click', '.newJobBtn', function() {
    $.ajax({
      url: 'jobs_form.php', type: 'post', success: function(response) {
        $('#modal .modal-dialog').addClass('modal-lg modal-dialog-scrollable').removeClass('modal-xl');
        $('#modal .modal-title').html('New Job Alert');
        $('#modal .modalDetails').html(response);
        addSMControls();
        $('#modal').modal('show');
      },
    });
  });
  // Edit Job
  $(document).on('click', '.editJob', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'jobs_form.php', type: 'post', data: {dataId: dataId}, success: function(response) {
        $('#modal .modal-dialog').addClass('modal-lg modal-dialog-scrollable').removeClass('modal-xl');
        $('#modal .modal-title').html('Edit Job Alert');
        $('#modal .modalDetails').html(response);
        addSMControls();
        $('#modal').modal('show');
      },
    });
  });
  // View Job Alert Details
  $(document).on('click', '.viewJob', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'jobs_view.php', type: 'post', data: {dataId: dataId}, success: function(response) {
        $('#modal .modal-dialog').addClass('modal-lg modal-dialog-scrollable').removeClass('modal-xl');
        $('#modal .modal-title').html('Job Alert Details');
        $('#modal .modalDetails').html(response);
        $('#modal').modal('show');
      },
    });
  });
  // Delete Job Alert
  $(document).on('click', '.deleteJob', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'jobs_delete.php', type: 'post', data: {dataId: dataId}, success: function(response) {
        $('.systemMsg').html(response);
      },
    });
  });
  
  /**************************
   * Job Alerts
   */
  // Add Job
  $(document).on('click', '.newServiceProvider', function() {
    $.ajax({
      url: 'service_provider_form.php', type: 'post', success: function(response) {
        $('#modal .modal-dialog').addClass('modal-lg modal-dialog-scrollable').removeClass('modal-xl');
        $('#modal .modal-title').html('New Service Provider');
        $('#modal .modalDetails').html(response);
        addSMControls();
        activateSelect();
        $('#modal').modal('show');
      },
    });
  });
  // View Provider Details
  $(document).on('click', '.viewProviderBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'service_provider_view.php', type: 'post', data: {dataId: dataId}, success: function(response) {
        $('#modal .modal-dialog').addClass('modal-lg modal-dialog-scrollable').removeClass('modal-xl');
        $('#modal .modal-title').html('Service Provider Details');
        $('#modal .modalDetails').html(response);
        addSMControls();
        $('#modal').modal('show');
      },
    });
  });
  // Edit Provider Details
  $(document).on('click', '.editProviderBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'service_provider_form.php', type: 'post', data: {dataId: dataId}, success: function(response) {
        $('#modal .modal-dialog').addClass('modal-lg modal-dialog-scrollable').removeClass('modal-xl');
        $('#modal .modal-title').html('Edit Service Provider Details');
        $('#modal .modalDetails').html(response);
        $('#modal').modal('show');
      },
    });
  });
  // Delete Provider
  $(document).on('click', '.deleteProviderBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'service_provider_delete.php', type: 'post', data: {dataId: dataId}, success: function(response) {
        $('.systemMsg').html(response);
      },
    });
  });
  
  /**************************
   * Chat, Contacts & Emails
   */
  // Add Email
  $(document).on('click', '.newEmailBtn', function() {
    $.ajax({
      url: 'chat_email_form.php', type: 'post', success: function(response) {
        $('#modal .modal-dialog').addClass('modal-lg modal-dialog-scrollable').removeClass('modal-xl');
        $('#modal .modal-title').html('Compose Email');
        $('#modal .modalDetails').html(response);
        addSMControls();
        activateSelect();
        activateEditor();
        $('#modal').modal('show');
      },
    });
  });
  // View Provider Details
  $(document).on('click', '.viewEmailBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'chat_bulk_email_view.php', type: 'post', data: {dataId: dataId}, success: function(response) {
        $('#modal .modal-dialog').addClass('modal-lg modal-dialog-scrollable').removeClass('modal-xl');
        $('#modal .modal-title').html('Email Details');
        $('#modal .modalDetails').html(response);
        $('#modal').modal('show');
      },
    });
  });
  // Delete Provider
  $(document).on('click', '.deleteEmailBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'chat_bulk_email_delete.php', type: 'post', data: {dataId: dataId}, success: function(response) {
        $('.systemMsg').html(response);
      },
    });
  });
  // Add Bulk Email
  $(document).on('click', '.newBulkEmailBtn', function() {
    $.ajax({
      url: 'chat_bulk_email_form.php', type: 'post', success: function(response) {
        $('#modal .modal-dialog').addClass('modal-lg modal-dialog-scrollable').removeClass('modal-xl');
        $('#modal .modal-title').html('Compose Bulk Email');
        $('#modal .modalDetails').html(response);
        addSMControls();
        activateSelect();
        activateEditor();
        $('#modal').modal('show');
      },
    });
  });
  
  /**************************
   * Subscription Plans
   */
  // Add Category
  $(document).on('click', '.addSubscriptionBtn', function() {
    $.ajax({
      url: 'subscriptions_form.php', type: 'post', success: function(response) {
        $('#modal .modal-dialog').removeClass('modal-lg');
        $('#modal .modal-title').html('New Subscription Plan');
        $('#modal .modalDetails').html(response);
        addSMControls();
        $('#modal').modal('show');
      },
    });
  });
  // Edit Category
  $(document).on('click', '.editSubscriptionBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'subscriptions_form.php', type: 'post', data: {dataId: dataId}, success: function(response) {
        $('#modal .modal-dialog').removeClass('modal-lg');
        $('#modal .modal-title').html('Edit Subscription Plan');
        $('#modal .modalDetails').html(response);
        addSMControls();
        $('#modal').modal('show');
      },
    });
  });
  // Edit Category
  $(document).on('click', '.viewSubscriptionBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'subscriptions_view.php', type: 'post', data: {dataId: dataId}, success: function(response) {
        $('#modal .modal-dialog').removeClass('modal-lg');
        $('#modal .modal-title').html('Subscription Plan Details');
        $('#modal .modalDetails').html(response);
        $('#modal').modal('show');
      },
    });
  });
  // Delete Category
  $(document).on('click', '.deleteSubscriptionBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'subscriptions_delete.php', type: 'post', data: {dataId: dataId}, success: function(response) {
        $('.systemMsg').html(response);
      },
    });
  });
  
  // Work on subscribers
  $(document).on('click', '.activateSubscriptionPlanBtn', function(){
    var dataId = $(this).data('id');
    $.ajax({
      url: 'subscribers_activate_subscription.php',
      type: 'POST',
      data: {dataId: dataId},
      success: function(response){
        $('.systemMsg').html(response);
      }
    });
  });
  
  $(document).on('click', '.editSubscriptionPlanBtn', function(){
    var dataId = $(this).data('id');
    $.ajax({
      url: 'subscribers_edit_subscription.php',
      type: 'POST',
      data: {dataId: dataId},
      success: function(response){
        $('#modal .modal-dialog').removeClass('modal-lg');
        $('#modal .modal-title').html('Edit Subscriber Subscription');
        $('#modal .modalDetails').html(response);
        $('#modal').modal('show');
      }
    });
  });
  
  // Vendor side
  if ($('#plan').length || $('#months').length) {
    $(document).on('change', '#plan', function() {
      var planPrice = $(this).find('option:selected').data('price');
      var months = $('#months').val();
      $('.to_pay').html(numberWithCommas(planPrice * months));
    });
    
    $(document).on('change', '#months', function() {
      var planPrice = $('#plan').find('option:selected').data('price');
      var months = $(this).val();
      $('.to_pay').html(numberWithCommas(planPrice * months));
    });
  }
  
  function numberWithCommas(x)
  {
    return parseFloat(x).
        toFixed(0).
        toString().
        replace(/\B(?=(\d{3})+(?!\d))/g, ',');
  }
  
  /**************************
   * Warehouses
   */
  // Add Warehouse
  $(document).on('click', '.addWarehouseBtn', function() {
    $.ajax({
      url: 'warehouses_form.php', type: 'post', success: function(response) {
        $('#modal .modal-dialog').removeClass('modal-lg');
        $('#modal .modal-title').html('New Warehouse');
        $('#modal .modalDetails').html(response);
        addSMControls();
        $('#modal').modal('show');
      },
    });
  });
  // Edit Warehouse
  $(document).on('click', '.editWarehouseBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'warehouses_form.php', type: 'post', data: {dataId: dataId}, success: function(response) {
        $('#modal .modal-dialog').removeClass('modal-lg');
        $('#modal .modal-title').html('Edit Warehouse');
        $('#modal .modalDetails').html(response);
        addSMControls();
        $('#modal').modal('show');
      },
    });
  });
  // Delete Warehouse
  $(document).on('click', '.deleteWarehouseBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'warehouses_delete.php', type: 'post', data: {dataId: dataId}, success: function(response) {
        $('.systemMsg').html(response);
      },
    });
  });
  
  /**************************
   * Purchase Orders
   */
  // Add Purchase Order
  $(document).on('click', '.addPurchaseOrderBtn', function() {
    $.ajax({
      url: 'purchase_orders_form.php', type: 'post', success: function(response) {
        $('#modal .modal-dialog').removeClass('modal-lg').addClass('modal-xl');
        $('#modal .modal-title').html('New Purchase Order');
        $('#modal .modalDetails').html(response);
        purchaseOrderItems();
        activateSelect();
        addSMControls();
        $('#modal').modal('show');
      },
    });
  });
  // View Purchase Order Items
  $(document).on('click', '.viewPurchaseOrderBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'purchase_orders_view.php', type: 'post', data: {dataId: dataId}, success: function(response) {
        $('#modal .modal-dialog').removeClass('modal-lg').addClass('modal-xl');
        $('#modal .modal-title').html('Order Details');
        $('#modal .modalDetails').html(response);
        activateDataTable();
        $('#modal').modal('show');
      },
    });
  });
  // Receive Purchase Order
  $(document).on('click', '.receivePurchaseOrderBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'purchase_orders_receive.php', type: 'post', data: {dataId: dataId}, success: function(response) {
        $('.systemMsg').html(response);
      },
    });
  });
  // Cancel Purchase Order
  $(document).on('click', '.cancelPurchaseOrderBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'purchase_orders_cancel.php', type: 'post', data: {dataId: dataId}, success: function(response) {
        $('.systemMsg').html(response);
      },
    });
  });
  
  /**************************
   * Sales Orders
   */
  // Add Sales Order
  $(document).on('click', '.addSalesOrderBtn', function() {
    $.ajax({
      url: 'sales_orders_form.php', type: 'post', success: function(response) {
        $('#modal .modal-dialog').removeClass('modal-lg').addClass('modal-xl');
        $('#modal .modal-title').html('New Sales Order');
        $('#modal .modalDetails').html(response);
        salesOrderItems();
        fetchAndAddEmptySalesOrderItem();
        activateSelect();
        addSMControls();
        $('#modal').modal('show');
      },
    });
  });
  // View Sales Order Items
  $(document).on('click', '.viewSalesOrderBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'sales_orders_view.php', type: 'POST', data: {dataId: dataId}, success: function(response) {
        $('#modal .modal-dialog').removeClass('modal-lg').addClass('modal-xl');
        $('#modal .modal-title').html('Sales Order Items');
        $('#modal .modalDetails').html(response);
        activateDataTable();
        $('#modal').modal('show');
      },
    });
  });
  // Cancel Sales Order
  $(document).on('click', '.cancelSalesOrderBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'sales_orders_cancel_order.php', type: 'POST', data: {dataId: dataId}, success: function(response) {
        $('.systemMsg').html(response);
      },
    });
  });
  
  /**************************
   * Notifications & Alerts
   */
  // Mark all Notifications as Seen
  $(document).on('click', '.markAllAlerts', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'notifications_all_seen.php', type: 'post', data: {dataId: dataId}, success: function(response) {
        $('.systemMsg').html(response);
      },
    });
  });
  // Mark Notification as Seen
  $(document).on('click', '.viewAlertBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'notifications_seen.php', type: 'post', data: {dataId: dataId}, success: function(response) {
        $('.systemMsg').html(response);
      },
    });
  });
  // Delete Notification
  $(document).on('click', '.deleteAlertBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'notifications_delete.php', type: 'post', data: {dataId: dataId}, success: function(response) {
        $('.systemMsg').html(response);
      },
    });
  });
  
  /**************************
   * Users
   */
  // Add User
  $(document).on('click', '.addUserBtn', function() {
    $.ajax({
      url: 'users_form.php', type: 'post', success: function(response) {
        $('#modal .modal-dialog').addClass('modal-lg').removeClass('modal-xl').removeClass('modal-dialog-scrollable');
        $('#modal .modal-title').html('New User');
        $('#modal .modalDetails').html(response);
        activateSelect();
        addSMControls();
        $('#modal').modal('show');
      },
    });
  });
  // View User Details & Audit Trails
  $(document).on('click', '.viewUserBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'users_view.php', type: 'post', data: {dataId: dataId}, success: function(response) {
        $('#modal .modal-dialog').removeClass('modal-lg').addClass('modal-xl').addClass('modal-dialog-scrollable');
        $('#modal .modal-title').html('User Audit Trails');
        $('#modal .modalDetails').html(response);
        activateDataTable();
        $('#modal').modal('show');
      },
    });
  });
  // Edit User
  $(document).on('click', '.editUserBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'users_form.php', type: 'post', data: {dataId: dataId}, success: function(response) {
        $('#modal .modal-dialog').addClass('modal-lg').removeClass('modal-xl').removeClass('modal-dialog-scrollable');
        $('#modal .modal-title').html('Edit User');
        $('#modal .modalDetails').html(response);
        activateSelect();
        addSMControls();
        $('#modal').modal('show');
      },
    });
  });
  // Delete User
  $(document).on('click', '.deleteUserBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'users_delete.php', type: 'post', data: {dataId: dataId}, success: function(response) {
        $('.systemMsg').html(response);
      },
    });
  });
  
  /**************************
   * PURCHASE ORDER THINGS
   */
  function purchaseOrderItems()
  {
    const addItemBtn = document.getElementById('addItemBtn');
    const itemForm = document.getElementById('itemForm');
    const productCombo = document.getElementById('productCombo');
    
    // Add event listener to the Add Item button
    addItemBtn.addEventListener('click', function(event) {
      event.preventDefault();
      addEmptyItemRow();
    });
    
    // Add event listener for calculating totals
    itemForm.addEventListener('input', function(event) {
      calculateTotal(event.target);
      calculateGrandTotal();
    });
  }
  
  // Function to add an empty item row to the form using jQuery
  function addEmptyItemRow()
  {
    const newRow = $('<div class="itemRow row"></div>');
    
    const newProductCombo = $('#productCombo').clone();
    // Reset the cloned combo box before initializing select2
    newProductCombo.find('select').val(null).trigger('change');
    newRow.append(newProductCombo);
    
    const newQuantityInput = $(
        '<div class="col-sm-2"><div class="form-group"><input type="number" name="quantity[]" placeholder="Quantity" class="quantity form-control form-control-sm"></div></div>');
    newRow.append(newQuantityInput);
    
    const newUnitCostInput = $(
        '<div class="col-sm-3"><div class="form-group"><input type="number" name="unit_cost[]" placeholder="Unit Cost" class="unit_cost form-control form-control-sm"></div></div>');
    newRow.append(newUnitCostInput);
    
    const newTotalAmountInput = $(
        '<div class="col-sm-3"><div class="form-group"><input type="number" name="total_amount[]" placeholder="Total Amount" readonly class="total_amount form-control form-control-sm"></div></div>');
    newRow.append(newTotalAmountInput);
    
    const removeButton = $(
        '<div class="col-sm-1"><button class="removeItemBtn btn btn-link text-danger btn-xs"><span class="fa fa-trash-alt"></span></button></div>');
    newRow.append(removeButton);
    
    newRow.insertBefore('#addItemDiv');
    
    // Initialize select2 for the cloned combo box
    newProductCombo.find('select').select2({
      width: '100%',
    });
  }
  
  // Calculate and update total amounts when input values change
  $(document).on('input', '.quantity, .unit_cost', function() {
    calculateRowTotal($(this));
    calculateGrandTotal();
  });
  
  // Calculate and update first row total amount
  function calculateTotal(inputElement)
  {
    const itemForm = document.getElementById('itemForm');
    const quantity = parseFloat($('.quantity').val()) || 0;
    const unitCost = parseFloat($('.unit_cost').val()) || 0;
    const totalAmount = quantity * unitCost;
    $('.total_amount').val(totalAmount.toFixed(2)); // Optional: Update the input field
  }
  
  // Calculate and update row total amount
  function calculateRowTotal(inputElement)
  {
    const row = inputElement.closest('.itemRow');
    const quantity = parseFloat(row.find('.quantity').val()) || 0;
    const unitCost = parseFloat(row.find('.unit_cost').val()) || 0;
    const totalAmount = quantity * unitCost;
    row.find('.total_amount').val(totalAmount.toFixed(2)); // Optional: Update the input field
  }
  
  // Calculate and update grand total
  function calculateGrandTotal()
  {
    let grandTotal = 0;
    $('.total_amount').each(function() {
      grandTotal += parseFloat($(this).val()) || 0;
    });
    $('#grandTotal span').text(grandTotal.toFixed(2)); // Update the span element inside #grandTotal
  }
  
  // Add event listener to the Remove button for dynamically added rows
  $(document).on('click', '.removeItemBtn', function() {
    $(this).closest('.itemRow').remove();
    calculateGrandTotal();
  });
  
  /**************************
   * SALES ORDER THINGS
   */
  function salesOrderItems()
  {
    const addItemBtn = document.getElementById('addItemBtn');
    const itemForm = document.getElementById('salesOrderForm');
    
    // Add event listener to the Add Item button
    addItemBtn.addEventListener('click', function(event) {
      event.preventDefault();
      fetchAndAddEmptySalesOrderItem();
    });
    
    // Add event listener for calculating totals
    itemForm.addEventListener('input', function(event) {
      calculateSalesOrderItemTotal(event.target);
      calculateSalesOrderGrandTotal();
    });
  }
  
  async function fetchProducts()
  {
    try {
      const response = await fetch('sales_order_get_products.php');
      const data = await response.json();
      return data;
    }
    catch (error) {
      console.error('Error fetching products:', error);
      return []; // Return an empty array on error
    }
  }
  
  function fetchAndAddEmptySalesOrderItem()
  {
    fetchProducts().then(products => {
      addEmptySalesOrderItem(products);
    }).catch(error => {
      console.error('Error fetching products:', error);
    });
  }
  
  function addEmptySalesOrderItem(products)
  {
    const itemsDiv = $('.salesOrderItems');
    const newRow = $('<div class="itemRow row"></div>');
    const newProductCombo = $('<div class="col-sm-3"><div class="form-group"><select name="product[]" class="form-control productCombo"></select></div></div>');
    populateProductCombo(newProductCombo, products);
    newRow.append(newProductCombo);
    newRow.append(
        '<div class="col-sm-2"><div class="form-group"><input type="number" name="quantity[]" placeholder="Quantity" class="quantity form-control form-control-sm"></div></div>');
    newRow.append(
        '<div class="col-sm-3"><div class="form-group"><input type="number" name="selling_price[]" placeholder="Selling Price" readonly class="selling_price form-control form-control-sm"></div></div>');
    newRow.append(
        '<div class="col-sm-3"><div class="form-group"><input type="number" name="total_amount[]" placeholder="Total Amount" readonly class="total_amount form-control form-control-sm"></div></div>');
    newRow.append('<div class="col-sm-1"><button class="removeItemBtn btn btn-link text-danger btn-xs"><span class="fa fa-trash-alt"></span></button></div>');
    itemsDiv.append(newRow);
    
    // Initialize select2 for the cloned combo box
    newProductCombo.find('select').select2({
      width: '100%',
    });
  }
  
  function calculateSalesOrderItemTotal(inputElement)
  {
    const row = inputElement.closest('.itemRow');
    if (row.length > 0) {
      const quantity = parseFloat(row.find('.quantity').val()) || 0;
      const unitCost = parseFloat(row.find('.selling_price').val()) || 0;
      const totalAmount = quantity * unitCost;
      row.find('.total_amount').val(totalAmount.toFixed(2)); // Optional: Update the input field
      calculateSalesOrderGrandTotal();
    }
  }
  
  function calculateSalesOrderGrandTotal()
  {
    let grandTotal = 0;
    $('.total_amount').each(function() {
      grandTotal += parseFloat($(this).val()) || 0;
    });
    $('#grandTotal span').text(grandTotal.toFixed(2)); // Update the span element inside #grandTotal
  }
  
  function populateProductCombo(productCombo, products)
  {
    productCombo.find('select').append('<option value="">Select a product</option>');
    $.each(products, function(key, product) {
      productCombo.find('select').
          append(`<option value="${product.product_id}" data-selling-price="${product.selling_price}">${product.product_name}</option>`);
    });
  }
  
  $(document).on('change', '.productCombo', function() {
    const productCombo = $(this);
    const row = productCombo.closest('.itemRow');
    const selectedProduct = productCombo.val();
    const sellingPrice = productCombo.find(`option:selected`).data('selling-price');
    row.find('.selling_price').val(sellingPrice);
    calculateSalesOrderItemTotal(productCombo);
  });
  
  $(document).on('input', '.quantity, .unit_price', function() {
    calculateSalesOrderItemTotal($(this));
  });
  
  $(document).on('click', '.removeSalesOrderItemBtn', function() {
    $(this).closest('.itemRow').remove();
    calculateSalesOrderGrandTotal();
  });
  
  /********
   * Contacts
   */
  $(document).on('click', '.viewContact', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'chat_contacts_view.php', type: 'post', data: {dataId: dataId}, success: function(response) {
        // Do Something
        $('#modal .modal-dialog').addClass('modal-lg modal-dialog-scrollable').removeClass('modal-xl');
        $('#modal .modal-title').html('Contact Details');
        $('#modal .modalDetails').html(response);
        $('#modal').modal('show');
      },
    });
  });
  
  $(document).on('click', '.replyContact', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'chat_contacts_reply_form.php', type: 'post', data: {dataId: dataId}, success: function(response) {
        $('#modal .modal-dialog').addClass('modal-lg modal-dialog-scrollable').removeClass('modal-xl');
        $('#modal .modal-title').html('Reply Contact');
        $('#modal .modalDetails').html(response);
        activateEditor();
        $('#modal').modal('show');
      },
    });
  });
  
  $(document).on('click', '.deleteContact', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'chat_contacts_delete.php', type: 'post', data: {dataId: dataId}, success: function(response) {
        $('.systemMsg').html(response);
      },
    });
  });
  
  $(document).ready(function() {
    activateDataTable();
    activateSelect();
    activateEditor();
  });
  
})(jQuery)

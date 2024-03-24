(function($) {
  'use strict';
  
  $(document).ready(function() {
    validatePassword();
    activateStarRating();
    contactSearch();
    loadChatHistory();
    activateMainMenu();
    activateChildMenu();
    activateVendorMenu();
    showLoginPassword();
    showPassword();
    //initializeDropzone();
    if ($('.chatVendor').length) {
      var receiver = $('.chatVendor').val();
      initializeDropzone(receiver);
    }
    
    // Get the current page URL
    var currentUrl = window.location.href;
    
    // Remove the "active" class from all menu items
    //$(".nav-link").removeClass("active");
    
    // Check the URL and add the "active" class to the corresponding menu item
    $('.nav-link').each(function() {
      var href = $(this).attr('href');
      if (currentUrl.indexOf(href) !== -1) {
        $(this).addClass('active');
      }
    });
    
    // Activate customer or vendor menu
    function activateMainMenu()
    {
      // Get the current URL
      var currentUrl = window.location.href;
      
      // Check each nav link and add 'active' class if the link matches the
      // current URL
      $('.main-nav a').each(function() {
        var linkUrl = $(this).attr('href');
        
        // Check if the link is the one in the URL
        if (currentUrl.includes(linkUrl)) {
          $(this).closest('li').addClass('active');
        }
      });
    }
    
    // Activate customer or vendor menu
    function activateVendorMenu()
    {
      // Get the current URL
      var currentUrl = window.location.href;
      
      // Check each nav link and add 'active' class if the link matches the
      // current URL
      $('.vendor-menu a').each(function() {
        var linkUrl = $(this).attr('href');
        
        // Check if the link is the one in the URL
        if (currentUrl.includes(linkUrl)) {
          $(this).closest('li').addClass('active');
        }
      });
    }
    
    // Activate Categories Masonry
    if ($('.category-grid').length) {
      $('.category-grid').masonry({
        columnWidth: '.category-item', itemSelector: '.category-item',
      });
    }
    
    activateMenu();
    aos_init();
    if ($('.messages').length) {
      loadChat();
    }
  });
  
  //.clearCompare - to clear the compare products part
  //.RemoveCompareProduct - To remove a single product from compare part
  //.RemoveFromCart - Remove a product from cart
  
  // Activate Register Password Visibility Toggle
  function showPassword()
  {
    $('#password-visibility').change(function() {
      var passwordField = $('#register-password');
      var passwordFieldType = passwordField.attr('type');
      
      if (passwordFieldType === 'password') {
        passwordField.attr('type', 'text');
      }
      else {
        passwordField.attr('type', 'password');
      }
    });
  }
  
  // Activate Login Password Visibility Toggle
  function showLoginPassword()
  {
    $('#login-password-visibility').change(function() {
      var passwordField = $('#singin-password');
      var passwordFieldType = passwordField.attr('type');
      
      if (passwordFieldType === 'password') {
        passwordField.attr('type', 'text');
      }
      else {
        passwordField.attr('type', 'password');
      }
    });
  }
  
  // reset password
  $(document).on('submit', '#resetPasswordForm', function(event) {
    event.preventDefault();
    var email = $('#email').val();
    var newPassword = $('#password').val();
    var verificationCode = $('#verificationCode').val();
    $.ajax({
      url: 'forms/user_reset_password.php',
      type: 'POST',
      data: {
        email: email,
        newPassword: newPassword,
        verificationCode: verificationCode,
      },
      success: function(response) {
        if (response.status === 'success') {
          toastr.success(response.message);
          $('#signin-modal').modal('show');
          $('#resetPasswordForm')[0].reset();
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  });
  
  // Activate menu
  function activateMenu()
  {
    var currentURL = window.location.href;
    
    $('.desktop-menu a').each(function() {
      if (currentURL === $(this).attr('href')) {
        $(this).closest('li').addClass('active');
      }
    });
  }
  
  // Activate Child Menu
  function activateChildMenu()
  {
    // Get the current URL
    var currentUrl = window.location.href;
    
    // Check each nav link and add 'active' class if the link matches the
    // current URL
    $('.child-navbar a').each(function() {
      var linkUrl = $(this).attr('href');
      
      // Check if the link is the one in the URL
      if (currentUrl.includes(linkUrl)) {
        $(this).closest('li').addClass('active');
      }
    });
  }
  
  // Activate star rating
  function activateStarRating()
  {
    if ($('#star-rating-container').length) {
      $('#star-rating-container').rateit({
        rating: 0, starSize: 20, readOnly: false,
      });
    }
  }
  
  // Init AOS
  function aos_init()
  {
    AOS.init({
      duration: 1000, easing: 'ease-in-out-back', once: true,
    });
  }
  
  // Activate Product Zoom
  function activateZoom()
  {
    if ($.fn.elevateZoom) {
      $('#product-zoom').elevateZoom({
        gallery: 'product-zoom-gallery',
        galleryActiveClass: 'active',
        zoomType: 'inner',
        cursor: 'crosshair',
        zoomWindowFadeIn: 400,
        zoomWindowFadeOut: 400,
        responsive: true,
      });
      
      // On click change thumbs active item
      $('.product-gallery-item').on('click', function(e) {
        $('#product-zoom-gallery').find('a').removeClass('active');
        $(this).addClass('active');
        
        e.preventDefault();
      });
      
      var ez = $('#product-zoom').data('elevateZoom');
      
      // Open popup - product images
      $('#btn-product-gallery').on('click', function(e) {
        if ($.fn.magnificPopup) {
          $.magnificPopup.open({
            items: ez.getGalleryList(), type: 'image', gallery: {
              enabled: true,
            }, fixedContentPos: false, removalDelay: 600, closeBtnInside: false,
          }, 0);
          
          e.preventDefault();
        }
      });
    }
  }
  
  // Sign In Form
  $('.signIn').submit(function(event) {
    // Prevent the default form submission behavior
    event.preventDefault();
    // Gather form data
    var formData = $(this).serialize();
    // Send an AJAX request to your server for form processing
    $.ajax({
      type: 'POST', // or "GET" depending on your needs
      url: 'login.php', // Replace with the actual URL to process the form
      data: formData, success: function(response) {
        $('.accountMsg').html(response);
      },
    });
  });
  
  // Registration Form
  $('.registerForm').submit(function(event) {
    // Prevent the default form submission behavior
    event.preventDefault();
    // Gather form data
    var formData = $(this).serialize();
    // Send an AJAX request to your server for form processing
    $.ajax({
      type: 'POST', // or "GET" depending on your needs
      url: 'register.php', // Replace with the actual URL to process the form
      data: formData, success: function(response) {
        $('.accountMsg').html(response);
      },
    });
  });
  
  // Add forn-control-sm to all form-controls
  function addSMControls()
  {
    $('.form-control').addClass('form-control-sm');
  }
  
  // Initialize tooltips
  $('[data-toggle="tooltip"]').tooltip();
  
  function activateToolTips()
  {
    $('[data-toggle="tooltip"]').tooltip();
  }
  
  /**************************
   * Products
   */
  // Add Product
  $(document).on('click', '.addProductBtn', function() {
    $.ajax({
      url: 'products_form.php', type: 'post', success: function(response) {
        $('#modal .modal-dialog').addClass('modal-xl modal-dialog-scrollable');
        $('#modal .modal-title').html('New Product');
        $('#modal .modalDetails').html(response);
        addSMControls();
        $('#modal').modal('show');
      },
    });
  });
  // Edit Product
  $(document).on('click', '.editProductBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'products_form.php',
      type: 'post',
      data: {dataId: dataId},
      success: function(response) {
        $('#modal .modal-dialog').
            addClass('modal-lg').
            removeClass('modal-xl modal-dialog-scrollable');
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
      url: 'products_view.php',
      type: 'post',
      data: {dataId: dataId},
      success: function(response) {
        $('#modal .modal-dialog').
            removeClass('modal-lg').
            addClass('modal-xl modal-dialog-scrollable');
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
      url: 'products_delete.php',
      type: 'post',
      data: {dataId: dataId},
      success: function(response) {
        $('.systemMsg').html(response);
      },
    });
  });
  
  /**************************
   * Shop Management
   */
  $(document).on('change', '#country', function() {
    var country = $(this).val();
    $.ajax({
      url: 'forms/select_cities.php',
      type: 'post',
      cache: false,
      data: {country: country},
      success: function(response) {
        $('#city').html(response);
      },
    });
  });
  
  $(document).on('change', '#dcountry', function() {
    var country = $(this).val();
    $.ajax({
      url: 'forms/select_cities.php',
      type: 'post',
      cache: false,
      data: {country: country},
      success: function(response) {
        $('#dcity').html(response);
      },
    });
  });
  
  /**************************
   * Addreses
   */
  // Add Address
  $(document).on('click', '.addAddressBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'forms/address_add.php',
      type: 'post',
      data: {dataId: dataId},
      success: function(response) {
        $('#modal .modal-dialog').addClass('modal-xl modal-dialog-scrollable');
        $('#modal .modal-title').html('New Address');
        $('#modal .modalDetails').html(response);
        activateSelect();
        addSMControls();
        activateEditor();
        $('#modal').modal('show');
      },
    });
  });
  // Edit Address
  $(document).on('click', '.editAddressBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'forms/address_add.php',
      type: 'post',
      data: {dataId: dataId},
      success: function(response) {
        $('#modal .modal-dialog').addClass('modal-xl modal-dialog-scrollable');
        $('#modal .modal-title').html('Edit Address');
        $('#modal .modalDetails').html(response);
        activateSelect();
        addSMControls();
        activateEditor();
        $('#modal').modal('show');
      },
    });
  });
  // Delete Address
  $(document).on('click', '.deleteAddressBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'forms/address_delete.php',
      type: 'post',
      data: {dataId: dataId},
      success: function(response) {
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
      url: 'notifications_all_seen.php',
      type: 'post',
      data: {dataId: dataId},
      success: function(response) {
        $('.systemMsg').html(response);
      },
    });
  });
  // Mark Notification as Seen
  $(document).on('click', '.viewAlertBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'notifications_seen.php',
      type: 'post',
      data: {dataId: dataId},
      success: function(response) {
        $('.systemMsg').html(response);
      },
    });
  });
  // Delete Notification
  $(document).on('click', '.deleteAlertBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'notifications_delete.php',
      type: 'post',
      data: {dataId: dataId},
      success: function(response) {
        $('.systemMsg').html(response);
      },
    });
  });
  
  /**************************
   * Cart, Wishlist, Compare & Quick View
   */
  // Add to cart
  $(document).on('click', '.cartBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'forms/cart_add.php',
      type: 'post',
      data: {dataId: dataId},
      success: function(response) {
        if (response.status === 'success') {
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  });
  // Remove from cart
  $(document).on('click', '.removeCartBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'forms/cart_remove.php',
      type: 'post',
      data: {dataId: dataId},
      success: function(response) {
        if (response.status === 'success') {
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  });
  // Add to cart from single product page
  $(document).on('click', '.productToCart', function() {
    var productId = window.location.search;
    var quantity = $('#qty').val();
    var color = [];
    $('.filter-colors a.selected').each(function() {
      color.push($(this).attr('id'));
    });
    var size = $('#size').val();
    $.ajax({
      url: 'forms/cart_add_single_product.php',
      type: 'post',
      data: {
        productId: productId,
        quantity: quantity,
        color: color,
        size: size,
      },
      success: function(response) {
        if (response.status === 'success') {
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  });
  // Update Cart
  // Handle quantity change event
  $('.cart-product-quantity input').on('input', function() {
    updateTotal($(this));
  });
  
  // Function to update total based on quantity
  function updateTotal(quantityInput)
  {
    var quantity = quantityInput.val();
    var price = quantityInput.closest('tr').
        find('.price-col').
        text().
        replace(/\$|,/g, ''); // assuming price is in a format like $1,000.00
    var total = (parseFloat(price) * parseInt(quantity)).toFixed(2);
    var formattedTotal = numberWithCommas(total); // format total with commas
                                                  // and 2 decimal places
    quantityInput.closest('tr').find('.total-col').text(formattedTotal);
    updateSubtotal(); // Call the function to update subtotal
  }
  
  // Function to add commas to number and format to 2 decimal places
  function numberWithCommas(x)
  {
    return parseFloat(x).
        toFixed(2).
        toString().
        replace(/\B(?=(\d{3})+(?!\d))/g, ',');
  }
  
  // Function to calculate and update the subtotal
  function updateSubtotal()
  {
    var subtotal = 0;
    $('.total-col').each(function() {
      var total = $(this).text().replace(/\$|,/g, '');
      subtotal += parseFloat(total);
    });
    
    var formattedSubtotal = numberWithCommas(subtotal.toFixed(2));
    $('.summary-subtotal td:last-child').
        text(CURRENCY + ' ' + formattedSubtotal);
  }
  
  // Now update cart
  $(document).on('click', '.updateCart', function() {
    var updatedQuantities = [];
    // Loop through each cart row
    $('.cart-product-quantity input').each(function() {
      var productId = $(this).data('id');
      var quantity = $(this).val();
      if (productId && quantity) {
        updatedQuantities.push({productId: productId, quantity: quantity});
      }
    });
    // Send AJAX request to update the cart
    $.ajax({
      url: 'forms/cart_update.php', // Replace with the actual update_cart
                                    // script
      type: 'POST',
      data: {updatedQuantities: updatedQuantities},
      success: function(response) {
        if (response.status === 'success') {
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  });
  // Add to Wishlist
  $(document).on('click', '.wishlistBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'forms/wishlist_add.php',
      type: 'post',
      data: {dataId: dataId},
      success: function(response) {
        if (response.status === 'success') {
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  });
  // Add to Cart from Wishlist
  $(document).on('click', '.wishlistCartBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'forms/cart_add_from_wishlist.php',
      type: 'post',
      data: {dataId: dataId},
      success: function(response) {
        if (response.status === 'success') {
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  });
  // Remove From Wishlist
  $(document).on('click', '.removeWishlistBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'forms/wishlist_remove.php',
      type: 'post',
      data: {dataId: dataId},
      success: function(response) {
        if (response.status === 'success') {
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  });
  // Launch quick view modal
  $(document).on('click', '.quickviewBtn', function(e) {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'forms/quickView.php',
      type: 'post',
      data: {dataId: dataId},
      success: function(response) {
        $('#modal-product .modal-dialog').
            addClass('modal-xl modal-dialog-scrollable');
        $('#modal-product .modal-title').html('Product Quick View');
        $('#modal-product .modalDetails').html(response);
        activateToolTips();
        activateZoom();
        $('#modal-product').modal('show');
      },
    });
  });
  // Add to compare
  $(document).on('click', '.compareBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'forms/compare_add.php',
      type: 'post',
      data: {dataId: dataId},
      success: function(response) {
        if (response.status === 'success') {
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  });
  // Remove from compare
  $(document).on('click', '.removeCompareBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'forms/compare_remove.php',
      type: 'post',
      data: {dataId: dataId},
      success: function(response) {
        if (response.status === 'success') {
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  });
  
  /**************************
   * Newsletter
   */
  // top newsletter
  $(document).on('submit', '#newsletter', function(e) {
    e.preventDefault();
    var email = $('#newsletter-email').val();
    $.ajax({
      url: 'forms/newsletter_subscribe.php',
      type: 'post',
      data: {email: email},
      success: function(response) {
        if (response.status === 'success') {
          $('#newsletter-email').val('');
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  });
  // Footer newsletter
  $(document).on('submit', '#newsletters', function(e) {
    e.preventDefault();
    var email = $('#newsletters-email').val();
    $.ajax({
      url: 'forms/newsletter_subscribe.php',
      type: 'post',
      data: {email: email},
      success: function(response) {
        if (response.status === 'success') {
          $('#newsletters-email').val('');
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  });
  
  /*******************************************************************************************************
   * All Products Display in Shop
   */
  /************************
   * Product Filters
   */
  //var priceRange = $('#pricing');
  $(document).ready(function() {
    // Initial load without filters
    loadProducts();
    // Capture changes in the "Sort by" select box
    $('#sortby').on('change', function() {
      var minPrice = $('#pricing').data('from');
      var maxPrice = $('#pricing').data('to');
      var sortBy = $(this).val(); // Define sortBy here
      applyFilters(minPrice, maxPrice, sortBy);
    });
    
    // Enable color selections
    const colorFilters = document.querySelectorAll('.filter-colors a');
    colorFilters.forEach(filter => {
      filter.addEventListener('click', () => {
        filter.classList.toggle('selected');
        
        // When a category or brand filter is selected/unselected
        var minPrice = $('#pricing').data('from');
        var maxPrice = $('#pricing').data('to');
        applyFilters(minPrice, maxPrice);
      });
    });
  });
  
  $('#pricing').ionRangeSlider({
    onFinish: function(data) {
      // When the price filter is adjusted
      var minPrice = data.from;
      var maxPrice = data.to;
      applyFilters(minPrice, maxPrice);
    },
  });
  
  $('.custom-control-input.category-filter, .custom-control-input.brand-filter, .custom-control-input.size-filter').
      on('change', function() {
        // When a category or brand filter is selected/unselected
        var minPrice = $('#pricing').data('from');
        var maxPrice = $('#pricing').data('to');
        applyFilters(minPrice, maxPrice);
      });
  
  function applyFilters(minPrice, maxPrice, sortBy)
  {
    var selectedFilters = [];
    
    // Capture selected category filters
    $('.custom-control-input.category-filter:checked').each(function() {
      selectedFilters.push($(this).attr('id'));
    });
    // Capture selected brand filters
    $('.custom-control-input.brand-filter:checked').each(function() {
      selectedFilters.push($(this).attr('id'));
    });
    // Capture selected size filters
    $('.custom-control-input.size-filter:checked').each(function() {
      selectedFilters.push($(this).attr('id'));
    });
    // Capture selected size filters
    $('.filter-colors a.selected').each(function() {
      selectedFilters.push($(this).attr('id'));
    });
    
    // Add ajax to carry the price filters and selected filters
  
    let urlLink = location.search;
    let category = urlLink.replace("?id=", "");
    $.ajax({
      url: 'forms/show_products.php', type: 'post', data: {
        category: category,
        minPrice: minPrice,
        maxPrice: maxPrice,
        selectedFilters: selectedFilters,
        sortBy: sortBy,  // Pass the sorting option to the server
      }, success: function(response) {
        $('.listings').html(response);
      },
    });
  }
  
  $(document).on('click', '.sidebar-filter-clear', function() {
    loadProducts();
  });
  
  function loadProducts()
  {
    // Load products without filters
    let urlLink = location.search;
    let category = urlLink.replace("?id=", "");
    $.ajax({
      url: 'forms/show_products.php', type: 'post', data: {
        category: category,},
      success: function(response) {
        $('.listings').html(response);
      },
    });
  }
  
  /************
   * Brand New Products
   */
  //var priceRange = $('#pricing');
  $(document).ready(function() {
    // Initial load without filters
    loadBrandNewProducts();
    // Capture changes in the "Sort by" select box
    $('.brandNewProducts #sortby').on('change', function() {
      var minPrice = $('#pricing').data('from');
      var maxPrice = $('#pricing').data('to');
      var sortBy = $(this).val(); // Define sortBy here
      applyBrandNewFilters(minPrice, maxPrice, sortBy);
    });
    
    // Enable color selections
    const colorFilters = document.querySelectorAll(
        '.brandNewProducts .filter-colors a');
    colorFilters.forEach(filter => {
      filter.addEventListener('click', () => {
        filter.classList.toggle('selected');
        
        // When a category or brand filter is selected/unselected
        var minPrice = $('#pricing').data('from');
        var maxPrice = $('#pricing').data('to');
        applyBrandNewFilters(minPrice, maxPrice);
      });
    });
  });
  
  $('.brandNewProducts #pricing').ionRangeSlider({
    onFinish: function(data) {
      // When the price filter is adjusted
      var minPrice = data.from;
      var maxPrice = data.to;
      applyBrandNewFilters(minPrice, maxPrice);
    },
  });
  
  $('.brandNewProducts .custom-control-input.category-filter, .brandNewProducts .custom-control-input.brand-filter, .brandNewProducts .custom-control-input.size-filter').
      on('change', function() {
        // When a category or brand filter is selected/unselected
        var minPrice = $('#pricing').data('from');
        var maxPrice = $('#pricing').data('to');
        applyBrandNewFilters(minPrice, maxPrice);
      });
  
  function applyBrandNewFilters(minPrice, maxPrice, sortBy)
  {
    var selectedFilters = [];
    
    // Capture selected category filters
    $('.custom-control-input.category-filter:checked').each(function() {
      selectedFilters.push($(this).attr('id'));
    });
    // Capture selected brand filters
    $('.custom-control-input.brand-filter:checked').each(function() {
      selectedFilters.push($(this).attr('id'));
    });
    // Capture selected size filters
    $('.custom-control-input.size-filter:checked').each(function() {
      selectedFilters.push($(this).attr('id'));
    });
    // Capture selected size filters
    $('.filter-colors a.selected').each(function() {
      selectedFilters.push($(this).attr('id'));
    });
    
    // Add ajax to carry the price filters and selected filters
    $.ajax({
      url: 'forms/show_brandNew_products.php', type: 'post', data: {
        minPrice: minPrice,
        maxPrice: maxPrice,
        selectedFilters: selectedFilters,
        sortBy: sortBy,  // Pass the sorting option to the server
      }, success: function(response) {
        $('.BrandNewListings').html(response);
      },
    });
  }
  
  $(document).
      on('click', '.brandNewProducts .sidebar-filter-clear', function() {
        loadBrandNewProducts();
      });
  
  function loadBrandNewProducts()
  {
    // Load products without filters
    $.ajax({
      url: 'forms/show_brandNew_products.php',
      type: 'post',
      success: function(response) {
        $('.BrandNewListings').html(response);
      },
    });
  }
  
  /************
   * Second Hand Products
   */
  //var priceRange = $('#pricing');
  $(document).ready(function() {
    // Initial load without filters
    loadSecondHandProducts();
    // Capture changes in the "Sort by" select box
    $('.secondHandProducts #sortby').on('change', function() {
      var minPrice = $('#pricing').data('from');
      var maxPrice = $('#pricing').data('to');
      var sortBy = $(this).val(); // Define sortBy here
      applySecondHandFilters(minPrice, maxPrice, sortBy);
    });
    
    // Enable color selections
    const colorFilters = document.querySelectorAll(
        '.secondHandProducts .filter-colors a');
    colorFilters.forEach(filter => {
      filter.addEventListener('click', () => {
        filter.classList.toggle('selected');
        
        // When a category or brand filter is selected/unselected
        var minPrice = $('#pricing').data('from');
        var maxPrice = $('#pricing').data('to');
        applySecondHandFilters(minPrice, maxPrice);
      });
    });
  });
  
  $('.secondHandProducts #pricing').ionRangeSlider({
    onFinish: function(data) {
      // When the price filter is adjusted
      var minPrice = data.from;
      var maxPrice = data.to;
      applySecondHandFilters(minPrice, maxPrice);
    },
  });
  
  $('.secondHandProducts .custom-control-input.category-filter, .secondHandProducts .custom-control-input.brand-filter, .secondHandProducts .custom-control-input.size-filter').
      on('change', function() {
        // When a category or brand filter is selected/unselected
        var minPrice = $('#pricing').data('from');
        var maxPrice = $('#pricing').data('to');
        applySecondHandFilters(minPrice, maxPrice);
      });
  
  function applySecondHandFilters(minPrice, maxPrice, sortBy)
  {
    var selectedFilters = [];
    
    // Capture selected category filters
    $('.custom-control-input.category-filter:checked').each(function() {
      selectedFilters.push($(this).attr('id'));
    });
    // Capture selected brand filters
    $('.custom-control-input.brand-filter:checked').each(function() {
      selectedFilters.push($(this).attr('id'));
    });
    // Capture selected size filters
    $('.custom-control-input.size-filter:checked').each(function() {
      selectedFilters.push($(this).attr('id'));
    });
    // Capture selected size filters
    $('.filter-colors a.selected').each(function() {
      selectedFilters.push($(this).attr('id'));
    });
    
    // Add ajax to carry the price filters and selected filters
    $.ajax({
      url: 'forms/show_secondHand_products.php', type: 'post', data: {
        minPrice: minPrice,
        maxPrice: maxPrice,
        selectedFilters: selectedFilters,
        sortBy: sortBy,  // Pass the sorting option to the server
      }, success: function(response) {
        $('.secondHandListings').html(response);
      },
    });
  }
  
  $(document).
      on('click', '.secondHandProducts .sidebar-filter-clear', function() {
        loadSecondHandProducts();
      });
  
  function loadSecondHandProducts()
  {
    // Load products without filters
    $.ajax({
      url: 'forms/show_secondHand_products.php',
      type: 'post',
      success: function(response) {
        $('.secondHandListings').html(response);
      },
    });
  }
  
  /************
   * Spare Part Products
   */
  //var priceRange = $('#pricing');
  $(document).ready(function() {
    // Initial load without filters
    loadSparePartProducts();
    // Capture changes in the "Sort by" select box
    $('.sparePartProducts #sortby').on('change', function() {
      var minPrice = $('#pricing').data('from');
      var maxPrice = $('#pricing').data('to');
      var sortBy = $(this).val(); // Define sortBy here
      applySpareFilters(minPrice, maxPrice, sortBy);
    });
    
    // Enable color selections
    const colorFilters = document.querySelectorAll(
        '.sparePartProducts .filter-colors a');
    colorFilters.forEach(filter => {
      filter.addEventListener('click', () => {
        filter.classList.toggle('selected');
        
        // When a category or brand filter is selected/unselected
        var minPrice = $('#pricing').data('from');
        var maxPrice = $('#pricing').data('to');
        applySpareFilters(minPrice, maxPrice);
      });
    });
  });
  
  $('.sparePartProducts #pricing').ionRangeSlider({
    onFinish: function(data) {
      // When the price filter is adjusted
      var minPrice = data.from;
      var maxPrice = data.to;
      applySpareFilters(minPrice, maxPrice);
    },
  });
  
  $('.sparePartProducts .custom-control-input.category-filter, .sparePartProducts .custom-control-input.brand-filter, .sparePartProducts .custom-control-input.size-filter').
      on('change', function() {
        // When a category or brand filter is selected/unselected
        var minPrice = $('#pricing').data('from');
        var maxPrice = $('#pricing').data('to');
        applySpareFilters(minPrice, maxPrice);
      });
  
  function applySpareFilters(minPrice, maxPrice, sortBy)
  {
    var selectedFilters = [];
    
    // Capture selected category filters
    $('.custom-control-input.category-filter:checked').each(function() {
      selectedFilters.push($(this).attr('id'));
    });
    // Capture selected brand filters
    $('.custom-control-input.brand-filter:checked').each(function() {
      selectedFilters.push($(this).attr('id'));
    });
    // Capture selected size filters
    $('.custom-control-input.size-filter:checked').each(function() {
      selectedFilters.push($(this).attr('id'));
    });
    // Capture selected size filters
    $('.filter-colors a.selected').each(function() {
      selectedFilters.push($(this).attr('id'));
    });
    
    // Add ajax to carry the price filters and selected filters
    $.ajax({
      url: 'forms/show_sparePart_products.php', type: 'post', data: {
        minPrice: minPrice,
        maxPrice: maxPrice,
        selectedFilters: selectedFilters,
        sortBy: sortBy,  // Pass the sorting option to the server
      }, success: function(response) {
        $('.sparePartsListings').html(response);
      },
    });
  }
  
  $(document).
      on('click', '.sparePartProducts .sidebar-filter-clear', function() {
        loadSparePartProducts();
      });
  
  function loadSparePartProducts()
  {
    // Load products without filters
    $.ajax({
      url: 'forms/show_sparePart_products.php',
      type: 'post',
      success: function(response) {
        $('.sparePartsListings').html(response);
      },
    });
  }
  
  /***************
   * Review Writing
   ******/
  $(document).on('submit', '#review-form', function(e) {
    e.preventDefault();
    var full_name = $('#full_name').val();
    var states = $('#status').val();
    var stars = $('#stars').val();
    var review = $('#review').val();
    var productId = $('#product_id').val();
    $.ajax({
      url: 'forms/review_add.php',
      type: 'post',
      data: {
        full_name: full_name,
        states: states,
        stars: stars,
        review: review,
        productId: productId,
      },
      success: function(response) {
        if (response.status === 'success') {
          $('input[type=text], textarea').val('');
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
      error: function(xhr, status, error) {
        console.error('AJAX Error:', status, error);
      },
    });
  });
  
  /***********************
   * CHAT & COMMUNICATION
   *****/
  $(document).on('click', '.toggle-contacts-btn', function() {
    $('.contacts').toggleClass('active');
  });
  // Send chat
  $(document).on('click', '.molla-send-button', function() {
    var receiver = $('.chatVendor').val();
    var message = $('.message-input-box').val();
    if (message !== '') {
      $.ajax({
        url: 'forms/sendChat.php',
        type: 'post',
        data: {receiver: receiver, message: message},
        success: function(response) {
          if (response.status === 'success') {
            $('.message-input-box').val('');
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
      toastr.warning(
          'You need to select a contact from the list or type something in the message box.');
    }
  });
  // Send Chat by pressing the enter key
  $(document).on('keyup', function(event) {
    if (event.keyCode === 13 || event.charCode === 13) {
      var receiver = $('.chatVendor').val();
      var message = $('.message-input-box').val();
      if (message !== '') {
        $.ajax({
          url: 'forms/sendChat.php',
          type: 'post',
          data: {receiver: receiver, message: message},
          success: function(response) {
            if (response.status === 'success') {
              $('.message-input-box').val('');
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
        toastr.warning(
            'You need to select a contact from the list or type something in the message box.');
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
      url: 'forms/getChatUserPic.php',
      type: 'POST',
      data: {user: user},
      success: function(response) {
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
                '</button>' +
                '<div class="dropdown-menu dropdown-menu-md-right" aria-labelledby="settingsDropdown">' +
                '<a class="dropdown-item" href="#">Setting 1</a>' +
                '<a class="dropdown-item" href="#">Setting 2</a>' +
                '<a class="dropdown-item" href="#">Setting 3</a>' +
                '</div></div></div></div>');
        
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
      url: 'forms/chat_upload.php?user=' + user, paramName: 'file', // The name
                                                                    // that
                                                                    // will be
                                                                    // used to
                                                                    // transfer
                                                                    // the file
      maxFilesize: 5, // MB
      acceptedFiles: 'image/*', clickable: '#dropzoneBtn', // Define a custom
                                                           // clickable area
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
        url: 'forms/getChat.php',
        type: 'post',
        data: {username: username},
        success: function(response) {
          $('.messages').html(response);
        },
      });
    }, 2000);
  }
  
  // Function to load and update chat history
  function loadChatHistory()
  {
    if ($('#contacts').length) {
      $.ajax({
        url: 'forms/getChatHistory.php', method: 'GET', // or 'POST' depending
                                                        // on your setup
        success: function(response) {
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
        if (contactName.includes(searchTerm) ||
            contactPreview.includes(searchTerm)) {
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
    $('.messages').animate({scrollTop: $('.messages')[0].scrollHeight});
  }
  
  /******************
   * Checkout
   *****************/
  $('#checkout-form').on('submit', function(e) {
    e.preventDefault();
    var formData = $(this).serializeArray();
    $.ajax({
      url: 'forms/checkout.php',
      type: 'POST',
      data: {formData: formData},
      success: function(response) {
        console.log(response);
        if (response.status === 'success') {
          toastr.success(response.message);
          // reset form and redirect to new page
          //$('#checkout-form').reset();
          window.setTimeout(() => {window.location.href = ('./invoice.php');},
              3000);
          //delay(1200).window.location.href=('./invoice.php');
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  });
  
  /*********************
   * Review Management
   *******/
  // Helpful Review
  $(document).on('click', '.helpful', function() {
    var reviewId = $(this).data('id');
    console.log(reviewId);
    $.ajax({
      url: 'forms/review_helpful.php',
      type: 'post',
      data: {reviewId: reviewId},
      success: function(response) {
        if (response.status === 'success') {
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  });
  // Unhelpful Review
  $(document).on('click', '.unhelpful', function() {
    var reviewId = $(this).data('id');
    $.ajax({
      url: 'forms/review_unhelpful.php',
      type: 'post',
      data: {reviewId: reviewId},
      success: function(response) {
        if (response.status === 'success') {
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  });
  
  /*********************
   * Contact Us
   *******/
  $(document).on('submit', '.contact-form', function(e) {
    e.preventDefault();
    var cname = $('#cname').val();
    var cemail = $('#cemail').val();
    var cphone = $('#cphone').val();
    var csubject = $('#csubject').val();
    var cmessage = $('#cmessage').val();
    $.ajax({
      url: 'forms/contact.php', type: 'post', data: {
        cname: cname,
        cemail: cemail,
        cphone: cphone,
        csubject: csubject,
        cmessage: cmessage,
      }, success: function(response) {
        if (response.status === 'success') {
          $('input[type=text], input[type=email], input[type=tel], textarea').
              val('');
          toastr.success(response.message);
        }
        else {
          toastr.warning(response.message);
        }
      },
    });
  });
  
  function validatePassword()
  {
    const passwordInput = document.getElementById('register-password');
    const passwordStrength = document.getElementById('passwordStrength');
    const btn = document.getElementById('signUpBtn');
    
    passwordInput.addEventListener('keyup', (event) => {
      const password = event.target.value;
      let strength = 0;
      
      if (password.length >= 8) {
        strength++;
      }
      
      if (password.match(/[a-z]/)) {
        strength++;
      }
      
      if (password.match(/[A-Z]/)) {
        strength++;
      }
      
      if (password.match(/\d/)) {
        strength++;
      }
      
      if (password.match(/[!@#$%^&*()_+{}|;:,.<>/?]/)) {
        strength++;
      }
      
      let strengthMessage = '';
      
      if (strength === 0) {
        strengthMessage = 'Your password is Weak';
      }
      else {
        if (strength === 1) {
          strengthMessage = 'Your password is Very weak';
        }
        else {
          if (strength === 2) {
            strengthMessage = 'Your password is Weak';
          }
          else {
            if (strength === 3) {
              strengthMessage = 'Your password is has moderate strength';
            }
            else {
              if (strength === 4) {
                strengthMessage = 'Your password is now Strong';
              }
              else {
                strengthMessage = 'Your password is now Very strong';
              }
            }
          }
        }
      }
      /*
      if (strength === 0) {
        strengthMessage = '<span class="text-danger">Your password is Weak</span>';
      } else {
        if (strength === 1) {
          strengthMessage = '<span class="text-danger">Your password is Very weak</span>';
        } else {
          if (strength === 2) {
            strengthMessage = '<span class="text-warning">Your password is Weak</span>';
          } else {
            if (strength === 3) {
              strengthMessage = '<span class="text-warning">Your password is now moderate</span>';
            } else {
              if (strength === 4) {
                strengthMessage = '<span class="text-success">Your password is now Strong</span>';
              } else {
                strengthMessage = '<span class="text-success">Your password is now Very strong</span>';
              }
            }
          }
        }
      }*/
      
      passwordStrength.textContent = strengthMessage;
    });
    
    passwordInput.addEventListener('blur', (e) => {
      passwordStrength.style.display = 'none';
    });
  }
  
  /************************************************
   * VENDORS SIDE
   */
  $(document).on('click', '.viewOrderBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'forms/order_view.php',
      type: 'post',
      data: {dataId: dataId},
      success: function(response) {
        // Display Model and complete order processing and other things
        $('#modalLabel').html('View & Process Order');
        $('.modalDetails').html(response);
        $('#modal').modal('show');
      },
    });
  });
  
  $(document).on('click', '.rejectOrderBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'forms/order_reject.php',
      type: 'post',
      data: {dataId: dataId},
      success: function(response) {
        // Display Model and complete order processing and other things
        $('#modalLabel').html('View & Process Order');
        $('.modalDetails').html(response);
        $('#modal').modal('show');
      },
    });
  });
  
  // Change Order Item Status
  $(document).on('change', '#orderProductStatusChanger', function() {
    var itemId = $(this).data('item');
    var status = $(this).val();
    var state = $('.orderProductStatus[data-item="' + itemId + '"]');
    $.ajax({
      url: 'forms/order_change_item_status.php',
      type: 'post',
      data: {itemId: itemId, status: status},
      success: function(response) {
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
  
  /************
   * Blogs
   */
  // Add comments to blog posts
  if ($('.commentReply').length) {
    $(document).on('click', '.commentReply', function() {
      var dataId = $(this).data('id');
      $('#commentId').val(dataId);
    });
  }
  /************
   * Job Alerts
   */
  // Client View of Job
  $(document).on('click', '.serviceDetails', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'service_details.php',
      type: 'post',
      data: {dataId: dataId},
      success: function(response) {
        $('#modal .modal-dialog').
            addClass('modal-lg modal-dialog-scrollable').
            removeClass('modal-xl');
        $('#modal .modal-title').html('Service Provider Details');
        $('#modal .modalDetails').html(response);
        $('#modal').modal('show');
      },
    });
  });
  // Search for the Service by Name
  function searchServices() {
    $('#serviceSearch').on('keyup', function() {
      var searchValue = $(this).val().toLowerCase();
      $('.service').each(function() {
        var serviceName = $(this).data('name');
        if (serviceName.includes(searchValue)) {
          $(this).show();
        }
        else {
          $(this).hide();
        }
      });
    });
  }
  
  /************
   * Job Alerts
   */
  // Client View of Job
  $(document).on('click', '.viewJobBtn', function() {
    var dataId = $(this).data('id');
    $.ajax({
      url: 'job_details.php',
      type: 'post',
      data: {dataId: dataId},
      success: function(response) {
        $('#modal .modal-dialog').
            addClass('modal-lg modal-dialog-scrollable').
            removeClass('modal-xl');
        $('#modal .modal-title').html('Job Alert Details');
        $('#modal .modalDetails').html(response);
        $('#modal').modal('show');
      },
    });
  });
  // Search for the Job by Title
  function searchJobs() {
    $('#jobSearch').on('keyup', function() {
      var searchValue = $(this).val().toLowerCase();
      $('.job').each(function() {
        var serviceName = $(this).data('name');
        if (serviceName.includes(searchValue)) {
          $(this).show();
        }
        else {
          $(this).hide();
        }
      });
    });
  }
  
  /***********************
   * Vendor Dashboard and others in the panel
   */
  // Function to create and initialize the real-time sales chart
  function createRealTimeChart()
  {
    const ctx = document.getElementById('realTimeSalesChart').getContext('2d');
    
    // Check if the dark mode class is applied to the body
    const isDarkMode = $('body').hasClass('dark-mode');
    
    // Define label color based on mode
    const labelColor = isDarkMode ? 'white' : 'black'; // Adjust the color as
                                                       // needed
    
    const salesChart = new Chart(ctx, {
      type: 'line', data: {
        labels: [], // X-axis labels (timestamps)
        datasets: [
          {
            label: 'Sales',
            data: [], // Sales data points
            fill: true,
            borderColor: 'rgb(20, 120, 255)',
            borderWidth: 4,
            pointBackgroundColor: 'rgb(20, 120, 255)',
            backgroundColor: 'transparent',
            tension: 0.3,
            color: labelColor,
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
        url: 'forms/dashboard_charts_sales.php', // Replace with the actual
                                                 // endpoint
        method: 'GET', dataType: 'json', success: function(data) {
          // Process the data and add it to the chart
          const salesData = data; // Assuming the data format is as provided by
                                  // your PHP endpoint
          
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
    
    // Set up a timer to update the chart data periodically (e.g., every 5
    // seconds)
    setInterval(updateData, 5000); // Adjust the interval as needed
  }
  
  // Call the function to create and initialize the real-time sales chart
  if ($('#realTimeSalesChart').length) {
    createRealTimeChart();
    setInterval(otherVitals, 5000);
  }
  
  function otherVitals()
  {
    $.ajax({
      url: 'forms/dashboard_total_counts.php',
      type: 'post',
      success: function(response) {
        $('.counts').html(response);
      },
    });
  }
  
  $(document).ready(function() {
    searchJobs();
    searchServices();
    $('#searchIcon').click(function() {
      $('#overlay').fadeIn();
      $('#overlay').show();
    });
    
    $('#overlay').click(function(e) {
      if (e.target === this) {
        $(this).fadeOut();
        $(this).hide();
      }
    });
  });
  
  $(document).ready(function() {
    const searchInput = $('#searchInput');
    const searchResults = $('#searchResults');
    
    searchInput.on('input', function() {
      const searchTerm = searchInput.val().trim();
      
      if (searchTerm !== '') {
        performSearch(searchTerm);
      }
      else {
        searchResults.empty();
      }
    });
    
    function performSearch(searchTerm)
    {
      $.ajax({
        url: 'forms/search_products.php',
        type: 'GET',
        data: {search: searchTerm},
        dataType: 'json',
        success: function(data) {
          displayProducts(data);
        },
        error: function(xhr, status, error) {
          console.error('Error fetching search results:', error);
        },
      });
    }
    
    function displayProducts(products)
    {
      searchResults.empty();
      
      $.each(products, function(index, product) {
        var productItem = $('<div class="product-item"></div>');
        productItem.append(
            '<a href="product.php?id=' + product.id + '">' + product.name +
            '</a>');
        
        searchResults.append(productItem);
      });
    }
  });
  
  $(document).ready(function() {
    const searchInputs = $('#search');
    const searchResult = $('#searchResult');
    
    searchInputs.on('input', function() {
      const searchTerms = searchInputs.val().trim();
      
      if (searchTerms !== '') {
        performSearch(searchTerms);
      }
      else {
        searchResult.empty();
      }
    });
    
    function performSearch(searchTerm)
    {
      $.ajax({
        url: 'forms/search_products.php',
        type: 'GET',
        data: {search: searchTerm},
        dataType: 'json',
        success: function(data) {
          displayProducts(data);
        },
        error: function(xhr, status, error) {
          console.error('Error fetching search results:', error);
        },
      });
    }
    
    function displayProducts(products)
    {
      searchResult.empty();
      
      $.each(products, function(index, product) {
        var productItem = $('<div class="product-items"></div>');
        productItem.append(
            '<a href="product.php?id=' + product.id + '">' + product.name +
            '</a>');
        
        searchResult.append(productItem);
      });
    }
  });
  
})(jQuery);
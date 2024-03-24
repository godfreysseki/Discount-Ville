<?php
  
  include_once "includes/header.inc.php";
  
  $data = new Orders();

?>

<main class="main">
  <nav aria-label="breadcrumb" class="breadcrumb-nav">
    <div class="container">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item"><a href="shop.php">Shop</a></li>
        <li class="breadcrumb-item active" aria-current="page">Checkout</li>
      </ol>
    </div><!-- End .container -->
  </nav><!-- End .breadcrumb-nav -->

  <div class="page-content">
    <div class="checkout">
      <div class="container">
        <form method="post" id="checkout-form">
          <div class="row">
            <div class="col-lg-9 checkout-details">
              <div id="accordion" class="py-5">
                <div class="card border-0">
                  <div class="card-header p-0 border-0" id="heading-245">
                    <button type="button" class="btn btn-link accordion-title border-0 collapse" data-toggle="collapse"
                      data-target="#collapse-245" aria-expanded="true" aria-controls="#collapse-245"><i
                        class="fas fa-minus text-center d-flex align-items-center justify-content-center h-100"></i>Contact Information
                    </button>
                  </div>
                  <div id="collapse-245" class="collapse show" aria-labelledby="heading-245" data-parent="#accordion">
                    <div class="card-body accordion-body">
                      <div class="contactInfo">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="full_name">Your Full Name</label>
                              <input type="text" name="full_name" id="full_name" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="email">Email Address</label>
                              <input type="email" name="email" id="email" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="telephone">Telephone Number</label>
                              <input type="text" name="telephone" id="telephone" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="contact_person">Contact Person</label>
                              <input type="text" name="contact_person" id="contact_person" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="contactPhone">Contact Person Phone Number</label>
                              <input type="text" name="contactPhone" id="contactPhone" class="form-control">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card border-0">
                  <div class="card-header p-0 border-0" id="heading-239">
                    <button type="button" class="btn btn-link accordion-title border-0 collapsed" data-toggle="collapse"
                      data-target="#collapse-239" aria-expanded="false" aria-controls="#collapse-239"><i
                        class="fas fa-minus text-center d-flex align-items-center justify-content-center h-100"></i>Billing
                      Address
                    </button>
                  </div>
                  <div id="collapse-239" class="collapse " aria-labelledby="heading-239" data-parent="#accordion">
                    <div class="card-body accordion-body">
                      <div class="p-3 card-1">
                        <?php
                          
                          $addresses = $data->userAddresses();
                          if (isset($addresses[0]['address_id'])) {
                            $no = 1;
                            foreach ($addresses as $address) {
                              echo '<div class="p-3 card-child" onclick="selectBillingAddress(this)">
																        <input type="radio" name="billingAddress" id="home' . $address['address_id'] . '" value="' . $address['address_id'] . '">
																        <label for="home" class="circle">
																          <i class="fa fa-home"></i>
																        </label>
																        <div class="d-flex flex-column ms-3">
																          <h6 class="fw-bold">Address ' . $no . '</h6>
																          <span>' . $address['postal_code'] . ', ' . $address['address_line1'] . '<br>' . $data->cityName($address['city']) . ', ' . $data->countryName($address['country']) . '</span>
																        </div>
																      </div>';
                              $no++;
                            }
                          }
                        
                        ?>
                        <div class="p-3 card-child py-4" onclick="selectBillingAddress(this)">
                          <input type="radio" name="billingAddress" id="addNew" value="Add New Address">
                          <label for="addNew" class="circle-3">
                            <i class="fa fa-plus"></i>
                          </label>
                          <div class="d-flex flex-column ms-3">
                            <h6 class="fw-bold text-primary">Add New Address</h6>
                          </div>
                        </div>
                      </div>
                      <div class="newBilling">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="address_line">Address Line 1</label>
                              <input type="text" name="address_line" id="address_line" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="address_line2">Address Line 2</label>
                              <input type="text" name="address_line2" id="address_line2" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="postal_code">Postal Code</label>
                              <input type="text" name="postal_code" id="postal_code" class="form-control">
                            </div>
                          </div>
                          <?= $data->cityCountries() ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card border-0 wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                  <div class="card-header p-0 border-0" id="heading-240">
                    <button type="button" class="btn btn-link accordion-title border-0 collapsed" data-toggle="collapse"
                      data-target="#collapse-240" aria-expanded="false" aria-controls="#collapse-240"><i
                        class="fas fa-minus text-center d-flex align-items-center justify-content-center h-100"></i>Delivery
                      Address
                    </button>
                  </div>
                  <div id="collapse-240" class="collapse " aria-labelledby="heading-240" data-parent="#accordion">
                    <div class="card-body accordion-body">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input sameAddress" name="sameAddress"
                          id="checkout-create-acc" value="Same as Billing Address">
                        <label class="custom-control-label" for="checkout-create-acc">Same as Billing Address</label>
                      </div><!-- End .custom-checkbox -->
                      <div class="p-3 card-2">
                        <?php
                          
                          $addresses = $data->userAddresses();
                          if (isset($addresses[0]['address_id'])) {
                            $no = 1;
                            foreach ($addresses as $address) {
                              echo '<div class="p-3 card-child" onclick="selectDeliveryAddress(this)">
																        <input type="radio" name="deliveryAddress" id="homeDelivery' . $address['address_id'] . '" value="' . $address['address_id'] . '">
																        <label for="home" class="circle">
																          <i class="fa fa-home"></i>
																        </label>
																        <div class="d-flex flex-column ms-3">
																          <h6 class="fw-bold">Address ' . $no . '</h6>
																          <span>' . $address['postal_code'] . ', ' . $address['address_line1'] . '<br>' . $data->cityName($address['city']) . ', ' . $data->countryName($address['country']) . '</span>
																        </div>
																      </div>';
                              $no++;
                            }
                          }
                        
                        ?>
                        <div class="p-3 card-child py-4" onclick="selectDeliveryAddress(this)">
                          <input type="radio" name="deliveryAddress" id="addNewDelivery"
                            value="Add New Delivery Address">
                          <label for="addNew" class="circle-3">
                            <i class="fa fa-plus"></i>
                          </label>
                          <div class="d-flex flex-column ms-3">
                            <h6 class="fw-bold text-primary">Add New Address</h6>
                          </div>
                        </div>
                      </div>
                      <div class="newDelivery">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="d_address_line">Address Line 1</label>
                              <input type="text" name="d_address_line" id="d_address_line" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="d_address_line2">Address Line 2</label>
                              <input type="text" name="d_address_line2" id="d_address_line2" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="postal_code">Postal Code</label>
                              <input type="text" name="d_postal_code" id="d_postal_code" class="form-control">
                            </div>
                          </div>
                          <?= $data->cityCountriesDelivery() ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card border-0 wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                  <div class="card-header p-0 border-0" id="heading-241">
                    <button type="button" class="btn btn-link accordion-title border-0 collapsed" data-toggle="collapse"
                      data-target="#collapse-241" aria-expanded="false" aria-controls="#collapse-241"><i
                        class="fas fa-minus text-center d-flex align-items-center justify-content-center h-100"></i>More
                      Information
                    </button>
                  </div>
                  <div id="collapse-241" class="collapse " aria-labelledby="heading-241" data-parent="#accordion">
                    <div class="card-body accordion-body">
                      <div class="form-group">
                        <label for="notes">Order Notes (Optional)</label>
                        <textarea name="notes" id="notes" cols="30" rows="4"
                          placeholder="Notes about your order, e.g. special notes for delivery or something else"
                          class="form-control"></textarea>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div><!-- End .col-lg-9 -->
            <aside class="col-lg-3">

              <?= $data->checkoutDetails() ?>

            </aside><!-- End .col-lg-3 -->
          </div><!-- End .row -->
        </form>
      </div><!-- End .container -->
    </div><!-- End .checkout -->
  </div><!-- End .page-content -->
</main><!-- End .main -->

<?php
  
  include_once "includes/footer.inc.php";

?>

<script>
function selectBillingAddress(card) {
  // Remove all attributes of checked from all radios in the card-1 class
  document.querySelectorAll('.card-1 .card-child input[type="radio"]').forEach(function(radio) {
    if (radio.hasAttribute('checked')) {
      radio.removeAttribute('checked');
    }
  });
  // Remove the selected class from all the card
  document.querySelectorAll('.card-1 .card-child').forEach(function(item) {
    item.classList.remove('selected');
  });
  // Add 'selected' class to the clicked card
  card.classList.add('selected');
  // Set the corresponding radio button as checked
  const radio = card.querySelector('input[type="radio"]');
  radio.checked = true;
  radio.setAttribute('checked', 'checked');
  if (radio.hasAttribute('checked') && radio.value === 'Add New Address') {
    $('.newBilling').show();
  } else {
    $('.newBilling').hide();
  }
}

function selectDeliveryAddress(card) {
  // Remove all attributes of checked from all radios in the card-1 class
  document.querySelectorAll('.card-2 .card-child input[type="radio"]').forEach(function(radio) {
    if (radio.hasAttribute('checked')) {
      radio.removeAttribute('checked');
    }
  });
  document.querySelectorAll('.card-2 .card-child').forEach(function(item) {
    item.classList.remove('selected');
  });
  // Add 'selected' class to the clicked card
  card.classList.add('selected');
  // Set the corresponding radio button as checked
  const radio = card.querySelector('input[type="radio"]');
  radio.checked = true;
  radio.setAttribute('checked', 'checked');
  if (radio.hasAttribute('checked') && radio.value === 'Add New Delivery Address') {
    $('.newDelivery').show();
  } else {
    $('.newDelivery').hide();
  }
}

$(document).ready(function() {
  // Listen for the change event on the checkbox
  $(".sameAddress").change(function() {
    // Check if the checkbox is checked
    if ($(this).prop("checked")) {
      // If checked, hide the card-2
      $(".card-2").hide();
      $(".newDelivery").hide();
    } else {
      // If not checked, show the card-2
      $(".card-2").show();
      $(".newDelivery").show();
    }
  });

});
</script>
<?php
  
  
  class Subscription extends Config
  {
    
    public function addSubscriptionPlan($planData)
    {
      if ($planData['subscription_id'] !== "" && $planData['subscription_id'] !== null) {
        // Updated the plan details
        $sql    = "UPDATE subscription_plans SET name=?, description=?, price=?, duration=?, max_products=?, deal_of_day=?, social_media=?, customer_support=? WHERE subscription_id=?";
        $params = [$planData['name'], $planData['description'], $planData['price'], $planData['duration'], $planData['max_products'], $planData['deal_of_day'], $planData['social_media'], $planData['customer_support'], $planData['subscription_id']];
        $id     = $this->updateQuery($sql, $params);
        if ($id > 0) {
          $msg = alert('success', 'Updated Subscription Plan successfully. Id: ' . $id);
        } else {
          $msg = alert('warning', 'Subscription Plan Updates Failed.');
        }
      } else {
        // Insert Plan Data
        $sql    = "INSERT INTO subscription_plans (name, description, price, duration, max_products, deal_of_day, social_media, customer_support) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $params = [$planData['name'], $planData['description'], $planData['price'], $planData['duration'], $planData['max_products'], $planData['deal_of_day'], $planData['social_media'], $planData['customer_support']];
        $id     = $this->updateQuery($sql, $params);
        if ($id > 0) {
          $msg = alert('success', 'Added Subscription Plan successfully. Id: ' . $id);
        } else {
          $msg = alert('warning', 'Subscription Plan Addition Failed.');
        }
      }
      
      return $msg;
    }
    
    public function subscriptionForm($planId = null)
    {
      $plan = [
        'subscription_id' => '',
        'name' => '',
        'description' => '',
        'price' => '',
        'max_products' => '',
        'deal_of_day' => '',
        'social_media' => '',
        'customer_support' => '',
        'duration' => ''
      ];
      
      if ($planId !== null) {
        $plan = $this->getPlanById($planId);
      }
      
      return '<form method="post" enctype="multipart/form-data">
                <input type="hidden" name="subscription_id" value="' . $plan['subscription_id'] . '">
                <div class="form-group">
                  <label for="name">Subscription Plan Name:</label>
                  <input type="text" name="name" id="name" value="' . $plan['name'] . '" class="form-control">
                </div>
                <div class="form-group">
                  <label for="description">Description:</label>
                  <textarea name="description" id="description" class="form-control" required>' . $plan['description'] . '</textarea>
                </div>
                <div class="form-group">
                  <label for="price">Price:</label>
                  <input type="number" name="price" id="price" min="0" value="' . $plan['price'] . '" class="form-control">
                </div>
                <div class="form-group">
                  <label for="max_products">Maximum Products:</label>
                  <input type="number" name="max_products" id="max_products" min="0" value="' . $plan['max_products'] . '" class="form-control">
                </div>
                <div class="form-group">
                  <label for="deal_of_day">Deals of the Day:</label>
                  <input type="number" name="deal_of_day" id="deal_of_day" min="0" value="' . $plan['deal_of_day'] . '" class="form-control">
                </div>
                <div class="form-group">
                  <label for="social_media">Products on Social Media:</label>
                  <input type="number" name="social_media" id="social_media" min="0" value="' . $plan['social_media'] . '" class="form-control">
                </div>
                <div class="form-group">
                  <label for="customer_support">Customer Support:</label>
                  <select name="customer_support" id="customer_support" class="select2 custom-select">
                    <option value="No" ' . (($plan['customer_support'] === "No") ? "selected" : "") . '>No</option>
                    <option value="Yes" ' . (($plan['customer_support'] === "Yes") ? "selected" : "") . '>Yes</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="duration">Duration (Months):</label>
                  <input type="number" name="duration" id="duration" min="0" value="' . $plan['duration'] . '" class="form-control">
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-primary float-right">' . (($planId !== null) ? "Edit" : "Add") . ' Plan</button>
                </div>
              </form>';
    }
    
    public function getPlanById($planId)
    {
      $sql    = "SELECT * FROM subscription_plans WHERE subscription_id=?";
      $params = [$planId];
      return $this->selectQuery($sql, $params)->fetch_assoc();
    }
    
    public function getPlanNameById($planId)
    {
      $sql    = "SELECT * FROM subscription_plans WHERE subscription_id=?";
      $params = [$planId];
      $row    = $this->selectQuery($sql, $params)->fetch_assoc();
      return $row['name'] ?? null;
    }
    
    public function deleteSubscriptionPlan($planId)
    {
      $sql    = "DELETE FROM subscription_plans WHERE subscription_id=?";
      $params = [$planId];
      $id     = $this->deleteQuery($sql, $params);
      if ($id > 0) {
        return alert('success', 'Subscription Plan Deleted Successfully.');
      } else {
        return alert('warning', 'subscription Plan Deletion Failed.');
      }
    }
    
    public function listSubscriptionPlans()
    {
      $sql = "SELECT * FROM subscription_plans";
      return $this->selectQuery($sql);
    }
    
    public function subscribeUser($subscriptionId)
    {
      // Activate User according to the selected plan
      // Get the previous subscription for the user and add the remaining time to the new plan
      // Update vendor's subscription plan
      $sql    = "UPDATE subscribers SET status='Active' WHERE subscriber_id=?";
      $params = [$subscriptionId];
      if ($this->updateQuery($sql, $params)) {
        return alert('success', 'Vendor subscribed successfully.');
      } else {
        return alert('warning', 'Vendor subscription activation failed.');
      }
    }
    
    public function subscriptionEditForm($subscriber_id)
    {
      $sql    = "SELECT * FROM subscribers WHERE subscriber_id=?";
      $params = [$subscriber_id];
      $row    = $this->selectQuery($sql, $params)->fetch_assoc();
      
      return '<form method="post">
                <input type="hidden" name="subscriberId" value="' . $subscriber_id . '" class="d-none">
                <div class="form-group">
                  <label for="plan">Subscription Plan</label>
                  <select name="plan" id="plan" class="custom-select select2">
                  ' . $this->getSubscriptionPlansComboOptions($row['subscription_id']) . '
                  </select>
                </div>
                <div class="form-group">
                  <label for="start_date">Start Date</label>
                  <input type="datetime-local" name="start_date" id="start_date" value="' . $row['subscription_start_date'] . '" class="form-control">
                </div>
                <div class="form-group">
                  <label for="end_date">End Date</label>
                  <input type="datetime-local" name="end_date" id="end_date" value="' . $row['subscription_end_date'] . '" class="form-control">
                </div>
                <div class="form-group">
                  <input type="submit" name="planEditBtn" value="Update Subscription" class="btn btn-primary float-right">
                </div>
              </form>';
    }
    
    public function updateSubscription($subscriberId, $plan, $start_date, $end_date)
    {
      $sql    = "UPDATE subscribers SET subscription_id=?, subscription_start_date=?, subscription_end_date=? WHERE subscriber_id=?";
      $params = [$plan, $start_date, $end_date, $subscriberId];
      if ($this->updateQuery($sql, $params)) {
        return alert('success', 'Subscription updated successfully.');
      } else {
        return alert('warning', 'Subscription failed to be updated.');
      }
    }
    
    public function getAllCustomerSubscriptions()
    {
      $sql = "SELECT * FROM subscribers s INNER JOIN subscription_plans sp ON s.subscription_id = sp.subscription_id INNER JOIN vendors v ON s.vendor_id = v.vendor_id INNER JOIN users u ON v.user_id = u.user_id ORDER BY subscriber_id DESC";
      return $this->selectQuery($sql);
    }
    
    // Add more methods as needed for your specific subscription-related features.
    public function getSubscriptionPlans()
    {
      // Retrieve a list of all subscription plans
      $sql    = "SELECT * FROM subscription_plans";
      $result = $this->selectQuery($sql);
      
      $plans = array();
      while ($row = $result->fetch_assoc()) {
        $plans[] = $row;
      }
      
      return $plans;
    }
    
    public function formatSubscriptionPlansForVendors()
    {
      $html              = '';
      $subscriptionPlans = $this->getSubscriptionPlans();
      $currentPlanId     = $this->vendorPlans($_SESSION['user_id']);
      $mostPopularPlanId = $this->mostPopularPlan();
      foreach ($subscriptionPlans as $plan) {
        $html .= '<div class="col-md-3">';
        $html .= '<div class="subscription-plan">';
        $html .= '<h3>' . $plan['name'] . '</h3>';
        
        // Add an image for the plan (replace 'image_url' with the actual column name)
        $html .= '<img src="./assets/img/subscriptions/' . $plan['image_url'] . '" alt="' . $plan['name'] . '">';
        
        $html .= '<p class="plan-description">' . $plan['description'] . '</p>';
        $html .= '<p class="plan-price">' . CURRENCY . ' ' . number_format($plan['price'], 2) . '</p>';
        $html .= '<p class="plan-duration">' . $plan['duration'] . ' months</p>';
        $html .= '<p class="plan-max-products">' . $plan['max_products'] . ' max products</p>';
        $html .= '<p class="plan-deal-of-day">' . ($plan['deal_of_day'] ? 'Deal of the Day' : 'No Deal of the Day') . '</p>';
        $html .= '<p class="plan-social-media">' . $plan['social_media'] . ' social media posts</p>';
        $html .= '<p class="plan-customer-support">' . ($plan['customer_support'] ? 'Customer Support Included' : 'No Customer Support') . '</p>';
        
        if ($plan['subscription_id'] === $currentPlanId) {
          // Indicate the user's current plan
          $html .= '<p class="current-plan">Current</p>';
        }
        
        $html .= '<a href="subscription_plan.php?id=' . $plan['subscription_id'] . '" class="btn btn-primary">Select Plan</a>';
        
        // Indicate the most popular plan (you can determine this based on your criteria)
        if ($plan['subscription_id'] === $mostPopularPlanId) {
          $html .= '<div class="popular-plan">Popular</div>';
        }
        
        $html .= '</div>';
        $html .= '</div>';
      }
      
      return $html;
    }
    
    public function renderPlans()
    {
      $html              = '<div class="text-center">
                              <div class="nav price-tabs" role="tablist">
                                <a class="nav-link active" href="#yearly" role="tab" data-toggle="tab">Yearly</a>
                                <a class="nav-link" href="#monthly" role="tab" data-toggle="tab">Monthly</a>
                              </div>
                            </div>
                            <div class="tab-content wow fadeIn" style="visibility: visible; animation-name: fadeIn;">';
      $subscriptionPlans = $this->getSubscriptionPlans();
      //$currentPlanId     = $this->vendorPlans($_SESSION['user_id']);
      $mostPopularPlanId = $this->mostPopularPlan();
      // Yearly
      $html .= '<div role="tabpanel" class="tab-pane fade show active" id="yearly">
                  <div class="row justify-content-center">';
      foreach ($subscriptionPlans as $plan) {
        $html .= '<div class="col mb-30">
                    <div class="price-item text-center">
                      <div class="price-top">
                        <h4>' . $plan['name'] . '</h4>
                        <h2 class="mb-0"><sup>' . CURRENCY . '</sup>' . number_format($plan['price'] * 12) . '</h2>
                        <span class="text-capitalize">per Year</span>
                      </div>
                      <div class="price-content">
                        <ul class="border-bottom mb-30 mt-md-4 pb-3 text-left">
                          <li>
                            <i class="la la-check font-weight-bold text-primary mr-2"></i>
                            <span class="c-black">System Training</span>
                          </li>
                          <li>
                            <i class="la la-check font-weight-bold text-primary mr-2"></i>
                            <span class="c-black">Customer Chat</span>
                          </li>
                          <li>
                            <i class="la la-check font-weight-bold text-primary mr-2"></i>
                            <span class="c-black">Appear In Vendor List</span>
                          </li>
                          <li>
                            <i class="la ' . ($plan['customer_support'] ? 'la-check text-primary' : 'la-times text-danger') . ' font-weight-bold mr-2"></i>
                            <span class="c-black">' . ($plan['customer_support'] ? 'Customer Support' : 'No Customer Support') . '</span>
                          </li>
                          <li>
                            <i class="la la-check font-weight-bold text-primary mr-2"></i>
                            <span class="c-black">' . $plan['max_products'] . ' Products</span>
                          </li>
                          <li>
                            <i class="la ' . ($plan['deal_of_day'] ? 'la-check text-primary' : 'la-times text-danger') . ' font-weight-bold mr-2"></i>
                            <span class="c-black">' . ($plan['deal_of_day'] ? 'Deal of the Day' : 'No Deal of the Day') . '</span>
                          </li>
                          <li>
                            <i class="la ' . ($plan['social_media'] ? 'la-check text-primary' : 'la-times text-danger') . ' font-weight-bold mr-2"></i>
                            <span class="c-black">' . ($plan['social_media'] ? $plan['social_media'] . ' Social Media Posts Per Month' : 'No Social Media Posts') . '</span>
                          </li>
                        </ul>
                        <a href="pricing_payment.php?id=' . $plan['subscription_id'] . '&plan=Yearly" class="btn btn-custom">Select Plan</a>
                      </div>
                    </div>
                  </div>';
      }
      $html .= '</div></div>';
      // Monthly
      $html .= '<div role="tabpanel" class="tab-pane fade" id="monthly">
                  <div class="row justify-content-center">';
      foreach ($subscriptionPlans as $plan) {
        $html .= '<div class="col mb-30">
                    <div class="price-item text-center">
                      <div class="price-top">
                        <h4>' . $plan['name'] . '</h4>
                        <h2 class="mb-0"><sup>' . CURRENCY . '</sup>' . number_format($plan['price']) . '</h2>
                        <span class="text-capitalize">per Month</span>
                      </div>
                      <div class="price-content">
                        <ul class="border-bottom mb-30 mt-md-4 pb-3 text-left">
                          <li>
                            <i class="la la-check font-weight-bold text-primary mr-2"></i>
                            <span class="c-black">System Training</span>
                          </li>
                          <li>
                            <i class="la la-check font-weight-bold text-primary mr-2"></i>
                            <span class="c-black">Customer Chat</span>
                          </li>
                          <li>
                            <i class="la la-check font-weight-bold text-primary mr-2"></i>
                            <span class="c-black">Appear In Vendor List</span>
                          </li>
                          <li>
                            <i class="la ' . ($plan['customer_support'] ? 'la-check text-primary' : 'la-times text-danger') . ' font-weight-bold mr-2"></i>
                            <span class="c-black">' . ($plan['customer_support'] ? 'Customer Support' : 'No Customer Support') . '</span>
                          </li>
                          <li>
                            <i class="la la-check font-weight-bold text-primary mr-2"></i>
                            <span class="c-black">' . $plan['max_products'] . ' Products</span>
                          </li>
                          <li>
                            <i class="la ' . ($plan['deal_of_day'] ? 'la-check text-primary' : 'la-times text-danger') . ' font-weight-bold mr-2"></i>
                            <span class="c-black">' . ($plan['deal_of_day'] ? 'Deal of the Day' : 'No Deal of the Day') . '</span>
                          </li>
                          <li>
                            <i class="la ' . ($plan['social_media'] ? 'la-check text-primary' : 'la-times text-danger') . ' font-weight-bold mr-2"></i>
                            <span class="c-black">' . ($plan['social_media'] ? $plan['social_media'] . ' Social Media Posts Per Month' : 'No Social Media Posts') . '</span>
                          </li>
                        </ul>
                        <a href="pricing_payment.php?id=' . $plan['subscription_id'] . '&plan=Monthly" class="btn btn-custom">Select Plan</a>
                      </div>
                    </div>
                  </div>';
      }
      $html .= '</div></div></div>';
      
      return $html;
    }
    
    public function vendorPlans($userId)
    {
      $sql = "SELECT s.subscription_id
                FROM users u
                JOIN vendors v ON u.user_id = v.user_id
                JOIN subscribers s ON v.vendor_id = s.vendor_id
                WHERE u.user_id = ?";
      
      $params = [$userId];
      $result = $this->selectQuery($sql, $params);
      
      // Check if a subscription plan was found
      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['subscription_id'];
      } else {
        return null; // No subscription plan found for this user
      }
    }
    
    public function mostPopularPlan()
    {
      $math    = "(SELECT COUNT(*) as num FROM subscription_plans WHERE price > 0)";
      $result  = $this->selectQuery($math);
      $the_one = $result->fetch_assoc()['num'] - 2;
      // First, retrieve the subscription plans excluding the first and last, ordered by price.
      $sql = "SELECT * FROM subscription_plans WHERE price > 0 ORDER BY price ASC LIMIT 1, {$the_one}";
      
      $result = $this->selectQuery($sql);
      
      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['subscription_id'];
      } else {
        return null; // No plans found
      }
    }
    
    public function addSubscription($newPlanId, $months, $transaction_id)
    {
      // Get vendor id
      // Get remaining time hence find how much to add to the new plan
      // activate the latest record for subscription
      $ids      = new Vendors();
      $vendorId = $ids->getVendorId();
      if ($vendorId !== 0 && $vendorId !== false) {
        $starts = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
        $ends   = date("Y-m-d H:i:s", strtotime("+" . $months . " month", $_SERVER['REQUEST_TIME']));
        $sql    = "INSERT INTO subscribers (vendor_id, transaction_id, subscription_id, subscription_start_date, subscription_end_date, status) VALUES (?, ?, ?, ?, ?, ?)";
        $params = [
          $vendorId,
          $transaction_id,
          $newPlanId,
          $starts,
          $ends,
          'Inactive'
        ];
        if ($this->insertQuery($sql, $params)) {
          return alert('success', 'Subscription obtained successfully. Wait for admin activation.');
        } else {
          return alert('warning', 'Transaction ID already used by someone.');
        }
      } else {
        return '<a href="shop.php" class="btn btn-sm btn-primary btn-block">Add your shop details first</a>';
      }
      
      
      // Check if the vendor has an active subscription
      $currentSubscription = $this->getCurrentSubscription($vendorId);
      
      if (!$currentSubscription) {
        return false; // Vendor does not have an active subscription
      }
      
      // Get details of the new subscription plan
      $newPlan = $this->getPlanById($newPlanId);
      
      if (!$newPlan) {
        return false; // New plan does not exist
      }
      
      // Calculate the remaining time on the current subscription
      $remainingDays = $this->calculateRemainingDays();
      
      // Calculate the cost for the remaining time
      $remainingCost = $this->calculateCostForRemainingTime($currentSubscription);
      
      // Calculate the cost of the new plan
      $newPlanCost = $this->calculateNewDays($newPlanId, $remainingCost);
      
      // Calculate the total cost to switch plans
      $totalCost = $remainingCost + $newPlanCost;
      
      // Deduct the total cost from the vendor's balance (handle payment)
      
      // Update the vendor's subscription with the new plan and duration
      return $this->updateVendorSubscription($vendorId, $newPlanId, $totalCost, $newPlan['duration']);
      
      //return true;
    }
    
    public function vendorCurrentPlan()
    {
      $data     = new Vendors();
      $vendorId = $data->getVendorId();
      $sql      = "SELECT * FROM subscribers WHERE vendor_id=? && status='Active' ";
      $params   = [$vendorId];
      $result   = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          return $this->getPlanNameById($row['subscription_id']) . ' till ' . dates($row['subscription_end_date']);
        }
      } else {
        return $this->getPlanNameById(1);
      }
    }
    
    private function getCurrentSubscription($vendorId)
    {
      // Retrieve the vendor's current subscription from the database
      // You need to implement this method to fetch the current subscription details
      $sql    = "SELECT * FROM subscribers WHERE vendor_id=? && status='Active' ";
      $params = [$vendorId];
      $result = $this->selectQuery($sql, $params)->fetch_assoc();
      
      return $result['subscription_id'];
    }
    
    private function calculateRemainingDays()
    {
      // Calculate the remaining days on the subscription
      // You need to implement this method based on the subscription details
      // Subtract the current date from the subscription's end date, considering the subscription duration.
      // Get vendor Id
      $vendorId = new Vendors();
      $vendor   = $vendorId->getVendorId();
      // Get remaining time
      $day    = "SELECT * FROM subscribers WHERE vendor_id=? ORDER BY subscriber_id DESC LIMIT 1";
      $params = [$vendor];
      $date   = $this->selectQuery($day, $params)->fetch_assoc();
      $days   = daysToDate($date['subscription_end_date']);
      
      // Get the amount for that time and this amount will be added to the new subscription
      return $days;
    }
    
    private function calculateCostForRemainingTime($subscriptionId)
    {
      // Get the plan daily payment
      $dailyPay     = "SELECT (price / (duration * 30)) AS dailyPay FROM subscription_plans WHERE subscription_id=?";
      $params       = [$subscriptionId];
      $dailyPayment = $this->selectQuery($dailyPay, $params)->fetch_assoc();
      $dailyPays    = $dailyPayment['dailyPay'];
      
      $days = $this->calculateRemainingDays();
      return round($days * $dailyPays);
    }
    
    private function calculateNewDays($newPlanId, $otherAmount)
    {
      // Get plan price
      $sql      = "SELECT * FROM subscription_plans WHERE subscription_id=?";
      $params   = [$newPlanId];
      $result   = $this->selectQuery($sql, $params)->fetch_assoc();
      $planCost = $result['price'];
      
      // Get total Price
      $total = ($planCost + $otherAmount);
      
      return $otherAmount;
      
      // Get the daily cost and calculate the time from now
      $dailyPay     = "SELECT (price / (duration * 30)) AS payment FROM subscription_plans WHERE subscription_id=?";
      $params       = [$newPlanId];
      $dailyPayment = $this->selectQuery($dailyPay, $params)->fetch_assoc();
      $dailyPays    = $dailyPayment['payment'];
      
      if ((float)$total !== 0 && (float)$dailyPays !== 0) {
        return $total / $dailyPays;
      } else {
        return 0;
      }
      //return (($total && $dailyPays) !== 0) ? ($total/$dailyPays) : 0;
      
      //     return $total;
    }
    
    private function updateVendorSubscription($vendorId, $newPlanId, $remainingDays, $newPlanDuration)
    {
      // Update the vendor's subscription in the database with the new plan and duration
      // You need to implement this method to update the subscription details.
      return $vendorId . ', ' . $newPlanId . ', ' . $remainingDays . ', ' . $newPlanDuration;
    }
    
    public function makePayment($data = null)
    {
      if (isset($data['username'])) {
        return '<p>Thank you for the subscription. We will update your plan as soon as possible. You can now configure your shop details and start adding your products to the system.</p>';
      } else {
        return '<p>If you are a new vendor, you can you this part to register and also make payments. You subscription plan will be updated as soon as the admin sees your transaction.</p>
                <form method="post">
                  <div class="row">
                    <div class="col-4">
                      <div class="form-group">
                        <label for="username">Your Name</label>
                        <input type="text" id="username" name="username" class="form-control">
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" class="form-control">
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" class="form-control">
                      </div>
                    </div>
                  </div>
                </form>';
      }
    } // TODO: remove & usage
  }
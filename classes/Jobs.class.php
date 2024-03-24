<?php
  
  
  class Jobs extends Config
  {
    
    public function saveJobAlert($data)
    {
      if (isset($data['jobId']) && !empty($data['jobId'])) {
        return $this->updateJob($data);
      } else {
        return $this->insertJob($data);
      }
    }
    
    public function insertJob($data)
    {
      $sql    = "INSERT INTO jobs (company, title, phone, email, location, user_location, details, job_type, requirements, skills, hours_of_work, min_salary, max_salary, state, views, regdate, expiry) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
      $params = [
        $data['company'],
        $data['title'],
        $data['phone'],
        $data['email'],
        $data['location'],
        $data['user_location'],
        $data['details'],
        $data['job_type'],
        $data['requirements'],
        $data['skills'],
        $data['hours_of_work'],
        $data['min_salary'],
        $data['max_salary'],
        $data['state'],
        0,
        date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']),
        $data['expiry']
      ];
      if ($this->insertQuery($sql, $params)) {
        echo alert('success', 'Job Alert added Successfully.');
      } else {
        echo alert('warning', 'Job Alert Failed');
      }
    }
    
    public function updateJob($data)
    {
      $sql    = "UPDATE jobs SET company=?, title=?, phone=?, email=?, location=?, user_location=?, details=?, job_type=?, requirements=?, skills=?, hours_of_work=?, min_salary=?, max_salary=?, state=?, expiry=? WHERE jid=?";
      $params = [
        $data['company'],
        $data['title'],
        $data['phone'],
        $data['email'],
        $data['location'],
        $data['user_location'],
        $data['details'],
        $data['job_type'],
        $data['requirements'],
        $data['skills'],
        $data['hours_of_work'],
        $data['min_salary'],
        $data['max_salary'],
        $data['state'],
        $data['expiry'],
        $data['jobId']
      ];
      if ($this->updateQuery($sql, $params)) {
        echo alert('success', 'Job Alert Updated Successfully.');
      } else {
        echo alert('warning', 'Job Alert Failed to be updated.');
      }
    }
    
    public function deleteJob($job_id)
    {
      $sql    = "DELETE FROM jobs WHERE jid=?";
      $params = [$this->decrypt($job_id)];
      if ($this->deleteQuery($sql, $params)) {
        return alert('success', 'Job Alert Deleted Successfully.');
      } else {
        return alert('warning', 'Job Alert was already deleted.');
      }
    }
    
    public function jobForm($job_id = null)
    {
      // If the id is set, then update the content in the array.
      if ($job_id !== null) {
        $data = $this->getJobDetails($job_id);
      } else {
        $data = [
          'jid' => '',
          'company' => '',
          'title' => '',
          'phone' => '',
          'email' => '',
          'location' => '',
          'user_location' => '',
          'details' => '',
          'job_type' => '',
          'requirements' => '',
          'skills' => '',
          'hours_of_work' => '',
          'min_salary' => '',
          'max_salary' => '',
          'state' => '',
          'expiry' => ''
        ];
      }
      
      // Generate Form
      $form = '<form method="post" class="row">
                  <input type="hidden" name="jobId" id="jobId" value="' . $data['jid'] . '" class="d-none">
                  <div class="form-group col-sm-6">
                    <label for="company">Company Name</label>
                    <input type="text" name="company" id="company" value="' . $data['company'] . '" required class="form-control">
                  </div>
                  <div class="form-group col-sm-6">
                    <label for="title">Job Title</label>
                    <input type="text" name="title" id="title" value="' . $data['title'] . '" required class="form-control">
                  </div>
                  <div class="form-group col-sm-4">
                    <label for="phone">Company Telephone</label>
                    <input type="text" name="phone" id="phone" value="' . $data['phone'] . '" required class="form-control">
                  </div>
                  <div class="form-group col-sm-4">
                    <label for="email">Company Email</label>
                    <input type="email" name="email" id="email" value="' . $data['email'] . '" required class="form-control">
                  </div>
                  <div class="form-group col-sm-4">
                    <label for="location">Company Location</label>
                    <input type="text" name="location" id="location" value="' . $data['location'] . '" required class="form-control">
                  </div>
                  <div class="form-group col-sm-6">
                    <label for="user_location">User Location</label>
                    <input type="text" name="user_location" id="user_location" value="' . $data['user_location'] . '" required class="form-control">
                  </div>
                  <div class="form-group col-sm-6">
                    <label for="job_type">Job Type</label>
                    <select name="job_type" id="job_type" required class="custom-select select2">
                      <option value="Remote" ' . (($data['job_type'] === 'Remote') ? "selected" : "") . '>Remote</option>
                      <option value="On Premises" ' . (($data['job_type'] === 'On Premises') ? "selected" : "") . '>On Premises</option>
                      <option value="Part Time Remote" ' . (($data['job_type'] === 'Part Time Remote') ? "selected" : "") . '>Part Time Remote</option>
                      <option value="Part Time On Premises" ' . (($data['job_type'] === 'Part Time On Premises') ? "selected" : "") . '>Part Time On Premises</option>
                      <option value="Full Time Remote" ' . (($data['job_type'] === 'Full Time Remote') ? "selected" : "") . '>Full Time Remote</option>
                      <option value="Full Time On Premises" ' . (($data['job_type'] === 'Full Time On Premises') ? "selected" : "") . '>Full Time On Premises</option>
                    </select>
                  </div>
                  <div class="form-group col-sm-12">
                    <label for="details">Job Details</label>
                    <textarea name="details" id="details" placeholder="Full Job Description" required class="form-control">' . $data['details'] . '</textarea>
                  </div>
                  <div class="form-group col-sm-6">
                    <label for="requirements">User Requirements</label>
                    <textarea name="requirements" id="requirements" placeholder="Separate with comma(,)" required class="form-control">' . $data['requirements'] . '</textarea>
                  </div>
                  <div class="form-group col-sm-6">
                    <label for="skills">Skills</label>
                    <textarea name="skills" id="skills" placeholder="Separate with comma(,)" required class="form-control">' . $data['skills'] . '</textarea>
                  </div>
                  <div class="form-group col-sm-4">
                    <label for="hours_of_work">Hours of Work</label>
                    <input type="number" min="0" max="24" name="hours_of_work" id="hours_of_work" value="' . $data['hours_of_work'] . '" required class="form-control">
                  </div>
                  <div class="form-group col-sm-4">
                    <label for="min_salary">Min. Salary</label>
                    <input type="number" min="0" name="min_salary" id="min_salary" value="' . $data['min_salary'] . '" required class="form-control">
                  </div>
                  <div class="form-group col-sm-4">
                    <label for="max_salary">Max. Salary</label>
                    <input type="number" min="0" name="max_salary" id="max_salary" value="' . $data['max_salary'] . '" required class="form-control">
                  </div>
                  <div class="form-group col-sm-6">
                    <label for="state">Job State</label>
                    <select name="state" id="state" required class="custom-select select2">
                      <option value="Running" ' . (($data['state'] === "Running") ? "selected" : "") . '>Running</option>
                      <option value="Taken" ' . (($data['state'] === "Taken") ? "selected" : "") . '>Taken</option>
                      <option value="Removed" ' . (($data['state'] === "Removed") ? "selected" : "") . '>Removed</option>
                      <option value="Expired" ' . (($data['state'] === "Expired") ? "selected" : "") . '>Expired</option>
                    </select>
                  </div>
                  <div class="form-group col-sm-6">
                    <label for="expiry">Alert Expiry</label>
                    <input type="datetime-local" name="expiry" id="expiry" value="' . $data['expiry'] . '" required class="form-control">
                  </div>
                  <div class="form-group col-12">
                    <input type="submit" name="saveJobBtn" value="Save" class="btn btn-primary float-right">
                  </div>
                </form>';
      
      return $form;
    }
    
    private function getJobDetails($job_id)
    {
      $sql    = "SELECT * FROM jobs WHERE jid=?";
      $params = [$this->decrypt($job_id)];
      return $this->selectQuery($sql, $params)->fetch_assoc();
    }
    
    public function listJobDetails($job_id)
    {
      $jobId = $this->decrypt($job_id);
      return $this->clientJobDetails($jobId);
    }
    
    public function listJobs()
    {
      $data   = '<p>No job alerts published yet.</p>';
      $sql    = "SELECT * FROM jobs ORDER BY jid DESC";
      $result = $this->selectQuery($sql);
      if ($result->num_rows) {
        $no   = 1;
        $data = '<div class="table-responsive">
                  <table class="table table-sm table-bordered table-striped dataTable">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Company</th>
                        <th>Title</th>
                        <th>Job Type</th>
                        <th>Clients Location</th>
                        <th>Views</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>';
        while ($row = $result->fetch_assoc()) {
          $id     = $this->encrypt($row['jid']);
          $action = '
                      <button data-id="' . $id . '" class="viewJob btn btn-link btn-xs text-primary" data-toggle="tooltip" title="View"><i class="fa fa-eye"></i></button>
                      <button data-id="' . $id . '" class="editJob btn btn-link btn-xs text-success" data-toggle="tooltip" title="Edit"><i class="fa fa-pen-fancy"></i></button>
                      <button data-id="' . $id . '" onclick="if(confirm(\'This will delete this record from the system.\\nIf connected to other records, they will be affected.\\n\\nAre you sure to continue?\')) {$(this).addClass(\'deleteJob\')}" data-toggle="tooltip" title="Delete" class="btn btn-link btn-xs text-danger"><span class="fa fa-trash"></span></button>
                    ';
          $data   .= '<tr>
                      <td>' . $no . '</td>
                      <td>' . $row['company'] . '</td>
                      <td>' . $row['title'] . '</td>
                      <td>' . $row['job_type'] . '</td>
                      <td>' . $row['user_location'] . '</td>
                      <td>' . number_format($row['views']) . '</td>
                      <td>' . $action . '</td>
                    </tr>';
          $no++;
        }
        $data .= '</tbody></table></div>';
      }
      return $data;
    }
    
    // Client Side
    public function showJobs()
    {
      $data   = '<p>No job posts currently available. Once job search alerts are available, they will be displayed here. Keep checking this page for updates.</p>';
      $sql    = "SELECT * FROM jobs WHERE state='Running' ORDER BY jid DESC";
      $result = $this->selectQuery($sql);
      if ($result->num_rows > 0) {
        $data = '';
        while ($row = $result->fetch_assoc()) {
          $skills          = explode(', ', $row['skills']);
          $skills_required = '';
          foreach ($skills as $skill) {
            $skills_required .= '<span class="badge bg-secondary">' . $skill . '</span> ';
          }
          $data .= '<div class="card mb-1 job" data-name="'.strtolower($row['title']).'">
                      <div class="card-body">
                        <div class="d-flex flex-column flex-lg-row">
                          <span class="avatar avatar-text rounded-3 me-4 bg-primary mb-2">' . getInitials(strtoupper($row['company'])) . '</span>
                          <div class="row flex-fill">
                            <div class="col-sm-5">
                              <h4 class="h5">' . $row['title'] . '<br><small class="text-muted">@ ' . $row['company'] . '</small></h4>
                              User from: <span class="badge bg-secondary">' . $row['user_location'] . '</span> <span class="badge bg-success">' . CURRENCY . ' ' . number_format($row['min_salary']) . ' - ' . number_format($row['max_salary']) . '</span>
                            </div>
                            <div class="col-sm-4 py-2 text-center">
                              <p class="font-weight-normal">
                              ' . $skills_required . '
                              </p>
                              <h4 class="font-weight-bold">
                              <span class="badge bg-info">' . $row['job_type'] . '</span>
                              </h4>
                            </div>
                            <div class="col-sm-3 text-right">
                              <a href="javascript:void(0)" data-id="' . $row['jid'] . '" class="viewJobBtn btn btn-primary stretched-link">View Details</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>';
        }
      }
      return $data;
    }
    
    public function clientJobDetails($job_id)
    {
      $data   = 'Please re-select the job using the button provided.';
      $sql    = "SELECT * FROM jobs WHERE jid=?";
      $params = [$job_id];
      $result = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        // Increase Views
        $this->viewedAlert($job_id);
        $data = '';
        while ($row = $result->fetch_assoc()) {
          $skills          = explode(', ', $row['skills']);
          $skills_required = '';
          foreach ($skills as $skill) {
            $skills_required .= '<span class="badge bg-secondary text-white p-2" style="font-size: 1.2rem">' . $skill . '</span> ';
          }
          $requirements          = explode(', ', $row['requirements']);
          $requirements_required = '<ul class="list-group list-group-flush">';
          foreach ($requirements as $requirement) {
            $requirements_required .= '<li class="list-group-item">' . $requirement . '</li>';
          }
          $requirements_required .= '</ul>';
          $data                  .= '<h5 class="mt-0 border-bottom">Company Details</h5>';
          $data                  .= '<p><b>Company:</b> ' . $row['company'] . '</p>';
          $data                  .= '<p><b>Contacts:</b> ' . phone($row['phone']) . ' | ' . email($row['email']) . '<br><b>Location:</b> ' . $row['location'] . '</p>';
          $data                  .= '<h5 class="border-bottom">Job Details</h5>';
          $data                  .= '<p><b>Job Descriptions:</b><br> ' . nl2br($row['details']) . '</p><br>';
          $data                  .= '<p><b>Job Requirements:</b><br> ' . $requirements_required . '</p>';
          $data                  .= '<h5 class="border-bottom">User Details</h5>';
          $data                  .= '<p>
                                  <b>Location:</b> ' . $row['user_location'] . '<br>
                                  <b>Skills:</b> ' . $skills_required . '<br>
                                  <b>Hours of Work:</b> ' . $row['hours_of_work'] . 'Hrs a Day<br>
                                  <b>Salary:</b> ' . CURRENCY . ' ' . number_format($row['min_salary']) . ' - ' . number_format($row['max_salary']) . '</p>';
          $data                  .= '<p><b>Applications Before:</b> ' . datel($row['expiry']) . '</p>';
          $data                  .= '<p><b>State:</b> ' . $row['state'] . '</p>';
        }
      }
      return $data;
    }
  
    public function viewedAlert($job_id)
    {
      $this->updateQuery("UPDATE jobs SET views=views+1 WHERE jid=?", [$job_id]);
    }
    
  }
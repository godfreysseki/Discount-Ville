<?php
  
  
  class FAQs extends Config
  {
    
    public function addFAQTitle($formData)
    {
      $sql    = "INSERT INTO faqs_titles (title) VALUES (?)";
      $params = [esc($formData['title'])];
      if ($this->insertQuery($sql, $params)) {
        return alert('success', 'FAQ Title Added Successfully.');
      } else {
        return alert('warning', 'FAQ Title Failed.');
      }
    }
    
    public function addFAQ($formData)
    {
      $sql    = "INSERT INTO faqs (question, answer, faq_title_id) VALUES (?, ?, ?)";
      $params = [esc($formData['question']), esc($formData['answer']), esc($formData['title_id'])];
      if ($this->insertQuery($sql, $params)) {
        return alert('success', 'FAQ Added Successfully.');
      } else {
        return alert('warning', 'FAQ Failed.');
      }
    }
    
    public function showFAQs()
    {
      $data   = '';
      $sql    = "SELECT * FROM faqs_titles";
      $result = $this->selectQuery($sql);
      $no     = 1;
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $data .= '<div class="accordion accordion-rounded" id="accordion-' . $no . '">
                    <h2 class="title text-center mb-3">' . $row['title'] . '</h2><!-- End .title -->
                    ' . $this->faqQuestions($row['faq_title_id'], $no) . '
                    </div><!-- End .accordion -->' . PHP_EOL;
          $no++;
        }
      }
      return $data;
    }
    
    private function faqQuestions($titleId, $accordion)
    {
      $data   = '';
      $sql    = "SELECT * FROM faqs WHERE faq_title_id=?";
      $params = [$titleId];
      $result = $this->selectQuery($sql, $params);
      if ($result->num_rows > 0) {
        $no = 1;
        while ($row = $result->fetch_assoc()) {
          $data .= '<div class="card card-box card-sm bg-light">
                      <div class="card-header" id="heading-' . $no . '">
                        <h2 class="card-title">
                          <a ' . (($no === 1) ? '' : 'class="collapsed"') . '" role="button" data-toggle="collapse" href="#collapse-' . $no . '" aria-expanded="' . (($no === 1) ? 'true' : 'false') . '"" aria-controls="collapse-' . $no . '">
                            ' . $row['question'] . '
                          </a>
                        </h2>
                      </div><!-- End .card-header -->
                      <div id="collapse-' . $no . '" class="collapse ' . (($no === 1) ? "show" : "") . '" aria-labelledby="heading-' . $no . '" data-parent="#accordion-' . $accordion . '">
                        <div class="card-body">
                          ' . $row['answer'] . '
                        </div><!-- End .card-body -->
                      </div><!-- End .collapse -->
                    </div><!-- End .card -->';
          $no++;
        }
      }
      return $data;
    }
    
  }
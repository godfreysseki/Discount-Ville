<?php
  
  include_once "../includes/config.inc.php";
  
  $data = new Category();
  $subs = $data->getChildCategories($_POST['dataId']);
  
  $no = 1;
  echo "<div class='table-responsive'>
          <table class='table table-sm table-bordered'>
            <thead>
              <tr>
                <th>#</th>
                <th>Image / Banner</th>
                <th>Category</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>";
  foreach ($subs as $sub) {
    echo '<tr>
            <td>'.$no.'</td>
            <td><img src="../assets/img/categories/'.esc($sub['banner']).'" alt="Sub Category Image"></td>
            
            <td>'.$sub['category_name'].'</td>
            <td>
              <button class="editCategoryBtn btn btn-xs btn-link text-success" data-id="'. esc($sub['category_id']) .'" data-toggle="tooltip" title="Edit"><span class="fa fa-pen-fancy"></span></button>
              <button class="btn btn-xs btn-link text-danger" onclick="if (confirm(\'Are you sure you want to delete this record?\')) {$(this).addClass(\'deleteCategoryBtn\');}" data-id="'.$sub["category_id"].'"
											        data-toggle="tooltip" title="Delete"><span class="fa fa-trash-alt"></span></button>
            </td>
          </tr>';
    $no++;
  }
  echo "</tbody></table></div>";

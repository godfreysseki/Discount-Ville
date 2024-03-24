<?php
  
  header("Content-type:application/json");
  
  include_once "../includes/config.inc.php";
  
  // Check if the file is uploaded successfully
  if ($_FILES["file"]["error"] == UPLOAD_ERR_OK) {
    
    // Get the file name and generate a unique name
    $originalName = $_FILES["file"]["name"];
    $extension    = pathinfo($originalName, PATHINFO_EXTENSION);
    $uniqueName   = str_replace(".", "", uniqid(time(), true)) . '.' . $extension;
    
    // Specify the directory where you want to store the uploaded files
    $uploadDirectory = '../assets/img/chat/';
    
    // Move the file to the specified directory
    $uploadPath = $uploadDirectory . $uniqueName;
    move_uploaded_file($_FILES["file"]["tmp_name"], $uploadPath);
    
    // Write to database
    $receiver = $_GET['user'];
    $data = new Chat();
    echo $data->uploadChatFile(esc($_SESSION['username']), $receiver, $uniqueName);
  } else {
    // Handle the error if the file upload fails
    echo json_encode(['status'=>'warning', 'message'=>'File Upload Failed.']);
  }
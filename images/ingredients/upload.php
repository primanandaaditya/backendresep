<?php 
 
  $response = array(); 
 
  $image = $_POST['image'];
  $name = $_POST['name'];
  $realImage = base64_decode($image);
  
  $success = file_put_contents($name,$realImage);
 
  if($success){
    $message = "Successfully Uploaded";
  }else{
    $message = "Fail Uploaded";
  }
 
  $response["success"] = $success; 
  $response["message"] = $message; 
 
  echo json_encode($response);  
  
 
?> 
 


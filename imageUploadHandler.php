<?php

function imgResize($src, $dest, $resizedMaxSize) {

  $x = getimagesize($src);            
  $width  = $x['0'];
  $height = $x['1'];

  if ($width > $height){
    $rs_width = $resizedMaxSize;
    $rs_height = $height/$width * $rs_width;
  }else{    
    $rs_height = $resizedMaxSize;
    $rs_width = $width/$height * $rs_height;
  }

  switch ($x['mime']) {
    case "image/gif":
      $img = imagecreatefromgif($src);
      break;
    case "image/jpeg":
      $img = imagecreatefromjpeg($src);
      break;
    case "image/png":
      $img = imagecreatefrompng($src);
      break;
  }

  $img_base = imagecreatetruecolor($rs_width, $rs_height);
  imagecopyresampled($img_base, $img, 0, 0, 0, 0, $rs_width, $rs_height, $width, $height);

  $path_info = pathinfo($dest);    
  switch ($path_info['extension']) {
    case "gif":
      imagegif($img_base, $dest);  
      break;
    case "jpg":
    case "jpeg":
      imagejpeg($img_base, $dest);  
      break;
    case "png":
      imagepng($img_base, $dest);  
      break;
  }

}

// Processes uploading of images
// Parameters:
// $name: the "name" of the form field with the file uploader
// $uploaddir: where to store the uploaded image
function processUpload($name, $uploaddir){
  
  // Store uploaded image into specified folder
  $uploadfile = $uploaddir . '/' . microtime() . '.jpg';

  // Throw exception if file is too big
  if ($_FILES[$name]['size'] > 2 * 1024 * 1024){
    throw new Exception('File size exceeded');
  }

  // Create temp file name
  $tempfile = tempnam (sys_get_temp_dir(), 'img');
  // Move uploaded file to temp file
  if (move_uploaded_file($_FILES[$name]['tmp_name'], $tempfile)) {
    
    if (!is_dir($uploaddir)){
      mkdir($uploaddir, 0777, true);
    }
    
    // Resize image and store to destination
    imgResize($tempfile, $uploadfile, 300);
    // Delete temp file
    unlink($tempfile);
    // Return uploaded file name generated
    return pathinfo($uploadfile, PATHINFO_BASENAME);
  } else {
    throw new Exception('Possible file upload attack');
  }
}

?>
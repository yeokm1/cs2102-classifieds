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

function processUpload($name){
  $uploaddir = 'content/profile/';
  $uploadfilename = basename(microtime()) . '.jpg';
  $uploadfile = $uploaddir . $uploadfilename;

  if ($_FILES[$name]['size'] > 2 * 1024 * 1024){
    throw new Exception('File size exceeded');
  }

  $tempfilename = tempnam ('content/temp/', 'img');
  if (move_uploaded_file($_FILES[$name]['tmp_name'], $tempfilename)) {
    imgResize($tempfilename, $uploadfile, 300);
    return $uploadfilename;
  } else {
    throw new Exception('Possible file upload attack');
  }
}

?>
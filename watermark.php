<?php

  // loads a png, jpeg or gif image from the given file name
  function imagecreatefromfile($image_path) {
    list($width, $height, $image_type) = getimagesize($image_path);

    switch ($image_type)
    {
      case IMAGETYPE_GIF: return imagecreatefromgif($image_path); break;
      case IMAGETYPE_JPEG: return imagecreatefromjpeg($image_path); break;
      case IMAGETYPE_PNG: return imagecreatefrompng($image_path); break;
      default: return ''; break;
    }
  }

  $image = imagecreatefromfile($_GET['image']);
  if (!$image) die('Unable to open image');

  $watermark = imagecreatefromfile($_GET['watermark']);
  if (!$image) die('Unable to open watermark');

  $watermark_pos_x = imagesx($image) - imagesx($watermark) - 50;
  $watermark_pos_y = imagesy($image) - imagesy($watermark) - 20;

  imagecopy($image, $watermark,  $watermark_pos_x, $watermark_pos_y, 0, 0,
  imagesx($watermark), imagesy($watermark));

  header('Content-Type: image/jpeg');
  imagejpeg($image, NULL, 100);  // use best image quality (100)

  imagedestroy($image);
  imagedestroy($watermark);

?>
<?php
     //Set the Content Type
  header('Content-type: image/jpeg');

  // Create Image From Existing File
  $jpg_image = imagecreatefromjpeg('uploads/certificate.jpg');

  // Allocate A Color For The Text
  $black = imagecolorallocate($jpg_image, 0, 0, 0);

  // Set Path to Font File
  $font_path = 'uploads/font.ttf';

  // Set Text to Be Printed On Image
  $textUser = "Username: ".$_SESSION['user'];
  $textResult = "Карл, ты прошел этот тест!";

  // Print Text On Image
  imagettftext($jpg_image, 25, 0, 130, 150, $white, $font_path, $textUser);
  imagettftext($jpg_image, 25, 0, 130, 250, $white, $font_path, $textResult);

  // Send Image to Browser
  imagejpeg($jpg_image);

//   // Clear Memory
  imagedestroy($jpg_image);
?>
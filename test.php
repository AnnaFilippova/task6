<?php
  session_start();

  if (!$_SESSION['user']) {
    header("Location: http://".$_SERVER[HTTP_HOST].str_replace('test.php', 'index.php', $_SERVER[REQUEST_URI]));
  }

 $fileData = file_get_contents(__DIR__ . '/uploads/'.$_GET['testName']);
 $data = json_decode($fileData, true);
  // foreach ($data as $question => $answer) {
  //   if(isset ($_GET['question'])){
  //     echo 'Question' . (($_GET['question']));    
  //   }
  // }
  if (!$fileData) {
    http_response_code(404);
    include('404.php');
    die();
  }

  $correctAnswers = true;

  if ( $_SERVER['REQUEST_METHOD'] === 'POST') {
    // проверяем тест
    foreach($data as $index => $item) {
      if ($item['answer'] != $_POST[$index]) {
        $correctAnswers = false;
        break;
      }
    }

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
    if ($correctAnswers) {
      $textResult = "Карл, ты прошел этот тест!";
    } else {
      $textResult = "Карл, ты все сломал, Карл!";
    }

    // Print Text On Image
    imagettftext($jpg_image, 25, 0, 130, 150, $white, $font_path, $textUser);
    imagettftext($jpg_image, 25, 0, 130, 250, $white, $font_path, $textResult);

    // Send Image to Browser
    imagejpeg($jpg_image);

    // Clear Memory
    imagedestroy($jpg_image);
    die();
  }


 ?>
 <!doctype html>
 <html lang="en">
 <head>
   <meta charset="utf-8">
   <meta name="viewport"
   content="width-device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Тест <?= $_GET['testName'] ?></title>
 </head>
  <body>
    <h2>Тест <?= $_GET['testName'] ?>; User: <?= $_SESSION['user'] ?></h2>


      <form method="POST">
        <?php foreach ($data as $index => $item ) { ?>
            <div>
              <label><?= $item['question'] ?></label>
              <input name="<?= $index ?>" />
            </div>
        <?php } ?>
        <button type="submit">Отправить</button>
      </form>


  </body>
</html>

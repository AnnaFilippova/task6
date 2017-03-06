<?php
  session_start();

  if (!$_SESSION['is_logged_in']) {
    http_response_code(403);
    include('403.php');
    die();
  }

  ini_set("display_errors","On"); 
  error_reporting(E_ALL);
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file = $_FILES['file']['tmp_name'];
    $filename = $_FILES['file']['name'];

    if(!empty($file)) {
      ini_set('memory_limit', '32M');
      $maxsize = "100000000";
      $extentions = array( "txt","json");
      $size = filesize ($_FILES['file']['tmp_name']);
      $type = strtolower(substr($filename, 1+strrpos($filename,".")));
      $new_name = 'file-'.time().'.'.$type;
      if($size > $maxsize){
        echo "Файл больше 100 мб. Уменьшите размер вашего файла или загрузите другой. <br><a href='' onClick=window.close();>Закрыть окно</a>";
      } elseif(!in_array($type,$extentions)) {
        echo ' <b>Файл имеет недопустимое расширение</b>. <br>';
      } else {
        if (copy($file, "uploads/".$new_name)) {
          header("Location: http://".$_SERVER[HTTP_HOST].str_replace('admin.php', 'list.php', $_SERVER[REQUEST_URI]));
          die();
          // echo "Файл загружен!<br>Скопируйте адрес файла</br> <a href=\"uploads/$new_name\"><b>http://site.com/uploads/$new_name</b></a><br> и нажмите</br><a href='' onClick=history.back();>Вернуться назад</a>";
        }
        else {
          echo "Файл НЕ был загружен."; 
        }
      }
    }
  }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport"
  content="width-device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Загрузка файлов</title>
</head>
<body>
  <form method="post" enctype="multipart/form-data">
      <p>Загрузить файл:</p>
      <p><input name="file" size="18" type="file" value=""></p>
      <p><input name="submit" type="submit" value="Загрузить"></p>
  </form>
</body>
</html>

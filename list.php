<?php
//  $fileData = file_get_contents(__DIR__ . 'uplo/data.json');
//  $data = json_decode($fileData, true);
  session_start();

  $tests = [];

 if ($handle = opendir('./uploads')) {
    while (false !== ($file = readdir($handle)))
    {
        if ($file != "." && $file != ".." && strtolower(substr($file, strrpos($file, '.') + 1)) == 'json')
        {
            array_push($tests, $file);
            // $testList .= '<li><a href="'.$file.'">'.$file.'</a></li>';
        }
    }
    closedir($handle);
  }
 ?>
 <!doctype html>
 <html lang="en">
 <head>
   <meta charset="utf-8">
   <meta name="viewport"
   content="width-device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Тесты</title>
 </head>
 <body>
   <table border="1" rules="all" width="360px" height="80px">
        <tr>
         <td width="90px" height="20px"><h2>Вопрос</h2></td>
        </tr>
        <?php foreach ($tests as $item) { ?>
         <tr>
           <td width="90px" height="20px">
              <a href="test.php?testName=<?=$item ?>"><?= $item ?></a>
            </td>
         </tr>
         <?php } ?>
    </table>
    <a href="admin.php" >Добавить тест</a>
 </body>
 </html>

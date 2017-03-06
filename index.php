<?php
    session_start();
    $error = "";
    function authorize() {
        if ($_POST['loginAsGuest'] && !$_POST['login']) {
            return 'Поле логин является обязательным';
        }

        if ($_POST['loginAsGuest'] && $_POST['login']) {
            $_SESSION['user'] = $_POST['login'];
            $_SESSION['is_logged_in'] = false;
            header("Location: http://".$_SERVER[HTTP_HOST].str_replace('index.php', 'list.php', $_SERVER[REQUEST_URI]));

            return;
        }


        $authDB = file_get_contents(__DIR__ . '/login.json');
        $authDB = json_decode($authDB, true);


        if (!$authDB) {
            $error = 'Не удалось открыть файл login.json';
            return $error;
        }

        if (!$authDB[$_POST['login']]) {
            $error = 'Пользователь '.$_POST['login'].' не найден';
            return $error;
        }

        if ($authDB[$_POST['login']] != $_POST['password']) {
            $error = "Пароль не подходит";
            return $error;
        }

        $_SESSION['user'] = $_POST['login'];
        $_SESSION['is_logged_in'] = true;
        header("Location: http://".$_SERVER[HTTP_HOST].str_replace('index.php', 'list.php', $_SERVER[REQUEST_URI]));

    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $error = authorize();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Авторизуйтесь</h1>
    <form method="POST">
        <input type="text" name="login" placeholder="login">
        <input type="password" name="password" placeholder="password">
        <label for="loginAsGuest">Войти как гость</label>
        <input type="checkbox" name="loginAsGuest">
        <button type="submit">Войти</button>
        <?= $error ?>
    </form>
</body>
</html>
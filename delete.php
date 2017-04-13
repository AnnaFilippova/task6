<?php
    session_start();

    if (!isset($_SESSION['is_logged_in'])) {
        http_response_code(403);
        include('403.php');
        die();
    }

    if (!isset($_GET['id'])) {
        echo "ID теста обязателен";
    }

    unlink(__DIR__ . '/uploads/'.$_GET['id']);
    echo "тест успешно удален";
?>
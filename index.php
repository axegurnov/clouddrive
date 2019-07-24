<?php



    if($_SERVER['REQUEST_URI']=='/' && !(isset($_COOKIE['userLogin'])))  {
            header('location: /login');
    }
    elseif($_SERVER['REQUEST_URI']=='/' && isset($_COOKIE['userLogin'])){
                header('location: /cloud_drive');
    }
    else{
        $page = substr($_SERVER['REQUEST_URI'], 1);
    }


    $CONNECT= new mysqli('localhost','root','','filetr');
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    mysqli_set_charset($CONNECT, "utf8");
    session_start();

    //вход
    $cokieLogin= $_COOKIE['userLogin'];
    $cokiePass= $_COOKIE['userPassword'];
    if (isset($cokieLogin) and isset($cokiePass)) {
        $row = $CONNECT->query("SELECT * FROM `users` WHERE `login` = '$cokieLogin' AND `pass` = '$cokiePass'")->fetch_assoc();
        foreach ($row as $key => $value)
            $_SESSION[$key] = $value;
    }

    if(file_exists('all/'.$page.'.php')) include 'all/'.$page.'.php';
    elseif ((isset($_SESSION['id'])) and file_exists('auth/'.$page.'.php')) include 'auth/'.$page.'.php';
    elseif (!(isset($_SESSION['id'])) and file_exists('guest/'.$page.'.php')) include 'guest/'.$page.'.php';
    elseif ( preg_match('/^create_folder\/[-0-9\/A-z]{1,150}$/', $page) ) include 'auth/create_folder.php';
    elseif ( preg_match('/^cloud_drive\/[-0-9\/A-z]{1,150}$/', $page) ) include 'auth/cloud_drive.php';
    elseif ( preg_match('/^edit\/[-0-9\/A-z]{1,150}$/', $page) ) include 'auth/edit.php';

    else {
        echo('Ошибка доступа');
        var_dump($page);
    }

    function top($title)
    {
        include 'all/header.php';
    }
?>				
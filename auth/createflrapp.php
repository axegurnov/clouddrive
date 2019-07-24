<?php

    $userid = $_SESSION['id'];
    $idReFlr = $_POST['idReFlr'];
    $nameFlr = $_POST['folder'];
    if(!isset($idReFlr)) exit("Ошибка доступа");

    $quary =$CONNECT->query("INSERT INTO `folders` VALUES ('','$userid','$idReFlr','$nameFlr')");
    //var_dump($CONNECT->error_list);
    header('Location: /');
?>
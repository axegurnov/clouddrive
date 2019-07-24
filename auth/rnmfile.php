<?php
    $userid = $_SESSION['id'];
    $fileId = $_POST['fileId'];
    $fileName = strip_tags($_POST['fileName']);
    if(!isset($fileId)) exit("Ошибка доступа");
    $oldFileName = $CONNECT->query("SELECT * FROM `files` where `id`='$fileId'")->fetch_assoc();
    //var_dump($oldFileName);
    //переменовываем
    rename("files/".$_SESSION['sha256']."/".$oldFileName['name'], "files/".$_SESSION['sha256']."/".$fileName);
    $CONNECT->query("UPDATE `files` SET `name` = '$fileName' WHERE `files`.`id` = '$fileId'");
    header('Location: /');

?>
<?
$userid = $_SESSION['id'];
$fileId = strip_tags($_POST['fileId']);
if(!isset($fileId)) exit("Ошибка доступа");
$fileName = $CONNECT->query("SELECT * FROM `files` where `id`='$fileId'")->fetch_assoc();
//var_dump($oldFileName);
//переменовываем
unlink("files/".$_SESSION['sha256']."/".$fileName['name']);
$CONNECT->query("DELETE FROM `files` WHERE `files`.`id` = '$fileId'");
header('Location: /');

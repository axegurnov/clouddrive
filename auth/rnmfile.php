<?php
    $userid = $_SESSION['id'];
    $fileId = $_POST['fileId'];
    $filePostName = $_POST['fileName'];
    if(!isset($fileId)) exit("Ошибка доступа");
    $oldFileName = $CONNECT->query("SELECT * FROM `files` where `id`='$fileId'")->fetch_assoc();
    //var_dump($oldFileName);
    //переменовываем
    function translit($s) {
        $s = (string) $s;
        $s = strip_tags($s);
        $s = str_replace(array("\n", "\r"), " ", $s);
        $s = preg_replace("/\s+/", ' ', $s);
        $s = trim($s);
        $s = function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s);
        $s = strtr($s, array('а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'j','з'=>'z','и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'shch','ы'=>'y','э'=>'e','ю'=>'yu','я'=>'ya','ъ'=>'','ь'=>''));
        $s = preg_replace("/[^0-9a-z-_ ]/i", "", $s);
        $s = str_replace(" ", "-", $s);
        return $s;
    }
    $fileName = translit($filePostName);
    rename("files/".$_SESSION['sha256']."/".$oldFileName['name'], "files/".$_SESSION['sha256']."/".$fileName);
    $CONNECT->query("UPDATE `files` SET `name` = '$fileName' WHERE `files`.`id` = '$fileId'");
    header('Location: /');

?>
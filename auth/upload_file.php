<?php
$uploadfile = "files/" . $_SESSION['sha256'] . "/" . $_FILES['fileUp']['name'];
$userid = $_SESSION['id'];
$idReFlr = $_POST['idReFlr'];
$nameFile = $_FILES['fileUp']['name'];
$blacklist = '/.(com|bat|exe|cmd|vbs|msi|jar|php(\d?)|phtml|access|js)$/i';

if (isset($_FILES['fileUp'])) {
    if (preg_match($blacklist, $_FILES['fileUp']['name']))
    {
        exit ("Файл с данным расширением запрещен к загрузке");
    }
    move_uploaded_file($_FILES['fileUp']['tmp_name'], $uploadfile);
    //add to database
    $CONNECT->query("INSERT INTO `files` VALUES ('','$userid','$idReFlr','$nameFile')");
    header('Location: /');
} else {
    echo "Ошибка доступа";
}
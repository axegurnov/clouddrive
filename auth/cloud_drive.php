<?
    top('Мой диск');
    $session_id = $_SESSION['id'];
    $url_array = explode('/', $_SERVER['REQUEST_URI']);
    $folder_name = $url_array[2];
    if ($folder_name == NULL) $folder_name = 1;
    $query_idfolder = $CONNECT->query("SELECT * from `folders` WHERE `name`='$folder_name'")->fetch_assoc();
    if($query_idfolder==NULL){$query_idfolder=1;}else{$query_idfolder=(int)$query_idfolder['id'];}
    $query_folder = $CONNECT->query("SELECT * from `folders` WHERE `id_author`='$session_id' and `id_refolder`='$query_idfolder'");
    $query_files = $CONNECT->query("SELECT * from `files` WHERE `id_author`='$session_id' and `id_folder`='$query_idfolder'");
?>
<div style="margin-left: 50px;margin-top: 20px"><h4>Здравствуйте, <? echo $_SESSION['login']; ?></h4> <a href="/logout">Выйти</a></div>
<div align="center"><h1><a href="/">Мой диск</a></h1>
    <form enctype="multipart/form-data" action="../upload_file" method="post">
        <input type="hidden" name="idReFlr" value="<?echo $query_idfolder?>">
        <input class="upload_button" type="file" name="fileUp" required>
        <button type="submit">Загрузить</button>
    </form>
</div>
<div><h2 style="margin-left: 20px">Ваши папки</h2>
    <form action="../create_folder" method="post" id="folder"><input type="hidden" name="idReFlr" value="<?echo $query_idfolder?>">
        <button type="submit" class="btn btn-default" style="cursor: pointer;margin-left: 20px">Создать новую папку</button>
    </form>
</div>
<table style="margin-left: 50px">
    <ul type="disc">
        <thead>
        <div style="margin-left: 20px"><?php if(!$query_folder->num_rows)echo "Нет папок"?></div>
        <? while ($folders = $query_folder->fetch_array()): ?>
            <tr>
                <td>

                    <li><a href="/cloud_drive/<?php echo $folders['name'] ?>"><?php echo $folders['name'] ?></a></li>
                </td>
            </tr>
        <? endwhile; ?>
        </thead>
    </ul>
</table>
<h2 style="margin-left: 20px;margin-top: 20px">Ваши файлы в папке</h2>
<table style="margin-left: 50px;margin-bottom: 50px">
    <ul type="disc">
        <thead>
        <div style="margin-left: 20px"><?php if(!$query_files->num_rows)echo "Нет файлов"?></div>
        <? while ($files = $query_files->fetch_array()): ?>
        <tr>
            <td>
                <li><a href="/files/<?php echo $_SESSION['sha256'] ?>/<?php echo $files['name'] ?>"><?php echo $files['name'] ?></a>
                    <form action="../rename_file" method="post">
                        <input type="hidden" name="fileId" value="<? echo $files['id']?>">
                        <h7><button type="submit">Переименовать</button></h7>
                    </form>
                    <form action="../del_file" method="post">
                        <input type="hidden" name="fileId" value="<? echo $files['id']?>">
                        <button type="submit">Удалить</button>
                    </form>
                </li>
            </td>
        </tr>
        <? endwhile; ?>
        </thead>
    </ul>
</table>
</body>
</html>
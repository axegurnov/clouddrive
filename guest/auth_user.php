<?php
$login=$_POST['login'];
$pass=$_POST['password'];


if (!$CONNECT->query("SELECT * FROM users where `login`='$login' AND `pass`='$pass'")->num_rows)
{
    echo "neverniy login ili pass";
    exit;
}
    else {
        setcookie('userLogin',$_POST['login'],strtotime('+30 days'),"/");
        setcookie('userPassword',$_POST['password'],strtotime('+30 days'),"/");
        $row = $CONNECT->query("SELECT * FROM `users` WHERE `login`='$login'")->fetch_assoc();
        foreach ($row as $key => $value)
            $_SESSION[$key] = $value;
        header('Location: /');
    }

?>
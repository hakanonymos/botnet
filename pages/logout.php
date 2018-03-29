<?php
$u = explode(":", $_SESSION['DarkC0ders']);
$username = $u[0];

$i = $odb->prepare("INSERT INTO plogs VALUES(NULL, :u, :ip, 'Logged out', UNIX_TIMESTAMP())");
$i->execute(array(":u" => $username, ":ip" => $_SERVER['REMOTE_ADDR']));

unset($_SESSION['DarkC0ders']);
session_destroy();
header("Location: login/");
?>
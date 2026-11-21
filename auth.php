

<?php
session_start();
require_once __DIR__ . '/baza.php';

$z = $pdo->prepare(
    'SELECT login, haslo_hash FROM uzytkownicy WHERE login = :login'
);

$z->execute(['login' => trim($_POST['login'] ?? '')]);

$u = $z->fetch();

if ($u && password_verify($_POST['haslo'] ?? '', $u['haslo_hash'])) {
    session_regenerate_id(true);
    $_SESSION['uzytkownik'] = $u['login'];
    header('Location: admin.php');
    exit;
} else {
    header('Location: login.php?blad=1');
    exit;
}
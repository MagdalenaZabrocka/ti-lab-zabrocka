

<?php
session_start();

if (!isset($_SESSION['uzytkownik'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Panel admina – Szprycha</title>
</head>
<body>

<h1>Witaj, <?= htmlspecialchars($_SESSION['uzytkownik']) ?></h1>

<a href="wyloguj.php">Wyloguj się</a>

</body>
</html>
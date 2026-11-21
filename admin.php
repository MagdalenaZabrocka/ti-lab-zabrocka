<?php
session_start();

if (!isset($_SESSION['uzytkownik'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/baza.php';

// Obsługa dodawania usługi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['akcja'] ?? '') === 'dodaj') {

    $nazwa = trim($_POST['nazwa'] ?? '');
    $cena = $_POST['cena'] ?? '';

    if ($nazwa !== '' && strlen($nazwa) <= 100 && is_numeric($cena) && $cena >= 1) {

        $z = $pdo->prepare(
            'INSERT INTO uslugi (nazwa, cena) VALUES (:nazwa, :cena)'
        );

        $z->execute([
            'nazwa' => $nazwa,
            'cena' => $cena
        ]);

        header('Location: admin.php');
        exit;
    }
}

// Pobranie usług z bazy
$z = $pdo->query('SELECT * FROM uslugi ORDER BY id');
$uslugi = $z->fetchAll();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel administratora – Szprycha</title>
</head>
<body>

<h1>Witaj, <?= htmlspecialchars($_SESSION['uzytkownik']) ?></h1>

<h2>Wszystkie usługi</h2>

<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Nazwa</th>
        <th>Cena</th>
    </tr>

    <?php foreach ($uslugi as $usluga): ?>
        <tr>
            <td><?= htmlspecialchars((string)$usluga['id']) ?></td>
            <td><?= htmlspecialchars($usluga['nazwa']) ?></td>
            <td><?= htmlspecialchars((string)$usluga['cena']) ?> zł</td>
        </tr>
    <?php endforeach; ?>
</table>

<h2>Dodaj usługę</h2>

<form method="post">
    <input type="hidden" name="akcja" value="dodaj">
    <label for="nazwa">Nazwa</label>
    <input id="nazwa" name="nazwa" required maxlength="100">
    <label for="cena">Cena (zł)</label>
    <input id="cena" name="cena" type="number" min="1" required>
    <button>Dodaj</button>
</form>

<p><a href="wyloguj.php">Wyloguj się</a></p>

</body>
</html>
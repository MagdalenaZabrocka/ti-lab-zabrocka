<?php
require_once __DIR__ . '/baza.php';
$firma = 'Szprycha';
$rok = date('Y');

$z = $pdo->query('SELECT * FROM uslugi ORDER BY id');
$uslugi = $z->fetchAll();
?>


<!DOCTYPE html>
<html lang="pl">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Szprycha – serwis rowerowy</title>
<link rel="stylesheet" href="style.css">
    <script src="app.js" defer> 
        
    </script>
</head>
<body>
<header class="site-header">
    <p class="logo">Szprycha</p>

    <button class="menu-toggle" aria-expanded="false">
        ☰ Menu</button>

    <nav class="menu">

        <a href="#uslugi">Usługi</a>
        <a href="#cennik">Cennik</a>
        <a href="#kontakt">Kontakt</a>
        <a href="login.php">Panel administratora</a>
    </nav>
</header>
<main>
<div class="cards">

    <article class="card">
        <h3>Przegląd</h3>
        <p>Hamulce i przerzutki.</p>
        <p class="card__price">od 120 zł</p>
    </article>

    <article class="card card--highlight">
        <span>Najczęściej wybierane</span>
        <h3>Serwis roweru</h3>
        <p>Kompleksowa kontrola i konserwacja.</p>
        <p class="card__price">od 200 zł</p>
    </article>

    <article class="card">
        <h3>Naprawa</h3>
        <p>Wymiana części i usuwanie usterek.</p>
        <p class="card__price">od 150 zł</p>
    </article>

</div>

<section class="cennik">
    <h2>Cennik usług</h2>

    <table class="price-table">
        <thead>
            <tr>
                <th>Usługa</th>
                <th class="num">Cena</th>
            </tr>
        </thead>

        <tbody>
              <?php foreach ($uslugi as $usluga): ?>
        <tr>
            <td><?= htmlspecialchars($usluga['nazwa']) ?></td>
            <td class="num">
                <?= htmlspecialchars((string)$usluga['cena']) ?> zł
            </td>
        </tr>
    <?php endforeach; ?>
        </tbody>
    </table>
</section>

</main>
<footer id="kontakt">

<h2>Kontakt</h2>

    <p>Adres: ul. Rowerowa 10, Bydgoszcz</p>

    <p>
        Telefon:
        <a href="tel:+48500100200">500 100 200</a>
    </p>

    <p>
        E-mail:
        <a href="mailto:kontakt@szprycha.pl">
            kontakt@szprycha.pl
        </a>
    </p>
<p>&copy; <?= $rok ?> <?= $firma ?></p>

</footer>
</body>
</html>
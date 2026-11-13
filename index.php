<?php
$firma = 'Szprycha';
$rok = date('Y');
?>


<!DOCTYPE html>
<html lang="pl">
<head>
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
            <tr>
                <td>Przegląd</td>
                <td class="num">120 zł</td>
            </tr>
            <tr>
                <td>Regulacja hamulców</td>
                <td class="num">80 zł</td>
            </tr>
            <tr>
                <td>Wymiana dętki</td>
                <td class="num">50 zł</td>
            </tr>
            <tr>
                <td>Pełny serwis roweru</td>
                <td class="num">200 zł</td>
            </tr>
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
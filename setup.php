
<?php

require_once 'baza.php';

// Tabela użytkowników
$pdo->exec('CREATE TABLE IF NOT EXISTS uzytkownicy (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    login TEXT NOT NULL UNIQUE,
    haslo_hash TEXT NOT NULL
)');

// Tabela usług
$pdo->exec('CREATE TABLE IF NOT EXISTS uslugi (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nazwa TEXT NOT NULL,
    cena REAL NOT NULL
)');

// Dodanie 4 usług, jeśli tabela jest pusta
$liczbaUslug = $pdo->query('SELECT COUNT(*) FROM uslugi')->fetchColumn();

if ($liczbaUslug == 0) {

    $z = $pdo->prepare(
        'INSERT INTO uslugi (nazwa, cena) VALUES (:nazwa, :cena)'
    );

    $uslugi = [
        ['Przegląd', 120],
        ['Regulacja hamulców', 80],
        ['Wymiana dętki', 50],
        ['Pełny serwis roweru', 200]
    ];

    foreach ($uslugi as $usluga) {
        $z->execute([
            'nazwa' => $usluga[0],
            'cena' => $usluga[1]
        ]);
    }
}

// Dodanie administratora, jeśli tabela użytkowników jest pusta
$liczbaUzytkownikow = $pdo->query(
    'SELECT COUNT(*) FROM uzytkownicy'
)->fetchColumn();

if ($liczbaUzytkownikow == 0) {

    $z = $pdo->prepare(
        'INSERT INTO uzytkownicy (login, haslo_hash)
         VALUES (:login, :hash)'
    );

    $z->execute([
        'login' => 'admin',
        'hash' => password_hash('TwojeHaslo', PASSWORD_DEFAULT)
    ]);
}

echo 'Baza danych została przygotowana!';

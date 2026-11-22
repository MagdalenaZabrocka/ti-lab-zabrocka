
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
    cena REAL NOT NULL,
    popularnosc INTEGER NOT NULL DEFAULT 0
)');
$kolumny = $pdo->query("PRAGMA table_info(uslugi)")->fetchAll();

$maPopularnosc = false;

foreach ($kolumny as $kolumna) {
    if ($kolumna['name'] === 'popularnosc') {
        $maPopularnosc = true;
    }
}

if (!$maPopularnosc) {
    $pdo->exec(
        'ALTER TABLE uslugi ADD COLUMN popularnosc INTEGER NOT NULL DEFAULT 0'
    );
}
// Dodanie 4 usług, jeśli tabela jest pusta
$liczbaUslug = $pdo->query('SELECT COUNT(*) FROM uslugi')->fetchColumn();

if ($liczbaUslug == 0) {

    $z = $pdo->prepare(
        'INSERT INTO uslugi (nazwa, cena, popularnosc)
        VALUES (:nazwa, :cena, :popularnosc)'
);

    $uslugi = [
        ['Przegląd', 120, 100],
        ['Regulacja hamulców', 80, 350],
        ['Wymiana dętki', 50,200],
        ['Pełny serwis roweru', 200, 250]
    ];

    foreach ($uslugi as $usluga) {
        $z->execute([
            'nazwa' => $usluga[0],
            'cena' => $usluga[1],
            'popularnosc' => $usluga[2]
        ]);
    }
}

$pdo->exec("
    UPDATE uslugi
    SET popularnosc = CASE nazwa
        WHEN 'Przegląd' THEN 100
        WHEN 'Regulacja hamulców' THEN 350
        WHEN 'Wymiana dętki' THEN 200
        WHEN 'Pełny serwis roweru' THEN 250
        ELSE popularnosc
    END
    WHERE popularnosc = 0
");



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

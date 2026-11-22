<?php

require 'baza.php';

header('Content-Type: application/json; charset=utf-8');

function odpowiedz(int $kod, array $dane): void {
    http_response_code($kod);
    echo json_encode($dane, JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $uslugi = $pdo->query('SELECT nazwa, cena FROM uslugi')->fetchAll();
    odpowiedz(200, $uslugi);
}

odpowiedz(405, ['blad' => 'Metoda niedozwolona.']);
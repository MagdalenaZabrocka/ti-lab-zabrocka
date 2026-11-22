<?php

require 'baza.php';

header('Content-Type: application/json; charset=utf-8');

function odpowiedz(int $kod, array $dane): void {
    http_response_code($kod);
    echo json_encode($dane, JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $max = $_GET['max'] ?? '';

    if ($max !== '') {

        if (!is_numeric($max) || $max < 0) {
            odpowiedz(400, ['blad' => 'Nieprawidłowa wartość max']);
        }

        $z = $pdo->prepare(
            'SELECT nazwa, cena, popularnosc
             FROM uslugi
             WHERE popularnosc <= :max
             ORDER BY id'
        );

        $z->execute([
            'max' => $max
        ]);

        $uslugi = $z->fetchAll();

    } else {

        $uslugi = $pdo->query(
            'SELECT nazwa, cena, popularnosc
             FROM uslugi ORDER BY id'
        )->fetchAll();

    }

    odpowiedz(200, $uslugi);
}

odpowiedz(405, ['blad' => 'Metoda niedozwolona.']);
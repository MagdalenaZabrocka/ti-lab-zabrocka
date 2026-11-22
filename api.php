
<?php

require_once 'baza.php';

header('Content-Type: application/json; charset=utf-8');

function odpowiedz($kod, $dane) {
    http_response_code($kod);
    echo json_encode($dane, JSON_UNESCAPED_UNICODE);
    exit;
}

// DODAWANIE USŁUGI – POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    session_start();

    // 401 – użytkownik niezalogowany
    if (empty($_SESSION['uzytkownik'])) {
        odpowiedz(401, ['blad' => 'Brak autoryzacji']);
    }

    // 415 – nieprawidłowy typ danych
    $typ = $_SERVER['CONTENT_TYPE'] ?? '';

    if (!str_starts_with($typ, 'application/json')) {
        odpowiedz(415, ['blad' => 'Wymagany format JSON']);
    }

    // Odczyt JSON – dane nie trafiają do $_POST
    $dane = json_decode(
        file_get_contents('php://input'),
        true
    );

    // 400 – nieprawidłowe dane
    if (
        !is_array($dane) ||
        !isset($dane['nazwa'], $dane['cena']) ||
        trim((string)$dane['nazwa']) === '' ||
        !is_numeric($dane['cena']) ||
        (float)$dane['cena'] <= 0
    ) {
        odpowiedz(400, ['blad' => 'Nieprawidłowa nazwa lub cena']);
    }

    $nazwa = trim($dane['nazwa']);
    $cena = (float)$dane['cena'];

    // Zapis usługi do bazy
    $z = $pdo->prepare(
        'INSERT INTO uslugi (nazwa, cena, popularnosc)
         VALUES (:nazwa, :cena, 0)'
    );

    $z->execute([
        'nazwa' => $nazwa,
        'cena' => $cena
    ]);

    // 201 – utworzono usługę
    odpowiedz(201, [
        'id' => (int)$pdo->lastInsertId(),
        'nazwa' => $nazwa,
        'cena' => $cena,
        'popularnosc' => 0
    ]);
}

// POBIERANIE USŁUG – GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $max = $_GET['max'] ?? '';

    if ($max !== '') {
        if (!is_numeric($max) || (float)$max < 0) {
            odpowiedz(400, ['blad' => 'Nieprawidłowy parametr max']);
        }

        $z = $pdo->prepare(
            'SELECT nazwa, cena, popularnosc FROM uslugi
             WHERE popularnosc <= :max ORDER BY id'
        );

        $z->execute(['max' => $max]);
        $uslugi = $z->fetchAll();

    } else {
        $uslugi = $pdo->query(
            'SELECT nazwa, cena, popularnosc FROM uslugi ORDER BY id'
        )->fetchAll();
    }

    odpowiedz(200, $uslugi);
}

// Inne metody są niedozwolone
odpowiedz(405, ['blad' => 'Niedozwolona metoda']);

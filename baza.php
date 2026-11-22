
<?php

try {
    $pdo = new PDO('sqlite:' . __DIR__ . '/szprycha.sqlite');

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die('Błąd połączenia z bazą danych.');
}





<?php
session_start();

if (!isset($_SESSION['uzytkownik'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/baza.php';

// Obsługa formularzy
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Dodawanie usługi
    if (($_POST['akcja'] ?? '') === 'dodaj') {

        $nazwa = trim($_POST['nazwa'] ?? '');
        $cena = $_POST['cena'] ?? '';

        if ($nazwa !== '' && strlen($nazwa) <= 100 &&
            is_numeric($cena) && $cena >= 1) {

            $z = $pdo->prepare(
                'INSERT INTO uslugi (nazwa, cena) VALUES (:nazwa, :cena)'
            );

            $z->execute([
                'nazwa' => $nazwa,
                'cena' => $cena
            ]);

            header('Location: admin.php?dodano=1');
            exit;
        }

        header('Location: admin.php?blad=1');
        exit;
    }

    // Usuwanie usługi
    if (($_POST['akcja'] ?? '') === 'usun') {

        $id = (int) ($_POST['id'] ?? 0);

        if ($id > 0) {
            $z = $pdo->prepare('DELETE FROM uslugi WHERE id = :id');
            $z->execute(['id' => $id]);
        }

        header('Location: admin.php?usunieto=1');
        exit;
    }
}

// Pobranie wszystkich usług
$z = $pdo->query('SELECT * FROM uslugi ORDER BY id');
$uslugi = $z->fetchAll();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel administratora – Szprycha</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Szprycha – panel administratora</a>
        <a href="wyloguj.php" class="btn btn-outline-light">Wyloguj się</a>
    </div>
</nav>

<div class="container mt-4">

    <div class="row">
        <div class="col-12">

            <h1 class="mb-4">
                Witaj, <?= htmlspecialchars($_SESSION['uzytkownik']) ?>!
            </h1>

            <?php if (isset($_GET['dodano'])): ?>
                <div class="alert alert-success">
                    Usługa została dodana!
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['usunieto'])): ?>
                <div class="alert alert-success">
                    Usługa została usunięta!
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['blad'])): ?>
                <div class="alert alert-danger">
                    Nieprawidłowe dane. Sprawdź nazwę i cenę.
                </div>
            <?php endif; ?>

            <h2 class="mb-3">Lista wszystkich usług</h2>

            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nazwa usługi</th>
                            <th>Cena</th>
                            <th>Akcja</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($uslugi as $usluga): ?>
                            <tr>
                                <td><?= (int) $usluga['id'] ?></td>
                                <td><?= htmlspecialchars($usluga['nazwa']) ?></td>
                                <td><?= htmlspecialchars((string) $usluga['cena']) ?> zł</td>
                                <td>
                                    <form method="post" class="d-inline">
                                        <input type="hidden" name="akcja" value="usun">
                                        <input type="hidden" name="id" value="<?= (int) $usluga['id'] ?>">
                                        <button class="btn btn-sm btn-outline-danger">Usuń</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <h2 class="mt-4 mb-3">Dodaj nową usługę</h2>

            <form method="post" class="row g-3">

                <input type="hidden" name="akcja" value="dodaj">

                <div class="col-md-6">
                    <label for="nazwa" class="form-label">Nazwa usługi</label>
                    <input
                        id="nazwa"
                        name="nazwa"
                        class="form-control"
                        required
                        maxlength="100"
                    >
                </div>

                <div class="col-md-4">
                    <label for="cena" class="form-label">Cena (zł)</label>
                    <input
                        id="cena"
                        name="cena"
                        type="number"
                        min="1"
                        step="0.01"
                        class="form-control"
                        required
                    >
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        Dodaj
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

</body>
</html>

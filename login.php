
<?php
session_start();

if (isset($_SESSION['uzytkownik'])) {
    header('Location: admin.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Logowanie – Szprycha</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Szprycha</a>
    </div>
</nav>

<div class="container mt-5">

    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">

            <div class="card shadow-sm">
                <div class="card-body p-4">

                    <h1 class="h3 text-center mb-4">
                        Panel administratora
                    </h1>

                    <?php if (isset($_GET['blad'])): ?>
                        <div class="alert alert-danger">
                            Nieprawidłowy login lub hasło!
                        </div>
                    <?php endif; ?>

                    <form action="auth.php" method="POST">

                        <div class="mb-3">
                            <label for="login" class="form-label">Login</label>
                            <input
                                type="text"
                                id="login"
                                name="login"
                                class="form-control"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="haslo" class="form-label">Hasło</label>
                            <input
                                type="password"
                                id="haslo"
                                name="haslo"
                                class="form-control"
                                required
                            >
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Zaloguj się
                        </button>

                    </form>

                    <div class="text-center mt-3">
                        <a href="index.php">Wróć na stronę główną</a>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>

</body>
</html>

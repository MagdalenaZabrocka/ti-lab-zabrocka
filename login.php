
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Logowanie – Szprycha</title>
</head>
<body>

<h1>Logowanie administratora</h1>

<form action="auth.php" method="POST">
    <label>Login:
        <input type="text" name="login" required>
    </label>

    <br><br>

    <label>Hasło:
        <input type="password" name="haslo" required>
    </label>

    <br><br>

    <button type="submit">Zaloguj się</button>
</form>

<?php if (isset($_GET['blad'])): ?>
    <p>Nieprawidłowy login lub hasło.</p>
<?php endif; ?>

</body>
</html>
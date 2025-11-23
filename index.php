<?php
session_start();
include 'validate.php';

// Preuzmi greške i prethodne unose ako postoje
$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];

// Očisti session greške nakon prikaza
unset($_SESSION['errors'], $_SESSION['old']);

// Ako je forma poslana
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    process_validation($_POST); // ovo više NE vraća ništa, radi redirect sam
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="style.css">

</head>
<body>


    <div class="container">
        <h1>Login</h1>
        <form action="" method="post">

            <label>Username</label><br>
            <input type="text" name="username" value="<?= htmlspecialchars($old['username'] ?? '') ?>">

            <label for="email">Email</label>
            <input type="text" name="email" value="<?= htmlspecialchars($old['email'] ?? '') ?>">

            <label for="password">Password</label>
            <input type="password" name="password">

            <input class="btn" type="submit" value="Login">

        </form>

        <?php 
        // Prikazivanje grešaka
        if (!empty($errors)) {
            echo "<ul class='errors'>";
            foreach ($errors as $field => $error) {
                echo "<li>$error</li>";
            }
            echo "</ul>";
        }
        ?>
    </div>
    
    
</body>
</html>
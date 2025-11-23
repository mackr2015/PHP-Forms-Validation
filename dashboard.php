<?php
session_start();

if (!isset($_SESSION['username'])) {
    // Ako user pokusa ući direktno na dashboard bez forme
    header('Location: index.php');
    exit;
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>



    <h1>Dobro došli na vaš dashboard, <?php echo htmlspecialchars($username); ?>!</h1>

    <div>
        <p>Nazad na Login</p>
        <a href="index.php">Login</a>
    </div>

</body>
</html>
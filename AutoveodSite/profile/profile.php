<?php
require ("../configuration/conf.php");
session_start();
global $yhendus;
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['setValmis'])) {
    // Получаем ID записи, которую нужно обновить
    $id = $_GET['setValmis'];

    // Подготовка запроса для обновления значения Valmis
    $paring = $yhendus->prepare("UPDATE autoveod SET Valmis = 1 WHERE Id = ?");
    $paring->bind_param("i", $id); // Привязываем ID как целое число
    $paring->execute();

    // Перенаправляем обратно на страницу, чтобы обновить данные
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Данные из сессии
$username = $_SESSION['username'];
$role = $_SESSION['role'];

$email = isset($_SESSION['email']) ? $_SESSION['email'] : 'Email not set';

$paring = $yhendus -> prepare("Select Id, Algus, Ots, Aeg, Autonr, Juht, user, Valmis from autoveod");
$paring -> bind_result($id, $algus, $ots, $aeg, $autonr, $juht, $user, $valmis);
$paring -> execute();
?>

<!doctype html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="profileStyle.css">
    <script src="https://kit.fontawesome.com/34392d1db2.js" crossorigin="anonymous"></script>
</head>
<body>

<div class="profile-card">
    <div class="profile-header">
        <div class="profile-pic">
            <!-- Поставьте здесь картинку профиля, если она есть -->
            <img src="imagee.png" alt="Profile Picture" width="100px">
        </div>
        <div class="profile-info">
            <h2><?php echo htmlspecialchars($username); ?></h2>
            <p>Email: <?php echo htmlspecialchars($email); ?></p>
            <br>
            <a href="javascript:history.back()" class="back-btn">Go back</a><br>
            <a href="../autorization/logout.php" class="logout-btn">Logout</a>
        </div>
    </div>
</div>


<?php if ($_SESSION['role'] == 'user') : ?>
<table>
    <tr>
        <th>Juht</th>
        <th>Algus</th>
        <th>Ots</th>
        <th>Aeg</th>
        <th>Auto number</th>
        <th>Valmis</th>

    </tr>

    <?php
    $paring -> free_result();
    $username = $_SESSION['username'];
    $paring = $yhendus -> prepare("Select Id, Juht, Algus, Ots, Aeg, Autonr, Valmis from autoveod where user = '$username'");
    $paring -> bind_result($id, $juht,$algus, $ots, $aeg, $autonr, $valmis);

    $paring -> execute();
    ?>
    <?php while ($paring -> fetch()) : ?>
        <tr>
            <td><?php echo htmlspecialchars($juht); ?></td>
            <td><?php echo htmlspecialchars($algus); ?></td>
            <td><?php echo htmlspecialchars($ots); ?></td>
            <td><?php echo htmlspecialchars($aeg); ?></td>
            <td><?php echo htmlspecialchars($autonr); ?> </td>
            <td><?php echo htmlspecialchars($valmis); ?></td>


        </tr>
    <?php endwhile; ?>
</table>
<?php endif; ?>


<?php if($_SESSION['role'] == 'admin') : ?>
<table>
    <tr>
        <th>Juht</th>
        <th>Algus</th>
        <th>Ots</th>
        <th>Aeg</th>
        <th>Auto number</th>
        <th>Valmis</th>
        <th>Menu</th>
    </tr>

    <?php
    $paring -> free_result();
    $paring = $yhendus -> prepare("Select Id, Juht, Algus, Ots, Aeg, Autonr, Valmis from autoveod");
    $paring -> bind_result($id, $juht,$algus, $ots, $aeg, $autonr, $valmis);

    $paring -> execute();
    ?>
    <?php while ($paring -> fetch()) : ?>
        <tr>
            <td><?php echo htmlspecialchars($juht); ?></td>
            <td><?php echo htmlspecialchars($algus); ?></td>
            <td><?php echo htmlspecialchars($ots); ?></td>
            <td><?php echo htmlspecialchars($aeg); ?></td>
            <td><?php echo htmlspecialchars($autonr); ?> </td>
            <td><?php echo htmlspecialchars($valmis); ?></td>
            <td><a href="?setValmis=<?php echo $id; ?>"><i class="fa-solid fa-check"></i> Valmis</a></td>
        </tr>
    <?php endwhile; ?>
</table>
<?php endif ; ?>


</body>
</html>

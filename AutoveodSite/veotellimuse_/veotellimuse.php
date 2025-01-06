<?php if (isset($_GET['code'])) {die(highlight_file(__FILE__, 1));} ?>
<?php
require_once ("../configuration/conf.php");
global $yhendus;
session_start();
$added = false;
if (!isset($_SESSION["username"])){
    $not_logged_in = true;
} else {
    $not_logged_in = false;
    $currentUserRole = null;

    $paring1 = $yhendus->prepare("SELECT Role FROM users WHERE Username = ?");
    $paring1->bind_param("s", $_SESSION["username"]);
    $paring1->execute();
    $paring1->bind_result($currentUserRole);
    $paring1->fetch();
    $paring1->close();
}



if (!empty($_REQUEST["juht"]) && !empty($_REQUEST["ots"]) && !empty($_REQUEST["autonr"])) {
    $juht = $_REQUEST["juht"];
    $algus = $_REQUEST["algus"];
    $ots = $_REQUEST["ots"];
    $aeg = $_REQUEST["aeg"];
    $autonr = $_REQUEST["autonr"];
    $user = $_SESSION["username"];

    $paring = $yhendus->prepare("INSERT INTO autoveod (Juht, Algus, Ots, Aeg, Autonr, user) VALUES (?, ?, ?, ?, ?, ?)");
    $paring->bind_param("ssssss", $juht, $algus, $ots, $aeg, $autonr, $user);
    $paring->execute();

    $added = true;
    header("Location: $_SERVER[PHP_SELF]");
    exit();
}



$paring = $yhendus -> prepare("Select Id, Algus, Ots, Aeg, Autonr, Juht from autoveod");
$paring -> bind_result($id, $algus, $ots, $aeg, $autonr, $juht);
$paring -> execute();
?>
<!doctype html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Veotellimuse sisestamiseks</title>
    <link rel="stylesheet" href="../Styles/veotellimuseStyle.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        .notification {
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
            font-size: 18px;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Autoveod veotellimuse sisestamiseks</h1>
</div>
<?php include('../components/nav.php'); ?>

<?php if($not_logged_in) : ?>
    <h2 style="margin: 190px 0 0 0">Sa ei ole sisse logitud</h2>
<?php else : ?>



<form action="">
    <label for="juht">Sisesta oma nimi ja perekonnanimi *</label>
    <input type="text" name="juht" id="juht" required>
    <label for="algus">Sisestage linn, kust peate auto transportima *</label>
    <select name="algus" id="algus" required>
        <option value="">Valige linn</option>
        <option value="Tallinn">Tallinn</option>
        <option value="Pärnu">Pärnu</option>
        <option value="Tartu">Tartu</option>
        <option value="Narva">Narva</option>
        <option value="Jõhvi">Jõhvi</option>
    </select>
    <label for="ots">Sisestage linn, millal peate oma autot transportima *</label>
    <select name="ots" id="ots" required>
        <option value="">Valige linn</option>
        <option value="Tallinn">Tallinn</option>
        <option value="Pärnu">Pärnu</option>
        <option value="Tartu">Tartu</option>
        <option value="Narva">Narva</option>
        <option value="Jõhvi">Jõhvi</option>
    </select>
    <label for="aeg">Sisesta tarneaeg </label>
    <input type="datetime-local" name="aeg" id="aeg">
    <label for="autonr">Sisesta auto number *</label>
    <input type="text" name="autonr" id="autonr" required>

    <input type="submit" value="Lisa">
</form>



<?php endif ; ?>
</body>
</html>

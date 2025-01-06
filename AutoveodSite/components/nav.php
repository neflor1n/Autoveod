<?php
require_once ('../configuration/conf.php');
?>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../Styles/nav.css">
<meta charset="UTF-8">

<div class="nav">
    <ul>
        <li><a href="../veotellimuse_/veotellimuse.php">Kodu</a></li>
        <?php if(isset($_SESSION['username'])) : ?>
            <li><a href="../profile/profile.php">Profile</a></li>
            <li><a href="../../Andmebaas/konkurss/logout.php">Logi välja</a></li>
        <?php else: ?>
            <li><a href="../autorization/login.php">Logi sisse</a></li>
            <li><a href="../autorization/reg.php">Registreerimine</a></li>
        <?php endif; ?>
    </ul>
</div>
<?php
$kasutaja = "bogdan";
$parool = "bserg?5xg3D11";
$andmebaas = "bogdan";
$servernimi = "localhost";

$yhendus = new mysqli(hostname: $servernimi, username: $kasutaja, password: $parool, database: $andmebaas);

$yhendus->set_charset("utf8");



<?php
const DB_HOST = "localhost";
const DB_USER = "root";
const DB_PASS = "";
const DB_BASE = "aboutdotme";
const DB_CHARSET = "utf8mb4";

$db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_BASE);

if (!$db) {
    header('Location: ../index.php?s=maintenance');
    exit;
}

mysqli_set_charset($db, DB_CHARSET);
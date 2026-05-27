<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'street_legends_v2');
define('DB_PORT', '3306');
define('DB_USER', 'root');
define('DB_PASS', '');

function base_url($path = '') {
    $scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
    $base = rtrim(str_replace(basename($scriptName), '', $scriptName), '/');
    return $base . '/' . ltrim($path, '/');
}

try {
    $pdoServer = new PDO(
        "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    );

    $pdoServer->exec('CREATE DATABASE IF NOT EXISTS `' . DB_NAME . '` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');

    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8mb4',
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    die('Erro ao conectar ao banco de dados: ' . $e->getMessage());
}
 catch (PDOException $e) {
    die('Erro ao conectar ao banco de dados. Verifique se o MySQL está ligado no XAMPP. Detalhe: ' . $e->getMessage());
}

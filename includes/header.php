<?php
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/functions.php';
$pageTitle = $pageTitle ?? 'Street Legends';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= h($pageTitle) ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>?v=<?= time(); ?>">
    <link rel="icon" type="image/png" href="<?= base_url('assets/img/favicon.png') ?>?v=<?= time(); ?>">
    <script src="<?= base_url('assets/js/script.js') ?>?v=2" defer></script>
</head>
<body>
<header class="site-header">
    <a class="brand" href="<?= base_url('index.php') ?>">
    <span class="brand-mark">
        <img src="<?= base_url('assets/img/favicon.png') ?>" alt="Street Legends">
    </span>
    <span>Street Legends</span>
</a>
    <button class="menu-btn" aria-label="Abrir menu">☰</button>
    <nav class="nav">
        <a href="<?= base_url('index.php') ?>">Início</a>
        <a href="<?= base_url('produtos.php') ?>">Produtos</a>
        <a href="<?= base_url('carrinho.php') ?>">Carrinho <span class="badge"><?= cartCount() ?></span></a>
        <a href="<?= base_url('logout.php') ?>">Sair</a>
        <a href="<?= base_url('login.php') ?>">Login</a>
        <a class="nav-pill" href="<?= base_url('cadastro.php') ?>">Criar conta</a>
        <?php if (isLoggedIn()): ?>
            <span class="hello">Olá, <?= h($_SESSION['user']['name']) ?></span>
            <a href="logout.php">Sair</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a class="nav-pill" href="cadastro.php">Criar conta</a>
        <?php endif; ?>
    </nav>
    <?php if (isset($_SESSION['user']['id'])): ?>
    <?php
        $adminCheck = $pdo->prepare("SELECT is_admin FROM users WHERE id = ?");
        $adminCheck->execute([$_SESSION['user']['id']]);
        $adminUser = $adminCheck->fetch(PDO::FETCH_ASSOC);
    ?>

    <?php if ($adminUser && (int)$adminUser['is_admin'] === 1): ?>
        <a href="<?= base_url('admin/produtos.php') ?>">Admin</a>
    <?php endif; ?>
<?php endif; ?>

</header>
<main>

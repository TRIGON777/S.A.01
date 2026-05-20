<?php
$pageTitle = 'Login - Street Legends';
include 'includes/header.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = ['id' => $user['id'], 'name' => $user['name'], 'email' => $user['email']];
        header('Location: produtos.php'); exit;
    } else {
        $error = 'E-mail ou senha inválidos.';
    }
}
?>
<section class="auth-page reveal">
    <form class="auth-card" method="POST">
        <p class="eyebrow">Acesse sua conta</p>
        <h1>Login</h1>
        <?php if (isset($_GET['aviso'])): ?><div class="notice">Faça login para finalizar a compra.</div><?php endif; ?>
        <?php if ($error): ?><div class="error"><?= h($error) ?></div><?php endif; ?>
        <label>E-mail<input type="email" name="email" required></label>
        <label>Senha<input type="password" name="password" required></label>
        <button class="btn primary full" type="submit">Entrar</button>
        <p>Não tem conta? <a href="cadastro.php">Criar conta</a></p>
    </form>
</section>
<?php include 'includes/footer.php'; ?>

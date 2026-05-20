<?php
$pageTitle = 'Cadastro - Street Legends';
include 'includes/header.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if (strlen($password) < 4) {
        $error = 'A senha precisa ter pelo menos 4 caracteres.';
    } else {
        try {
            $stmt = $pdo->prepare('INSERT INTO users (name, email, password) VALUES (?, ?, ?)');
            $stmt->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT)]);
            header('Location: login.php?criado=1'); exit;
        } catch (PDOException $e) {
            $error = 'Este e-mail já está cadastrado.';
        }
    }
}
?>
<section class="auth-page reveal">
    <form class="auth-card" method="POST">
        <p class="eyebrow">Entre para finalizar compras</p>
        <h1>Criar conta</h1>
        <?php if ($error): ?><div class="error"><?= h($error) ?></div><?php endif; ?>
        <label>Nome<input type="text" name="name" required></label>
        <label>E-mail<input type="email" name="email" required></label>
        <label>Senha<input type="password" name="password" required></label>
        <button class="btn primary full" type="submit">Cadastrar</button>
        <p>Já tem conta? <a href="login.php">Entrar</a></p>
    </form>
</section>
<?php include 'includes/footer.php'; ?>

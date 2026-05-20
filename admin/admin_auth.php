<?php
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/header.php';

if (!isset($_SESSION['user']['id'])) {
    header('Location: ../login.php');
    exit;
}

$adminCheck = $pdo->prepare("SELECT is_admin FROM users WHERE id = ?");
$adminCheck->execute([$_SESSION['user']['id']]);
$adminUser = $adminCheck->fetch(PDO::FETCH_ASSOC);

if (!$adminUser || (int)$adminUser['is_admin'] !== 1) {
    header('Location: ../index.php');
    exit;
}

$pageTitle = 'Admin - Produtos';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $preco = $_POST['preco'] ?? 0;
    $categoria = $_POST['categoria'] ?? '';
    $imagem = $_POST['imagem'] ?? '';

    if (isset($_POST['criar'])) {
        $stmt = $pdo->prepare("INSERT INTO products (name, description, price, category, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nome, $descricao, $preco, $categoria, $imagem]);
    }

    if (isset($_POST['editar'])) {
        $id = $_POST['id'];
        $stmt = $pdo->prepare("UPDATE products SET name = ?, description = ?, price = ?, category = ?, image = ? WHERE id = ?");
        $stmt->execute([$nome, $descricao, $preco, $categoria, $imagem, $id]);
    }

    header('Location: produtos.php');
    exit;
}

if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: produtos.php');
    exit;
}

$produtos = $pdo->query("SELECT * FROM products ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);

require_once __DIR__ . '/../includes/header.php';
?>

<section class="admin-page">
    <h1>Painel Admin - Produtos</h1>

    <h2>Adicionar produto</h2>

    <form method="post" class="admin-form">
        <input type="text" name="nome" placeholder="Nome do produto" required>
        <textarea name="descricao" placeholder="Descrição" required></textarea>
        <input type="number" name="preco" placeholder="Preço" step="0.01" required>
        <input type="text" name="categoria" placeholder="Categoria" required>
        <input type="text" name="imagem" placeholder="Imagem. Ex: camiseta1.png" required>
        <button type="submit" name="criar">Adicionar</button>
    </form>

    <h2>Produtos cadastrados</h2>

    <?php foreach ($produtos as $produto): ?>
        <form method="post" class="admin-product">
            <input type="hidden" name="id" value="<?= h($produto['id']) ?>">

            <input type="text" name="nome" value="<?= h($produto['name']) ?>" required>
            <textarea name="descricao" required><?= h($produto['description']) ?></textarea>
            <input type="number" name="preco" value="<?= h($produto['price']) ?>" step="0.01" required>
            <input type="text" name="categoria" value="<?= h($produto['category']) ?>" required>
            <input type="text" name="imagem" value="<?= h($produto['image']) ?>" required>

            <button type="submit" name="editar">Salvar</button>
            <a href="produtos.php?excluir=<?= h($produto['id']) ?>" onclick="return confirm('Excluir este produto?')">Excluir</a>
        </form>
    <?php endforeach; ?>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
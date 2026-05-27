<?php
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../includes/functions.php';

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
    $nome = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $preco = $_POST['preco'] ?? 0;
    $categoria = trim($_POST['categoria'] ?? '');
    $imagem = trim($_POST['imagem'] ?? '');

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

<section class="page-hero small">
    <p class="eyebrow">Painel Admin</p>
    <h1>Gerenciar Produtos</h1>
    <p>Adicione, edite e exclua produtos da Street Legends.</p>
</section>

<section class="admin-form-wrap">
    <form method="post" class="admin-form">
        <h2>Adicionar produto</h2>

        <label>
            Nome
            <input type="text" name="nome" required>
        </label>

        <label>
            Descrição
            <textarea name="descricao" required></textarea>
        </label>

        <div class="admin-two-cols">
            <label>
                Preço
                <input type="number" name="preco" step="0.01" required>
            </label>

            <label>
                Categoria
                <input type="text" name="categoria" required>
            </label>
        </div>

        <label>
            Imagem
            <input type="text" name="imagem" placeholder="ex: assets/img/produtos/bone/bone01.png" required>
        </label>

        <div class="admin-form-buttons">
            <button class="btn primary" type="submit" name="criar">Adicionar produto</button>
        </div>
    </form>
</section>

<section class="admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Imagem</th>
                <th>Produto</th>
                <th>Preço</th>
                <th>Categoria</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($produtos as $produto): ?>
                <tr>
                    <form method="post">
                        <input type="hidden" name="id" value="<?= h($produto['id']) ?>">

                        <td>
                            <img
                                class="admin-product-img"
                                src="<?= base_url($produto['image']) ?>"
                                alt="<?= h($produto['name']) ?>"
                            >
                        </td>

                        <td>
                            <input type="text" name="nome" value="<?= h($produto['name']) ?>" required>
                            <textarea name="descricao" required><?= h($produto['description']) ?></textarea>
                        </td>

                        <td>
                            <input type="number" name="preco" value="<?= h($produto['price']) ?>" step="0.01" required>
                        </td>

                        <td>
                            <input type="text" name="categoria" value="<?= h($produto['category']) ?>" required>
                            <input type="text" name="imagem" value="<?= h($produto['image']) ?>" required>
                        </td>

                        <td>
                            <div class="admin-actions-cell">
                                <button class="btn small primary" type="submit" name="editar">Salvar</button>

                                <a class="btn small danger-btn" href="produtos.php?excluir=<?= h($produto['id']) ?>" onclick="return confirm('Excluir este produto?')">
                                    Excluir
                                </a>
                            </div>
                        </td>
                    </form>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
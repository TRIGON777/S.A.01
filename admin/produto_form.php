<?php
require_once __DIR__ . '/admin_auth.php';

$admin = requireAdmin();

$pageTitle = 'Admin - Produto';
require_once __DIR__ . '/../includes/header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$produto = [
    'id' => 0,
    'name' => '',
    'description' => '',
    'price' => '',
    'category' => 'camisa',
    'image' => '',
    'stock' => 20
];

if ($id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $produtoEncontrado = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$produtoEncontrado) {
        die('Produto não encontrado.');
    }

    $produto = $produtoEncontrado;
}

$categorias = [
    'camisa' => 'Camisa',
    'calca' => 'Calça',
    'moletom' => 'Moletom',
    'tenis' => 'Tênis',
    'bone' => 'Boné'
];
?>

<main class="admin-page">
    <section class="page-hero compact">
        <p class="eyebrow">Área administrativa</p>
        <h1><?= $id > 0 ? 'Editar produto' : 'Adicionar produto' ?></h1>
    </section>

    <section class="admin-form-wrap">
        <form class="admin-form" action="produto_salvar.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= (int)$produto['id'] ?>">
            <input type="hidden" name="old_image" value="<?= htmlspecialchars($produto['image']) ?>">

            <label>
                Nome do produto
                <input type="text" name="name" required value="<?= htmlspecialchars($produto['name']) ?>">
            </label>

            <label>
                Descrição
                <textarea name="description" required><?= htmlspecialchars($produto['description']) ?></textarea>
            </label>

            <div class="admin-two-cols">
                <label>
                    Preço
                    <input type="number" name="price" required step="0.01" min="0" value="<?= htmlspecialchars($produto['price']) ?>">
                </label>

                <label>
                    Estoque
                    <input type="number" name="stock" required min="0" value="<?= isset($produto['stock']) ? (int)$produto['stock'] : 20 ?>">
                </label>
            </div>

            <label>
                Categoria
                <select name="category" required>
                    <?php foreach ($categorias as $valor => $nome): ?>
                        <option value="<?= $valor ?>" <?= $produto['category'] === $valor ? 'selected' : '' ?>>
                            <?= $nome ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>

            <label>
                Imagem do produto
                <input type="file" name="image_file" accept="image/png,image/jpeg,image/jpg,image/webp">
            </label>

            <?php if (!empty($produto['image'])): ?>
                <div class="admin-current-image">
                    <p>Imagem atual:</p>
                    <img src="../<?= htmlspecialchars($produto['image']) ?>" alt="Imagem atual">
                </div>
            <?php endif; ?>

            <div class="admin-form-buttons">
                <button type="submit" class="btn primary">Salvar produto</button>
                <a href="produtos.php" class="btn ghost">Cancelar</a>
            </div>
        </form>
    </section>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

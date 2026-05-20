<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/header.php';

$busca = isset($_GET['busca']) ? trim($_GET['busca']) : '';
$categoria = isset($_GET['categoria']) ? trim($_GET['categoria']) : '';

$sql = "SELECT * FROM products WHERE 1=1";
$params = [];

if ($busca !== '') {
    $sql .= " AND (name LIKE :busca OR description LIKE :busca OR category LIKE :busca)";
    $params[':busca'] = '%' . $busca . '%';
}

if ($categoria !== '') {
    $sql .= " AND category = :categoria";
    $params[':categoria'] = $categoria;
}

$sql .= " ORDER BY id ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$categorias = [
    '' => 'Todas as categorias',
    'camisa' => 'Camisas',
    'calca' => 'Calças',
    'moletom' => 'Moletons',
    'tenis' => 'Tênis',
    'bone' => 'Bonés'
];
?>

<main class="products-page">
    <section class="page-hero compact">
        <div>
            <p class="eyebrow">Street Legends</p>
            <h1>Produtos</h1>
            <p>Explore a coleção urbana com busca inteligente e filtros por categoria.</p>
        </div>
    </section>

    <section class="search-panel search-panel-below-header">
        <form action="produtos.php" method="GET" class="search-form" autocomplete="off">
            <div class="search-box">
                <input
                    type="text"
                    id="searchInput"
                    name="busca"
                    value="<?= htmlspecialchars($busca) ?>"
                    placeholder="Pesquisar produtos..."
                    list="sugestoesProdutos"
                >

                <datalist id="sugestoesProdutos">
                    <option value="camisa oversized">
                    <option value="camisa marrom">
                    <option value="calça cargo">
                    <option value="calça wide">
                    <option value="moletom com capuz">
                    <option value="moletom oversized">
                    <option value="tênis urbano">
                    <option value="tênis marrom">
                    <option value="boné streetwear">
                    <option value="boné marrom">
                </datalist>
            </div>

            <select name="categoria">
                <?php foreach ($categorias as $valor => $nome): ?>
                    <option value="<?= $valor ?>" <?= $categoria === $valor ? 'selected' : '' ?>>
                        <?= $nome ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit" class="btn-primary">Buscar</button>
        </form>
    </section>

    <section class="products-grid">
        <?php if (count($produtos) === 0): ?>
            <p class="empty-message">Nenhum produto encontrado.</p>
        <?php endif; ?>

        <?php foreach ($produtos as $produto): ?>
            <article class="product-card">
                <div class="product-image">
                    <img
                        src="<?= htmlspecialchars($produto['image']) ?>"
                        alt="<?= htmlspecialchars($produto['name']) ?>"
                    >
                </div>

                <div class="product-info">
                    <span class="product-category"><?= htmlspecialchars(ucfirst($produto['category'])) ?></span>
                    <h3><?= htmlspecialchars($produto['name']) ?></h3>
                    <p><?= htmlspecialchars($produto['description']) ?></p>

                    <div class="product-bottom">
                        <strong>R$ <?= number_format($produto['price'], 2, ',', '.') ?></strong>

                        <form action="carrinho.php" method="POST">
                            <input type="hidden" name="action" value="add">
                            <input type="hidden" name="id" value="<?= (int)$produto['id'] ?>">
                            <button class="btn-secondary" type="submit">Adicionar</button>
                        </form>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    </section>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
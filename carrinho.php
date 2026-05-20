<?php
$pageTitle = 'Carrinho - Street Legends';
include 'includes/header.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_GET['add'])) {
    $id = (int) $_GET['add'];

    if ($id > 0) {
        $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
    }

    header('Location: carrinho.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id = (int)($_POST['id'] ?? 0);

    if ($action === 'add' && $id > 0) {
        $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
    }

    if ($action === 'update' && $id > 0) {
        $qty = max(0, (int)($_POST['qty'] ?? 0));

        if ($qty === 0) {
            unset($_SESSION['cart'][$id]);
        } else {
            $_SESSION['cart'][$id] = $qty;
        }
    }

    if ($action === 'remove' && $id > 0) {
        unset($_SESSION['cart'][$id]);
    }

    header('Location: carrinho.php');
    exit;
}

$items = [];
$subtotal = 0;

if (!empty($_SESSION['cart'])) {
    $ids = array_keys($_SESSION['cart']);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));

    $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->execute($ids);

    foreach ($stmt->fetchAll() as $p) {
        $qty = $_SESSION['cart'][$p['id']] ?? 0;

        $p['qty'] = $qty;
        $p['total'] = $qty * $p['price'];

        $subtotal += $p['total'];
        $items[] = $p;
    }
}

$discount = $subtotal > 300 ? $subtotal * 0.10 : 0;
$total = $subtotal - $discount;
?>

<section class="page-hero small reveal">
    <h1>Carrinho</h1>
</section>

<section class="cart-layout reveal">
    <div class="cart-list">
        <?php if (empty($items)): ?>
            <div class="empty">
                Seu carrinho está vazio.
                <a href="produtos.php">Ver produtos</a>
            </div>
        <?php endif; ?>

        <?php foreach ($items as $item): ?>
            <article class="cart-item">
                <img src="<?= base_url($item['image']) ?>" alt="<?= h($item['name']) ?>">

                <div>
                    <h3><?= h($item['name']) ?></h3>
                    <p><?= money($item['price']) ?></p>
                </div>

                <form method="POST" class="qty-form">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
                    <input type="number" min="0" name="qty" value="<?= (int)$item['qty'] ?>">
                    <button class="btn small" type="submit">Atualizar</button>
                </form>

                <form method="POST">
                    <input type="hidden" name="action" value="remove">
                    <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
                    <button class="link-danger" type="submit">Remover</button>
                </form>
            </article>
        <?php endforeach; ?>
    </div>

    <aside class="summary-card">
        <h2>Resumo</h2>

        <p>Subtotal <strong><?= money($subtotal) ?></strong></p>
        <p>Desconto <strong><?= money($discount) ?></strong></p>

        <hr>

        <p class="summary-total">Total <strong><?= money($total) ?></strong></p>

        <a class="btn primary full" href="checkout.php">Finalizar compra</a>
    </aside>
</section>

<?php include 'includes/footer.php'; ?>
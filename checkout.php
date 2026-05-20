<?php
$pageTitle = 'Checkout - Street Legends';
include 'includes/header.php';

requireLogin();

$subtotal = 0;

if (!empty($_SESSION['cart'])) {
    $ids = array_keys($_SESSION['cart']);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));

    $stmt = $pdo->prepare("SELECT id, price FROM products WHERE id IN ($placeholders)");
    $stmt->execute($ids);

    foreach ($stmt->fetchAll() as $p) {
        $subtotal += $p['price'] * ($_SESSION['cart'][$p['id']] ?? 0);
    }
}

$discount = $subtotal > 300 ? $subtotal * 0.10 : 0;
$total = $subtotal - $discount;

if ($subtotal <= 0) {
    header('Location: carrinho.php');
    exit;
}
?>

<section class="page-hero small reveal">
    <h1>Checkout</h1>
    <p>Escolha cartão ou Pix</p>
</section>

<section class="checkout-grid reveal">
    <form class="payment-card" action="pedido.php" method="POST">
        <h2>Dados da compra</h2>

        <div class="summary-mini">
            <p>Subtotal <strong><?= money($subtotal) ?></strong></p>
            <p>Desconto <strong><?= money($discount) ?></strong></p>
            <p>Total <strong><?= money($total) ?></strong></p>
        </div>

        <h2>Pagamento</h2>

        <div class="payment-tabs">
            <label>
                <input type="radio" name="payment" value="card" checked>
                Cartão
            </label>

            <label>
                <input type="radio" name="payment" value="pix">
                Pix
            </label>
        </div>

        <div class="card-fields" data-payment-box="card">
            <label>
                Nome no cartão
                <input name="card_name" placeholder="Nome impresso">
            </label>

            <label>
                Número do cartão
                <input name="card_number" maxlength="19" placeholder="0000 0000 0000 0000">
            </label>

            <div class="two-cols">
                <label>
                    Validade
                    <input name="card_date" placeholder="MM/AA">
                </label>

                <label>
                    CVV
                    <input name="card_cvv" maxlength="4" placeholder="123">
                </label>
            </div>
        </div>

        <div class="pix-box hidden" data-payment-box="pix">
            <div class="qr-code">PIX<br>QR</div>
            <p>Escaneie o QR Code demonstrativo para simular o pagamento.</p>
            <code>00020101021226890014br.gov.bcb.pix.streetlegends</code>
        </div>

        <button class="btn primary full" type="submit">Confirmar pedido</button>
    </form>
</section>

<?php include 'includes/footer.php'; ?>
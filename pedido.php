<?php
$pageTitle = 'Pedido confirmado - Street Legends';
include 'includes/header.php';
requireLogin();
$payment = $_POST['payment'] ?? 'card';
$_SESSION['cart'] = [];
?>
<section class="success-page reveal">
    <div class="success-card">
        <span class="success-icon">✓</span>
        <h1>Pedido confirmado!</h1>
        <p>Sua compra foi registrada com pagamento <?= $payment === 'pix' ? 'via Pix' : 'via cartão' ?>.</p>
        <a class="btn primary" href="produtos.php">Continuar comprando</a>
    </div>
</section>
<?php include 'includes/footer.php'; ?>

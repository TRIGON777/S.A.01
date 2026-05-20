<?php $pageTitle = 'Street Legends - Início'; include 'includes/header.php'; ?>
<section class="hero reveal">
    <div class="hero-content">
        <p class="eyebrow">Nova coleção Streetwear</p>
        <h1>Street Legends Quem tá na rua sabe!
        </h1>
        <p>Loja virtual pra quem vive o estilo Street</p>
        <div class="hero-actions">
            <a class="btn primary" href="produtos.php">Ver produtos</a>
            <a class="btn ghost" href="cadastro.php">Criar conta</a>
        </div>
    </div>
    <div class="hero-card reveal">
        <!-- TROQUE A IMAGEM ABAIXO pela sua foto/banner principal da Street Legends -->
        <!-- Coloque o arquivo em: assets/img/banner.png -->
        <img src="<?= base_url('assets/img/banner2.png') ?>" alt="Coleção Street Legends">
    </div>
</section>

<section class="search-showcase reveal">
    <p class="eyebrow">Busca inteligente</p>
    <form class="smart-search" action="produtos.php" method="GET" autocomplete="off">
        <input type="text" name="q" id="homeSearch" placeholder="Pesquise por moletom, jaqueta, boné..." data-suggest="true">
        <button class="btn primary" type="submit">Pesquisar</button>
        <div class="suggestions" data-suggestions-for="homeSearch"></div>
    </form>
</section>

<section class="section reveal">
    <p class="eyebrow">Experiência profissional</p>
    <h2>Fluxo completo de compra</h2>
    <div class="features">
        <article><span>01</span><h3>Conta obrigatória</h3><p>O usuário pode ver produtos e montar carrinho, mas só finaliza compra após login.</p></article>
        <article><span>02</span><h3>Pesquisa e filtros</h3><p>Busca com sugestões de palavras e filtro por categoria direto na tela de produtos.</p></article>
        <article><span>03</span><h3>Pagamento duplo</h3><p>Cartão com CVV e Pix com QR Code demonstrativo.</p></article>
    </div>
</section>
<?php include 'includes/footer.php'; ?>

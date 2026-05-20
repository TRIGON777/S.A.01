<?php
require_once __DIR__ . '/config.php';

function setupDatabase($pdo) {
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(120) NOT NULL,
        email VARCHAR(160) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $pdo->exec("CREATE TABLE IF NOT EXISTS products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(160) NOT NULL,
        category VARCHAR(80) NOT NULL,
        description TEXT NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        image VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $count = (int)$pdo->query('SELECT COUNT(*) FROM products')->fetchColumn();
    if ($count === 0) {
        $products = [
            ['Jaqueta Cargo Brown', 'Jaquetas', 'Jaqueta oversized em tom café, com bolsos utilitários e visual urbano.', 249.90, 'assets/img/produto-jaqueta.svg'],
            ['Moletom Urban Cocoa', 'Moletons', 'Moletom marrom premium com capuz e acabamento street minimalista.', 189.90, 'assets/img/produto-moletom.svg'],
            ['Camiseta Desert Logo', 'Camisetas', 'Camiseta bege com estampa Street Legends no peito.', 89.90, 'assets/img/produto-camiseta.svg'],
            ['Calça Wide Coffee', 'Calças', 'Calça wide leg em sarja marrom para composição streetwear.', 159.90, 'assets/img/produto-calca.svg'],
            ['Boné SL Classic', 'Acessórios', 'Boné marrom com bordado frontal minimalista.', 69.90, 'assets/img/produto-bone.svg'],
            ['Tênis Asphalt Brown', 'Tênis', 'Tênis casual marrom com sola robusta e visual urbano.', 299.90, 'assets/img/produto-tenis.svg'],
            ['Bolsa Crossbody Caramel', 'Acessórios', 'Bolsa transversal caramelo para rotina urbana.', 119.90, 'assets/img/produto-bolsa.svg'],
            ['Camisa Oversized Taupe', 'Camisetas', 'Camisa oversized em tom taupe com caimento premium.', 109.90, 'assets/img/produto-camisa.svg']
        ];
        $stmt = $pdo->prepare('INSERT INTO products (name, category, description, price, image) VALUES (?, ?, ?, ?, ?)');
        foreach ($products as $p) {
            $stmt->execute($p);
        }
    }
}

setupDatabase($pdo);

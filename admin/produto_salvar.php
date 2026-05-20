<?php
require_once __DIR__ . '/admin_auth.php';

requireAdmin();

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$name = trim($_POST['name'] ?? '');
$description = trim($_POST['description'] ?? '');
$price = (float)($_POST['price'] ?? 0);
$category = trim($_POST['category'] ?? '');
$stock = (int)($_POST['stock'] ?? 0);
$oldImage = trim($_POST['old_image'] ?? '');

if ($name === '' || $description === '' || $price <= 0 || $category === '') {
    die('Preencha todos os campos corretamente.');
}

$allowedCategories = ['camisa', 'calca', 'moletom', 'tenis', 'bone'];

if (!in_array($category, $allowedCategories)) {
    die('Categoria inválida.');
}

$slug = adminSlug($name);
$imagePath = $oldImage;

if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['image_file'];

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowedExt = ['png', 'jpg', 'jpeg', 'webp'];

    if (!in_array($ext, $allowedExt)) {
        die('Formato inválido. Use PNG, JPG, JPEG ou WEBP.');
    }

    $uploadDir = __DIR__ . '/../assets/img/produtos/' . $category . '/';

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileName = $slug . '-' . time() . '.' . $ext;
    $destination = $uploadDir . $fileName;

    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        die('Erro ao enviar imagem.');
    }

    $imagePath = 'assets/img/produtos/' . $category . '/' . $fileName;
}

if ($imagePath === '') {
    die('Envie uma imagem para o produto.');
}

if ($id > 0) {
    $stmt = $pdo->prepare("
        UPDATE products
        SET name = ?, slug = ?, description = ?, price = ?, category = ?, image = ?, stock = ?
        WHERE id = ?
    ");

    $stmt->execute([
        $name,
        $slug . '-' . $id,
        $description,
        $price,
        $category,
        $imagePath,
        $stock,
        $id
    ]);
} else {
    $stmt = $pdo->prepare("
        INSERT INTO products (name, slug, description, price, category, image, stock)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $name,
        $slug . '-' . time(),
        $description,
        $price,
        $category,
        $imagePath,
        $stock
    ]);
}

header('Location: produtos.php');
exit;

<?php

require_once __DIR__ . '/../controllers/CategoryController.php';

$controller = new CategoryController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['cat_name'] ?? '';

    $result = $controller->addCategory($name);

    if ($result['success']) {
        header('Location: ../views/categories.php?success=1');
        exit;
    }

    header(
        'Location: ../views/categories.php?error=' .
        urlencode($result['error'])
    );
    exit;
}

header('Location: ../views/categories.php');
exit;

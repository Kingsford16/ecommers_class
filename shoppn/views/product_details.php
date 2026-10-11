
<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

$controller = new ProductController();

// Get the product ID from the URL
$product_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

$product = $product_id
    ? $controller->getProductById($product_id)
    : false;

require_once __DIR__ . '/layout/header.php';
?>

<main>
    <?php if (!$product): ?>

        <h1>Product Not Found</h1>
        <p>Sorry, this product could not be found.</p>
        <p><a href="../index.php">Return to ShopPN</a></p>

    <?php else: ?>

        <h1><?= htmlspecialchars($product['product_title']) ?></h1>

        <?php if (!empty($product['product_image'])): ?>

            <img
                src="../uploads/products/<?= rawurlencode(basename($product['product_image'])) ?>"
                alt="<?= htmlspecialchars($product['product_title']) ?>"
                style="width: 300px; max-width: 100%; height: auto;"
            >

        <?php else: ?>

            <p>No image available for this product.</p>

        <?php endif; ?>

        <p>
            <strong>Price:</strong>
            <?= number_format((float) $product['product_price'], 2) ?>
        </p>

        <p>
            <strong>Brand ID:</strong>
            <?= (int) $product['product_brand'] ?>
        </p>

        <p>
            <strong>Category ID:</strong>
            <?= (int) $product['product_cat'] ?>
        </p>

        <h2>Description</h2>

        <p>
            <?= nl2br(htmlspecialchars($product['product_desc'] ?? 'No description available.')) ?>
        </p>

        <?php if (!empty($product['product_keywords'])): ?>
            <p>
                <strong>Keywords:</strong>
                <?= htmlspecialchars($product['product_keywords']) ?>
            </p>
        <?php endif; ?>

        <p><a href="../index.php">Back to ShopPN</a></p>

    <?php endif; ?>
</main>

<?php require_once __DIR__ . '/layout/footer.php'; ?>

<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

// Read and validate the product ID
$product_id = filter_input(INPUT_GET, 'pro_id', FILTER_VALIDATE_INT);

if (!$product_id || $product_id < 1) {
    header('Location: ../index.php');
    exit;
}

// Retrieve the product through the controller
$controller = new ProductController();
$product = $controller->getProductById($product_id);

// Redirect if the product does not exist
if (!$product) {
    header('Location: ../index.php');
    exit;
}

require_once __DIR__ . '/layout/header.php';
?>

<main style="padding: 20px;">
    <h1><?= htmlspecialchars($product['product_title']) ?></h1>

    <div style="display: flex; flex-wrap: wrap; gap: 30px; align-items: flex-start;">

        <div style="width: 300px; max-width: 100%;">

            <?php if (!empty($product['product_image'])): ?>

                <img
                    src="../images/products/<?= rawurlencode(basename($product['product_image'])) ?>"
                    alt="<?= htmlspecialchars($product['product_title']) ?>"
                    style="width: 100%; max-height: 350px; object-fit: contain;"
                >

            <?php else: ?>

                <div style="height: 250px; display: flex; align-items: center; justify-content: center; background: #f2f2f2;">
                    No image available
                </div>

            <?php endif; ?>

        </div>

        <div style="flex: 1; min-width: 250px;">

            <p>
                <strong>Price:</strong>
                <?= number_format((float) $product['product_price'], 2) ?>
            </p>

            <p>
                <strong>Category:</strong>
                <?= htmlspecialchars($product['cat_name'] ?? 'N/A') ?>
            </p>

            <p>
                <strong>Brand:</strong>
                <?= htmlspecialchars($product['brand_name'] ?? 'N/A') ?>
            </p>

            <p>
                <strong>Description:</strong><br>
                <?= htmlspecialchars($product['product_desc'] ?? 'No description available.') ?>
            </p>

            <p>
                <strong>Keywords:</strong>
                <?= htmlspecialchars($product['product_keywords'] ?? 'None') ?>
            </p>

            <p>
                <a href="../index.php?add_cart=<?= (int) $product['product_id'] ?>">
                    Add to Cart
                </a>
            </p>

            <p>
                <a href="../index.php">Back to Products</a>
            </p>

        </div>
    </div>
</main>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
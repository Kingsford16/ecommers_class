
<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

// Create the controller
$controller = new ProductController();

// Base URL for local and remote hosting
$baseUrl = app_base_url();

// Decide which products to display
if (isset($_GET['cat']) && is_numeric($_GET['cat'])) {
    $products = $controller->getProductsByCategory((int) $_GET['cat']);
    $pageTitle = 'Products by Category';
} elseif (isset($_GET['brand']) && is_numeric($_GET['brand'])) {
    $products = $controller->getProductsByBrand((int) $_GET['brand']);
    $pageTitle = 'Products by Brand';
} else {
    $products = $controller->getFeaturedProducts(6);
    $pageTitle = 'Featured Products';
}

// Load the page header
require_once __DIR__ . '/layout/header.php';
?>

<main>
    <h1>Welcome to ShopPN</h1>
    <p>Discover our available products below.</p>

    <?php if (isset($_SESSION['cart_message'])): ?>
        <p>
            <?= htmlspecialchars($_SESSION['cart_message']) ?>
        </p>
        <?php unset($_SESSION['cart_message']); ?>
    <?php endif; ?>

    <div style="display: flex; gap: 30px; align-items: flex-start;">

        <?php
        // Display category and brand navigation
        require_once __DIR__ . '/layout/sidebar.php';
        ?>

        <section style="flex: 1;">
            <h2><?= htmlspecialchars($pageTitle) ?></h2>

            <?php if (empty($products)): ?>

                <p>No products found. Please try another category or brand.</p>

            <?php else: ?>

                <div style="display: flex; flex-wrap: wrap; gap: 20px;">

                    <?php foreach ($products as $product): ?>

                        <div style="border: 1px solid #ddd; padding: 15px; width: 220px;">

                            <?php if (!empty($product['product_image'])): ?>

                                <img
                                    src="<?= $baseUrl ?>/images/products/<?= rawurlencode(basename($product['product_image'])) ?>"
                                    alt="<?= htmlspecialchars($product['product_title']) ?>"
                                    style="width: 100%; height: 160px; object-fit: contain;"
                                >

                            <?php else: ?>

                                <div style="height: 160px; display: flex; align-items: center; justify-content: center; background: #f2f2f2;">
                                    <span>No image available</span>
                                </div>

                            <?php endif; ?>

                            <h3>
                                <?= htmlspecialchars($product['product_title']) ?>
                            </h3>

                            <p>
                                <strong>Price:</strong>
                                <?= number_format((float) $product['product_price'], 2) ?>
                            </p>

                            <p>
                                <strong>Brand:</strong>
                                <?= htmlspecialchars($product['brand_name'] ?? 'N/A') ?>
                            </p>

                            <p>
                                <strong>Category:</strong>
                                <?= htmlspecialchars($product['cat_name'] ?? 'N/A') ?>
                            </p>

                            <?php if (!empty($product['product_desc'])): ?>
                                <p>
                                    <?= htmlspecialchars($product['product_desc']) ?>
                                </p>
                            <?php endif; ?>

                            <p>
                                <a
                                    href="<?= $baseUrl ?>/views/single_product.php?pro_id=<?= (int) $product['product_id'] ?>"
                                    style="display: inline-block; background-color: #2563eb; color: white; padding: 8px 14px; text-decoration: none; border-radius: 5px;"
                                >
                                    View Details
                                </a>
                            </p>

                            <p>
                                <a
                                    href="<?= $baseUrl ?>/actions/add_to_cart_action.php?add_cart=<?= (int) $product['product_id'] ?>"
                                    style="display: inline-block; background-color: #16a34a; color: white; padding: 8px 14px; text-decoration: none; border-radius: 5px;"
                                >
                                    Add to Cart
                                </a>
                            </p>

                        </div>

                    <?php endforeach; ?>

                </div>

            <?php endif; ?>
        </section>

    </div>
</main>

<?php require_once __DIR__ . '/layout/footer.php'; ?>


<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

// Read the search term from the URL
$query = trim($_GET['user_query'] ?? '');

// Create the controller
$controller = new ProductController();

// Search only when a search term is provided
$products = ($query !== '')
    ? $controller->searchProducts($query)
    : [];

require_once __DIR__ . '/layout/header.php';
?>

<main style="padding: 20px;">

    <h1>Search Results</h1>

    <form action="search_results.php" method="GET">
        <label for="user_query">Search for a product:</label>

        <input
            type="text"
            id="user_query"
            name="user_query"
            value="<?= htmlspecialchars($query) ?>"
            placeholder="Enter product name or keyword"
            required
        >

        <button type="submit">Search</button>
    </form>

    <?php if ($query === ''): ?>

        <p>Enter a product name or keyword to search.</p>

    <?php elseif (empty($products)): ?>

        <p>No products found for "<?= htmlspecialchars($query) ?>". Try another search.</p>

    <?php else: ?>

        <h2>Results for "<?= htmlspecialchars($query) ?>"</h2>

        <div style="display: flex; flex-wrap: wrap; gap: 20px;">

            <?php foreach ($products as $product): ?>

                <div style="border: 1px solid #ddd; padding: 15px; width: 220px;">

                    <?php if (!empty($product['product_image'])): ?>

                        <img
                            src="../uploads/products/<?= rawurlencode(basename($product['product_image'])) ?>"
                            alt="<?= htmlspecialchars($product['product_title']) ?>"
                            style="width: 100%; height: 160px; object-fit: contain;"
                        >

                    <?php else: ?>

                        <div style="height: 160px; display: flex; align-items: center; justify-content: center; background: #f2f2f2;">
                            No image available
                        </div>

                    <?php endif; ?>

                    <h3><?= htmlspecialchars($product['product_title']) ?></h3>

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

                    <p>
                        <a href="single_product.php?pro_id=<?= (int) $product['product_id'] ?>">
                            View Details
                        </a>
                    </p>

                    <p>
                        <a href="../index.php?add_cart=<?= (int) $product['product_id'] ?>">
                            Add to Cart
                        </a>
                    </p>

                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

    <p><a href="../index.php">Back to Home</a></p>

</main>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
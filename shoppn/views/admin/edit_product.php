<?php
require_once __DIR__ . '/../../core/core.php';
require_once __DIR__ . '/../../controllers/ProductController.php';

require_admin();

$controller = new ProductController();

$product_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$product_id || $product_id < 1) {
    $_SESSION['error'] = 'Invalid product ID.';
    redirect('manage_products.php');
}

$product = $controller->getProductById($product_id);

if (!$product) {
    $_SESSION['error'] = 'Product not found.';
    redirect('manage_products.php');
}

$categories = $controller->getAllCategories();
$brands = $controller->getAllBrands();

$success = $_SESSION['success'] ?? '';
$error = $_SESSION['error'] ?? '';

unset($_SESSION['success'], $_SESSION['error']);

require_once __DIR__ . '/../layout/header.php';
?>

<main style="padding: 20px;">
    <h2>Edit Product</h2>

    <?php if ($success !== ''): ?>
        <p style="color: green;">
            <?= htmlspecialchars($success) ?>
        </p>
    <?php endif; ?>

    <?php if ($error !== ''): ?>
        <p style="color: red;">
            <?= htmlspecialchars($error) ?>
        </p>
    <?php endif; ?>

    <form
        action="../../actions/update_product_action.php"
        method="POST"
        enctype="multipart/form-data"
    >
        <input
            type="hidden"
            name="product_id"
            value="<?= (int) $product['product_id'] ?>"
        >

        <p>
            <label for="product_title">Product Name *</label><br>
            <input
                type="text"
                id="product_title"
                name="product_title"
                maxlength="200"
                required
                value="<?= htmlspecialchars($product['product_title']) ?>"
            >
        </p>

        <p>
            <label for="product_price">Price *</label><br>
            <input
                type="number"
                id="product_price"
                name="product_price"
                min="0"
                step="0.01"
                required
                value="<?= htmlspecialchars((string) $product['product_price']) ?>"
            >
        </p>

        <p>
            <label for="product_cat">Category *</label><br>
            <select id="product_cat" name="product_cat" required>
                <?php foreach ($categories as $category): ?>
                    <option
                        value="<?= (int) $category['cat_id'] ?>"
                        <?= (int) $product['product_cat'] === (int) $category['cat_id'] ? 'selected' : '' ?>
                    >
                        <?= htmlspecialchars($category['cat_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>

        <p>
            <label for="product_brand">Brand *</label><br>
            <select id="product_brand" name="product_brand" required>
                <?php foreach ($brands as $brand): ?>
                    <option
                        value="<?= (int) $brand['brand_id'] ?>"
                        <?= (int) $product['product_brand'] === (int) $brand['brand_id'] ? 'selected' : '' ?>
                    >
                        <?= htmlspecialchars($brand['brand_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>

        <p>
            <label for="product_desc">Description</label><br>
            <textarea
                id="product_desc"
                name="product_desc"
                maxlength="500"
                rows="4"
            ><?= htmlspecialchars($product['product_desc'] ?? '') ?></textarea>
        </p>

        <p>
            <label for="product_keywords">Search Keywords</label><br>
            <input
                type="text"
                id="product_keywords"
                name="product_keywords"
                maxlength="100"
                value="<?= htmlspecialchars($product['product_keywords'] ?? '') ?>"
            >
        </p>

        <p>
            <strong>Current image:</strong><br>

            <?php
            $currentImage = $product['product_image'] ?? '';
            $currentImagePath = __DIR__ . '/../../images/products/'
                . basename($currentImage);
            ?>

            <?php if (
                $currentImage !== '' &&
                basename($currentImage) === $currentImage &&
                is_file($currentImagePath)
            ): ?>
                <img
                    src="../../images/products/<?= rawurlencode(basename($currentImage)) ?>"
                    alt="<?= htmlspecialchars($product['product_title']) ?>"
                    style="width: 150px; max-height: 150px; object-fit: contain;"
                >
            <?php else: ?>
                <p>No image available in the products image folder.</p>
            <?php endif; ?>
        </p>

        <p>
            <label for="product_image">Replace Image (optional)</label><br>
            <input
                type="file"
                id="product_image"
                name="product_image"
                accept=".jpg,.jpeg,.png,.gif,.webp,image/jpeg,image/png,image/gif,image/webp"
            >
            <br>
            <small>
                Maximum size: 5 MB. Leave empty to keep the current image.
                Accepted formats: JPG, PNG, GIF, WebP.
            </small>
        </p>

        <button type="submit">Save Changes</button>
    </form>

    <p><a href="manage_products.php">Back to Manage Products</a></p>
</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
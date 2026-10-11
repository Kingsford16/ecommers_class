
<?php

require_once __DIR__ . '/../../core/core.php';
require_once __DIR__ . '/../../controllers/ProductController.php';

// Only administrators can access this page
require_admin();

$controller = new ProductController();

$categories = $controller->getAllCategories();
$brands = $controller->getAllBrands();

// Retrieve messages from the action
$success = $_SESSION['success'] ?? '';
$error = $_SESSION['error'] ?? '';

unset($_SESSION['success'], $_SESSION['error']);

require_once __DIR__ . '/../layout/header.php';
?>

<h2>Add New Product</h2>

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
    action="../../actions/add_product_action.php"
    method="POST"
    enctype="multipart/form-data"
>
    <p>
        <label for="product_title">Product Name *</label><br>
        <input
            type="text"
            id="product_title"
            name="product_title"
            maxlength="200"
            required
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
        >
    </p>

    <p>
        <label for="product_cat">Category *</label><br>
        <select id="product_cat" name="product_cat" required>
            <option value="">Select a category</option>

            <?php foreach ($categories as $category): ?>
                <option value="<?= (int) $category['cat_id'] ?>">
                    <?= htmlspecialchars($category['cat_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </p>

    <p>
        <label for="product_brand">Brand *</label><br>
        <select id="product_brand" name="product_brand" required>
            <option value="">Select a brand</option>

            <?php foreach ($brands as $brand): ?>
                <option value="<?= (int) $brand['brand_id'] ?>">
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
        ></textarea>
    </p>

    <p>
        <label for="product_keywords">Search Keywords</label><br>
        <input
            type="text"
            id="product_keywords"
            name="product_keywords"
            maxlength="100"
        >
    </p>

    <p>
        <label for="product_image">Product Image</label><br>
        <input
            type="file"
            id="product_image"
            name="product_image"
            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
        >
        <small>Optional. JPG, PNG, or WebP. Maximum 5 MB.</small>
    </p>

    <button type="submit">Add Product</button>
</form>

<p>
    <a href="brand.php">Manage Brands</a> |
    <a href="category.php">Manage Categories</a>
</p>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>



<?php
require_once __DIR__ . '/../../core/core.php';
require_once __DIR__ . '/../../controllers/ProductController.php';

// Only administrators can access this page
require_admin();

$controller = new ProductController();
$products = $controller->getAllProducts();

require_once __DIR__ . '/../layout/header.php';
?>

<h2>Manage Products</h2>

<?php if (empty($products)): ?>
    <p>No products have been added yet.</p>
<?php else: ?>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Category</th>
                <th>Brand</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= (int) $product['product_id'] ?></td>

                    <td>
                        <?php if (!empty($product['product_image'])): ?>
                            <img
                                src="../../uploads/products/<?= rawurlencode(basename($product['product_image'])) ?>"
                                alt="<?= htmlspecialchars($product['product_title']) ?>"
                                width="70"
                            >
                        <?php else: ?>
                            No image
                        <?php endif; ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($product['product_title']) ?>
                    </td>

                    <td>
                        <?= number_format((float) $product['product_price'], 2) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($product['cat_name'] ?? 'N/A') ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($product['brand_name'] ?? 'N/A') ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($product['product_desc'] ?? '') ?>
                    </td>
                    
                    <td>
                      <a href="edit_product.php?id=<?= (int) $product['product_id'] ?>">
                          Edit
                      </a>
                  </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php endif; ?>

<p>
    <a href="add_product.php">Add Another Product</a>
</p>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
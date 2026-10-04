<?php

require_once __DIR__ . '/../../core/core.php';
require_once __DIR__ . '/../../controllers/ProductController.php';

// Admin check must happen before any HTML output
require_admin();

$controller = new ProductController();

$brands = $controller->getAllBrands();

// Check whether we are editing a brand
$edit_id = isset($_GET['edit_id']) ? (int) $_GET['edit_id'] : 0;

$edit_brand = null;

if ($edit_id > 0) {
    $edit_brand = $controller->getBrandById($edit_id);

    if (!$edit_brand) {
        $_SESSION['error'] = 'Brand not found.';
        redirect('brand.php');
    }
}

require_once __DIR__ . '/../layout/header.php';
?>

<h2>Manage Brands</h2>

<?php if (isset($_SESSION['success'])): ?>
    <p>
        <?= htmlspecialchars($_SESSION['success']) ?>
    </p>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <p>
        <?= htmlspecialchars($_SESSION['error']) ?>
    </p>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>


<?php if ($edit_brand): ?>

    <h3>Edit Brand</h3>

    <form action="../../actions/update_brand_action.php" method="POST">

        <input
            type="hidden"
            name="brand_id"
            value="<?= (int) $edit_brand['brand_id'] ?>"
        >

        <label for="brand_name">Brand Name</label>

        <input
            type="text"
            id="brand_name"
            name="brand_name"
            value="<?= htmlspecialchars($edit_brand['brand_name']) ?>"
            maxlength="100"
            required
        >

        <button type="submit">Update Brand</button>

        <a href="brand.php">Cancel</a>

    </form>

<?php else: ?>

    <h3>Add Brand</h3>

    <form action="../../actions/add_brand_action.php" method="POST">

        <label for="brand_name">Brand Name</label>

        <input
            type="text"
            id="brand_name"
            name="brand_name"
            maxlength="100"
            required
        >

        <button type="submit">Add Brand</button>

    </form>

<?php endif; ?>


<h3>Existing Brands</h3>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Brand Name</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>

        <?php foreach ($brands as $brand): ?>

            <tr>
                <td>
                    <?= htmlspecialchars($brand['brand_id']) ?>
                </td>

                <td>
                    <?= htmlspecialchars($brand['brand_name']) ?>
                </td>

                <td>
                    <a href="brand.php?edit_id=<?= (int) $brand['brand_id'] ?>">
                        Edit
                    </a>
                </td>
            </tr>

        <?php endforeach; ?>

    </tbody>
</table>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
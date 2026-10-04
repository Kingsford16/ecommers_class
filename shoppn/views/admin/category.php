
<?php

require_once __DIR__ . '/../../core/core.php';
require_once __DIR__ . '/../../controllers/ProductController.php';

// Admin check must happen before any HTML output
require_admin();

$controller = new ProductController();

// Check whether we are editing a category
$edit_id = filter_input(INPUT_GET, 'edit_id', FILTER_VALIDATE_INT);

$edit_category = null;

if ($edit_id !== false && $edit_id !== null && $edit_id > 0) {
    $edit_category = $controller->getCategoryById($edit_id);

    if (!$edit_category) {
        $_SESSION['error'] = 'Category not found.';
        redirect('category.php');
    }
}

// Get all categories
$categories = $controller->getAllCategories();

require_once __DIR__ . '/../layout/header.php';
?>

<h2>Manage Categories</h2>

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


<?php if ($edit_category): ?>

    <h3>Edit Category</h3>

    <form action="../../actions/update_category_action.php" method="POST">

        <input
            type="hidden"
            name="cat_id"
            value="<?= (int) $edit_category['cat_id'] ?>"
        >

        <label for="cat_name">Category Name</label>

        <input
            type="text"
            id="cat_name"
            name="cat_name"
            maxlength="100"
            value="<?= htmlspecialchars($edit_category['cat_name']) ?>"
            required
        >

        <button type="submit">Update Category</button>

        <a href="category.php">Cancel</a>

    </form>

<?php else: ?>

    <h3>Add Category</h3>

    <form action="../../actions/add_category_action.php" method="POST">

        <label for="cat_name">Category Name</label>

        <input
            type="text"
            id="cat_name"
            name="cat_name"
            maxlength="100"
            required
        >

        <button type="submit">Add Category</button>

    </form>

<?php endif; ?>


<h3>Existing Categories</h3>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Category Name</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>

        <?php foreach ($categories as $category): ?>

            <tr>
                <td>
                    <?= htmlspecialchars($category['cat_id']) ?>
                </td>

                <td>
                    <?= htmlspecialchars($category['cat_name']) ?>
                </td>

                <td>
                    <a href="category.php?edit_id=<?= (int) $category['cat_id'] ?>">
                        Edit
                    </a>
                </td>
            </tr>

        <?php endforeach; ?>

    </tbody>
</table>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>


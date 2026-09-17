<?php

require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';
require_once __DIR__ . '/../classes/CategoryClass.php';

$productController = new ProductController();
$categoryModel = new CategoryClass();

$brands = $productController->getAllBrands();
$categories = $categoryModel->getAllCategories();
$products = $productController->getAllProducts();

$success = isset($_GET['success']);
$error = $_GET['error'] ?? '';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Products</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f5f5f5;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
        }

        h1 {
            margin-bottom: 25px;
        }

        h2 {
            margin-top: 30px;
        }

        form {
            margin-bottom: 40px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            margin-bottom: 15px;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        button {
            padding: 10px 18px;
            cursor: pointer;
        }

        .success {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            margin-bottom: 15px;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #eee;
        }

        img {
            width: 70px;
            height: 70px;
            object-fit: cover;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Product Management</h1>

    <?php if ($success): ?>

        <div class="success">
            Product added successfully.
        </div>

    <?php endif; ?>

    <?php if ($error !== ''): ?>

        <div class="error">
            <?= htmlspecialchars($error) ?>
        </div>

    <?php endif; ?>


    <h2>Add Product</h2>

    <form
        method="POST"
        action="../actions/add_product_action.php"
        enctype="multipart/form-data"
    >

        <label for="product_cat">Category</label>

        <select name="product_cat" id="product_cat" required>

            <option value="">Select Category</option>

            <?php foreach ($categories as $category): ?>

                <option value="<?= (int) $category['cat_id'] ?>">
                    <?= htmlspecialchars($category['cat_name']) ?>
                </option>

            <?php endforeach; ?>

        </select>


        <label for="product_brand">Brand</label>

        <select name="product_brand" id="product_brand" required>

            <option value="">Select Brand</option>

            <?php foreach ($brands as $brand): ?>

                <option value="<?= (int) $brand['brand_id'] ?>">
                    <?= htmlspecialchars($brand['brand_name']) ?>
                </option>

            <?php endforeach; ?>

        </select>


        <label for="product_title">Product Title</label>

        <input
            type="text"
            id="product_title"
            name="product_title"
            required
        >


        <label for="product_price">Price</label>

        <input
            type="number"
            id="product_price"
            name="product_price"
            step="0.01"
            min="0"
            required
        >


        <label for="product_desc">Description</label>

        <textarea
            id="product_desc"
            name="product_desc"
        ></textarea>


        <label for="product_image">Product Image</label>

        <input
            type="file"
            id="product_image"
            name="product_image"
            accept=".jpg,.jpeg,.png,.gif,.webp"
        >


        <label for="product_keywords">Keywords</label>

        <input
            type="text"
            id="product_keywords"
            name="product_keywords"
            placeholder="Example: phone, smartphone, android"
        >


        <button type="submit">
            Add Product
        </button>

    </form>


    <h2>Existing Products</h2>

    <?php if (empty($products)): ?>

        <p>No products found.</p>

    <?php else: ?>

        <table>

            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Product</th>
                <th>Category</th>
                <th>Brand</th>
                <th>Price</th>
                <th>Description</th>
            </tr>

            <?php foreach ($products as $product): ?>

                <tr>

                    <td>
                        <?= (int) $product['product_id'] ?>
                    </td>

                    <td>

                        <?php if (!empty($product['product_image'])): ?>

                            <img
                                src="../images/products/<?= htmlspecialchars($product['product_image']) ?>"
                                alt="Product image"
                            >

                        <?php else: ?>

                            No image

                        <?php endif; ?>

                    </td>

                    <td>
                        <?= htmlspecialchars($product['product_title']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($product['cat_name'] ?? 'Unknown') ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($product['brand_name'] ?? 'Unknown') ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($product['product_price']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($product['product_desc'] ?? '') ?>
                    </td>

                </tr>

            <?php endforeach; ?>

        </table>

    <?php endif; ?>

</div>

</body>
</html>

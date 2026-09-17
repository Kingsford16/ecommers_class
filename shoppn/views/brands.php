<?php

require_once __DIR__ . '/../controllers/ProductController.php';

$controller = new ProductController();

$brands = $controller->getAllBrands();

$success = isset($_GET['success']);
$error = $_GET['error'] ?? '';

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Brands</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f5f5f5;
        }

        .container {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
        }

        h1 {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            margin-bottom: 10px;
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
            margin-top: 25px;
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

    </style>

</head>

<body>

<div class="container">

    <h1>Brand Management</h1>

    <?php if ($success): ?>

        <div class="success">
            Brand added successfully.
        </div>

    <?php endif; ?>

    <?php if ($error !== ''): ?>

        <div class="error">
            <?= htmlspecialchars($error) ?>
        </div>

    <?php endif; ?>


    <h2>Add Brand</h2>

    <form
        method="POST"
        action="../actions/add_brand_action.php"
    >

        <label for="brand_name">
            Brand Name
        </label>

        <input
            type="text"
            id="brand_name"
            name="brand_name"
            required
        >

        <button type="submit">
            Add Brand
        </button>

    </form>


    <h2>Existing Brands</h2>

    <?php if (empty($brands)): ?>

        <p>No brands found.</p>

    <?php else: ?>

        <table>

            <tr>
                <th>ID</th>
                <th>Brand Name</th>
            </tr>

            <?php foreach ($brands as $brand): ?>

                <tr>

                    <td>
                        <?= (int) $brand['brand_id'] ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($brand['brand_name']) ?>
                    </td>

                </tr>

            <?php endforeach; ?>

        </table>

    <?php endif; ?>

</div>

</body>

</html>


<?php
require_once __DIR__ . '/../../controllers/CartController.php';

$headerCartController = new CartController();
$headerCartIp = get_ip();

$headerCartCount = $headerCartController->getCartCount($headerCartIp);
$headerCartTotal = $headerCartController->getCartTotal($headerCartIp);

$baseUrl = app_base_url();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopPN</title>

    <link rel="stylesheet"
          href="<?= $baseUrl ?>/css/style.css">
</head>

<body>

<header>
    <nav>

        <a href="<?= $baseUrl ?>/index.php">
            Home
        </a>

        <a href="<?= $baseUrl ?>/views/cart.php">
            Cart (<?= (int) $headerCartCount ?>)
        </a>

        <?php if (is_logged_in()): ?>

            <span>
                Welcome, <?= htmlspecialchars(
                    $_SESSION['customer_name'] ?? '',
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
            </span>

            <a href="<?= $baseUrl ?>/views/account/my_account.php">
                My Account
            </a>

            <?php if (is_admin()): ?>

                <a href="<?= $baseUrl ?>/views/admin/brand.php">
                    Brands
                </a>

                <a href="<?= $baseUrl ?>/views/admin/category.php">
                    Categories
                </a>

                <a href="<?= $baseUrl ?>/views/admin/add_product.php">
                    Add Product
                </a>

                <a href="<?= $baseUrl ?>/views/admin/manage_products.php">
                    Manage Products
                </a>

            <?php endif; ?>

            <a href="<?= $baseUrl ?>/logout.php">
                Logout
            </a>

        <?php else: ?>

            <a href="<?= $baseUrl ?>/views/register.php">
                Register
            </a>

            <a href="<?= $baseUrl ?>/views/login.php">
                Login
            </a>

        <?php endif; ?>

    </nav>

    <div style="
        margin-top: 10px;
        padding: 8px 12px;
        background: #f5f5f5;
        border-radius: 5px;
        font-size: 14px;
        display: flex;
        flex-wrap: wrap;
        gap: 8px 18px;
        align-items: center;
    ">
        <strong>Shopping Cart</strong>

        <span>
            Total Items: <?= (int) $headerCartCount ?>
        </span>

        <span>
            Total Price: $<?= number_format((float) $headerCartTotal, 2) ?>
        </span>

        <a href="<?= $baseUrl ?>/views/cart.php">
            Go to Cart
        </a>
    </div>

    <?php
    $current_page = basename($_SERVER['PHP_SELF']);

    $search_pages = [
        'index.php',
        'single_product.php'
    ];
    ?>

    <?php if (
        is_logged_in() &&
        in_array($current_page, $search_pages, true)
    ): ?>

        <form
            action="<?= $baseUrl ?>/views/search_results.php"
            method="GET"
            style="margin: 15px 0; display: flex; gap: 8px; align-items: center;"
        >
            <label for="user_query">Search products:</label>

            <input
                type="text"
                id="user_query"
                name="user_query"
                placeholder="Enter product name or keyword"
                required
            >

            <button type="submit">Search</button>
        </form>

    <?php endif; ?>

</header>

<hr>

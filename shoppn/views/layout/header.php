
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopPN</title>

    <link rel="stylesheet" href="/ecommers_class/shoppn/css/style.css">
</head>

<body>

<header>
    <nav>

        <a href="/ecommers_class/shoppn/index.php">
            Home
        </a>

        <?php if (is_logged_in()): ?>

            <span>
                Welcome, <?= htmlspecialchars($_SESSION['customer_name']) ?>
            </span>

            <a href="/ecommers_class/shoppn/views/account/my_account.php">
                My Account
            </a>

            <?php if (is_admin()): ?>

                <a href="/ecommers_class/shoppn/views/admin/brand.php">
                    Brands
                </a>

                <a href="/ecommers_class/shoppn/views/admin/category.php">
                    Categories
                </a>

                <a href="/ecommers_class/shoppn/views/admin/add_product.php">
                    Add Product
                </a>

                <a href="/ecommers_class/shoppn/views/admin/manage_products.php">
                    Manage Products
                </a>

            <?php endif; ?>

            <a href="/ecommers_class/shoppn/logout.php">
                Logout
            </a>

        <?php else: ?>

            <a href="/ecommers_class/shoppn/views/register.php">
                Register
            </a>

            <a href="/ecommers_class/shoppn/views/login.php">
                Login
            </a>

        <?php endif; ?>

    </nav>

    <?php
    // Identify the current page.
    $current_page = basename($_SERVER['PHP_SELF']);

    // Pages where product search is useful.
        $search_pages = [
            'index.php',
            'single_product.php'
        ];
    ?>

    <?php if (
        is_logged_in() &&
        in_array($current_page, $search_pages, true)
    ): ?>

        <!-- Product Search Form -->
        <form
            action="/ecommers_class/shoppn/views/search_results.php"
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


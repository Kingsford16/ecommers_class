<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopPN</title>
    <link rel="stylesheet" href="/~kingsford.amissah/shoppn/css/style.css">
</head>

<body>

<header>
    <nav>
        <a href="/~kingsford.amissah/shoppn/index.php">Home</a>

        <?php if (is_logged_in()): ?>

            <span>Welcome, <?= htmlspecialchars($_SESSION['customer_name']) ?></span>
            <a href="/~kingsford.amissah/shoppn/views/account/my_account.php">
                My Account
            </a>
            <a href="/~kingsford.amissah/shoppn/logout.php">Logout</a>

        <?php else: ?>

            <a href="/~kingsford.amissah/shoppn/views/register.php">
                Register
            </a>
            <a href="/~kingsford.amissah/shoppn/views/login.php">
                Login
            </a>

        <?php endif; ?>

        <?php if (is_admin()): ?>

            <a href="/~kingsford.amissah/shoppn/views/admin/brand.php">
                Brands
            </a>
            <a href="/~kingsford.amissah/shoppn/views/admin/category.php">
                Categories
            </a>
            <a href="/~kingsford.amissah/shoppn/views/admin/product.php">
                Products
            </a>

        <?php endif; ?>
    </nav>
</header>

<hr>

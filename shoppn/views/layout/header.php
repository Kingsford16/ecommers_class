
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
                    Manage Brands
                </a>

                <a href="/ecommers_class/shoppn/views/admin/category.php">
                    Manage Categories
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
</header>

<hr>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopPN</title>

    <link rel="stylesheet" href="/ecommers_class/lab-register_and_login/css/style.css">
</head>

<body>

<header>
    <nav>

        <a href="/ecommers_class/lab-register_and_login/index.php">
            Home
        </a>

        <?php if (is_logged_in()): ?>

            <span>
                Welcome, <?= htmlspecialchars($_SESSION['customer_name']) ?>
            </span>

            <a href="/ecommers_class/lab-register_and_login/views/account/my_account.php">
                My Account
            </a>

            <a href="/ecommers_class/lab-register_and_login/logout.php">
                Logout
            </a>

        <?php else: ?>

            <a href="/ecommers_class/lab-register_and_login/views/register.php">
                Register
            </a>

            <a href="/ecommers_class/lab-register_and_login/views/login.php">
                Login
            </a>

        <?php endif; ?>

    </nav>
</header>

<hr>


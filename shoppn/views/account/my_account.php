<?php

require_once __DIR__ . '/../../core/core.php';

require_login();

?>

<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container">

    <h2>My Account</h2>

    <p>
        Welcome,
        <strong>
            <?= htmlspecialchars($_SESSION['customer_name'] ?? 'Customer') ?>
        </strong>
    </p>

    <p>You are successfully logged in.</p>

    <p>
        <a href="../../index.php">Continue Shopping</a>
    </p>

    <p>
        <a href="../../logout.php">Logout</a>
    </p>

</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>

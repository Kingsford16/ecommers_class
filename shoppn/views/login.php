<?php

require_once __DIR__ . '/../core/core.php';

$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);

?>

<?php require_once __DIR__ . '/layout/header.php'; ?>

<div class="container">

    <h2>Customer Login</h2>

    <?php if ($error): ?>
        <div class="error">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form action="../actions/login_action.php" method="POST" id="login-form">

        <div>
            <label for="email">Email:</label>
            <input
                type="email"
                id="email"
                name="email"
                required
            >
        </div>

        <br>

        <div>
            <label for="pass">Password:</label>
            <input
                type="password"
                id="pass"
                name="pass"
                required
            >
        </div>

        <br>

        <button type="submit">Login</button>

    </form>

    <p>
        Don't have an account?
        <a href="register.php">Register here</a>
    </p>

</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>

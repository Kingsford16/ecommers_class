<?php

require_once __DIR__ . '/../core/core.php';

$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);

?>

<?php require_once __DIR__ . '/layout/header.php'; ?>

<div class="container">

    <h2>Create an Account</h2>

    <?php if ($error): ?>
        <div class="error-message">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form
        id="register-form"
        action="../actions/register_action.php"
        method="POST"
    >

        <div class="form-group">
            <label for="name">Full Name</label>
            <input
                type="text"
                id="name"
                name="name"
                required
            >
            <small id="name-error"></small>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                required
            >
            <small id="email-error"></small>
        </div>

        <div class="form-group">
            <label for="pass">Password</label>
            <input
                type="password"
                id="pass"
                name="pass"
                required
            >
            <small id="pass-error"></small>
        </div>

        <div class="form-group">
            <label for="country">Country</label>

            <select
                id="country"
                name="country"
                required
            >
                <option value="">Select Country</option>
                <option value="Ghana">Ghana</option>
                <option value="Nigeria">Nigeria</option>
                <option value="Egypt">Egypt</option>
                <option value="Kenya">Kenya</option>
                <option value="South Africa">South Africa</option>
                <option value="United States">United States</option>
                <option value="United Kingdom">United Kingdom</option>
            </select>

            <small id="country-error"></small>
        </div>

        <div class="form-group">
            <label for="city">City</label>

            <input
                type="text"
                id="city"
                name="city"
                required
            >

            <small id="city-error"></small>
        </div>

        <div class="form-group">
            <label for="contact">Contact Number</label>

            <input
                type="text"
                id="contact"
                name="contact"
                required
            >

            <small id="contact-error"></small>
        </div>

        <button type="submit" id="register-button">
            Register
        </button>

    </form>

    <p>
        Already have an account?
        <a href="login.php">Login here</a>
    </p>

</div>

<script src="../js/validate.js"></script>

<?php require_once __DIR__ . '/layout/footer.php'; ?>

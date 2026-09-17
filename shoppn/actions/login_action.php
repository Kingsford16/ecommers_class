<?php

require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/CustomerController.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../views/login.php');
}

// Get submitted values
$email = trim(strip_tags($_POST['email'] ?? ''));
$pass = $_POST['pass'] ?? '';

// Basic server-side validation
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = 'Please enter a valid email address.';
    redirect('../views/login.php');
}

if ($pass === '') {
    $_SESSION['error'] = 'Please enter your password.';
    redirect('../views/login.php');
}

// Create controller
$controller = new CustomerController();

// Attempt login
$result = $controller->login($email, $pass);

// Successful login
if (isset($result['customer_id'])) {

    $_SESSION['customer_id'] = $result['customer_id'];
    $_SESSION['customer_name'] = $result['customer_name'];
    $_SESSION['customer_email'] = $result['customer_email'];
    $_SESSION['user_role'] = $result['user_role'];

    redirect('../index.php');
}

// Login failed
$_SESSION['error'] = $result['error'] ?? 'Invalid email or password.';

redirect('../views/login.php');

<?php

require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/CustomerController.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../views/register.php');
}

// Get and clean form data
$name = trim(strip_tags($_POST['name'] ?? ''));
$email = trim(strip_tags($_POST['email'] ?? ''));
$pass = $_POST['pass'] ?? '';
$country = trim(strip_tags($_POST['country'] ?? ''));
$city = trim(strip_tags($_POST['city'] ?? ''));
$contact = trim(strip_tags($_POST['contact'] ?? ''));

// Validate name
if ($name === '' || strlen($name) < 2 || strlen($name) > 100) {
    $_SESSION['error'] = 'Please enter a valid name.';
    redirect('../views/register.php');
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = 'Please enter a valid email address.';
    redirect('../views/register.php');
}

// Match the database VARCHAR(50)
if (strlen($email) > 50) {
    $_SESSION['error'] = 'Email address must not exceed 50 characters.';
    redirect('../views/register.php');
}

// Validate password
if (strlen($pass) < 8) {
    $_SESSION['error'] = 'Password must be at least 8 characters.';
    redirect('../views/register.php');
}

// Validate country
if ($country === '' || strlen($country) > 30) {
    $_SESSION['error'] = 'Please enter a valid country.';
    redirect('../views/register.php');
}

// Validate city
if ($city === '' || strlen($city) > 30) {
    $_SESSION['error'] = 'Please enter a valid city.';
    redirect('../views/register.php');
}

// Validate contact
if ($contact === '' || strlen($contact) > 15) {
    $_SESSION['error'] = 'Please enter a valid contact number.';
    redirect('../views/register.php');
}

// Put the validated data into an array
$data = [
    'name' => $name,
    'email' => $email,
    'pass' => $pass,
    'country' => $country,
    'city' => $city,
    'contact' => $contact
];

// Send the data to the Controller
$controller = new CustomerController();
$result = $controller->register($data);

// Registration successful
if ($result['success']) {

    $_SESSION['customer_id'] = $result['customer_id'];
    $_SESSION['customer_name'] = $data['name'];
    $_SESSION['customer_email'] = $data['email'];
    $_SESSION['user_role'] = 2;

    redirect('../views/account/my_account.php');
}   
// Registration failed
$_SESSION['error'] = $result['error'] ?? 'Registration failed. Please try again.';

redirect('../views/register.php');
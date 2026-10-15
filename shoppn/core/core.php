
<?php

session_start();

date_default_timezone_set('Africa/Accra');

require_once __DIR__ . '/db_class.php';

// Detect whether ShopPN is running locally or on the remote server.
function app_base_url()
{
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';

    if (
        $host === 'localhost' ||
        str_starts_with($host, 'localhost:') ||
        str_starts_with($host, '127.0.0.1')
    ) {
        return '/ecommers_class/shoppn';
    }

    return '/~kingsford.amissah/ecommers_class/shoppn';
}

function get_ip()
{
    return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}

function redirect($url)
{
    header('Location: ' . $url);
    exit;
}

function is_logged_in()
{
    return isset($_SESSION['customer_id']);
}

function is_admin()
{
    return isset($_SESSION['user_role']) && (int) $_SESSION['user_role'] === 1;
}

function require_login()
{
    if (!is_logged_in()) {
        redirect(app_base_url() . '/views/login.php');
    }
}

function require_admin()
{
    if (!is_admin()) {
        $_SESSION['error'] = 'You do not have permission to access that page.';
        redirect(app_base_url() . '/index.php');
    }
}

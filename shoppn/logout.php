
<?php

require_once __DIR__ . '/core/core.php';

session_unset();
session_destroy();

header('Location: ' . app_base_url() . '/index.php');
exit;

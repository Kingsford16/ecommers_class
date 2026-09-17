<?php

$host = "localhost";
$db_user = "kingsford.amissah";
$db_pass = "0204312003";
$db_name = "ecommerce_2026A_kingsford_amissah";

$conn = new mysqli($host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

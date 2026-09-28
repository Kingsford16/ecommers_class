<?php

session_start();

session_unset();
session_destroy();

header('Location: /ecommers_class/lab-register_and_login/index.php');
exit;

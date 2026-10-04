<?php

session_start();

session_unset();
session_destroy();

header('Location: /ecommers_class/shoppn/index.php');
exit;
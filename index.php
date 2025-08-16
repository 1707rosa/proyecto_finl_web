<?php
session_start();
    // No logueado → Login
    header("Location: modules/auth/login.php");

exit;

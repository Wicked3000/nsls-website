<?php
// auth guard — include at top of every protected page
session_start();
if (empty($_SESSION['nsls_admin'])) {
    header('Location: login.php');
    exit;
}

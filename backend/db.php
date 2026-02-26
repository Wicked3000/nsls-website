<?php
// ============================================================
//  NSLS — Database Connection Configuration
// ============================================================

define('DB_HOST', 'localhost');
define('DB_USER', 'root');        // Default XAMPP MySQL user
define('DB_PASS', '');            // Default XAMPP MySQL password (blank)
define('DB_NAME', 'nsls_db');
define('DB_CHARSET', 'utf8mb4');

// Set Timezone to Papua New Guinea
date_default_timezone_set('Pacific/Port_Moresby');

function getDB(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        $dsn = "mysql:host=" . DB_HOST . ";charset=" . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "`");
            $pdo->exec("USE `" . DB_NAME . "`");

            // Ensure required tables exist
            $pdo->exec("
                CREATE TABLE IF NOT EXISTS offices (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(255) NOT NULL,
                    type ENUM('head_office', 'branch') DEFAULT 'branch',
                    address TEXT,
                    phone VARCHAR(50),
                    fax VARCHAR(50),
                    email VARCHAR(150),
                    latitude DECIMAL(10, 6),
                    longitude DECIMAL(10, 6)
                );
            ");
            $pdo->exec("
                CREATE TABLE IF NOT EXISTS downloads (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    title VARCHAR(255) NOT NULL,
                    category ENUM('form', 'brochure') DEFAULT 'form',
                    file_path VARCHAR(255) NOT NULL,
                    file_size VARCHAR(50)
                );
            ");
            $pdo->exec("
                CREATE TABLE IF NOT EXISTS admins (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    username VARCHAR(50) NOT NULL UNIQUE,
                    password_hash VARCHAR(255) NOT NULL
                );
            ");

            // Seed admin if none exists
            $adminCount = $pdo->query("SELECT COUNT(*) FROM admins")->fetchColumn();
            if ($adminCount == 0) {
                // Default: admin / nsls2026
                $hash = password_hash('nsls2026', PASSWORD_DEFAULT);
                $pdo->exec("INSERT INTO admins (username, password_hash) VALUES ('admin', '$hash')");
            }

        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
            exit;
        }
    }

    return $pdo;
}

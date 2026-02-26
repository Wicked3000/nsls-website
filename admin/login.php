<?php
session_start();

require_once __DIR__ . '/../backend/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['username'] ?? '');
    $pass = trim($_POST['password'] ?? '');

    try {
        $pdo = getDB();
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->execute([$user]);
        $adminRow = $stmt->fetch();

        if ($adminRow && password_verify($pass, $adminRow['password_hash'])) {
            $_SESSION['nsls_admin'] = true;
            $_SESSION['admin_user'] = $adminRow['username'];
            $_SESSION['admin_id'] = $adminRow['id'];
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Invalid username or password.';
        }
    } catch (Exception $e) {
        $error = 'System error: ' . $e->getMessage();
    }
}

if (!empty($_SESSION['nsls_admin'])) {
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | NSLS</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #0a0f1e;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Animated background */
        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 20% 30%, rgba(0, 102, 204, 0.18) 0%, transparent 70%),
                radial-gradient(ellipse 60% 50% at 80% 70%, rgba(0, 180, 120, 0.12) 0%, transparent 70%);
            z-index: 0;
        }

        .login-card {
            position: relative;
            z-index: 1;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 48px 44px;
            width: 420px;
            box-shadow: 0 32px 80px rgba(0, 0, 0, 0.5);
        }

        .login-logo {
            text-align: center;
            margin-bottom: 32px;
        }

        .login-logo img {
            width: 140px;
            height: 140px;
            object-fit: contain;
            border-radius: 18px;
            filter: drop-shadow(0 6px 20px rgba(0, 102, 204, 0.45));
            margin-bottom: 8px;
        }

        .login-logo h1 {
            color: #fff;
            font-size: 1.4rem;
            font-weight: 700;
            margin-top: 12px;
        }

        .login-logo p {
            color: rgba(255, 255, 255, 0.45);
            font-size: 0.82rem;
            margin-top: 4px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.78rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 8px;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.3);
            font-size: 0.85rem;
        }

        .form-group input {
            width: 100%;
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 10px;
            padding: 12px 14px 12px 40px;
            color: #fff;
            font-size: 0.9rem;
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: border-color 0.2s, background 0.2s;
        }

        .form-group input:focus {
            border-color: #0066cc;
            background: rgba(0, 102, 204, 0.08);
        }

        .form-group input::placeholder {
            color: rgba(255, 255, 255, 0.2);
        }

        .error-msg {
            background: rgba(220, 53, 69, 0.15);
            border: 1px solid rgba(220, 53, 69, 0.4);
            color: #ff6b7a;
            border-radius: 10px;
            padding: 11px 14px;
            font-size: 0.84rem;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, #0066cc, #0052a3);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 13px;
            font-size: 0.95rem;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            margin-top: 8px;
            transition: opacity 0.2s, transform 0.15s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-login:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: rgba(255, 255, 255, 0.35);
            font-size: 0.82rem;
            text-decoration: none;
            transition: color 0.2s;
        }

        .back-link a:hover {
            color: rgba(255, 255, 255, 0.7);
        }
    </style>
</head>

<body>
    <div class="login-card">
        <div class="login-logo">
            <img src="../images/Logo.jpg" alt="NSLS Logo">
            <h1>NSLS Admin</h1>
            <p>Secure Administrator Portal</p>
        </div>

        <?php if ($error): ?>
            <div class="error-msg"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" autocomplete="off">
            <div class="form-group">
                <label>Username</label>
                <div class="input-wrap">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" placeholder="Enter username" required autofocus>
                </div>
            </div>
            <div class="form-group">
                <label>Password</label>
                <div class="input-wrap">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Enter password" required>
                </div>
            </div>
            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i> Sign In
            </button>
        </form>
        <div class="back-link">
            <a href="../index.html"><i class="fas fa-arrow-left"></i> Back to Website</a>
        </div>
    </div>
</body>

</html>
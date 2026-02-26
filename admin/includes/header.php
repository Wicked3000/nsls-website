<?php
// $pageTitle and $activePage must be set before including this file
$pageTitle = $pageTitle ?? 'Dashboard';
$activePage = $activePage ?? 'dashboard';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= htmlspecialchars($pageTitle) ?> | NSLS Admin
    </title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg-dark: #f4f7f6;
            --bg-sidebar: #ffffff;
            --bg-panel: #ffffff;
            --bg-panel-hover: #f9fafa;
            --border: #e0e6ed;
            --blue: #8bc34a;
            --blue-hover: #7cb342;
            --green: #4caf50;
            --yellow: #ff9800;
            --red: #f44336;
            --text: #2d3748;
            --muted: #718096;
            --sidebar-w: 272px;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            height: 100%;
            font-family: 'Inter', sans-serif;
            background: var(--bg-dark);
            color: var(--text);
            overflow-x: hidden;
        }

        body {
            display: flex;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* ── Ambient background ── */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            background:
                radial-gradient(circle at 12% 50%, rgba(139, 195, 74, 0.08) 0%, transparent 45%),
                radial-gradient(circle at 88% 25%, rgba(124, 179, 66, 0.05) 0%, transparent 40%);
        }

        /* ── Sidebar ── */
        .sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: var(--bg-sidebar);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 100;
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .logo-wrap {
            padding: 40px 0 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            border-bottom: 1px solid var(--border);
            width: 100%;
        }

        .logo-wrap img {
            width: 90%;
            max-width: 220px;
            height: auto;
            max-height: 140px;
            object-fit: contain;
            display: block;
            margin: 0 auto;
        }

        .nav-section {
            padding: 20px 14px;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .nav-label {
            font-size: 0.65rem;
            font-weight: 600;
            color: var(--muted);
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 12px 10px 6px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 12px;
            color: var(--muted);
            font-size: 0.92rem;
            font-weight: 500;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .nav-link i {
            width: 18px;
            text-align: center;
            font-size: 1rem;
        }

        .nav-link:hover {
            background: var(--bg-panel-hover);
            color: var(--text);
        }

        .nav-link.active {
            background: linear-gradient(135deg, var(--blue), var(--blue-hover));
            color: #fff;
            box-shadow: 0 4px 16px rgba(0, 102, 204, 0.28);
        }

        .sidebar-footer {
            padding: 18px 14px;
            border-top: 1px solid var(--border);
        }

        .logout-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 12px;
            color: var(--red);
            font-size: 0.92rem;
            font-weight: 500;
            transition: background 0.2s;
        }

        .logout-link:hover {
            background: rgba(232, 69, 69, 0.1);
        }

        /* ── Page wrapper ── */
        .page-wrap {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            position: relative;
            z-index: 1;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ── Top bar ── */
        .topbar {
            position: sticky;
            top: 0;
            z-index: 50;
            padding: 28px 36px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--border);
        }

        .topbar-left h2 {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .topbar-left h2 span {
            color: var(--blue);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .topbar-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: var(--bg-panel);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--blue);
            font-size: 1.1rem;
            transition: transform 0.2s;
            cursor: pointer;
        }

        .topbar-avatar:hover {
            transform: scale(1.07);
        }

        /* ── Content area ── */
        .content {
            padding: 36px;
            flex: 1;
        }

        /* ── Cards / Panels ── */
        .panel {
            background: var(--bg-panel);
            border: 1px solid var(--border);
            border-radius: 20px;
            backdrop-filter: blur(12px);
        }

        .panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 22px 26px;
            border-bottom: 1px solid var(--border);
        }

        .panel-header h3 {
            font-size: 1.05rem;
            font-weight: 600;
        }

        .panel-body {
            padding: 26px;
        }

        /* ── Buttons ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 0.88rem;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--blue), var(--blue-hover));
            color: #fff;
            box-shadow: 0 4px 14px rgba(0, 102, 204, 0.25);
        }

        .btn-primary:hover {
            opacity: 0.88;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: var(--bg-panel);
            border: 1px solid var(--border);
            color: var(--text);
        }

        .btn-secondary:hover {
            background: var(--bg-panel-hover);
        }

        .btn-danger {
            background: rgba(232, 69, 69, 0.12);
            border: 1px solid rgba(232, 69, 69, 0.25);
            color: var(--red);
        }

        .btn-danger:hover {
            background: rgba(232, 69, 69, 0.22);
        }

        .btn-sm {
            padding: 7px 14px;
            font-size: 0.82rem;
            border-radius: 8px;
        }

        .btn-icon {
            padding: 8px;
            min-width: unset;
            border-radius: 8px;
        }

        /* ── Table ── */
        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            padding: 13px 16px;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        td {
            padding: 14px 16px;
            font-size: 0.92rem;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tbody tr:hover {
            background: var(--bg-panel-hover);
        }

        /* ── Badges ── */
        .badge {
            display: inline-block;
            padding: 4px 11px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.04em;
        }

        .badge-green {
            background: rgba(0, 180, 120, 0.15);
            color: var(--green);
        }

        .badge-yellow {
            background: rgba(245, 166, 35, 0.15);
            color: var(--yellow);
        }

        .badge-red {
            background: rgba(232, 69, 69, 0.15);
            color: var(--red);
        }

        .badge-blue {
            background: rgba(0, 102, 204, 0.15);
            color: var(--blue);
        }

        /* ── Form elements ── */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.07em;
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 11px 14px;
            color: var(--text);
            font-size: 0.9rem;
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(139, 195, 74, 0.15);
        }

        .form-control::placeholder {
            color: var(--muted);
        }

        select.form-control {
            appearance: none;
            cursor: pointer;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        /* ── Grid ── */
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        /* ── Alert ── */
        .alert {
            padding: 13px 18px;
            border-radius: 10px;
            font-size: 0.88rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: rgba(0, 180, 120, 0.12);
            border: 1px solid rgba(0, 180, 120, 0.3);
            color: var(--green);
        }

        .alert-error {
            background: rgba(232, 69, 69, 0.12);
            border: 1px solid rgba(232, 69, 69, 0.3);
            color: var(--red);
        }

        /* ── Modal ── */
        .modal-overlay {
            position: fixed;
            inset: 0;
            z-index: 200;
            background: rgba(0, 0, 0, 0.65);
            backdrop-filter: blur(6px);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.25s;
        }

        .modal-overlay.open {
            opacity: 1;
            pointer-events: all;
        }

        .modal {
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: 22px;
            width: 560px;
            max-width: 95vw;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.6);
            transform: scale(0.94);
            transition: transform 0.25s;
        }

        .modal-overlay.open .modal {
            transform: scale(1);
        }

        .modal-header {
            padding: 24px 28px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-header h3 {
            font-size: 1.1rem;
            font-weight: 700;
        }

        .modal-close {
            background: none;
            border: none;
            color: var(--muted);
            font-size: 1.3rem;
            cursor: pointer;
            transition: color 0.2s;
            line-height: 1;
        }

        .modal-close:hover {
            color: var(--text);
        }

        .modal-body {
            padding: 28px;
        }

        .modal-footer {
            padding: 20px 28px;
            border-top: 1px solid var(--border);
            display: flex;
            gap: 12px;
            justify-content: flex-end;
        }

        /* ── Toast ── */
        #toast-container {
            position: fixed;
            bottom: 28px;
            right: 28px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .toast {
            min-width: 280px;
            padding: 14px 18px;
            border-radius: 12px;
            font-size: 0.88rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            animation: slideUp 0.3s ease;
        }

        .toast-success {
            background: #e8f5e9;
            border: 1px solid rgba(139, 195, 74, 0.4);
            color: var(--green);
        }

        .toast-error {
            background: #ffebee;
            border: 1px solid rgba(244, 67, 54, 0.4);
            color: var(--red);
        }

        @keyframes slideUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* ── Collapsed Sidebar ── */
        body.sidebar-collapsed .sidebar {
            width: 84px;
        }

        body.sidebar-collapsed .page-wrap {
            margin-left: 84px;
        }

        body.sidebar-collapsed .logo-wrap {
            padding: 32px 0;
            border-bottom: 1px solid var(--border);
            height: 97px;
        }

        body.sidebar-collapsed .logo-wrap img {
            display: none;
        }

        body.sidebar-collapsed .logo-wrap::after {
            content: 'N';
            font-family: 'Inter', sans-serif;
            font-weight: 900;
            font-size: 2.2rem;
            color: var(--blue);
            display: block;
        }

        body.sidebar-collapsed .nav-label,
        body.sidebar-collapsed .nav-link span,
        body.sidebar-collapsed .logout-link span {
            display: none !important;
        }

        body.sidebar-collapsed .nav-link,
        body.sidebar-collapsed .logout-link {
            justify-content: center;
            padding: 14px;
            margin-bottom: 6px;
        }

        body.sidebar-collapsed .nav-link i,
        body.sidebar-collapsed .logout-link i {
            margin: 0;
            font-size: 1.3rem;
        }

        body.sidebar-collapsed .sidebar-footer {
            padding: 18px 0;
            display: flex;
            justify-content: center;
        }

        @media (max-width: 900px) {
            .sidebar {
                width: 70px;
            }

            .logo-wrap .brand,
            .nav-link span,
            .nav-label,
            .logout-link span,
            .sidebar-footer span {
                display: none;
            }

            .nav-link {
                justify-content: center;
                padding: 14px;
            }

            .nav-link i {
                margin: 0;
            }

            .page-wrap {
                margin-left: 70px;
            }
        }
    </style>
</head>

<body>
    <script>
        if (localStorage.getItem('sidebar-collapsed') === 'true') {
            document.body.classList.add('sidebar-collapsed');
        }
    </script>

    <aside class="sidebar">
        <div class="logo-wrap">
            <img src="../images/Logo.jpg" alt="NSLS Logo">
        </div>
        <nav class="nav-section">
            <div class="nav-label">Main</div>
            <a href="dashboard.php" class="nav-link <?= $activePage === 'dashboard' ? 'active' : '' ?>">
                <i class="fas fa-chart-pie"></i><span>Dashboard</span>
            </a>
            <div class="nav-label">Management</div>
            <a href="offices.php" class="nav-link <?= $activePage === 'offices' ? 'active' : '' ?>">
                <i class="fas fa-building"></i><span>Offices</span>
            </a>
            <a href="downloads.php" class="nav-link <?= $activePage === 'downloads' ? 'active' : '' ?>">
                <i class="fas fa-file-pdf"></i><span>Forms &amp; Brochures</span>
            </a>
            <a href="messages.php" class="nav-link <?= $activePage === 'messages' ? 'active' : '' ?>">
                <i class="fas fa-envelope-open-text"></i><span>Messages</span>
                <?php
                // badge for unread messages
                try {
                    $pdo = getDB();
                    $unread = $pdo->query("SELECT COUNT(*) FROM contacts WHERE is_read=0")->fetchColumn();
                    if ($unread > 0)
                        echo '<span style="margin-left:auto;background:var(--red);color:#fff;border-radius:20px;padding:2px 8px;font-size:0.7rem;font-weight:700;">' . $unread . '</span>';
                } catch (Exception $e) {
                }
                ?>
            </a>
            <div class="nav-label">System</div>
            <a href="settings.php" class="nav-link <?= $activePage === 'settings' ? 'active' : '' ?>">
                <i class="fas fa-cog"></i><span>Settings</span>
            </a>
        </nav>
        <div class="sidebar-footer">
            <a href="logout.php" class="logout-link">
                <i class="fas fa-sign-out-alt"></i><span>Logout</span>
            </a>
        </div>
    </aside>

    <div class="page-wrap">
        <header class="topbar">
            <div class="topbar-left" style="display:flex;align-items:center;gap:18px;">
                <button id="sidebarToggle"
                    style="background:none;border:none;font-size:1.4rem;color:var(--text);cursor:pointer;padding:4px 8px;border-radius:8px;transition:0.2s;"
                    onmouseover="this.style.background='var(--bg-panel-hover)'"
                    onmouseout="this.style.background='none'">
                    <i class="fas fa-bars"></i>
                </button>
                <h2 style="margin:0;">
                    <?= htmlspecialchars($pageTitle) ?> &mdash; <span>NSLS Admin</span>
                </h2>
            </div>
            <div class="topbar-right">
                <div class="topbar-avatar" title="<?= htmlspecialchars($_SESSION['admin_user'] ?? 'Admin') ?>">
                    <i class="fas fa-user-shield"></i>
                </div>
            </div>
        </header>
        <div class="content">

            <!-- *** PAGE CONTENT STARTS BELOW *** -->
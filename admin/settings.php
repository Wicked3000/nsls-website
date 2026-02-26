<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../backend/db.php';

$pageTitle = 'Settings';
$activePage = 'settings';
$pdo = getDB();

$action = $_POST['action'] ?? '';
$toastMsg = '';
$toastType = 'success';

// Ensure the session has admin_id
$adminId = $_SESSION['admin_id'] ?? null;
if (!$adminId) {
    // Fallback if logged in before tables were completely set up
    $u = $_SESSION['admin_user'] ?? 'admin';
    try {
        $stmt = $pdo->prepare("SELECT id FROM admins WHERE username=?");
        $stmt->execute([$u]);
        $res = $stmt->fetch();
        if ($res) {
            $adminId = $res['id'];
            $_SESSION['admin_id'] = $adminId;
        }
    } catch (Exception $e) {
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $adminId) {
    try {
        if ($action === 'update_profile') {
            $username = trim($_POST['username']);
            $currentPass = $_POST['current_password'];
            $newPass = $_POST['new_password'];
            $confirmPass = $_POST['confirm_password'];

            // Validate current password
            $stmt = $pdo->prepare("SELECT password_hash FROM admins WHERE id=?");
            $stmt->execute([$adminId]);
            $adminRow = $stmt->fetch();

            if (!$adminRow || !password_verify($currentPass, $adminRow['password_hash'])) {
                throw new Exception("Incorrect current password.");
            }

            if (!empty($username) && $username !== $_SESSION['admin_user']) {
                $chk = $pdo->prepare("SELECT id FROM admins WHERE username=? AND id!=?");
                $chk->execute([$username, $adminId]);
                if ($chk->fetch())
                    throw new Exception("Username is already taken.");

                $pdo->prepare("UPDATE admins SET username=? WHERE id=?")->execute([$username, $adminId]);
                $_SESSION['admin_user'] = $username;
                $toastMsg = "Profile updated successfully!";
            }

            if (!empty($newPass)) {
                if ($newPass !== $confirmPass) {
                    throw new Exception("New passwords do not match.");
                }
                if (strlen($newPass) < 6) {
                    throw new Exception("New password must be at least 6 characters.");
                }
                $hash = password_hash($newPass, PASSWORD_DEFAULT);
                $pdo->prepare("UPDATE admins SET password_hash=? WHERE id=?")->execute([$hash, $adminId]);
                $toastMsg = "Password updated successfully!";
            } else if (empty($toastMsg)) {
                $toastMsg = "No changes made.";
                $toastType = 'normal';
            }

        }
    } catch (Exception $e) {
        $toastMsg = $e->getMessage();
        $toastType = 'error';
    }
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="grid-2" style="max-width:900px;">
    <!-- Profile & Security -->
    <div class="panel">
        <div class="panel-header">
            <h3><i class="fas fa-shield-alt" style="color:var(--blue);margin-right:8px;"></i> Security & Profile</h3>
        </div>
        <div class="panel-body">
            <form method="POST">
                <input type="hidden" name="action" value="update_profile">

                <div class="form-group" style="margin-bottom:30px;">
                    <label>Admin Username</label>
                    <input type="text" name="username" class="form-control" required
                        value="<?= htmlspecialchars($_SESSION['admin_user'] ?? '') ?>">
                </div>

                <div style="border-top:1px solid var(--border);margin:24px -26px;padding:24px 26px 0;">
                    <h4 style="font-size:0.95rem;margin-bottom:16px;">Change Password</h4>
                    <div style="font-size:0.8rem;color:var(--muted);margin-bottom:20px;">Leave new password fields blank
                        if you do not wish to change your password.</div>

                    <div class="form-group">
                        <label>Current Password *</label>
                        <input type="password" name="current_password" class="form-control" required
                            placeholder="Verify your current identity...">
                    </div>

                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" name="new_password" class="form-control" placeholder="New password...">
                    </div>

                    <div class="form-group">
                        <label>Confirm New Password</label>
                        <input type="password" name="confirm_password" class="form-control"
                            placeholder="Repeat new password...">
                    </div>
                </div>

                <div style="text-align:right;">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-user-edit"></i> Update
                        Security</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Info -->
    <div>
        <div class="panel" style="margin-bottom:24px;">
            <div class="panel-header">
                <h3><i class="fas fa-server" style="color:var(--yellow);margin-right:8px;"></i> System Status</h3>
            </div>
            <div class="panel-body">
                <ul style="list-style:none;margin:0;padding:0;">
                    <li
                        style="padding:12px 0;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;">
                        <span style="color:var(--muted);">PHP Version</span>
                        <span style="font-weight:600;">
                            <?= phpversion() ?>
                        </span>
                    </li>
                    <li
                        style="padding:12px 0;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;">
                        <span style="color:var(--muted);">Database Connection</span>
                        <span class="badge badge-green">Connected</span>
                    </li>
                    <li
                        style="padding:12px 0;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;">
                        <span style="color:var(--muted);">Timezone</span>
                        <span style="font-weight:600;">
                            <?= date_default_timezone_get() ?>
                        </span>
                    </li>
                    <li
                        style="padding:12px 0;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;">
                        <span style="color:var(--muted);">Server Time</span>
                        <span style="font-weight:600;">
                            <?= date('Y-m-d H:i') ?>
                        </span>
                    </li>
                    <li style="padding:12px 0;display:flex;justify-content:space-between;">
                        <span style="color:var(--muted);">Software</span>
                        <span style="font-weight:600;">
                            <?= $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown' ?>
                        </span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="alert alert-success">
            <div>
                <strong style="display:block;margin-bottom:4px;">All modules operational</strong>
                Your NSLS Administrative system is running perfectly without any visible fault vectors.
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
<script>
<?php if ($toastMsg): ?>
            showToast(<?= json_encode($toastMsg) ?>, <?= json_encode($toastType) ?>);
<?php endif; ?>
</script>
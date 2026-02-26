<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../backend/db.php';

$pageTitle = 'Messages / Inquiries';
$activePage = 'messages';
$pdo = getDB();

$action = $_POST['action'] ?? '';
$toastMsg = '';
$toastType = 'success';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($action)) {
    try {
        if ($action === 'delete') {
            $stmt = $pdo->prepare("DELETE FROM contacts WHERE id=?");
            $stmt->execute([$_POST['id']]);
            $toastMsg = "Message deleted successfully!";
        }
    } catch (Exception $e) {
        $toastMsg = "Error: " . $e->getMessage();
        $toastType = 'error';
    }
}

// ── Mark as read if viewing ──
$viewId = $_GET['view'] ?? null;
if ($viewId) {
    try {
        $pdo->prepare("UPDATE contacts SET is_read=1 WHERE id=?")->execute([$viewId]);
        // Also fetch the specific message to view
        $stmt = $pdo->prepare("SELECT * FROM contacts WHERE id=?");
        $stmt->execute([$viewId]);
        $viewingMsg = $stmt->fetch();
    } catch (Exception $e) {
    }
}

$messages = $pdo->query("SELECT * FROM contacts ORDER BY created_at DESC")->fetchAll();

require_once __DIR__ . '/includes/header.php';
?>

<div
    style="display:grid;grid-template-columns:<?= $viewId && isset($viewingMsg) && $viewingMsg ? '1fr 1.5fr' : '1fr' ?>;gap:24px;">

    <!-- Inbox List -->
    <div class="panel" style="display:flex;flex-direction:column;max-height:calc(100vh - 120px);overflow:hidden;">
        <div class="panel-header" style="flex-shrink:0;">
            <h3><i class="fas fa-inbox" style="color:var(--yellow);margin-right:8px;"></i> Inbox</h3>
            <span class="badge badge-yellow">
                <?= count($messages) ?> Total
            </span>
        </div>
        <div style="overflow-y:auto;flex:1;">
            <?php foreach ($messages as $m): ?>
                <?php $isActive = ($viewId == $m['id']); ?>
                <a href="messages.php?view=<?= $m['id'] ?>"
                    style="display:flex;gap:14px;padding:20px 24px;border-bottom:1px solid var(--border);background:<?= $isActive ? 'var(--bg-panel-hover)' : 'transparent' ?>;transition:background 0.2s;">
                    <div
                        style="width:10px;height:10px;border-radius:50%;margin-top:5px;flex-shrink:0;background:<?= $m['is_read'] ? 'var(--bg-panel)' : 'var(--blue)' ?>;">
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;">
                            <span
                                style="font-size:0.95rem;font-weight:<?= $m['is_read'] ? '400' : '700' ?>;color:<?= $m['is_read'] ? 'var(--muted)' : 'var(--text)' ?>;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                <?= htmlspecialchars($m['name']) ?>
                            </span>
                            <span style="font-size:0.75rem;color:var(--muted);white-space:nowrap;">
                                <?= date('M j, g:i A', strtotime($m['created_at'])) ?>
                            </span>
                        </div>
                        <div
                            style="font-size:0.85rem;color:<?= $m['is_read'] ? 'var(--muted)' : 'calc(var(--muted)/.8)' ?>;margin-bottom:4px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            <?= htmlspecialchars($m['subject']) ?>
                        </div>
                        <div
                            style="font-size:0.8rem;color:var(--muted);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-weight:300;">
                            <?= htmlspecialchars(substr($m['message'], 0, 80)) ?>...
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
            <?php if (empty($messages)): ?>
                <div style="padding:40px;text-align:center;color:var(--muted);">
                    <i class="fas fa-inbox" style="font-size:3rem;margin-bottom:16px;opacity:0.3;"></i>
                    <p>Your inbox is empty.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Reading Pane -->
    <?php if ($viewId && !empty($viewingMsg)): ?>
        <div class="panel" style="display:flex;flex-direction:column;max-height:calc(100vh - 120px);overflow:hidden;">
            <div class="panel-header" style="flex-shrink:0;">
                <h3>Message Details</h3>
                <div style="display:flex;gap:10px;">
                    <a href="mailto:<?= htmlspecialchars($viewingMsg['email']) ?>" class="btn btn-primary btn-sm"><i
                            class="fas fa-reply"></i> Reply</a>
                    <form method="POST" style="margin:0;" onsubmit="return confirm('Delete this message permanently?');">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= $viewingMsg['id'] ?>">
                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</button>
                    </form>
                    <a href="messages.php" class="btn btn-secondary btn-sm btn-icon"><i class="fas fa-times"></i></a>
                </div>
            </div>
            <div style="padding:40px 32px;overflow-y:auto;flex:1;">
                <div style="font-size:1.4rem;font-weight:700;margin-bottom:20px;line-height:1.3;">
                    <?= htmlspecialchars($viewingMsg['subject']) ?>
                </div>

                <div
                    style="display:flex;align-items:center;gap:16px;margin-bottom:32px;padding-bottom:24px;border-bottom:1px solid var(--border);">
                    <div
                        style="width:48px;height:48px;border-radius:50%;background:#f1f8e9;color:var(--blue);display:flex;align-items:center;justify-content:center;font-size:1.2rem;font-weight:700;">
                        <?= strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $viewingMsg['name']), 0, 1) ?: '?') ?>
                    </div>
                    <div>
                        <div style="font-weight:600;font-size:1rem;margin-bottom:2px;">
                            <?= htmlspecialchars($viewingMsg['name']) ?>
                        </div>
                        <div style="font-size:0.85rem;color:var(--muted);">
                            <a href="mailto:<?= htmlspecialchars($viewingMsg['email']) ?>"
                                style="color:var(--blue);text-decoration:none;">&lt;
                                <?= htmlspecialchars($viewingMsg['email']) ?>&gt;
                            </a>
                            &nbsp;&bull;&nbsp;
                            <?= date('F j, Y, g:i a', strtotime($viewingMsg['created_at'])) ?>
                        </div>
                    </div>
                </div>

                <div style="font-size:0.95rem;line-height:1.7;color:var(--text);white-space:pre-wrap;font-weight:400;">
                    <?= htmlspecialchars($viewingMsg['message']) ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
<script>
    <?php if ($toastMsg): ?>
        showToast(<?= json_encode($toastMsg) ?>, <?= json_encode($toastType) ?>);
    <?php endif; ?>
</script>
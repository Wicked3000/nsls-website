<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../backend/db.php';

$pageTitle = 'Manage Offices';
$activePage = 'offices';
$pdo = getDB();

// ── Handle Actions ──
$action = $_POST['action'] ?? '';
$toastMsg = '';
$toastType = 'success';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($action)) {
    try {
        if ($action === 'add') {
            $stmt = $pdo->prepare("INSERT INTO offices (name, type, address, phone, fax, email, latitude, longitude) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                trim($_POST['name']),
                trim($_POST['type']),
                trim($_POST['address']),
                trim($_POST['phone']) ?: null,
                trim($_POST['fax']) ?: null,
                trim($_POST['email']) ?: null,
                $_POST['latitude'] ?: null,
                $_POST['longitude'] ?: null
            ]);
            $toastMsg = "Office added successfully!";
        } elseif ($action === 'edit') {
            $stmt = $pdo->prepare("UPDATE offices SET name=?, type=?, address=?, phone=?, fax=?, email=?, latitude=?, longitude=? WHERE id=?");
            $stmt->execute([
                trim($_POST['name']),
                trim($_POST['type']),
                trim($_POST['address']),
                trim($_POST['phone']) ?: null,
                trim($_POST['fax']) ?: null,
                trim($_POST['email']) ?: null,
                $_POST['latitude'] ?: null,
                $_POST['longitude'] ?: null,
                $_POST['id']
            ]);
            $toastMsg = "Office updated successfully!";
        } elseif ($action === 'delete') {
            $stmt = $pdo->prepare("DELETE FROM offices WHERE id=?");
            $stmt->execute([$_POST['id']]);
            $toastMsg = "Office deleted successfully!";
        }
    } catch (Exception $e) {
        $toastMsg = "Error: " . $e->getMessage();
        $toastType = 'error';
    }
}

// ── Fetch all ──
$offices = $pdo->query("SELECT * FROM offices ORDER BY name ASC")->fetchAll();

require_once __DIR__ . '/includes/header.php';
?>

<div class="panel">
    <div class="panel-header">
        <h3><i class="fas fa-building" style="color:var(--blue);margin-right:8px;"></i> All Branches & Offices</h3>
        <button class="btn btn-primary" onclick="openAddModal()">
            <i class="fas fa-plus"></i> Add Office
        </button>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Location Name</th>
                    <th>Type</th>
                    <th>Contact</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($offices as $o): ?>
                    <tr>
                        <td style="font-weight:600;">
                            <?= htmlspecialchars($o['name']) ?>
                        </td>
                        <td>
                            <?php if ($o['type'] === 'head_office'): ?>
                                <span class="badge badge-blue">Head Office</span>
                            <?php else: ?>
                                <span class="badge badge-green">Branch</span>
                            <?php endif; ?>
                        </td>
                        <td style="font-size:0.85rem;color:var(--muted);white-space:nowrap;">
                            <?php if ($o['phone'])
                                echo '<div><i class="fas fa-phone fa-fw"></i> ' . htmlspecialchars($o['phone']) . '</div>'; ?>
                            <?php if ($o['email'])
                                echo '<div><i class="fas fa-envelope fa-fw"></i> ' . htmlspecialchars($o['email']) . '</div>'; ?>
                        </td>
                        <td style="font-size:0.85rem;color:var(--muted);max-width:300px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"
                            title="<?= htmlspecialchars($o['address']) ?>">
                            <?= htmlspecialchars($o['address']) ?>
                        </td>
                        <td>
                            <div style="display:flex;gap:6px;">
                                <button class="btn btn-secondary btn-sm btn-icon"
                                    onclick='openEditModal(<?= json_encode($o) ?>)' title="Edit"><i
                                        class="fas fa-pen"></i></button>
                                <form method="POST" style="display:inline;"
                                    onsubmit="return confirm('Are you sure you want to delete this office?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $o['id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm btn-icon" title="Delete"><i
                                            class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($offices)): ?>
                    <tr>
                        <td colspan="5" style="text-align:center;padding:30px;color:var(--muted);">No offices found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Add / Edit -->
<div class="modal-overlay" id="officeModal">
    <div class="modal">
        <form method="POST">
            <div class="modal-header">
                <h3 id="modalTitle">Add Office</h3>
                <button type="button" class="modal-close" onclick="closeModal('officeModal')">&times;</button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="action" id="modalAction" value="add">
                <input type="hidden" name="id" id="modalId" value="">

                <div class="grid-2">
                    <div class="form-group">
                        <label>Location Name *</label>
                        <input type="text" name="name" id="modalName" class="form-control" required
                            placeholder="e.g. Port Moresby">
                    </div>
                    <div class="form-group">
                        <label>Type *</label>
                        <select name="type" id="modalType" class="form-control" required>
                            <option value="branch">Branch</option>
                            <option value="head_office">Head Office</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Physical Address *</label>
                    <textarea name="address" id="modalAddress" class="form-control" required
                        placeholder="Full street address..." rows="2"></textarea>
                </div>

                <div class="grid-3">
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="phone" id="modalPhone" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Fax</label>
                        <input type="text" name="fax" id="modalFax" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" id="modalEmail" class="form-control">
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label>Latitude (optional)</label>
                        <input type="text" name="latitude" id="modalLat" class="form-control" placeholder="-9.4438">
                    </div>
                    <div class="form-group">
                        <label>Longitude (optional)</label>
                        <input type="text" name="longitude" id="modalLng" class="form-control" placeholder="147.1803">
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('officeModal')">Cancel</button>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Office</button>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
<script>
<?php if ($toastMsg): ?>
            showToast(<?= json_encode($toastMsg) ?>, <?= json_encode($toastType) ?>);
<?php endif; ?>

        function openAddModal() {
            document.getElementById('modalTitle').innerText = 'Add Office';
            document.getElementById('modalAction').value = 'add';
            document.getElementById('modalId').value = '';

            document.getElementById('modalName').value = '';
            document.getElementById('modalType').value = 'branch';
            document.getElementById('modalAddress').value = '';
            document.getElementById('modalPhone').value = '';
            document.getElementById('modalFax').value = '';
            document.getElementById('modalEmail').value = '';
            document.getElementById('modalLat').value = '';
            document.getElementById('modalLng').value = '';
            openModal('officeModal');
        }

    function openEditModal(o) {
        document.getElementById('modalTitle').innerText = 'Edit Office';
        document.getElementById('modalAction').value = 'edit';
        document.getElementById('modalId').value = o.id;

        document.getElementById('modalName').value = o.name;
        document.getElementById('modalType').value = o.type;
        document.getElementById('modalAddress').value = o.address;
        document.getElementById('modalPhone').value = o.phone || '';
        document.getElementById('modalFax').value = o.fax || '';
        document.getElementById('modalEmail').value = o.email || '';
        document.getElementById('modalLat').value = o.latitude || '';
        document.getElementById('modalLng').value = o.longitude || '';
        openModal('officeModal');
    }
</script>
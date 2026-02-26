<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../backend/db.php';

$pageTitle = 'Forms & Brochures';
$activePage = 'downloads';
$pdo = getDB();

$action = $_POST['action'] ?? '';
$toastMsg = '';
$toastType = 'success';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($action)) {
    try {
        if ($action === 'add') {
            $stmt = $pdo->prepare("INSERT INTO downloads (title, category, file_path, file_size) VALUES (?, ?, ?, ?)");
            $stmt->execute([
                trim($_POST['title']),
                trim($_POST['category']),
                trim($_POST['file_path']),
                trim($_POST['file_size'])
            ]);
            $toastMsg = "Document added successfully!";
        } elseif ($action === 'edit') {
            $stmt = $pdo->prepare("UPDATE downloads SET title=?, category=?, file_path=?, file_size=? WHERE id=?");
            $stmt->execute([
                trim($_POST['title']),
                trim($_POST['category']),
                trim($_POST['file_path']),
                trim($_POST['file_size']),
                $_POST['id']
            ]);
            $toastMsg = "Document updated successfully!";
        } elseif ($action === 'delete') {
            $stmt = $pdo->prepare("DELETE FROM downloads WHERE id=?");
            $stmt->execute([$_POST['id']]);
            $toastMsg = "Document deleted successfully!";
        }
    } catch (Exception $e) {
        $toastMsg = "Error: " . $e->getMessage();
        $toastType = 'error';
    }
}

$downloads = $pdo->query("SELECT * FROM downloads ORDER BY category ASC, title ASC")->fetchAll();

require_once __DIR__ . '/includes/header.php';
?>

<div class="panel" style="margin-bottom:30px;">
    <div class="panel-header">
        <h3><i class="fas fa-file-pdf" style="color:var(--green);margin-right:8px;"></i> Document Library</h3>
        <button class="btn btn-primary" onclick="openAddModal()">
            <i class="fas fa-upload"></i> Add Document
        </button>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Document Title</th>
                    <th>Category</th>
                    <th>File Path</th>
                    <th>Size</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($downloads as $d): ?>
                    <tr>
                        <td style="font-weight:600;">
                            <i class="fas fa-file-pdf" style="color:#d32f2f;margin-right:8px;"></i>
                            <?= htmlspecialchars($d['title']) ?>
                        </td>
                        <td>
                            <?php if ($d['category'] === 'form'): ?>
                                <span class="badge badge-blue">Form</span>
                            <?php else: ?>
                                <span class="badge badge-yellow">Brochure</span>
                            <?php endif; ?>
                        </td>
                        <td style="font-family:monospace;font-size:0.8rem;color:var(--muted);">
                            <?= htmlspecialchars($d['file_path']) ?>
                        </td>
                        <td style="font-size:0.85rem;font-weight:600;">
                            <?= htmlspecialchars($d['file_size']) ?>
                        </td>
                        <td>
                            <div style="display:flex;gap:6px;">
                                <a href="../<?= htmlspecialchars($d['file_path']) ?>" target="_blank"
                                    class="btn btn-secondary btn-sm btn-icon" title="Preview File"><i
                                        class="fas fa-external-link-alt"></i></a>
                                <button class="btn btn-secondary btn-sm btn-icon"
                                    onclick='openEditModal(<?= json_encode($d) ?>)' title="Edit"><i
                                        class="fas fa-pen"></i></button>
                                <form method="POST" style="display:inline;"
                                    onsubmit="return confirm('Delete this document record?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $d['id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm btn-icon" title="Delete"><i
                                            class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($downloads)): ?>
                    <tr>
                        <td colspan="5" style="text-align:center;padding:30px;color:var(--muted);">No documents found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Add / Edit -->
<div class="modal-overlay" id="docModal">
    <div class="modal">
        <form method="POST">
            <div class="modal-header">
                <h3 id="modalTitle">Add Document</h3>
                <button type="button" class="modal-close" onclick="closeModal('docModal')">&times;</button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="action" id="modalAction" value="add">
                <input type="hidden" name="id" id="modalId" value="">

                <div class="form-group">
                    <label>Document Title *</label>
                    <input type="text" name="title" id="modalDocTitle" class="form-control" required
                        placeholder="e.g. New Membership Form">
                </div>

                <div class="form-group">
                    <label>Category *</label>
                    <select name="category" id="modalDocCategory" class="form-control" required>
                        <option value="form">Form</option>
                        <option value="brochure">Brochure</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>File Path *</label>
                    <input type="text" name="file_path" id="modalDocPath" class="form-control" required
                        placeholder="downloads/forms/file.pdf">
                    <div style="font-size:0.75rem;color:var(--muted);margin-top:6px;"><i class="fas fa-info-circle"></i>
                        Relative path to the file from the website root. Make sure the file actually exists in the
                        correct folder via FTP.</div>
                </div>

                <div class="form-group">
                    <label>File Size *</label>
                    <input type="text" name="file_size" id="modalDocSize" class="form-control" required
                        placeholder="e.g. 1.2MB">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('docModal')">Cancel</button>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Document</button>
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
            document.getElementById('modalTitle').innerText = 'Add Document';
            document.getElementById('modalAction').value = 'add';
            document.getElementById('modalId').value = '';

            document.getElementById('modalDocTitle').value = '';
            document.getElementById('modalDocCategory').value = 'form';
            document.getElementById('modalDocPath').value = 'downloads/forms/';
            document.getElementById('modalDocSize').value = '';

            openModal('docModal');
        }

    function openEditModal(d) {
        document.getElementById('modalTitle').innerText = 'Edit Document';
        document.getElementById('modalAction').value = 'edit';
        document.getElementById('modalId').value = d.id;

        document.getElementById('modalDocTitle').value = d.title;
        document.getElementById('modalDocCategory').value = d.category;
        document.getElementById('modalDocPath').value = d.file_path;
        document.getElementById('modalDocSize').value = d.file_size;

        openModal('docModal');
    }
</script>
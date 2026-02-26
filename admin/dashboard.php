<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../backend/db.php';

$pageTitle = 'Dashboard';
$activePage = 'dashboard';

$pdo = getDB();

// ── Stats ──
$totalOffices = $pdo->query("SELECT COUNT(*) FROM offices")->fetchColumn();
$totalDownloads = $pdo->query("SELECT COUNT(*) FROM downloads")->fetchColumn();
$totalMessages = $pdo->query("SELECT COUNT(*) FROM contacts")->fetchColumn();
$unreadMessages = $pdo->query("SELECT COUNT(*) FROM contacts WHERE is_read=0")->fetchColumn();

// ── Recent offices ──
$recentOffices = $pdo->query("SELECT id, name, type FROM offices ORDER BY id DESC LIMIT 5")->fetchAll();

// ── Recent messages ──
$recentMessages = $pdo->query("SELECT id, name, subject, is_read, created_at FROM contacts ORDER BY created_at DESC LIMIT 5")->fetchAll();

// ── Top Downloads ──
$topDownloads = $pdo->query("SELECT title, download_count FROM downloads ORDER BY download_count DESC LIMIT 5")->fetchAll();
$chartLabels = [];
$chartData = [];
foreach($topDownloads as $td) {
    // Truncate long titles for the chart labels
    $chartLabels[] = strlen($td['title']) > 18 ? substr($td['title'], 0, 18) . '...' : $td['title'];
    $chartData[] = (int)$td['download_count'];
}

require_once __DIR__ . '/includes/header.php';
?>

<!-- Stats Widgets -->
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:22px;margin-bottom:32px;">
    <?php
    $widgets = [
        ['icon' => 'fa-building', 'color' => 'blue', 'number' => $totalOffices, 'label' => 'Total Branches'],
        ['icon' => 'fa-file-pdf', 'color' => 'green', 'number' => $totalDownloads, 'label' => 'Downloads Available'],
        ['icon' => 'fa-envelope', 'color' => 'yellow', 'number' => $totalMessages, 'label' => 'Total Messages'],
        ['icon' => 'fa-bell', 'color' => 'red', 'number' => $unreadMessages, 'label' => 'Unread Messages'],
    ];
    foreach ($widgets as $w): ?>
        <div class="panel" style="display:flex;align-items:center;gap:18px;padding:22px;transition:transform .25s;"
            onmouseenter="this.style.transform='translateY(-4px)'" onmouseleave="this.style.transform='translateY(0)'">
            <div style="width:60px;height:60px;border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:1.6rem;
            <?php if ($w['color'] === 'blue')
                echo 'background:#f1f8e9;color:var(--blue);';
            elseif ($w['color'] === 'green')
                echo 'background:#e8f5e9;color:var(--green);';
            elseif ($w['color'] === 'yellow')
                echo 'background:#fff3e0;color:var(--yellow);';
            else
                echo 'background:#ffebee;color:var(--red);'; ?>">
                <i class="fas <?= $w['icon'] ?>"></i>
            </div>
            <div>
                <div style="font-size:2rem;font-weight:700;line-height:1;"><?= number_format((int) $w['number']) ?></div>
                <div style="color:var(--muted);font-size:0.88rem;margin-top:3px;"><?= $w['label'] ?></div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Top Downloads Graph Panel -->
<div class="panel" style="margin-bottom: 24px;">
    <div class="panel-header">
        <h3><i class="fas fa-chart-bar" style="color:var(--green);margin-right:8px;"></i>Most Popular Downloads</h3>
    </div>
    <div class="panel-body">
        <div style="height: 280px; width: 100%;">
            <canvas id="downloadsChart"></canvas>
        </div>
    </div>
</div>

<!-- Content Grid -->
<div style="display:grid;grid-template-columns:3fr 2fr;gap:24px;">

    <!-- Recent Offices Table -->
    <div class="panel">
        <div class="panel-header">
            <h3><i class="fas fa-building" style="color:var(--blue);margin-right:8px;"></i>Recent Offices</h3>
            <a href="offices.php" class="btn btn-secondary btn-sm">View All</a>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentOffices as $o): ?>
                        <tr>
                            <td><?= htmlspecialchars($o['name']) ?></td>
                            <td>
                                <?php if ($o['type'] === 'head_office'): ?>
                                    <span class="badge badge-blue">Head Office</span>
                                <?php else: ?>
                                    <span class="badge badge-green">Branch</span>
                                <?php endif; ?>
                            </td>
                            <td><a href="offices.php?edit=<?= $o['id'] ?>" class="btn btn-secondary btn-sm btn-icon"><i
                                        class="fas fa-pen"></i></a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Messages -->
    <div class="panel">
        <div class="panel-header">
            <h3><i class="fas fa-envelope" style="color:var(--yellow);margin-right:8px;"></i>Recent Messages</h3>
            <a href="messages.php" class="btn btn-secondary btn-sm">View All</a>
        </div>
        <div style="padding:8px 0;">
            <?php if (empty($recentMessages)): ?>
                <p style="color:var(--muted);padding:20px 26px;font-size:0.9rem;">No messages yet.</p>
            <?php endif; ?>
            <?php foreach ($recentMessages as $m): ?>
                <div
                    style="display:flex;align-items:flex-start;gap:12px;padding:14px 22px;border-bottom:1px solid var(--border);">
                    <div
                        style="width:8px;height:8px;border-radius:50%;margin-top:5px;flex-shrink:0;background:<?= $m['is_read'] ? 'var(--border)' : 'var(--red)' ?>">
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div
                            style="font-size:0.88rem;font-weight:<?= $m['is_read'] ? '400' : '600' ?>;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            <?= htmlspecialchars($m['subject'] ?: '(No subject)') ?>
                        </div>
                        <div style="color:var(--muted);font-size:0.78rem;margin-top:2px;">
                            <?= htmlspecialchars($m['name']) ?> &mdash; <?= date('d M Y', strtotime($m['created_at'])) ?>
                        </div>
                    </div>
                    <a href="messages.php?view=<?= $m['id'] ?>" class="btn btn-secondary btn-sm btn-icon" title="Read"><i
                            class="fas fa-eye"></i></a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

<!-- Chart.js for Statistics Graph -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('downloadsChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($chartLabels) ?>,
            datasets: [{
                label: 'Total Downloads',
                data: <?= json_encode($chartData) ?>,
                backgroundColor: '#8bc34a', // Using the primary brand green
                borderRadius: 6,
                borderSkipped: false,
                barPercentage: 0.5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#2d3748',
                    padding: 10,
                    cornerRadius: 8,
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0,
                        color: '#718096',
                        stepSize: 1
                    },
                    grid: { color: '#e0e6ed', borderDash: [5, 5] },
                    border: { display: false }
                },
                x: {
                    ticks: { color: '#718096', font: {family: "'Inter', sans-serif"} },
                    grid: { display: false },
                    border: { display: false }
                }
            }
        }
    });
</script>
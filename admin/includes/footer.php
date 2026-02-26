<!-- *** PAGE CONTENT ENDS ABOVE *** -->
</div><!-- .content -->
</div><!-- .page-wrap -->

<div id="toast-container"></div>

<script>
    // ── Global toast helper ──
    function showToast(msg, type = 'success') {
        const tc = document.getElementById('toast-container');
        const t = document.createElement('div');
        t.className = 'toast toast-' + type;
        t.innerHTML = `<i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i> ${msg}`;
        tc.appendChild(t);
        setTimeout(() => t.remove(), 3800);
    }

    // ── Modal helpers ──
    function openModal(id) { document.getElementById(id)?.classList.add('open'); }
    function closeModal(id) { document.getElementById(id)?.classList.remove('open'); }

    // Close modal on backdrop click
    document.querySelectorAll('.modal-overlay').forEach(ov => {
        ov.addEventListener('click', e => { if (e.target === ov) ov.classList.remove('open'); });
    });

    // ── Sidebar Toggle ──
    const sidebarToggle = document.getElementById('sidebarToggle');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', () => {
            const isCollapsed = document.body.classList.toggle('sidebar-collapsed');
            localStorage.setItem('sidebar-collapsed', isCollapsed);
        });
    }
</script>
</body>

</html>
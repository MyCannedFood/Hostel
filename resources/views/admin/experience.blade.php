<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Experience - AlaSare</title>
    @vite(['resources/css/dashboard.css', 'resources/js/app.js'])
</head>
<body>
    <div class="dashboard-container">
        <x-admin_sidenavbar />
        <div class="sidebar-backdrop" id="sidebarBackdrop" hidden></div>

        <main class="main-content">
            <header class="header">
                <button type="button" class="hamburger mobile-only" id="sidebarToggle" aria-label="Open sidebar" aria-controls="adminSidebar" aria-expanded="false">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <div class="header-actions">
                    <img src="{{ asset('images/admin/img_button_trailing.svg') }}" alt="Menu" width="34" height="28">
                    <img src="{{ asset('images/admin/img_button_white_a700.svg') }}" alt="Notifications" width="32" height="36">
                    <img src="{{ asset('images/admin/profile.png') }}" alt="User profile" width="40" height="40">
                </div>
            </header>

            <div class="content-area">
                <section>
                    <div class="content-header">
                        <h2 class="page-title">Experience</h2>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <script>
        const sidebar = document.getElementById('adminSidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarBackdrop = document.getElementById('sidebarBackdrop');

        function setSidebarOpen(isOpen) {
            if (!sidebar || !sidebarToggle || !sidebarBackdrop) return;

            sidebar.classList.toggle('open', isOpen);
            sidebarBackdrop.hidden = !isOpen;
            document.body.classList.toggle('sidebar-open', isOpen);
            sidebarToggle.setAttribute('aria-expanded', String(isOpen));
            sidebarToggle.setAttribute('aria-label', isOpen ? 'Close sidebar' : 'Open sidebar');
        }

        if (sidebarToggle && sidebarBackdrop && sidebar) {
            sidebarToggle.addEventListener('click', function () {
                setSidebarOpen(!sidebar.classList.contains('open'));
            });

            sidebarBackdrop.addEventListener('click', function () {
                setSidebarOpen(false);
            });

            window.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') setSidebarOpen(false);
            });

            window.addEventListener('resize', function () {
                if (window.innerWidth >= 1024) setSidebarOpen(false);
            });
        }
    </script>
</body>
</html>


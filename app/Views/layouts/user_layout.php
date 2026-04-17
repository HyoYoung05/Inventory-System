<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? $pageTitle . ' - ' : '' ?>User Dashboard | Inventory System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-bg: #131921;
            --sidebar-hover: #1f2937;
            --primary-color: #f59e0b;
            --primary-dark: #d97706;
            --text-dark: #101828;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Manrope', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(180deg, #f4f7fb 0%, #eef3f8 100%);
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 280px;
            background-color: var(--sidebar-bg);
            color: white;
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            transition: all 0.3s ease;
            z-index: 1000;
        }

        body.sidebar-collapsed .sidebar {
            width: 92px;
        }

        .sidebar .brand {
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 1.35rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .sidebar .brand i {
            font-size: 1.8rem;
            color: var(--primary-color);
        }

        .brand-main {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
        }

        .sidebar-toggle-btn {
            width: 38px;
            height: 38px;
            border: 0;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.08);
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all 0.2s ease;
        }

        .sidebar-toggle-btn:hover {
            background: rgba(255, 255, 255, 0.16);
        }

        body.sidebar-collapsed .sidebar-toggle-btn i {
            transform: rotate(180deg);
        }

        .sidebar-nav {
            list-style: none;
            margin: 20px 0;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px 20px;
            color: rgba(255, 255, 255, 0.82);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .sidebar-nav a:hover {
            background-color: var(--sidebar-hover);
            color: white;
            border-left-color: var(--primary-color);
            padding-left: 24px;
        }

        .sidebar-nav a.active {
            background-color: var(--primary-color);
            color: #111827;
            border-left-color: white;
        }

        .sidebar-nav i {
            width: 20px;
            text-align: center;
            font-size: 1.2rem;
        }

        .nav-badge {
            min-width: 1.4rem;
            padding: 0.2rem 0.45rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.18);
            color: inherit;
            font-size: 0.72rem;
            font-weight: 800;
            text-align: center;
        }

        .sidebar-panel {
            margin: 0 18px 20px;
            padding: 1rem;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sidebar-panel h6 {
            margin-bottom: 0.9rem;
            font-size: 0.95rem;
            font-weight: 800;
            color: white;
        }

        .sidebar-panel .form-label {
            margin-bottom: 0.35rem;
            font-size: 0.78rem;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.7);
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .sidebar-panel .form-select {
            min-height: 2.8rem;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            background: rgba(255, 255, 255, 0.96);
        }

        .sidebar-panel .btn {
            border-radius: 12px;
        }

        .sidebar-user {
            padding: 15px 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: auto;
        }

        .sidebar-user .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
            text-decoration: none;
        }

        .sidebar-user .user-avatar {
            width: 40px;
            height: 40px;
            background-color: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #111827;
        }

        .sidebar-user .user-details {
            flex: 1;
        }

        .sidebar-user .user-name {
            font-size: 0.9rem;
            font-weight: 600;
            color: white;
        }

        .sidebar-user .user-role {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.6);
            text-transform: uppercase;
        }

        .sidebar-user .user-info:hover .user-name,
        .sidebar-user .user-info:hover .user-role {
            color: white;
        }

        .sidebar-user .btn-logout {
            width: 100%;
            padding: 8px;
            background-color: #e74c3c;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            display: block;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }

        .sidebar-user .btn-logout:hover {
            background-color: #c0392b;
            color: white;
            text-decoration: none;
        }

        .main-content {
            margin-left: 280px;
            flex: 1;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s ease;
        }

        body.sidebar-collapsed .main-content {
            margin-left: 92px;
        }

        .content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }

        .alert {
            margin-bottom: 20px;
            border-radius: 14px;
        }

        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.08);
            margin-bottom: 20px;
        }

        .card-header {
            background-color: #fbfcfe;
            border-bottom: 1px solid #dee2e6;
            border-radius: 20px 20px 0 0;
            padding: 20px;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: var(--text-dark);
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .btn {
            border-radius: 10px;
            font-weight: 700;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: #111827;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            color: #111827;
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: 0.85rem;
        }

        .badge {
            border-radius: 999px;
            padding: 6px 10px;
            font-size: 0.85rem;
            font-weight: 700;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                padding: 0;
            }

            .main-content {
                margin-left: 0;
            }

            .content {
                padding: 15px;
            }

            body.sidebar-collapsed .main-content {
                margin-left: 0;
            }

            .sidebar-toggle-btn {
                display: none;
            }
        }

        .sidebar::-webkit-scrollbar {
            width: 8px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        body.sidebar-collapsed .sidebar .brand span,
        body.sidebar-collapsed .sidebar-nav a span,
        body.sidebar-collapsed .sidebar-panel,
        body.sidebar-collapsed .sidebar-user .user-details,
        body.sidebar-collapsed .sidebar-user .btn-logout {
            display: none !important;
        }

        body.sidebar-collapsed .sidebar-nav a {
            justify-content: center;
            padding: 15px 0;
        }

        body.sidebar-collapsed .sidebar-nav a:hover {
            padding-left: 0;
        }

        body.sidebar-collapsed .sidebar-nav i {
            width: auto;
        }

        body.sidebar-collapsed .sidebar-user {
            display: flex;
            justify-content: center;
            padding: 15px 10px;
        }

        body.sidebar-collapsed .sidebar-user .user-info {
            margin-bottom: 0;
        }
    </style>
    <?php if (isset($additionalCSS)): ?>
        <?= $additionalCSS ?>
    <?php endif; ?>
</head>
<body>
    <?php $cartCount = (int) ($cartCount ?? 0); ?>
    <div class="wrapper">
        <aside class="sidebar">
            <div class="brand">
                <div class="brand-main">
                    <i class="bi bi-bag-check"></i>
                    <span>Marketplace</span>
                </div>
                <button type="button" class="sidebar-toggle-btn" data-desktop-sidebar-toggle aria-label="Toggle sidebar">
                    <i class="bi bi-chevron-double-left"></i>
                </button>
            </div>

            <ul class="sidebar-nav">
                <li>
                    <a href="<?= site_url('user/dashboard') ?>" class="<?= current_url() === site_url('user/dashboard') ? 'active' : '' ?>">
                        <i class="bi bi-graph-up"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="<?= site_url('browse') ?>" class="<?= current_url() === site_url('browse') ? 'active' : '' ?>">
                        <i class="bi bi-compass"></i>
                        <span>Browse</span>
                    </a>
                </li>
                <li>
                    <a href="<?= site_url('user/categories') ?>" class="<?= strpos(current_url(), 'user/categories') !== false || strpos(current_url(), 'user/products') !== false ? 'active' : '' ?>">
                        <i class="bi bi-shop-window"></i>
                        <span>Categories</span>
                    </a>
                </li>
                <li>
                    <a href="<?= site_url('user/cart') ?>" class="<?= strpos(current_url(), 'user/cart') !== false ? 'active' : '' ?>">
                        <i class="bi bi-cart3"></i>
                        <span>Cart</span>
                        <?php if ($cartCount > 0): ?>
                            <span class="nav-badge ms-auto"><?= $cartCount ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <li>
                    <a href="<?= site_url('user/orders') ?>" class="<?= strpos(current_url(), 'user/orders') !== false ? 'active' : '' ?>">
                        <i class="bi bi-bag"></i>
                        <span>My Orders</span>
                    </a>
                </li>
            </ul>

            <?= $this->renderSection('sidebarExtras') ?>

            <div class="sidebar-user">
                <a href="<?= site_url('user/profile') ?>" class="user-info">
                    <div class="user-avatar">
                        <?= strtoupper(substr(esc($username ?? 'User'), 0, 1)) ?>
                    </div>
                    <div class="user-details">
                        <div class="user-name"><?= esc($username ?? 'User') ?></div>
                        <div class="user-role"><?= esc($role ?? 'Customer') ?></div>
                    </div>
                </a>
                <a href="<?= site_url('auth/logout') ?>" class="btn-logout">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </aside>

        <div class="main-content">
            <div class="content">
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i> <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle"></i> <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener('load', function () {
            const toggle = document.querySelector('[data-desktop-sidebar-toggle]');
            const storageKey = 'ims-user-sidebar-collapsed';

            if (!toggle) {
                return;
            }

            const syncState = function () {
                if (window.innerWidth <= 768) {
                    document.body.classList.remove('sidebar-collapsed');
                    return;
                }

                if (localStorage.getItem(storageKey) === '1') {
                    document.body.classList.add('sidebar-collapsed');
                } else {
                    document.body.classList.remove('sidebar-collapsed');
                }
            };

            toggle.addEventListener('click', function () {
                document.body.classList.toggle('sidebar-collapsed');
                localStorage.setItem(storageKey, document.body.classList.contains('sidebar-collapsed') ? '1' : '0');
            });

            window.addEventListener('resize', syncState);
            syncState();
        });
    </script>
    <?php if (isset($additionalJS)): ?>
        <?= $additionalJS ?>
    <?php endif; ?>
</body>
</html>


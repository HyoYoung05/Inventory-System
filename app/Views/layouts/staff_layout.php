<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? $pageTitle . ' - ' : '' ?>Staff Dashboard | Inventory System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.min.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-bg: #2c3e50;
            --sidebar-hover: #34495e;
            --primary-color: #3498db;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #ecf0f1;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
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

        .sidebar .brand {
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 1.5rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar .brand i {
            font-size: 1.8rem;
            color: var(--primary-color);
        }

        .sidebar-nav {
            list-style: none;
            margin: 20px 0;
        }

        .sidebar-nav li {
            margin: 0;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px 20px;
            color: rgba(255, 255, 255, 0.8);
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
            color: white;
            border-left-color: white;
        }

        .sidebar-nav i {
            width: 20px;
            text-align: center;
            font-size: 1.2rem;
        }

        .sidebar-divider {
            height: 1px;
            background-color: rgba(255, 255, 255, 0.1);
            margin: 15px 0;
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
            color: white;
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

        .sidebar-user .btn-logout {
            width: 100%;
            padding: 8px;
            background-color: #e74c3c;
            color: white;
            border: none;
            border-radius: 4px;
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

        /* Main Content Area */
        .main-content {
            margin-left: 280px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            background-color: white;
            padding: 15px 30px;
            border-bottom: 1px solid #ddd;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .topbar-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2c3e50;
        }

        .topbar-actions {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }

        /* Alert Styles */
        .alert {
            margin-bottom: 20px;
            border-radius: 8px;
        }

        /* Card Styles */
        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            border-radius: 8px 8px 0 0;
            padding: 20px;
        }

        /* Table Styles */
        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: #2c3e50;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        /* Button Styles */
        .btn {
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: 0.85rem;
        }

        /* Badge Styles */
        .badge {
            border-radius: 4px;
            padding: 6px 10px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .badge-pending {
            background-color: #f39c12;
            color: white;
        }

        .badge-to-be-packed {
            background-color: #f59e0b;
            color: white;
        }

        .badge-to-be-shipped {
            background-color: #3b82f6;
            color: white;
        }

        .badge-to-be-delivered {
            background-color: #8b5cf6;
            color: white;
        }

        .badge-completed {
            background-color: #27ae60;
            color: white;
        }

        .badge-cancelled {
            background-color: #e74c3c;
            color: white;
        }

        /* Responsive Design */
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

            .topbar {
                padding: 15px;
            }

            .topbar-title {
                font-size: 1.2rem;
            }
        }

        .sidebar.active {
            width: 280px;
        }

        /* Scrollbar Style */
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
    </style>
    <?php if(isset($additionalCSS)): ?>
        <?= $additionalCSS ?>
    <?php endif; ?>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="brand">
                <i class="bi bi-box-seam"></i>
                <span>Inventory</span>
            </div>

            <ul class="sidebar-nav">
                <li>
                    <a href="<?= base_url('staff/dashboard') ?>" class="<?= current_url() === base_url('staff/dashboard') ? 'active' : '' ?>">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('staff/inventory') ?>" class="<?= strpos(current_url(), 'staff/inventory') !== false ? 'active' : '' ?>">
                        <i class="bi bi-box-seam"></i>
                        <span>Inventory</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('staff/orders') ?>" class="<?= strpos(current_url(), 'staff/orders') !== false ? 'active' : '' ?>">
                        <i class="bi bi-receipt"></i>
                        <span>Orders</span>
                    </a>
                </li>
            </ul>

            <div class="sidebar-user">
                <div class="user-info">
                    <div class="user-avatar">
                        <?= strtoupper(substr(esc($username ?? 'User'), 0, 1)) ?>
                    </div>
                    <div class="user-details">
                        <div class="user-name"><?= esc($username ?? 'User') ?></div>
                        <div class="user-role"><?= esc($role ?? 'Staff') ?></div>
                    </div>
                </div>
                <a href="<?= base_url('auth/logout') ?>" class="btn-logout">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Topbar -->
            <div class="topbar">
                <h1 class="topbar-title"><?= $pageTitle ?? 'Dashboard' ?></h1>
                <div class="topbar-actions">
                    <span class="text-muted">Last updated: <?= date('M d, Y H:i') ?></span>
                </div>
            </div>

            <!-- Content Area -->
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

                <!-- Page Content -->
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.min.js"></script>
    <?php if(isset($additionalJS)): ?>
        <?= $additionalJS ?>
    <?php endif; ?>
</body>
</html>

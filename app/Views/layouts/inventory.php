<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= esc($pageTitle ?? 'Inventory System') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Inventory management dashboard">
    <link rel="shortcut icon" type="image/png" href="favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="css/inventory-ui.css" rel="stylesheet">
    <style>
        .topbar-shell .container {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 1rem 1.5rem;
        }
        .topbar-shell .navbar-brand {
            color: white !important;
            font-weight: 700;
            gap: 10px;
        }
        .topbar-shell .navbar-brand strong {
            font-size: 18px;
        }
        .topbar-shell .navbar-brand small {
            color: rgba(255,255,255,0.8);
            font-size: 11px;
        }
        .topbar-shell .nav-link {
            color: rgba(255,255,255,0.9) !important;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .topbar-shell .nav-link:hover {
            color: white !important;
            opacity: 1;
        }
        .sync-chip {
            color: rgba(255,255,255,0.8);
            font-size: 13px;
        }
        .status-dot {
            background: #4caf50;
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 6px;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        .topbar-shell .btn {
            background: rgba(255,255,255,0.2) !important;
            border: 1px solid rgba(255,255,255,0.3);
            color: white !important;
            transition: all 0.3s ease;
        }
        .topbar-shell .btn:hover {
            background: rgba(255,255,255,0.3) !important;
        }
        .footer-strip {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            color: white;
            margin-top: 50px;
        }
    </style>
</head>
<body class="inventory-shell">
    <div class="page-orb orb-one"></div>
    <div class="page-orb orb-two"></div>

    <nav class="navbar navbar-expand-lg topbar-shell">
        <div class="container">
            <a class="navbar-brand brand-mark" href="./">
                <span class="brand-icon">IS</span>
                <span>
                    <strong>Inventory System</strong>
                    <small>Bootstrap dashboard</small>
                </span>
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav mx-auto mb-3 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" href="<?= base_url('/') ?>">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('products') ?>">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Orders</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Suppliers</a></li>
                </ul>

                <div class="d-flex flex-column flex-lg-row align-items-lg-center gap-3">
                    <div class="sync-chip">
                        <span class="status-dot"></span>
                        Updated <?= esc($updatedAt ?? 'just now') ?>
                    </div>
                    <?php if (session()->get('isLoggedIn')): ?>
                        <a href="<?= base_url('auth/logout') ?>" class="btn btn-dark rounded-pill px-4">Logout</a>
                    <?php else: ?>
                        <a href="<?= base_url('auth/login') ?>" class="btn btn-dark rounded-pill px-4">Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <main>
        <?= $this->renderSection('content') ?>
    </main>

    <footer class="footer-strip">
        <div class="container d-flex flex-column flex-lg-row justify-content-between gap-2">
            <span>Built with CodeIgniter 4 and Bootstrap 5.</span>
            <span>Inventory overview for smoother daily operations.</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

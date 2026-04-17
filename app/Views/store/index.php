<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($pageTitle ?? 'Store') ?> - Inventory System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root { --sidebar-bg:#131921; --sidebar-hover:#1f2937; --primary:#f59e0b; --primary-dark:#d97706; --ink:#132238; --soft:#617089; }
        body { margin:0; font-family:"Manrope","Segoe UI",sans-serif; color:var(--ink); background:linear-gradient(180deg,#f7f2ea 0%,#fdfbf8 35%,#eef5f4 100%); }
        .page-shell { display:flex; min-height:100vh; position:relative; }
        .sidebar-backdrop { position:fixed; inset:0; background:rgba(15,23,42,.45); opacity:0; pointer-events:none; transition:opacity .25s ease; z-index:999; }
        .mobile-topbar { display:none; align-items:center; justify-content:space-between; gap:1rem; margin-bottom:1rem; padding:.9rem 1rem; border:1px solid rgba(15,23,42,.08); border-radius:18px; background:rgba(255,255,255,.92); box-shadow:0 12px 30px rgba(15,23,42,.07); }
        .mobile-topbar-title { font-weight:800; color:var(--ink); }
        .mobile-menu-btn { display:inline-flex; align-items:center; gap:.5rem; border-radius:12px; font-weight:700; }
        .sidebar { width:280px; background:var(--sidebar-bg); color:#fff; position:fixed; inset:0 auto 0 0; overflow-y:auto; transition:transform .25s ease, width .25s ease; z-index:1000; }
        body.sidebar-collapsed .sidebar { width:92px; }
        .brand { padding:20px; border-bottom:1px solid rgba(255,255,255,.1); font-size:1.35rem; font-weight:800; display:flex; align-items:center; justify-content:space-between; gap:10px; }
        .brand i { font-size:1.8rem; color:var(--primary); }
        .brand-main { display:flex; align-items:center; gap:10px; min-width:0; }
        .sidebar-toggle-btn { width:38px; height:38px; border:0; border-radius:12px; background:rgba(255,255,255,.08); color:#fff; display:inline-flex; align-items:center; justify-content:center; flex-shrink:0; transition:all .2s ease; }
        .sidebar-toggle-btn:hover { background:rgba(255,255,255,.16); }
        body.sidebar-collapsed .sidebar-toggle-btn i { transform:rotate(180deg); }
        .sidebar-nav { list-style:none; margin:20px 0; padding:0; }
        .sidebar-nav a { display:flex; align-items:center; gap:12px; padding:15px 20px; color:rgba(255,255,255,.82); text-decoration:none; border-left:4px solid transparent; transition:.2s ease; }
        .sidebar-nav a:hover { background:var(--sidebar-hover); color:#fff; border-left-color:var(--primary); padding-left:24px; }
        .sidebar-nav a.active { background:var(--primary); color:#111827; border-left-color:#fff; }
        .sidebar-nav i { width:20px; text-align:center; font-size:1.2rem; }
        .nav-badge { min-width:1.4rem; padding:.2rem .45rem; border-radius:999px; background:rgba(255,255,255,.18); color:inherit; font-size:.72rem; font-weight:800; text-align:center; }
        .sidebar-panel { margin:0 18px 20px; padding:1rem; border-radius:18px; background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.08); }
        .sidebar-panel h6 { margin-bottom:.9rem; font-size:.95rem; font-weight:800; color:#fff; }
        .sidebar-panel .form-label { margin-bottom:.35rem; font-size:.78rem; font-weight:700; color:rgba(255,255,255,.7); text-transform:uppercase; letter-spacing:.03em; }
        .sidebar-panel .form-select { min-height:2.8rem; border-radius:12px; background:rgba(255,255,255,.96); }
        .sidebar-filter-actions { display:grid; grid-template-columns:1fr 1fr; gap:.65rem; }
        .sidebar-user { padding:15px 20px; border-top:1px solid rgba(255,255,255,.1); border-bottom:1px solid rgba(255,255,255,.1); }
        .user-info { display:flex; align-items:center; gap:10px; margin-bottom:12px; text-decoration:none; }
        .user-avatar { width:40px; height:40px; background:var(--primary); border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:700; color:#111827; }
        .user-name { font-size:.9rem; font-weight:600; color:#fff; }
        .user-role { font-size:.75rem; color:rgba(255,255,255,.6); text-transform:uppercase; }
        .user-info:hover .user-name, .user-info:hover .user-role { color:#fff; }
        .btn-logout { width:100%; padding:8px; background:#e74c3c; color:#fff; border:none; border-radius:8px; text-decoration:none; text-align:center; display:block; font-size:.85rem; }
        .main-content { margin-left:280px; flex:1; transition:margin-left .25s ease; }
        body.sidebar-collapsed .main-content { margin-left:92px; }
        .shell { width:min(1180px,calc(100% - 2rem)); margin:0 auto; padding:1.5rem 0 3rem; }
        .hero, .search-card, .section-shell { border:1px solid rgba(19,34,56,.08); border-radius:28px; background:rgba(255,255,255,.9); box-shadow:0 24px 70px rgba(20,35,57,.08); }
        .hero { margin-top:1.25rem; padding:2rem; background:radial-gradient(circle at top right,rgba(245,158,11,.25),transparent 28%),linear-gradient(135deg,#0f172a,#1f2937 58%,#334155); color:#fff; }
        .hero h1 { margin:0 0 .75rem; font-family:"Space Grotesk",sans-serif; font-size:clamp(2.2rem,4vw,4rem); line-height:.96; letter-spacing:-.04em; }
        .hero p { max-width:44rem; margin:0; color:rgba(255,255,255,.76); }
        .search-card { margin:1.25rem 0; padding:1rem; }
        .search-card .form-control { min-height:3.2rem; border-radius:18px; }
        .section-shell { padding:1.25rem; }
        .product-grid { display:grid; grid-template-columns:repeat(5,minmax(0,1fr)); gap:1rem; }
        .product-card { display:flex; flex-direction:column; height:100%; padding:1.2rem; border-radius:24px; background:#fff; border:1px solid rgba(15,23,42,.08); box-shadow:0 14px 40px rgba(15,23,42,.06); }
        .product-trigger { display:flex; flex:1; flex-direction:column; width:100%; height:100%; padding:0; border:0; background:transparent; text-align:left; color:inherit; }
        .product-visual { display:grid; place-items:center; overflow:hidden; height:160px; margin-bottom:1rem; border-radius:22px; background:linear-gradient(135deg,rgba(245,158,11,.18),rgba(29,78,216,.12)); font-size:3rem; font-weight:800; color:#101828; }
        .product-visual img { width:100%; height:100%; object-fit:cover; }
        .meta { display:grid; grid-template-columns:minmax(0,1fr) minmax(0,1fr); align-items:start; gap:.75rem; min-height:2.6rem; margin-bottom:.75rem; font-size:.85rem; color:var(--soft); }
        .meta span { min-width:0; }
        .meta span:last-child { text-align:right; overflow-wrap:anywhere; }
        .name { display:-webkit-box; min-height:2.8rem; margin-bottom:.35rem; overflow:hidden; font-size:1.08rem; font-weight:800; line-height:1.3; line-clamp:2; -webkit-box-orient:vertical; -webkit-line-clamp:2; }
        .description { display:-webkit-box; min-height:5.5rem; margin-bottom:1rem; overflow:hidden; color:var(--soft); font-size:.92rem; line-height:1.45; line-clamp:3; -webkit-box-orient:vertical; -webkit-line-clamp:3; }
        .product-card-footer { margin-top:auto; min-height:4rem; }
        .price-block { display:flex; flex-direction:column; gap:.25rem; min-height:4rem; }
        .price { font-size:1.45rem; font-weight:800; line-height:1.1; }
        .stock { color:var(--soft); font-size:.9rem; line-height:1.35; text-align:left; white-space:normal; word-break:break-word; overflow-wrap:anywhere; }
        .product-actions { display:grid; grid-template-columns:1fr 1fr; gap:.75rem; margin-top:1rem; }
        .product-actions form { margin:0; }
        .product-actions .btn { width:100%; border-radius:14px; font-weight:700; }
        .browse-pagination { display:flex; justify-content:center; gap:.6rem; flex-wrap:wrap; margin-top:1.5rem; }
        .browse-pagination .page-link { display:inline-flex; align-items:center; justify-content:center; min-width:2.75rem; min-height:2.75rem; padding:.65rem .95rem; border-radius:999px; border:1px solid rgba(15,23,42,.08); background:#fff; color:#101828; font-weight:800; text-decoration:none; box-shadow:0 10px 24px rgba(15,23,42,.06); }
        .browse-pagination .page-link.active { background:var(--primary); border-color:var(--primary); color:#111827; }
        .browse-pagination .page-link.disabled { pointer-events:none; opacity:.5; }
        .gate-note { color:var(--soft); font-size:.92rem; margin-top:.65rem; }
        .empty-state { padding:3rem 1.5rem; text-align:center; color:var(--soft); }
        .modal-product-visual { display:grid; place-items:center; overflow:hidden; min-height:320px; border-radius:24px; background:linear-gradient(135deg,rgba(245,158,11,.18),rgba(29,78,216,.12)); font-size:5rem; font-weight:800; color:#101828; }
        .modal-product-visual img { width:100%; height:100%; object-fit:cover; }
        .modal-action-grid { display:grid; grid-template-columns:1fr 1fr; gap:.75rem; margin-top:1rem; }
        .modal-action-grid form { margin:0; }
        .modal-action-grid .btn { width:100%; border-radius:14px; font-weight:700; }
        @media (max-width:1399.98px) { .product-grid { grid-template-columns:repeat(4,minmax(0,1fr)); } }
        @media (max-width:1199.98px) { .product-grid { grid-template-columns:repeat(3,minmax(0,1fr)); } }
        @media (max-width:767.98px) { .product-grid { grid-template-columns:repeat(2,minmax(0,1fr)); } .product-actions { grid-template-columns:1fr; } .modal-action-grid { grid-template-columns:1fr; } }
        @media (max-width:575.98px) { .product-grid { grid-template-columns:1fr; } }
        body.sidebar-collapsed .brand span,
        body.sidebar-collapsed .sidebar-nav a span,
        body.sidebar-collapsed .sidebar-panel,
        body.sidebar-collapsed .sidebar-user .user-details,
        body.sidebar-collapsed .sidebar-user .btn-logout { display:none !important; }
        body.sidebar-collapsed .sidebar-nav a { justify-content:center; padding:15px 0; }
        body.sidebar-collapsed .sidebar-nav a:hover { padding-left:0; }
        body.sidebar-collapsed .sidebar-nav i { width:auto; }
        body.sidebar-collapsed .sidebar-user { display:flex; justify-content:center; padding:15px 10px; }
        body.sidebar-collapsed .sidebar-user .user-info { margin-bottom:0; }
        @media (max-width:991.98px) { body.sidebar-open { overflow:hidden; } .sidebar { transform:translateX(-100%); box-shadow:0 24px 60px rgba(15,23,42,.25); } .sidebar.is-open { transform:translateX(0); } .sidebar-backdrop.is-active { opacity:1; pointer-events:auto; } .mobile-topbar { display:flex; } .main-content { margin-left:0; } body.sidebar-collapsed .main-content { margin-left:0; } .shell { width:min(100%,calc(100% - 1rem)); padding:1rem 0 2rem; } .hero { margin-top:0; padding:1.5rem; } .sidebar-toggle-btn { display:none; } }
    </style>
</head>
<body>
    <div class="page-shell">
        <div class="sidebar-backdrop" data-sidebar-backdrop></div>
        <aside class="sidebar" data-sidebar>
            <div class="brand">
                <div class="brand-main"><i class="bi bi-bag-check"></i><span>Marketplace</span></div>
                <button type="button" class="sidebar-toggle-btn" data-desktop-sidebar-toggle aria-label="Toggle sidebar">
                    <i class="bi bi-chevron-double-left"></i>
                </button>
            </div>
            <ul class="sidebar-nav">
                <?php if ($isLoggedIn && $role === 'user'): ?>
                    <li><a href="<?= site_url('user/dashboard') ?>"><i class="bi bi-graph-up"></i><span>Dashboard</span></a></li>
                    <li><a href="<?= site_url('browse') ?>" class="active"><i class="bi bi-compass"></i><span>Browse</span></a></li>
                    <li><a href="<?= site_url('user/categories') ?>"><i class="bi bi-shop-window"></i><span>Categories</span></a></li>
                    <li><a href="<?= site_url('user/cart') ?>"><i class="bi bi-cart3"></i><span>Cart</span><?php if (($cartCount ?? 0) > 0): ?><span class="nav-badge ms-auto"><?= (int) $cartCount ?></span><?php endif; ?></a></li>
                    <li><a href="<?= site_url('user/orders') ?>"><i class="bi bi-bag"></i><span>My Orders</span></a></li>
                <?php elseif ($isLoggedIn): ?>
                    <li><a href="<?= esc($dashboardUrl) ?>"><i class="bi bi-speedometer2"></i><span><?= esc($dashboardLabel) ?></span></a></li>
                    <li><a href="<?= site_url('browse') ?>" class="active"><i class="bi bi-compass"></i><span>Browse</span></a></li>
                <?php else: ?>
                    <li><a href="<?= site_url('browse') ?>" class="active"><i class="bi bi-compass"></i><span>Browse</span></a></li>
                    <li><a href="<?= site_url('buyer/login') ?>"><i class="bi bi-box-arrow-in-right"></i><span>Login</span></a></li>
                    <li><a href="<?= site_url('buyer/register') ?>"><i class="bi bi-person-plus"></i><span>Register</span></a></li>
                <?php endif; ?>
            </ul>
            <div class="sidebar-panel">
                <h6><i class="bi bi-funnel me-2"></i>Filter Products</h6>
                <form method="GET" action="<?= site_url('browse') ?>" class="d-grid gap-3">
                    <input type="hidden" name="search" value="<?= esc($search ?? '') ?>">
                    <div>
                        <label for="browse-category" class="form-label">Category</label>
                        <select name="category" id="browse-category" class="form-select">
                            <option value="">All Categories</option>
                            <?php foreach (($categories ?? []) as $category): ?>
                                <option value="<?= esc($category['name']) ?>" <?= strcasecmp((string) ($selectedCategory ?? ''), (string) $category['name']) === 0 ? 'selected' : '' ?>><?= esc($category['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="browse-price-range" class="form-label">Price Range</label>
                        <select name="price_range" id="browse-price-range" class="form-select">
                            <option value="">All Prices</option>
                            <option value="under_500" <?= ($selectedPriceRange ?? '') === 'under_500' ? 'selected' : '' ?>>Under P500</option>
                            <option value="500_1000" <?= ($selectedPriceRange ?? '') === '500_1000' ? 'selected' : '' ?>>P500 to P1,000</option>
                            <option value="1000_5000" <?= ($selectedPriceRange ?? '') === '1000_5000' ? 'selected' : '' ?>>P1,001 to P5,000</option>
                            <option value="above_5000" <?= ($selectedPriceRange ?? '') === 'above_5000' ? 'selected' : '' ?>>Above P5,000</option>
                        </select>
                    </div>
                    <div class="sidebar-filter-actions">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-funnel me-2"></i>Apply</button>
                        <a href="<?= site_url('browse') ?>" class="btn btn-outline-light"><i class="bi bi-arrow-counterclockwise me-2"></i>Reset</a>
                    </div>
                </form>
            </div>
            <div class="sidebar-user">
                <?php if ($isLoggedIn && $role === 'user'): ?>
                    <a href="<?= site_url('user/profile') ?>" class="user-info">
                        <div class="user-avatar"><?= strtoupper(substr(esc($username ?: 'User'), 0, 1)) ?></div>
                        <div class="user-details"><div class="user-name"><?= esc($username ?: 'User') ?></div><div class="user-role"><?= esc($role ?: 'user') ?></div></div>
                    </a>
                    <a href="<?= site_url('auth/logout') ?>" class="btn-logout"><i class="bi bi-box-arrow-right"></i> Logout</a>
                <?php elseif ($isLoggedIn): ?>
                    <div class="user-info">
                        <div class="user-avatar"><?= strtoupper(substr((string) esc($dashboardLabel), 0, 1)) ?></div>
                        <div class="user-details"><div class="user-name"><?= esc($dashboardLabel) ?></div><div class="user-role"><?= esc($role ?: 'user') ?></div></div>
                    </div>
                    <a href="<?= site_url('auth/logout') ?>" class="btn-logout"><i class="bi bi-box-arrow-right"></i> Logout</a>
                <?php else: ?>
                    <div class="user-info">
                        <div class="user-avatar">G</div>
                        <div class="user-details"><div class="user-name">Guest</div><div class="user-role">public browse</div></div>
                    </div>
                    <a href="<?= site_url('buyer/login') ?>" class="btn-logout" style="background-color:var(--primary);color:#111827;"><i class="bi bi-box-arrow-in-right"></i> Login</a>
                    <a href="<?= site_url('buyer/register') ?>" class="btn-logout" style="margin-top:8px;background-color:#0f766e;"><i class="bi bi-person-plus"></i> Register</a>
                <?php endif; ?>
            </div>
        </aside>
        <main class="main-content">
            <div class="shell">
                <div class="mobile-topbar">
                    <button type="button" class="btn btn-outline-dark mobile-menu-btn" data-sidebar-toggle>
                        <i class="bi bi-list"></i> Menu
                    </button>
                    <div class="mobile-topbar-title">Marketplace</div>
                </div>
                <section class="hero">
                    <h1>Browse all products.</h1>
                    <p>Anyone can explore the catalog here. Sign in or create a buyer account when you're ready to add items to cart and checkout.</p>
                </section>
                <div class="search-card">
                    <form method="GET" class="row g-2 align-items-center">
                        <input type="hidden" name="category" value="<?= esc($selectedCategory ?? '') ?>">
                        <input type="hidden" name="price_range" value="<?= esc($selectedPriceRange ?? '') ?>">
                        <div class="col-lg-10"><input type="text" name="search" class="form-control" placeholder="Search by product name or SKU..." value="<?= esc($search ?? '') ?>"></div>
                        <div class="col-lg-2 d-grid"><button type="submit" class="btn btn-primary"><i class="bi bi-search me-2"></i>Search</button></div>
                    </form>
                </div>
                <section class="section-shell">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                        <div><h4 class="mb-1 fw-bold">Product Catalog</h4><div class="text-muted">All available items are shown here.</div></div>
                        <?php if (($selectedCategory ?? '') !== '' || ($selectedPriceRange ?? '') !== '' || ($search ?? '') !== ''): ?><a href="<?= site_url('browse') ?>" class="btn btn-outline-secondary"><i class="bi bi-arrow-counterclockwise me-2"></i>Clear Filters</a><?php endif; ?>
                    </div>
                    <?php if (empty($products)): ?>
                        <div class="empty-state"><i class="bi bi-bag-x" style="font-size:2.4rem;"></i><h3 class="mt-3">No products found</h3><p class="mb-0">Try a different search term or filter.</p></div>
                    <?php else: ?>
                        <div class="product-grid">
                            <?php foreach ($products as $product): ?>
                                <?php
                                    $stock = (int) ($product['stock_quantity'] ?? 0);
                                    $productModalId = 'browseProductModal' . (int) $product['id'];
                                ?>
                                <article class="product-card">
                                    <button type="button" class="product-trigger" data-bs-toggle="modal" data-bs-target="#<?= esc($productModalId) ?>">
                                        <div class="product-visual">
                                            <?php if (!empty($product['image_path']) && in_array(strtolower(pathinfo($product['image_path'], PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'], true)): ?>
                                                <img src="<?= media_url($product['image_path']) ?>" alt="<?= esc($product['name']) ?>">
                                            <?php else: ?>
                                                <?= esc(strtoupper(substr((string) $product['name'], 0, 1))) ?>
                                            <?php endif; ?>
                                        </div>
                                        <div class="meta">
                                            <span><?= esc($product['category_name'] ?? 'Uncategorized') ?></span>
                                            <span>SKU <?= esc($product['sku']) ?></span>
                                        </div>
                                        <div class="name"><?= esc($product['name']) ?></div>
                                        <div class="description"><?= esc($product['description'] ?: 'Available in the store catalog.') ?></div>
                                        <div class="product-card-footer">
                                            <div class="price-block">
                                                <div class="price">&#8369;<?= number_format((float) $product['price'], 2) ?></div>
                                                <div class="stock"><?= $stock ?> unit<?= $stock === 1 ? '' : 's' ?> available</div>
                                            </div>
                                        </div>
                                    </button>
                                    <div class="product-actions">
                                        <?php if ($isLoggedIn && $role === 'user' && $stock > 0): ?>
                                            <form method="POST" action="<?= site_url('user/cart/add') ?>"><?= csrf_field() ?><input type="hidden" name="product_id" value="<?= (int) $product['id'] ?>"><input type="hidden" name="quantity" value="1"><button type="submit" class="btn btn-outline-dark"><i class="bi bi-cart-plus me-2"></i>Add to Cart</button></form>
                                            <form method="POST" action="<?= site_url('user/buy-now') ?>"><?= csrf_field() ?><input type="hidden" name="product_id" value="<?= (int) $product['id'] ?>"><input type="hidden" name="quantity" value="1"><button type="submit" class="btn btn-warning"><i class="bi bi-lightning-charge me-2"></i>Buy Now</button></form>
                                        <?php elseif ($stock < 1): ?>
                                            <button type="button" class="btn btn-outline-secondary" disabled>Out of Stock</button>
                                            <button type="button" class="btn btn-secondary" disabled>Unavailable</button>
                                        <?php elseif ($isLoggedIn): ?>
                                            <a href="<?= esc($dashboardUrl) ?>" class="btn btn-warning"><i class="bi bi-speedometer2 me-2"></i>Go to Dashboard</a>
                                            <button type="button" class="btn btn-outline-secondary" disabled>Buyer Only</button>
                                        <?php else: ?>
                                            <a href="<?= site_url('buyer/login') ?>" class="btn btn-warning"><i class="bi bi-box-arrow-in-right me-2"></i>Login</a>
                                            <a href="<?= site_url('buyer/register') ?>" class="btn btn-outline-secondary"><i class="bi bi-person-plus me-2"></i>Register</a>
                                        <?php endif; ?>
                                    </div>
                                </article>
                                <div class="modal fade" id="<?= esc($productModalId) ?>" tabindex="-1" aria-labelledby="<?= esc($productModalId) ?>Label" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content border-0" style="border-radius: 28px;">
                                            <div class="modal-header border-0 pb-0">
                                                <h5 class="modal-title fw-bold" id="<?= esc($productModalId) ?>Label"><?= esc($product['name']) ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body pt-3">
                                                <div class="row g-4 align-items-start">
                                                    <div class="col-lg-6">
                                                        <div class="modal-product-visual">
                                                            <?php if (!empty($product['image_path']) && in_array(strtolower(pathinfo($product['image_path'], PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'], true)): ?>
                                                                <img src="<?= media_url($product['image_path']) ?>" alt="<?= esc($product['name']) ?>">
                                                            <?php else: ?>
                                                                <?= esc(strtoupper(substr((string) $product['name'], 0, 1))) ?>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="d-flex flex-wrap gap-2 mb-3">
                                                            <span class="badge text-bg-light"><?= esc($product['category_name'] ?? 'Uncategorized') ?></span>
                                                            <span class="badge text-bg-secondary">SKU <?= esc($product['sku']) ?></span>
                                                        </div>
                                                        <div class="mb-3 fs-3 fw-bold">&#8369;<?= number_format((float) $product['price'], 2) ?></div>
                                                        <p class="text-muted mb-3"><?= esc($product['description'] ?: 'Available in the store catalog.') ?></p>
                                                        <div class="small text-muted"><?= $stock ?> unit<?= $stock === 1 ? '' : 's' ?> available</div>
                                                        <?php if ($isLoggedIn && $role === 'user'): ?>
                                                            <?php if ($stock > 0): ?>
                                                                <div class="modal-action-grid">
                                                                    <form method="POST" action="<?= site_url('user/cart/add') ?>"><?= csrf_field() ?><input type="hidden" name="product_id" value="<?= (int) $product['id'] ?>"><input type="hidden" name="quantity" value="1"><button type="submit" class="btn btn-outline-dark"><i class="bi bi-cart-plus me-2"></i>Add to Cart</button></form>
                                                                    <form method="POST" action="<?= site_url('user/buy-now') ?>"><?= csrf_field() ?><input type="hidden" name="product_id" value="<?= (int) $product['id'] ?>"><input type="hidden" name="quantity" value="1"><button type="submit" class="btn btn-warning"><i class="bi bi-lightning-charge me-2"></i>Buy Now</button></form>
                                                                </div>
                                                            <?php else: ?>
                                                                <div class="modal-action-grid"><button type="button" class="btn btn-outline-secondary" disabled>Out of Stock</button><button type="button" class="btn btn-secondary" disabled>Unavailable</button></div>
                                                            <?php endif; ?>
                                                        <?php elseif ($isLoggedIn): ?>
                                                            <a href="<?= esc($dashboardUrl) ?>" class="btn btn-warning mt-3"><i class="bi bi-speedometer2 me-2"></i>Go to Dashboard</a>
                                                            <div class="gate-note">Browsing is public, but purchases are only available from buyer accounts.</div>
                                                        <?php else: ?>
                                                            <div class="modal-action-grid">
                                                                <a href="<?= site_url('buyer/login') ?>" class="btn btn-warning"><i class="bi bi-box-arrow-in-right me-2"></i>Login</a>
                                                                <a href="<?= site_url('buyer/register') ?>" class="btn btn-outline-secondary"><i class="bi bi-person-plus me-2"></i>Register</a>
                                                            </div>
                                                            <div class="gate-note">You can browse freely, but checkout requires a buyer login.</div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php if (($totalPages ?? 1) > 1): ?>
                            <?php
                                $baseQuery = $_GET;
                                unset($baseQuery['page']);
                                $buildPageUrl = static function (int $page) use ($baseQuery): string {
                                    $query = array_merge($baseQuery, ['page' => $page]);

                                    return site_url('browse') . '?' . http_build_query($query);
                                };
                            ?>
                            <div class="browse-pagination">
                                <a href="<?= ($currentPage ?? 1) > 1 ? esc($buildPageUrl($currentPage - 1)) : '#' ?>" class="page-link <?= ($currentPage ?? 1) <= 1 ? 'disabled' : '' ?>">Prev</a>
                                <?php for ($page = 1; $page <= ($totalPages ?? 1); $page++): ?>
                                    <a href="<?= esc($buildPageUrl($page)) ?>" class="page-link <?= $page === ($currentPage ?? 1) ? 'active' : '' ?>"><?= $page ?></a>
                                <?php endfor; ?>
                                <a href="<?= ($currentPage ?? 1) < ($totalPages ?? 1) ? esc($buildPageUrl($currentPage + 1)) : '#' ?>" class="page-link <?= ($currentPage ?? 1) >= ($totalPages ?? 1) ? 'disabled' : '' ?>">Next</a>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </section>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener("load", function () {
            const sidebar = document.querySelector("[data-sidebar]");
            const backdrop = document.querySelector("[data-sidebar-backdrop]");
            const toggles = document.querySelectorAll("[data-sidebar-toggle]");
            const desktopToggle = document.querySelector("[data-desktop-sidebar-toggle]");
            const storageKey = "ims-browse-sidebar-collapsed";

            if (sidebar && backdrop && toggles.length) {
                const closeSidebar = function () {
                    sidebar.classList.remove("is-open");
                    backdrop.classList.remove("is-active");
                    document.body.classList.remove("sidebar-open");
                };

                const openSidebar = function () {
                    sidebar.classList.add("is-open");
                    backdrop.classList.add("is-active");
                    document.body.classList.add("sidebar-open");
                };

                toggles.forEach(function (toggle) {
                    toggle.addEventListener("click", function () {
                        if (sidebar.classList.contains("is-open")) {
                            closeSidebar();
                        } else {
                            openSidebar();
                        }
                    });
                });

                backdrop.addEventListener("click", closeSidebar);
                window.addEventListener("resize", function () {
                    if (window.innerWidth > 991.98) {
                        closeSidebar();
                    }
                });
            }

            if (desktopToggle) {
                const syncDesktopState = function () {
                    if (window.innerWidth <= 991.98) {
                        document.body.classList.remove("sidebar-collapsed");
                        return;
                    }

                    if (localStorage.getItem(storageKey) === "1") {
                        document.body.classList.add("sidebar-collapsed");
                    } else {
                        document.body.classList.remove("sidebar-collapsed");
                    }
                };

                desktopToggle.addEventListener("click", function () {
                    document.body.classList.toggle("sidebar-collapsed");
                    localStorage.setItem(storageKey, document.body.classList.contains("sidebar-collapsed") ? "1" : "0");
                });

                window.addEventListener("resize", syncDesktopState);
                syncDesktopState();
            }
        });
    </script>
</body>
</html>





<?= $this->extend('layouts/user_layout') ?>

<?= $this->section('content') ?>

<style>
    .market-hero {
        position: relative;
        overflow: hidden;
        padding: 2rem;
        border-radius: 28px;
        background:
            radial-gradient(circle at top right, rgba(245, 158, 11, 0.24), transparent 28%),
            linear-gradient(135deg, #111827, #1f2937 55%, #334155);
        color: #fff;
    }

    .market-hero h2,
    .section-title {
        font-family: 'Space Grotesk', 'Manrope', sans-serif;
        letter-spacing: -0.04em;
    }

    .market-hero h2 {
        font-size: clamp(2rem, 4vw, 3.3rem);
        line-height: 0.96;
        margin-bottom: 0.9rem;
    }

    .hero-copy {
        max-width: 40rem;
        color: rgba(255, 255, 255, 0.78);
    }

    .hero-chip-row {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-top: 1.5rem;
    }

    .hero-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.8rem 1rem;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.08);
        font-size: 0.92rem;
        font-weight: 800;
        color: #fff;
        text-decoration: none;
    }

    .hero-chip:hover {
        background: rgba(255, 255, 255, 0.14);
        color: #fff;
    }

    .hero-panel {
        padding: 1.3rem;
        border-radius: 22px;
        background: rgba(255, 255, 255, 0.08);
    }

    .filter-form {
        display: grid;
        gap: 0.75rem;
    }

    .filter-form .form-select {
        min-height: 3rem;
        border-radius: 14px;
    }

    .filter-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 1rem;
    }

    .product-card {
        display: flex;
        flex-direction: column;
        height: 100%;
        padding: 1rem;
        border-radius: 20px;
        background: #fff;
        border: 1px solid rgba(15, 23, 42, 0.08);
        box-shadow: 0 12px 34px rgba(15, 23, 42, 0.06);
    }

    .product-trigger {
        display: flex;
        flex: 1;
        flex-direction: column;
        width: 100%;
        height: 100%;
        padding: 0;
        border: 0;
        background: transparent;
        text-align: left;
        color: inherit;
    }

    .product-card .visual {
        display: grid;
        place-items: center;
        overflow: hidden;
        height: 140px;
        margin-bottom: 0.9rem;
        border-radius: 18px;
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.16), rgba(37, 99, 235, 0.12));
        font-size: 2.6rem;
        font-weight: 800;
        color: #101828;
    }

    .product-card .visual img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-card .name {
        font-weight: 800;
        color: #101828;
    }

    .product-card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 0.75rem;
        margin-top: auto;
    }

    .product-card-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.7rem;
        margin-top: 1rem;
    }

    .product-card-actions form {
        margin: 0;
    }

    .product-card-actions .btn {
        width: 100%;
        border-radius: 14px;
        font-weight: 700;
    }

    .product-card .desc {
        display: -webkit-box;
        min-height: 4.2rem;
        overflow: hidden;
        color: #667085;
        font-size: 0.9rem;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 3;
    }

    .dashboard-pagination {
        display: flex;
        justify-content: center;
        gap: 0.6rem;
        margin-top: 1.5rem;
        flex-wrap: wrap;
    }

    .dashboard-pagination .page-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 2.75rem;
        min-height: 2.75rem;
        padding: 0.65rem 0.95rem;
        border-radius: 999px;
        border: 1px solid rgba(15, 23, 42, 0.08);
        background: #fff;
        color: #101828;
        font-weight: 800;
        text-decoration: none;
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.06);
    }

    .dashboard-pagination .page-link.active {
        background: #f59e0b;
        border-color: #f59e0b;
        color: #101828;
    }

    .dashboard-pagination .page-link.disabled {
        pointer-events: none;
        opacity: 0.5;
    }

    @media (max-width: 1399.98px) {
        .product-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }
    }

    @media (max-width: 1199.98px) {
        .product-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 767.98px) {
        .product-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 575.98px) {
        .product-grid {
            grid-template-columns: 1fr;
        }
    }

    .modal-product-visual {
        display: grid;
        place-items: center;
        overflow: hidden;
        min-height: 320px;
        border-radius: 24px;
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.18), rgba(29, 78, 216, 0.12));
        font-size: 5rem;
        font-weight: 800;
        color: #101828;
    }

    .modal-product-visual img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .modal-action-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
        margin-top: 1.25rem;
    }

    .modal-action-grid form {
        margin: 0;
    }

    .modal-action-grid .btn {
        width: 100%;
        border-radius: 14px;
        font-weight: 700;
    }
</style>

<section class="market-hero mb-4">
    <div class="row g-4 align-items-center">
        <div class="col-lg-8">
            <h2>Shop your inventory catalog like a real marketplace.</h2>
            <p class="hero-copy mb-0">
                Discover categories, explore matching items, fill your cart, and place orders from one simple customer dashboard.
            </p>
            <div class="hero-chip-row">
                <a href="<?= site_url('user/categories') ?>" class="hero-chip"><i class="bi bi-grid-3x3-gap"></i><?= (int) ($totalCategories ?? 0) ?> categories</a>
                <a href="<?= site_url('user/cart') ?>" class="hero-chip"><i class="bi bi-cart3"></i><?= $cartSummary['itemCount'] ?> cart items</a>
                <a href="<?= site_url('user/orders') ?>" class="hero-chip"><i class="bi bi-bag-check"></i><?= $totalOrders ?> orders placed</a>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="hero-panel">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-white-50">Current cart subtotal</span>
                    <strong>&#8369;<?= number_format((float) $cartSummary['subtotal'], 2) ?></strong>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span class="text-white-50">Categories available</span>
                    <strong><?= (int) ($totalCategories ?? 0) ?></strong>
                </div>
                <div class="d-grid gap-2">
                    <a href="<?= site_url('user/categories') ?>" class="btn btn-warning">
                        <i class="bi bi-grid-3x3-gap me-2"></i>Browse Categories
                    </a>
                    <a href="<?= site_url('user/cart') ?>" class="btn btn-outline-light">
                        <i class="bi bi-cart-check me-2"></i>Go to Cart
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="row g-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="section-title mb-0">
                    <?php
                        $activeFilters = array_filter([
                            $selectedCategory !== '' ? $selectedCategory : null,
                            match ($selectedPriceRange ?? '') {
                                'under_500' => 'Under P500',
                                '500_1000' => 'P500 to P1,000',
                                '1000_5000' => 'P1,001 to P5,000',
                                'above_5000' => 'Above P5,000',
                                default => null,
                            },
                        ]);
                    ?>
                    <?= !empty($activeFilters) ? 'Featured Picks: ' . esc(implode(' | ', $activeFilters)) : 'Featured Picks by Category' ?>
                </h5>
                <a href="<?= site_url('browse') ?>" class="btn btn-sm btn-primary">Browse All</a>
            </div>
            <div class="card-body">
                <?php if (empty($featuredProducts)): ?>
                    <p class="text-muted mb-0">No products are available yet.</p>
                <?php else: ?>
                    <div class="product-grid">
                        <?php foreach ($featuredProducts as $product): ?>
                            <?php $productModalId = 'dashboardProductModal' . (int) $product['id']; ?>
                            <article class="product-card">
                                <button type="button" class="product-trigger" data-bs-toggle="modal" data-bs-target="#<?= esc($productModalId) ?>">
                                    <div class="visual">
                                        <?php if (!empty($product['image_path']) && in_array(strtolower(pathinfo($product['image_path'], PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'], true)): ?>
                                            <img src="<?= media_url($product['image_path']) ?>" alt="<?= esc($product['name']) ?>">
                                        <?php else: ?>
                                            <?= esc(strtoupper(substr($product['name'], 0, 1))) ?>
                                        <?php endif; ?>
                                    </div>
                                    <div class="small text-muted mb-2"><?= esc($product['category_name'] ?? 'General') ?></div>
                                    <div class="name mb-1"><?= esc($product['name']) ?></div>
                                    <div class="desc mb-3"><?= esc($product['description'] ?: 'Ready to add to your cart.') ?></div>
                                    <div class="product-card-footer">
                                        <strong>&#8369;<?= number_format((float) $product['price'], 2) ?></strong>
                                        <span class="badge <?= ((int) $product['stock_quantity']) > 0 ? 'bg-success' : 'bg-danger' ?>">
                                            <?= (int) $product['stock_quantity'] ?> left
                                        </span>
                                    </div>
                                </button>
                                <div class="product-card-actions">
                                    <?php if ((int) $product['stock_quantity'] > 0): ?>
                                        <form method="POST" action="<?= site_url('user/cart/add') ?>">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="product_id" value="<?= (int) $product['id'] ?>">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-outline-dark">
                                                <i class="bi bi-cart-plus me-1"></i>Add to Cart
                                            </button>
                                        </form>
                                        <form method="POST" action="<?= site_url('user/buy-now') ?>">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="product_id" value="<?= (int) $product['id'] ?>">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-warning">
                                                <i class="bi bi-lightning-charge me-1"></i>Buy Now
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <button type="button" class="btn btn-outline-secondary" disabled>Out of Stock</button>
                                        <button type="button" class="btn btn-secondary" disabled>Unavailable</button>
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
                                                            <?= esc(strtoupper(substr($product['name'], 0, 1))) ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="d-flex flex-wrap gap-2 mb-3">
                                                        <span class="badge text-bg-light"><?= esc($product['category_name'] ?? 'General') ?></span>
                                                        <span class="badge text-bg-secondary">SKU <?= esc($product['sku']) ?></span>
                                                    </div>
                                                    <div class="mb-3 fs-3 fw-bold">&#8369;<?= number_format((float) $product['price'], 2) ?></div>
                                                    <p class="text-muted mb-3"><?= esc($product['description'] ?: 'Ready to add to your cart.') ?></p>
                                                    <div class="small text-muted"><?= (int) $product['stock_quantity'] ?> left in stock</div>
                                                    <div class="modal-action-grid">
                                                        <?php if ((int) $product['stock_quantity'] > 0): ?>
                                                            <form method="POST" action="<?= site_url('user/cart/add') ?>">
                                                                <?= csrf_field() ?>
                                                                <input type="hidden" name="product_id" value="<?= (int) $product['id'] ?>">
                                                                <input type="hidden" name="quantity" value="1">
                                                                <button type="submit" class="btn btn-outline-dark">
                                                                    <i class="bi bi-cart-plus me-2"></i>Add to Cart
                                                                </button>
                                                            </form>
                                                            <form method="POST" action="<?= site_url('user/buy-now') ?>">
                                                                <?= csrf_field() ?>
                                                                <input type="hidden" name="product_id" value="<?= (int) $product['id'] ?>">
                                                                <input type="hidden" name="quantity" value="1">
                                                                <button type="submit" class="btn btn-warning">
                                                                    <i class="bi bi-lightning-charge me-2"></i>Buy Now
                                                                </button>
                                                            </form>
                                                        <?php else: ?>
                                                            <button type="button" class="btn btn-outline-secondary" disabled>Out of Stock</button>
                                                            <button type="button" class="btn btn-secondary" disabled>Unavailable</button>
                                                        <?php endif; ?>
                                                    </div>
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

                                return site_url('user/dashboard') . '?' . http_build_query($query);
                            };
                        ?>
                        <div class="dashboard-pagination">
                            <a href="<?= ($currentPage ?? 1) > 1 ? esc($buildPageUrl($currentPage - 1)) : '#' ?>" class="page-link <?= ($currentPage ?? 1) <= 1 ? 'disabled' : '' ?>">Prev</a>
                            <?php for ($page = 1; $page <= ($totalPages ?? 1); $page++): ?>
                                <a href="<?= esc($buildPageUrl($page)) ?>" class="page-link <?= $page === ($currentPage ?? 1) ? 'active' : '' ?>"><?= $page ?></a>
                            <?php endfor; ?>
                            <a href="<?= ($currentPage ?? 1) < ($totalPages ?? 1) ? esc($buildPageUrl($currentPage + 1)) : '#' ?>" class="page-link <?= ($currentPage ?? 1) >= ($totalPages ?? 1) ? 'disabled' : '' ?>">Next</a>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

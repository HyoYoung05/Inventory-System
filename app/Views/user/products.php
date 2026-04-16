<?= $this->extend('layouts/user_layout') ?>

<?= $this->section('content') ?>

<style>
    .shop-hero {
        position: relative;
        overflow: hidden;
        padding: 2rem;
        border-radius: 28px;
        background:
            radial-gradient(circle at top right, rgba(245, 158, 11, 0.25), transparent 28%),
            linear-gradient(135deg, #0f172a, #1f2937 58%, #334155);
        color: #fff;
    }

    .shop-hero h2,
    .section-title {
        font-family: 'Space Grotesk', 'Manrope', sans-serif;
        letter-spacing: -0.04em;
    }

    .shop-hero h2 {
        margin-bottom: 0.75rem;
        font-size: clamp(2rem, 4vw, 3.1rem);
        line-height: 0.96;
    }

    .shop-hero p {
        max-width: 42rem;
        color: rgba(255, 255, 255, 0.74);
    }

    .store-search-card {
        margin-top: -2rem;
        position: relative;
        z-index: 2;
    }

    .store-search-card .card-body {
        padding: 1rem;
    }

    .store-search-card .form-control {
        min-height: 3.2rem;
        border-radius: 18px;
    }

    .category-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
        gap: 1rem;
    }

    .category-card {
        display: flex;
        flex-direction: column;
        height: 100%;
        padding: 1.15rem;
        border-radius: 24px;
        background: linear-gradient(180deg, #ffffff, #fbfdff);
        border: 1px solid rgba(15, 23, 42, 0.08);
        box-shadow: 0 14px 40px rgba(15, 23, 42, 0.06);
        color: inherit;
        text-decoration: none;
        transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
    }

    .category-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 22px 50px rgba(15, 23, 42, 0.11);
        color: inherit;
        text-decoration: none;
    }

    .category-card.active {
        border-color: rgba(245, 158, 11, 0.8);
        box-shadow: 0 22px 50px rgba(245, 158, 11, 0.18);
    }

    .category-visual {
        display: grid;
        place-items: center;
        overflow: hidden;
        height: 150px;
        margin-bottom: 1rem;
        border-radius: 20px;
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.18), rgba(29, 78, 216, 0.12));
        font-size: 2.8rem;
        font-weight: 800;
        color: #101828;
    }

    .category-visual img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .category-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.8rem;
    }

    .category-name {
        margin-bottom: 0.35rem;
        font-size: 1.08rem;
        font-weight: 800;
        color: #101828;
    }

    .category-copy {
        display: -webkit-box;
        min-height: 4.2rem;
        overflow: hidden;
        color: #667085;
        font-size: 0.92rem;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 3;
    }

    .category-count {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.45rem 0.75rem;
        border-radius: 999px;
        background: #f8fafc;
        color: #475467;
        font-size: 0.76rem;
        font-weight: 800;
    }

    .selected-category-shell {
        border: 1px solid rgba(15, 23, 42, 0.08);
        border-radius: 24px;
        background: linear-gradient(180deg, #ffffff, #fbfdff);
        box-shadow: 0 14px 40px rgba(15, 23, 42, 0.06);
    }

    .selected-category-header {
        padding: 1.35rem 1.35rem 0.25rem;
    }

    .selected-category-header h4 {
        margin-bottom: 0.35rem;
        font-weight: 800;
        color: #101828;
    }

    .catalog-list {
        display: grid;
        gap: 1rem;
        padding: 1.1rem 1.35rem 1.35rem;
    }

    .catalog-item {
        display: grid;
        grid-template-columns: 140px minmax(0, 1fr);
        gap: 1rem;
        padding: 1rem;
        border-radius: 20px;
        background: #fff;
        border: 1px solid rgba(15, 23, 42, 0.08);
    }

    .catalog-visual {
        display: grid;
        place-items: center;
        overflow: hidden;
        border-radius: 18px;
        min-height: 140px;
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.18), rgba(29, 78, 216, 0.12));
        font-size: 2.4rem;
        font-weight: 800;
        color: #101828;
    }

    .catalog-visual img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .catalog-body {
        display: flex;
        flex-direction: column;
        gap: 0.8rem;
    }

    .catalog-top {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        align-items: flex-start;
    }

    .catalog-top h5 {
        margin-bottom: 0.3rem;
        font-weight: 800;
        color: #101828;
    }

    .catalog-copy {
        display: -webkit-box;
        overflow: hidden;
        color: #667085;
        font-size: 0.93rem;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 3;
    }

    .catalog-price {
        font-size: 1.3rem;
        font-weight: 800;
        color: #101828;
        white-space: nowrap;
    }

    .catalog-top-copy {
        min-height: 5.3rem;
    }

    .catalog-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .catalog-meta .badge {
        border-radius: 999px;
        padding: 0.45rem 0.75rem;
        font-weight: 700;
    }

    .catalog-actions {
        display: grid;
        grid-template-columns: 90px max-content max-content;
        gap: 0.65rem;
        justify-content: start;
        align-items: center;
        margin-top: auto;
    }

    .catalog-actions .form-control,
    .catalog-actions .btn {
        min-height: 3rem;
        border-radius: 14px;
        font-weight: 800;
    }

    .catalog-actions .btn {
        white-space: nowrap;
    }

    .catalog-actions form {
        margin: 0;
        justify-self: start;
    }

    .cart-summary-card {
        padding: 1.2rem;
        border-radius: 22px;
        background: linear-gradient(180deg, #fff8ec, #ffffff);
        border: 1px solid rgba(245, 158, 11, 0.18);
    }

    .cart-summary-card h5 {
        margin-bottom: 0.9rem;
        font-weight: 800;
        color: #101828;
    }

    .cart-summary-card .summary-label {
        color: #667085;
    }

    .cart-summary-card .summary-value {
        color: #101828;
        font-weight: 800;
    }

    .empty-store {
        padding: 3rem 1.5rem;
        text-align: center;
        color: #667085;
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
        margin-top: 1rem;
    }

    .modal-action-grid form {
        margin: 0;
    }

    .modal-action-grid .btn {
        width: 100%;
        border-radius: 14px;
        font-weight: 800;
    }

    @media (max-width: 991.98px) {
        .catalog-item {
            grid-template-columns: 1fr;
        }

        .catalog-actions {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="shop-hero card mb-4">
    <div class="row align-items-center g-4">
        <div class="col-lg-8">
            <h2>Browse by category first.</h2>
            <p class="mb-0">
                Pick a category to narrow the catalog, then add only the products you want from that section.
            </p>
        </div>
        <div class="col-lg-4">
            <div class="cart-summary-card">
                <h5><i class="bi bi-bag-check me-2"></i>Your Cart</h5>
                <div class="d-flex justify-content-between mb-2">
                    <span class="summary-label">Items Added</span>
                    <strong class="summary-value"><?= (int) $cartSummary['itemCount'] ?></strong>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span class="summary-label">Subtotal</span>
                    <strong class="summary-value">&#8369;<?= number_format((float) $cartSummary['subtotal'], 2) ?></strong>
                </div>
                <a href="<?= site_url('user/cart') ?>" class="btn btn-primary w-100">
                    <i class="bi bi-cart-check me-2"></i>View Cart
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card store-search-card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-2 align-items-center">
            <input type="hidden" name="category" value="<?= esc($selectedCategory ?? '') ?>">
            <div class="col-lg-10">
                <input type="text" name="search" class="form-control" placeholder="Search inside categories by product name or SKU..." value="<?= esc($search ?? '') ?>">
            </div>
            <div class="col-lg-2 d-grid">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search me-2"></i>Search
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="section-title mb-0">Categories</h5>
        <?php if (($selectedCategory ?? '') !== ''): ?>
            <a href="<?= site_url('user/categories' . (($search ?? '') !== '' ? '?search=' . urlencode((string) $search) : '')) ?>" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-counterclockwise me-2"></i>Show All Categories
            </a>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <?php if (empty($categories)): ?>
            <div class="empty-store">
                <i class="bi bi-grid-3x3-gap" style="font-size: 2.3rem;"></i>
                <h4 class="mt-3 mb-2">No categories found</h4>
                <p class="mb-0">Categories will appear here once inventory sections are available.</p>
            </div>
        <?php else: ?>
            <div class="category-grid">
                <?php foreach ($categories as $category): ?>
                    <?php
                        $categoryName = (string) ($category['name'] ?? '');
                        $categoryImage = (string) ($category['image_path'] ?? '');
                        $isActiveCategory = strcasecmp((string) ($selectedCategory ?? ''), $categoryName) === 0;
                        $categoryUrl = site_url('user/categories?' . http_build_query(array_filter([
                            'category' => $categoryName,
                            'search' => (string) ($search ?? ''),
                        ], static fn ($value): bool => $value !== '')));
                    ?>
                    <a href="<?= esc($categoryUrl) ?>" class="category-card<?= $isActiveCategory ? ' active' : '' ?>">
                        <div class="category-visual">
                            <?php if ($categoryImage !== '' && in_array(strtolower(pathinfo($categoryImage, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'], true)): ?>
                                <img src="<?= media_url($categoryImage) ?>" alt="<?= esc($categoryName) ?>">
                            <?php else: ?>
                                <?= esc(strtoupper(substr($categoryName, 0, 1))) ?>
                            <?php endif; ?>
                        </div>
                        <div class="category-meta">
                            <div class="category-name"><?= esc($categoryName) ?></div>
                            <span class="category-count">
                                <i class="bi bi-box-seam"></i><?= (int) ($category['product_count'] ?? 0) ?>
                            </span>
                        </div>
                        <div class="category-copy">
                            <?= esc($category['description'] ?: 'Open this category to see all matching products.') ?>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php if (($selectedCategory ?? '') !== ''): ?>
    <div class="selected-category-shell">
        <div class="selected-category-header">
            <h4><?= esc($selectedCategory) ?></h4>
            <p class="text-muted mb-0">Only products from this category are shown below.</p>
        </div>

        <?php if (empty($products)): ?>
            <div class="empty-store">
                <i class="bi bi-bag-x" style="font-size: 2.3rem;"></i>
                <h4 class="mt-3 mb-2">No products found in this category</h4>
                <p class="mb-0">Try another category or adjust your search.</p>
            </div>
        <?php else: ?>
            <div class="catalog-list">
                <?php foreach ($products as $product): ?>
                    <?php
                        $stock = (int) ($product['stock_quantity'] ?? 0);
                        $stockLabel = $stock > 20 ? 'Ready to ship' : ($stock > 0 ? 'Limited stock' : 'Out of stock');
                        $stockBadgeClass = $stock > 20 ? 'bg-success' : ($stock > 0 ? 'bg-warning text-dark' : 'bg-danger');
                        $productInitial = strtoupper(substr((string) $product['name'], 0, 1));
                        $productModalId = 'categoryProductModal' . (int) $product['id'];
                    ?>
                    <div class="catalog-item">
                        <button type="button" class="catalog-visual border-0 p-0" data-bs-toggle="modal" data-bs-target="#<?= esc($productModalId) ?>">
                            <?php if (!empty($product['image_path']) && in_array(strtolower(pathinfo($product['image_path'], PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'], true)): ?>
                                <img src="<?= media_url($product['image_path']) ?>" alt="<?= esc($product['name']) ?>">
                            <?php else: ?>
                                <?= esc($productInitial) ?>
                            <?php endif; ?>
                        </button>

                        <div class="catalog-body">
                            <div class="catalog-top">
                                <div class="catalog-top-copy">
                                    <h5><button type="button" class="btn btn-link p-0 text-decoration-none fw-bold text-start" data-bs-toggle="modal" data-bs-target="#<?= esc($productModalId) ?>"><?= esc($product['name']) ?></button></h5>
                                    <div class="catalog-copy"><?= esc($product['description'] ?: 'A well-stocked inventory item ready for your next order.') ?></div>
                                </div>
                                <div class="catalog-price">&#8369;<?= number_format((float) $product['price'], 2) ?></div>
                            </div>

                            <div class="catalog-meta">
                                <span class="badge text-bg-light">SKU <?= esc($product['sku']) ?></span>
                                <span class="badge <?= $stockBadgeClass ?>"><?= esc($stockLabel) ?></span>
                                <span class="badge text-bg-secondary"><?= $stock ?> unit<?= $stock === 1 ? '' : 's' ?> available</span>
                            </div>

                            <div class="catalog-actions">
                                <input type="number" name="quantity" class="form-control product-quantity" min="1" max="<?= max(1, $stock) ?>" value="1" <?= $stock < 1 ? 'disabled' : '' ?> data-product-id="<?= (int) $product['id'] ?>">
                                <form method="POST" action="<?= site_url('user/cart/add') ?>">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="product_id" value="<?= (int) $product['id'] ?>">
                                    <input type="hidden" name="quantity" value="1" class="quantity-sync" data-product-id="<?= (int) $product['id'] ?>">
                                    <button type="submit" class="btn btn-primary" <?= $stock < 1 ? 'disabled' : '' ?>>
                                        <i class="bi bi-cart-plus me-2"></i><?= $stock < 1 ? 'Unavailable' : 'Add to Cart' ?>
                                    </button>
                                </form>
                                <form method="POST" action="<?= site_url('user/buy-now') ?>">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="product_id" value="<?= (int) $product['id'] ?>">
                                    <input type="hidden" name="quantity" value="1" class="quantity-sync" data-product-id="<?= (int) $product['id'] ?>">
                                    <button type="submit" class="btn btn-warning" <?= $stock < 1 ? 'disabled' : '' ?>>
                                        <i class="bi bi-lightning-charge me-2"></i><?= $stock < 1 ? 'Unavailable' : 'Buy Now' ?>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
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
                                                    <?= esc($productInitial) ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="d-flex flex-wrap gap-2 mb-3">
                                                <span class="badge text-bg-light"><?= esc($product['category_name'] ?? 'Uncategorized') ?></span>
                                                <span class="badge text-bg-secondary">SKU <?= esc($product['sku']) ?></span>
                                            </div>
                                            <div class="mb-3 fs-3 fw-bold">&#8369;<?= number_format((float) $product['price'], 2) ?></div>
                                            <p class="text-muted mb-3"><?= esc($product['description'] ?: 'A well-stocked inventory item ready for your next order.') ?></p>
                                            <div class="small text-muted"><?= $stock ?> unit<?= $stock === 1 ? '' : 's' ?> available</div>
                                            <div class="modal-action-grid">
                                                <?php if ($stock > 0): ?>
                                                    <form method="POST" action="<?= site_url('user/cart/add') ?>">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="product_id" value="<?= (int) $product['id'] ?>">
                                                        <input type="hidden" name="quantity" value="1">
                                                        <button type="submit" class="btn btn-primary">
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
        <?php endif; ?>
    </div>
<?php endif; ?>

<script>
    window.addEventListener('load', function () {
        const quantityInputs = Array.from(document.querySelectorAll('.product-quantity'));

        quantityInputs.forEach(function (input) {
            const productId = input.dataset.productId;
            const syncTargets = Array.from(document.querySelectorAll('.quantity-sync[data-product-id="' + productId + '"]'));

            const syncQuantity = function () {
                const safeValue = Math.max(1, parseInt(input.value || '1', 10) || 1);
                input.value = safeValue;

                syncTargets.forEach(function (target) {
                    target.value = safeValue;
                });
            };

            input.addEventListener('input', syncQuantity);
            input.addEventListener('change', syncQuantity);
            syncQuantity();
        });
    });
</script>

<?= $this->endSection() ?>

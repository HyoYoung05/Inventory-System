<?= $this->extend('layouts/user_layout') ?>

<?= $this->section('content') ?>

<style>
    .cart-page {
        display: grid;
        grid-template-columns: minmax(0, 1.6fr) minmax(300px, 0.8fr);
        gap: 1.5rem;
    }

    .cart-list {
        display: grid;
        gap: 1rem;
    }

    .cart-item {
        display: grid;
        grid-template-columns: 96px minmax(0, 1fr) auto;
        gap: 1rem;
        align-items: start;
        padding: 1.2rem;
        border: 1px solid rgba(15, 23, 42, 0.08);
        border-radius: 22px;
        background: #fff;
    }

    .cart-thumb {
        display: grid;
        place-items: center;
        overflow: hidden;
        width: 96px;
        height: 96px;
        border-radius: 18px;
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.18), rgba(59, 130, 246, 0.16));
        color: #111827;
        font-size: 2rem;
        font-weight: 800;
    }

    .cart-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .cart-item h5 {
        margin-bottom: 0.35rem;
        font-weight: 800;
    }

    .cart-item p {
        margin-bottom: 0.5rem;
        color: #667085;
    }

    .cart-price {
        font-size: 1.2rem;
        font-weight: 800;
        color: #111827;
    }

    .cart-actions {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 0.75rem;
    }

    .cart-actions .form-control {
        width: 96px;
        min-height: 3rem;
        border-radius: 14px;
        text-align: center;
    }

    .cart-line-total {
        min-width: 110px;
    }

    .cart-summary {
        position: sticky;
        top: 1rem;
        padding: 1.4rem;
        border-radius: 24px;
        background: linear-gradient(180deg, #111827, #1f2937);
        color: #fff;
    }

    .cart-summary h4 {
        font-family: 'Space Grotesk', 'Manrope', sans-serif;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.75rem;
        color: rgba(255, 255, 255, 0.74);
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid rgba(255, 255, 255, 0.14);
        font-size: 1.15rem;
        font-weight: 800;
        color: #fff;
    }

    .summary-note {
        margin: 1rem 0 1.25rem;
        padding: 0.9rem 1rem;
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.08);
        color: rgba(255, 255, 255, 0.78);
        font-size: 0.9rem;
    }

    .payment-methods {
        display: grid;
        gap: 0.75rem;
        margin: 1rem 0 1.25rem;
    }

    .payment-option {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        padding: 0.95rem 1rem;
        border-radius: 18px;
        border: 1px solid rgba(255, 255, 255, 0.14);
        background: rgba(255, 255, 255, 0.06);
    }

    .payment-option.active {
        border-color: rgba(245, 158, 11, 0.55);
        background: rgba(245, 158, 11, 0.18);
    }

    .payment-option.disabled {
        opacity: 0.72;
    }

    .payment-option .title {
        font-weight: 800;
        color: #fff;
    }

    .payment-option .copy {
        color: rgba(255, 255, 255, 0.72);
        font-size: 0.88rem;
    }

    .payment-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 102px;
        padding: 0.45rem 0.7rem;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 800;
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }

    .payment-badge.available {
        background: #fbbf24;
        color: #111827;
    }

    .payment-badge.unavailable {
        background: rgba(255, 255, 255, 0.12);
        color: rgba(255, 255, 255, 0.74);
    }

    .empty-cart {
        padding: 3rem 1.5rem;
        text-align: center;
        color: #667085;
    }

    @media (max-width: 991.98px) {
        .cart-page {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 575.98px) {
        .cart-item {
            grid-template-columns: 1fr;
        }

        .cart-actions {
            align-items: stretch;
        }

        .cart-actions .form-control {
            width: 100%;
        }
    }
</style>

<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
        <h3 class="mb-1"><i class="bi bi-cart3"></i> Your Cart</h3>
        <p class="text-muted mb-0">Review your selections, adjust quantities, and place your order.</p>
    </div>
    <a href="<?= site_url('user/categories') ?>" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Browse Categories
    </a>
</div>

<?php if (empty($cartSummary['items'])): ?>
    <div class="card">
        <div class="empty-cart">
            <i class="bi bi-cart-x" style="font-size: 2.4rem;"></i>
            <h4 class="mt-3 mb-2">Your cart is empty</h4>
            <p class="mb-3">Start browsing categories and add items to build your order.</p>
            <a href="<?= site_url('user/categories') ?>" class="btn btn-primary">
                <i class="bi bi-grid-3x3-gap me-2"></i>Browse Categories
            </a>
        </div>
    </div>
<?php else: ?>
    <div class="cart-page">
        <div>
            <form method="POST" action="<?= site_url('user/cart/update') ?>">
                <?= csrf_field() ?>
                <div class="cart-list">
                    <?php foreach ($cartSummary['items'] as $item): ?>
                        <article class="cart-item">
                            <div class="cart-thumb">
                                <?php if (!empty($item['image_path']) && in_array(strtolower(pathinfo($item['image_path'], PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'], true)): ?>
                                    <img src="<?= media_url($item['image_path']) ?>" alt="<?= esc($item['name']) ?>">
                                <?php else: ?>
                                    <?= esc(strtoupper(substr($item['name'], 0, 1))) ?>
                                <?php endif; ?>
                            </div>
                            <div>
                                <span class="badge bg-light text-dark mb-2"><?= esc($item['category_name'] ?? 'Uncategorized') ?></span>
                                <h5><?= esc($item['name']) ?></h5>
                                <p><?= esc($item['description'] ?: 'Inventory item ready for checkout.') ?></p>
                                <div class="small text-muted mb-2">SKU <?= esc($item['sku']) ?> • <?= (int) $item['stock_quantity'] ?> available</div>
                                <div class="cart-price">&#8369;<?= number_format((float) $item['price'], 2) ?></div>
                            </div>
                            <div class="cart-actions">
                                <label class="small text-muted">Quantity</label>
                                <input
                                    type="number"
                                    name="quantities[<?= (int) $item['cart_item_id'] ?>]"
                                    class="form-control cart-quantity-input"
                                    min="0"
                                    max="<?= (int) $item['stock_quantity'] ?>"
                                    value="<?= (int) $item['quantity'] ?>"
                                    data-price="<?= esc((string) $item['price']) ?>"
                                    data-line-total-target="line-total-<?= (int) $item['cart_item_id'] ?>"
                                >
                                <div class="fw-bold text-end cart-line-total" id="line-total-<?= (int) $item['cart_item_id'] ?>">&#8369;<?= number_format((float) $item['line_total'], 2) ?></div>
                                <button type="submit" formaction="<?= site_url('user/cart/remove/' . $item['cart_item_id']) ?>" formmethod="post" class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-trash me-1"></i>Remove
                                </button>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-arrow-repeat me-2"></i>Update Cart
                    </button>
                </div>
            </form>
        </div>

        <aside class="cart-summary">
            <h4>Order Summary</h4>
            <div class="summary-row">
                <span>Unique items</span>
                <strong><?= $cartSummary['productCount'] ?></strong>
            </div>
            <div class="summary-row">
                <span>Total items</span>
                <strong><?= $cartSummary['itemCount'] ?></strong>
            </div>
            <div class="summary-total">
                <span>Subtotal</span>
                <span id="cart-subtotal">&#8369;<?= number_format($cartSummary['subtotal'], 2) ?></span>
            </div>
            <div class="mt-4">
                <div class="fw-bold mb-2">Payment Methods</div>
                <div class="payment-methods">
                    <div class="payment-option active">
                        <div>
                            <div class="title">Cash on Delivery</div>
                            <div class="copy">Pay when your order arrives at your address.</div>
                        </div>
                        <span class="payment-badge available">Available</span>
                    </div>
                    <div class="payment-option disabled">
                        <div>
                            <div class="title">GCash</div>
                            <div class="copy">Digital wallet checkout is still being prepared.</div>
                        </div>
                        <span class="payment-badge unavailable">Unavailable</span>
                    </div>
                    <div class="payment-option disabled">
                        <div>
                            <div class="title">Credit or Debit Card</div>
                            <div class="copy">Card payments are temporarily disabled.</div>
                        </div>
                        <span class="payment-badge unavailable">Unavailable</span>
                    </div>
                    <div class="payment-option disabled">
                        <div>
                            <div class="title">Bank Transfer</div>
                            <div class="copy">Manual transfer confirmation is not active yet.</div>
                        </div>
                        <span class="payment-badge unavailable">Unavailable</span>
                    </div>
                </div>
            </div>
            <div class="summary-note">
                Orders are currently submitted with Cash on Delivery only, then move through packing, shipping, and delivery updates inside the inventory system.
            </div>
            <form method="POST" action="<?= site_url('user/checkout') ?>">
                <?= csrf_field() ?>
                <input type="hidden" name="payment_method" value="cash_on_delivery">
                <button type="submit" class="btn btn-warning w-100">
                    <i class="bi bi-bag-check me-2"></i>Place Order
                </button>
            </form>
        </aside>
    </div>
<?php endif; ?>

<script>
    window.addEventListener('load', function () {
        const quantityInputs = Array.from(document.querySelectorAll('.cart-quantity-input'));
        const subtotalTarget = document.getElementById('cart-subtotal');

        if (!quantityInputs.length || !subtotalTarget) {
            return;
        }

        const formatCurrency = function (value) {
            return new Intl.NumberFormat('en-PH', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(value);
        };

        const refreshTotals = function () {
            let subtotal = 0;

            quantityInputs.forEach(function (input) {
                const quantity = Math.max(0, parseInt(input.value || '0', 10) || 0);
                const price = parseFloat(input.dataset.price || '0') || 0;
                const lineTotal = quantity * price;
                const lineTotalTarget = document.getElementById(input.dataset.lineTotalTarget || '');

                if (lineTotalTarget) {
                    lineTotalTarget.textContent = '₱' + formatCurrency(lineTotal);
                }

                subtotal += lineTotal;
            });

            subtotalTarget.textContent = '₱' + formatCurrency(subtotal);
        };

        quantityInputs.forEach(function (input) {
            input.addEventListener('input', refreshTotals);
            input.addEventListener('change', refreshTotals);
        });

        refreshTotals();
    });
</script>

<?= $this->endSection() ?>

<?= $this->extend('layouts/user_layout') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
        <h3 class="mb-1"><i class="bi bi-receipt"></i> Order #<?= esc($order['id']) ?></h3>
        <p class="text-muted mb-0">Review the items and status for this order.</p>
    </div>
    <a href="<?= site_url('user/orders') ?>" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to Orders
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Items</h5>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orderItems as $item): ?>
                            <tr>
                                <td>
                                    <strong><?= esc($item['product_name'] ?? 'Product') ?></strong>
                                    <div class="small text-muted">SKU <?= esc($item['sku'] ?? 'N/A') ?></div>
                                </td>
                                <td><?= esc($item['category_name'] ?? 'N/A') ?></td>
                                <td><?= (int) $item['quantity'] ?></td>
                                <td>&#8369;<?= number_format((float) $item['price_at_time'], 2) ?></td>
                                <td><strong>&#8369;<?= number_format((float) $item['subtotal'], 2) ?></strong></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Order Summary</h5>
            </div>
            <div class="card-body">
                <?php
                    $statusClass = match($order['status']) {
                        'to_be_packed' => 'bg-warning text-dark',
                        'to_be_shipped' => 'bg-primary',
                        'to_be_delivered' => 'bg-info text-dark',
                        'completed' => 'bg-success',
                        'cancelled' => 'bg-danger',
                        default => 'bg-warning text-dark',
                    };
                    $statusLabel = match($order['status']) {
                        'to_be_packed' => 'To Be Packed',
                        'to_be_shipped' => 'To Be Shipped',
                        'to_be_delivered' => 'To Be Delivered',
                        default => ucwords(str_replace('_', ' ', $order['status']))
                    };
                ?>
                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted">Customer</span>
                    <strong><?= esc($order['customer_name']) ?></strong>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted">Placed on</span>
                    <strong><?= date('M d, Y h:i A', strtotime($order['created_at'])) ?></strong>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted">Status</span>
                    <span class="badge <?= $statusClass ?>"><?= esc($statusLabel) ?></span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Total</span>
                    <strong>&#8369;<?= number_format((float) $order['total_amount'], 2) ?></strong>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

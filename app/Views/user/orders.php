<?= $this->extend('layouts/user_layout') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
        <h3 class="mb-1"><i class="bi bi-bag"></i> My Orders</h3>
        <p class="text-muted mb-0">Track the orders you placed through the storefront.</p>
    </div>
    <a href="<?= site_url('user/categories') ?>" class="btn btn-primary">
        <i class="bi bi-grid-3x3-gap me-2"></i>Browse Categories
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Order History</h5>
    </div>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Date</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($orders)): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            No orders yet. Start shopping to place your first order.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($orders as $order): ?>
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
                        <tr>
                            <td>
                                <strong>#<?= esc($order['id']) ?></strong>
                                <div class="small text-muted"><?= esc($order['customer_name']) ?></div>
                            </td>
                            <td><?= date('M d, Y h:i A', strtotime($order['created_at'])) ?></td>
                            <td><?= (int) ($order['total_items'] ?? 0) ?> item<?= ((int) ($order['total_items'] ?? 0) === 1) ? '' : 's' ?></td>
                            <td><strong>&#8369;<?= number_format((float) $order['total_amount'], 2) ?></strong></td>
                            <td><span class="badge <?= $statusClass ?>"><?= esc($statusLabel) ?></span></td>
                            <td>
                                <div class="d-flex flex-wrap gap-2">
                                    <a href="<?= site_url('user/orders/details/' . $order['id']) ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye me-1"></i>Details
                                    </a>
                                    <?php if (($order['status'] ?? '') === 'to_be_packed'): ?>
                                        <form method="POST" action="<?= site_url('user/orders/cancel/' . $order['id']) ?>" onsubmit="return confirm('Cancel this order? This will return the stock to inventory.');">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-x-circle me-1"></i>Cancel
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>

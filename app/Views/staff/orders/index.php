<?= $this->extend('layouts/staff_layout') ?>

<?= $this->section('content') ?>

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3><i class="bi bi-receipt"></i> Orders</h3>
        </div>
        <p class="text-muted">Review all orders and update their current status.</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <form method="GET" class="d-flex gap-2">
            <input type="text" name="search" class="form-control" placeholder="Search by order ID or customer name..." value="<?= esc($search ?? '') ?>">
            <select name="status" class="form-select" style="max-width: 150px;">
                <option value="">All Status</option>
                <option value="to_be_packed" <?= ($status ?? '') === 'to_be_packed' ? 'selected' : '' ?>>To Be Packed</option>
                <option value="to_be_shipped" <?= ($status ?? '') === 'to_be_shipped' ? 'selected' : '' ?>>To Be Shipped</option>
                <option value="to_be_delivered" <?= ($status ?? '') === 'to_be_delivered' ? 'selected' : '' ?>>To Be Delivered</option>
                <option value="completed" <?= ($status ?? '') === 'completed' ? 'selected' : '' ?>>Completed</option>
                <option value="cancelled" <?= ($status ?? '') === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
            </select>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-search"></i> Filter
            </button>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Date & Time</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($orders)): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No orders found</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><strong>#<?= esc($order['id']) ?></strong></td>
                            <td><?= esc($order['customer_name']) ?></td>
                            <td><?= date('M d, Y h:i A', strtotime($order['created_at'])) ?></td>
                            <td><strong>&#8369;<?= number_format($order['total_amount'], 2) ?></strong></td>
                            <td>
                                <?php
                                    $statusClass = match($order['status']) {
                                        'to_be_packed' => 'badge-to-be-packed',
                                        'to_be_shipped' => 'badge-to-be-shipped',
                                        'to_be_delivered' => 'badge-to-be-delivered',
                                        'completed' => 'badge-completed',
                                        'cancelled' => 'badge-cancelled',
                                        default => 'badge-pending'
                                    };
                                    $statusLabel = match($order['status']) {
                                        'to_be_packed' => 'To Be Packed',
                                        'to_be_shipped' => 'To Be Shipped',
                                        'to_be_delivered' => 'To Be Delivered',
                                        default => ucwords(str_replace('_', ' ', $order['status']))
                                    };
                                ?>
                                <span class="badge <?= $statusClass ?>"><?= esc($statusLabel) ?></span>
                            </td>
                            <td>
                                <a href="<?= base_url('staff/orders/details/' . $order['id']) ?>" class="btn btn-sm btn-info" title="View Details">
                                    <i class="bi bi-eye"></i> Details
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>

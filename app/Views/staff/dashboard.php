<?= $this->extend('layouts/staff_layout') ?>

<?= $this->section('content') ?>

<div class="row mb-4">
    <div class="col-12">
        <h3><i class="bi bi-speedometer2"></i> Dashboard Overview</h3>
        <p class="text-muted">Monitor low-stock items and keep orders moving.</p>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6 col-lg-3 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small mb-1">Total Orders</div>
                        <h3 class="mb-0"><?= $totalOrders ?></h3>
                    </div>
                    <i class="bi bi-receipt" style="font-size: 2rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small mb-1">Total Products</div>
                        <h3 class="mb-0"><?= $totalProducts ?></h3>
                    </div>
                    <i class="bi bi-box-seam" style="font-size: 2rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small mb-1">Low Stock Items</div>
                        <h3 class="mb-0"><?= count($lowStockProducts) ?></h3>
                    </div>
                    <i class="bi bi-exclamation-triangle" style="font-size: 2rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-3">
        <div class="card text-white bg-danger">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small mb-1">Out of Stock</div>
                        <h3 class="mb-0"><?= (int) ($outOfStockCount ?? 0) ?></h3>
                    </div>
                    <i class="bi bi-x-octagon" style="font-size: 2rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-receipt"></i> Recent Orders</h5>
                <a href="<?= base_url('staff/orders') ?>" class="btn btn-sm btn-primary">Manage Orders</a>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer Name</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Date & Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($recentOrders)): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No orders yet</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($recentOrders as $order): ?>
                                <tr>
                                    <td><strong>#<?= esc($order['id']) ?></strong></td>
                                    <td><?= esc($order['customer_name']) ?></td>
                                    <td><strong>&#8369;<?= number_format($order['total_amount'] ?? 0, 2) ?></strong></td>
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
                                    <td><?= date('M d, Y H:i', strtotime($order['created_at'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

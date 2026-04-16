<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('content') ?>

<div class="row mb-4">
    <div class="col-12">
        <a href="<?= site_url('admin/orders') ?>" class="btn btn-sm btn-secondary mb-3">
            <i class="bi bi-arrow-left"></i> Back to Orders
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-header">
                <h4 class="mb-0"><i class="bi bi-receipt"></i> Order #<?= esc($order['id']) ?></h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-3">Customer Information</h5>
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-bold">Customer Name:</td>
                                <td><?= esc($order['customer_name']) ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Order Date:</td>
                                <td><?= date('M d, Y', strtotime($order['created_at'])) ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Order Time:</td>
                                <td><?= date('h:i A', strtotime($order['created_at'])) ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h5 class="mb-3">Order Summary</h5>
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-bold">Total Amount:</td>
                                <td><strong>&#8369;<?= number_format((float) $order['total_amount'], 2) ?></strong></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Status:</td>
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
                            </tr>
                            <tr>
                                <td class="fw-bold">Processed By:</td>
                                <td><?= esc($order['processed_by'] ?? 'N/A') ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <?php if (!empty($orderItems)): ?>
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-list-check"></i> Order Items</h5>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orderItems as $item): ?>
                                <tr>
                                    <td><?= esc($item['product_name'] ?? 'N/A') ?></td>
                                    <td><?= (int) $item['quantity'] ?></td>
                                    <td>&#8369;<?= number_format((float) ($item['price'] ?? 0), 2) ?></td>
                                    <td>&#8369;<?= number_format((float) (($item['quantity'] ?? 0) * ($item['price'] ?? 0)), 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-gear"></i> Update Status</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?= site_url('admin/orders/updateStatus/' . $order['id']) ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="status" class="form-label">Order Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="to_be_packed" <?= $order['status'] === 'to_be_packed' ? 'selected' : '' ?>>To Be Packed</option>
                            <option value="to_be_shipped" <?= $order['status'] === 'to_be_shipped' ? 'selected' : '' ?>>To Be Shipped</option>
                            <option value="to_be_delivered" <?= $order['status'] === 'to_be_delivered' ? 'selected' : '' ?>>To Be Delivered</option>
                            <option value="completed" <?= $order['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                            <option value="cancelled" <?= $order['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check-circle"></i> Update Status
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

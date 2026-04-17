<?= $this->extend('layouts/user_layout') ?>

<?= $this->section('content') ?>

<style>
    .orders-table td,
    .orders-table th {
        vertical-align: middle;
    }

    @media (max-width: 767.98px) {
        .orders-table thead {
            display: none;
        }

        .orders-table,
        .orders-table tbody,
        .orders-table tr,
        .orders-table td {
            display: block;
            width: 100%;
        }

        .orders-table tbody {
            display: grid;
            gap: 1rem;
            padding: 1rem;
        }

        .orders-table tr {
            padding: 1rem;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.06);
        }

        .orders-table td {
            padding: 0.45rem 0;
            border: 0;
        }

        .orders-table td::before {
            content: attr(data-label);
            display: block;
            margin-bottom: 0.2rem;
            color: #667085;
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .orders-table td:last-child {
            padding-top: 0.75rem;
        }
    }
</style>

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
        <table class="table align-middle mb-0 orders-table">
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
                            <td data-label="Order">
                                <strong>#<?= esc($order['id']) ?></strong>
                                <div class="small text-muted"><?= esc($order['customer_name']) ?></div>
                            </td>
                            <td data-label="Date"><?= date('M d, Y h:i A', strtotime($order['created_at'])) ?></td>
                            <td data-label="Items"><?= (int) ($order['total_items'] ?? 0) ?> item<?= ((int) ($order['total_items'] ?? 0) === 1) ? '' : 's' ?></td>
                            <td data-label="Total"><strong>&#8369;<?= number_format((float) $order['total_amount'], 2) ?></strong></td>
                            <td data-label="Status"><span class="badge <?= $statusClass ?>"><?= esc($statusLabel) ?></span></td>
                            <td data-label="Actions">
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

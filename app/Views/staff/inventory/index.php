<?= $this->extend('layouts/staff_layout') ?>

<?= $this->section('content') ?>

<div class="row mb-4">
    <div class="col-12">
        <h3><i class="bi bi-box-seam"></i> Inventory Overview</h3>
        <p class="text-muted">Review stock status and product availability without editing inventory quantities.</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <form method="GET" class="d-flex gap-2">
            <input type="text" name="search" class="form-control" placeholder="Search by product name or SKU..." value="<?= esc($search ?? '') ?>">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-search"></i> Search
            </button>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>SKU</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock Quantity</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No products found</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
                        <?php
                            $stock = (int) ($product['stock_quantity'] ?? 0);
                            $stockStatus = $stock > 20 ? 'In Stock' : ($stock > 0 ? 'Low Stock' : 'Out of Stock');
                            $statusClass = $stock > 20 ? 'bg-success' : ($stock > 0 ? 'bg-warning text-dark' : 'bg-danger');
                        ?>
                        <tr>
                            <td><code><?= esc($product['sku']) ?></code></td>
                            <td>
                                <strong><?= esc($product['name']) ?></strong>
                                <br>
                                <small class="text-muted"><?= esc(substr((string) ($product['description'] ?? ''), 0, 60)) ?></small>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark"><?= esc($product['category_name'] ?? 'N/A') ?></span>
                            </td>
                            <td><strong>&#8369;<?= number_format((float) ($product['price'] ?? 0), 2) ?></strong></td>
                            <td><span class="badge <?= $statusClass ?>"><?= $stock ?> units</span></td>
                            <td><span class="badge <?= $statusClass ?>"><?= esc($stockStatus) ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>

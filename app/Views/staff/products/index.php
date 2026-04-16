<?= $this->extend('layouts/staff_layout') ?>

<?= $this->section('content') ?>

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h3><i class="bi bi-box-seam"></i> Inventory Products</h3>
            <a href="<?= base_url('staff/products/create') ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add Product
            </a>
        </div>
        <p class="text-muted">View and manage all products in the inventory</p>
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
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">No products found</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($products as $product): 
                        $stockStatus = $product['stock_quantity'] > 20 ? 'In Stock' : ($product['stock_quantity'] > 0 ? 'Low Stock' : 'Out of Stock');
                        $statusClass = $product['stock_quantity'] > 20 ? 'badge-success' : ($product['stock_quantity'] > 0 ? 'badge-warning' : 'badge-danger');
                    ?>
                        <tr>
                            <td><code><?= esc($product['sku']) ?></code></td>
                            <td>
                                <strong><?= esc($product['name']) ?></strong>
                                <br>
                                <small class="text-muted"><?= esc(substr($product['description'] ?? '', 0, 50)) ?></small>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark"><?= esc($product['category_name'] ?? 'N/A') ?></span>
                            </td>
                            <td><strong>₱<?= number_format($product['price'], 2) ?></strong></td>
                            <td>
                                <span class="badge <?= $product['stock_quantity'] > 20 ? 'bg-success' : ($product['stock_quantity'] > 0 ? 'bg-warning' : 'bg-danger') ?>">
                                    <?= $product['stock_quantity'] ?> units
                                </span>
                            </td>
                            <td>
                                <span class="badge <?= $statusClass ?>">
                                    <?= $stockStatus ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= base_url('staff/products/details/' . $product['id']) ?>" class="btn btn-sm btn-info" title="View Details">
                                    <i class="bi bi-eye"></i>
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
